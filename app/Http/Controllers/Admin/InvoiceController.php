<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentSetting;
use App\Models\Reservation;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show(Reservation $reservation)
    {
        $content = ContentSetting::pluck('value', 'key');
        
        // Calculate nights logic for display if needed
        $nights = $reservation->check_in->diffInDays($reservation->check_out);
        $nights = $nights > 0 ? $nights : 1;

        return view('admin.invoices.show', compact('reservation', 'content', 'nights'));
    }
}
