<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\EventBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class MaintenanceController extends Controller
{
    /**
     * Download a full system backup (Lite version for SQLite).
     */
    public function downloadBackup()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $dbPath = database_path('database.sqlite');
        $backupPath = storage_path('app/backups/backup-' . Carbon::now()->format('Y-m-d-His') . '.sqlite');

        if (!File::exists(storage_path('app/backups'))) {
            File::makeDirectory(storage_path('app/backups'), 0755, true);
        }

        File::copy($dbPath, $backupPath);

        return response()->download($backupPath)->deleteFileAfterSend(true);
    }
    /**
     * Restore the system from a previous backup file (.sqlite).
     */
    public function restoreBackup(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'backup_file' => 'required|file',
            'password' => 'required',
        ]);

        if (!Hash::check($request->password, auth()->user()->password)) {
            return back()->with('error', 'Authentication failed. Restoration aborted.');
        }

        $backupFile = $request->file('backup_file');
        
        // Basic check for SQLite extension
        if ($backupFile->getClientOriginalExtension() !== 'sqlite') {
            return back()->with('error', 'Restore aborted: Invalid file format (Must be .sqlite).');
        }

        try {
            $dbPath = database_path('database.sqlite');
            
            // Backup CURRENT state just in case before restoring
            $emergencyBackupPath = storage_path('app/backups/emergency-pre-restore-' . Carbon::now()->format('Y-m-d-His') . '.sqlite');
            if (!File::exists(storage_path('app/backups'))) {
                File::makeDirectory(storage_path('app/backups'), 0755, true);
            }
            File::copy($dbPath, $emergencyBackupPath);

            // Replace current DB with the backup
            File::move($backupFile->getRealPath(), $dbPath);

            return back()->with('success', 'System Restored Successfully! Current state has been replaced with the uploaded backup.');
        } catch (\Exception $e) {
            return back()->with('error', 'Restoration Failed: ' . $e->getMessage());
        }
    }

    /**
     * Generate a MySQL-compatible SQL dump from the current SQLite database.
     */
    public function exportToMysql()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        try {
            $tables = ['users', 'rooms', 'reservations', 'event_bookings', 
                       'garden_bookings', 'content_settings', 'home_events', 
                       'garden_profiles', 'migrations'];
            
            $sqlDump = "-- Rosevilla MySQL Dump\n";
            $sqlDump .= "-- Generated: " . Carbon::now()->toDateTimeString() . "\n";
            $sqlDump .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

            foreach ($tables as $table) {
                // Get data
                if (!Schema::hasTable($table)) continue;
                
                $rows = DB::table($table)->get();
                if ($rows->isEmpty()) continue;

                $sqlDump .= "-- Dumping data for table `$table` --\n";
                
                foreach ($rows as $row) {
                    $cols = array_keys((array)$row);
                    $vals = array_values((array)$row);
                    
                    $colsStr = implode(', ', array_map(fn($c) => "`$c`", $cols));
                    $valsStr = implode(', ', array_map(function($v) {
                        if (is_null($v)) return "NULL";
                        if (is_numeric($v)) return $v;
                        return "'" . addslashes($v) . "'";
                    }, $vals));

                    $sqlDump .= "INSERT INTO `$table` ($colsStr) VALUES ($valsStr);\n";
                }
                $sqlDump .= "\n";
            }

            $sqlDump .= "SET FOREIGN_KEY_CHECKS=1;\n";

            $filename = 'rosevilla-mysql-export-' . Carbon::now()->format('Y-m-d-His') . '.sql';
            
            return response($sqlDump)
                ->header('Content-Type', 'application/sql')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');

        } catch (\Exception $e) {
            return back()->with('error', 'MySQL Export Failed: ' . $e->getMessage());
        }
    }

    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        return view('admin.maintenance.index');
    }

    /**
     * Wipe all transactional data from the system.
     * Restricted to Administrators only.
     */
    public function wipeAllData(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'password' => 'required',
        ]);

        if (!Hash::check($request->password, auth()->user()->password)) {
            return back()->with('error', 'Authentication failed. Data wipe aborted.');
        }

        try {
            // Automatic Backup before wiping
            $dbPath = database_path('database.sqlite');
            $autoBackupPath = storage_path('app/backups/auto-wipe-backup-' . Carbon::now()->format('Y-m-d-His') . '.sqlite');
            if (!File::exists(storage_path('app/backups'))) {
                File::makeDirectory(storage_path('app/backups'), 0755, true);
            }
            File::copy($dbPath, $autoBackupPath);

            DB::transaction(function () use ($request) {
                $deletedItems = [];

                // Delete Room Stays
                if ($request->has('include_rooms')) {
                    Reservation::query()->delete();
                    $deletedItems[] = 'Room Reservations';
                }

                // Delete General Events/Inquiries
                if ($request->has('include_events')) {
                    EventBooking::query()->delete();
                    $deletedItems[] = 'General Events';
                }
                
                // Delete Garden Bookings
                if ($request->has('include_garden')) {
                    \App\Models\GardenBooking::query()->delete();
                    $deletedItems[] = 'Garden Bookings';
                }
                
                if (empty($deletedItems)) {
                    throw new \Exception('No data categories selected for deletion.');
                }

                // Clear system notifications
                DB::table('notifications')->delete();
                
                session()->flash('success', 'System Cleared: ' . implode(', ', $deletedItems) . ' have been permanently removed.');
            });

            return back();
        } catch (\Exception $e) {
            return back()->with('error', 'System Error: Failed to wipe data. ' . $e->getMessage());
        }
    }
}
