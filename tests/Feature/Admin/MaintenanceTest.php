<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Reservation;
use App\Models\EventBooking;
use App\Models\GardenBooking;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MaintenanceTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $staff;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $this->staff = User::create([
            'name' => 'Staff User',
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);
    }

    public function test_admin_can_access_maintenance_page()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.maintenance.index'));
        $response->assertStatus(200);
    }

    public function test_staff_cannot_access_maintenance_page()
    {
        $response = $this->actingAs($this->staff)->get(route('admin.maintenance.index'));
        $response->assertStatus(403);
    }

    public function test_admin_can_download_sqlite_backup()
    {
        Storage::fake('local');
        
        $response = $this->actingAs($this->admin)->get(route('admin.maintenance.backup'));
        
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.sqlite3');
    }

    public function test_admin_can_export_to_mysql()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.maintenance.export-mysql'));
        
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/sql');
        $response->assertSee('SET FOREIGN_KEY_CHECKS=0');
    }

    public function test_admin_can_wipe_specific_data_categories()
    {
        // Setup data
        $room = Room::create([
            'title' => 'Room 101', 
            'slug' => 'room-101',
            'price_per_night' => 100, 
            'is_active' => true
        ]);
        
        Reservation::create([
            'room_id' => $room->id,
            'guest_name' => 'Guest 1',
            'check_in' => now()->format('Y-m-d'),
            'check_out' => now()->addDay()->format('Y-m-d'),
            'total_price' => 100,
            'status' => 'confirmed',
            'phone' => '1234567890',
            'email' => 'guest1@example.com'
        ]);

        EventBooking::create([
            'customer_name' => 'Event Guest',
            'customer_email' => 'event@example.com',
            'customer_phone' => '1234567890',
            'event_type' => 'Hall Only',
            'event_date' => now()->format('Y-m-d'),
            'start_time' => '08:00',
            'end_time' => '16:00',
            'guests' => 50,
            'status' => 'pending',
            'total_price' => 500
        ]);

        GardenBooking::create([
            'guest_name' => 'Garden Guest',
            'email' => 'garden@example.com',
            'phone' => '1234567890',
            'check_in' => now()->format('Y-m-d'),
            'check_out' => now()->addDay()->format('Y-m-d'),
            'guests' => 10,
            'status' => 'pending',
            'total_price' => 1000,
            'tax_amount' => 100,
            'final_price' => 1100
        ]);

        $this->assertDatabaseCount('reservations', 1);
        $this->assertDatabaseCount('event_bookings', 1);
        $this->assertDatabaseCount('garden_bookings', 1);

        // Wipe only rooms and events
        $response = $this->actingAs($this->admin)->post(route('admin.maintenance.wipe-all'), [
            'password' => 'password',
            'include_rooms' => '1',
            'include_events' => '1',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseCount('reservations', 0);
        $this->assertDatabaseCount('event_bookings', 0);
        $this->assertDatabaseCount('garden_bookings', 1); // Preserved
        
        // Check session message
        $this->assertStringContainsString('Room Reservations', session('success'));
        $this->assertStringContainsString('General Events', session('success'));
    }

    public function test_wipe_requires_correct_password()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.maintenance.wipe-all'), [
            'password' => 'wrong-password',
            'include_rooms' => '1',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertStringContainsString('Authentication failed', session('error'));
    }

    public function test_wipe_requires_at_least_one_category()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.maintenance.wipe-all'), [
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertStringContainsString('No data categories selected', session('error'));
    }
}
