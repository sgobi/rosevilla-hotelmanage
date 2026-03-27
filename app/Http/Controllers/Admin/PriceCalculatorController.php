<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\ContentSetting;
use Illuminate\Http\Request;

class PriceCalculatorController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        $taxRate = ContentSetting::getValue('tax_percentage', 0);
        $gardenRate = ContentSetting::getValue('garden_price_per_day', 30000);

        return view('admin.price-calculator.index', compact('rooms', 'taxRate', 'gardenRate'));
    }

    public function calculate(Request $request)
    {
        $type = $request->type; // room, garden, event
        $taxRate = ContentSetting::getValue('tax_percentage', 0);
        
        $totalPrice = 0;
        $details = [];

        if ($type === 'room') {
            $roomIds = $request->room_ids ?: [];
            $checkIn = \Carbon\Carbon::parse($request->check_in);
            $checkOut = \Carbon\Carbon::parse($request->check_out);
            $days = $checkIn->diffInDays($checkOut) + 1;
            
            $rooms = Room::whereIn('id', $roomIds)->get();
            foreach ($rooms as $room) {
                $roomTotal = $room->price_per_night * $days;
                $totalPrice += $roomTotal;
                $details[] = "{$room->title}: {$room->price_per_night} x {$days} days = {$roomTotal}";
            }
        } elseif ($type === 'garden') {
            $checkIn = \Carbon\Carbon::parse($request->check_in);
            $checkOut = \Carbon\Carbon::parse($request->check_out);
            $days = $checkIn->diffInDays($checkOut) + 1;
            $dailyRate = ContentSetting::getValue('garden_price_per_day', 30000);
            
            $totalPrice = $dailyRate * $days;
            $details[] = "Garden Booking: {$dailyRate} x {$days} days = {$totalPrice}";
            
            $roomIds = $request->room_ids ?: [];
            if (!empty($roomIds)) {
                $rooms = Room::whereIn('id', $roomIds)->get();
                foreach ($rooms as $room) {
                    $roomTotal = $room->price_per_night * $days;
                    $totalPrice += $roomTotal;
                    $details[] = "{$room->title}: {$room->price_per_night} x {$days} days = {$roomTotal}";
                }
            }
        } elseif ($type === 'event') {
            $checkIn = \Carbon\Carbon::parse($request->check_in);
            $checkOut = \Carbon\Carbon::parse($request->check_out);
            $days = $checkIn->diffInDays($checkOut) + 1;

            $totalPrice = (float)$request->base_price;
            if ($totalPrice > 0) {
                $details[] = "Event Base Price: {$totalPrice}";
            }

            $roomIds = $request->room_ids ?: [];
            if (!empty($roomIds)) {
                $rooms = Room::whereIn('id', $roomIds)->get();
                foreach ($rooms as $room) {
                    $roomTotal = $room->price_per_night * $days;
                    $totalPrice += $roomTotal;
                    $details[] = "{$room->title}: {$room->price_per_night} x {$days} days = {$roomTotal}";
                }
            }

            if ($request->include_garden) {
                $dailyRate = ContentSetting::getValue('garden_price_per_day', 30000);
                $gardenTotal = $dailyRate * $days;
                $totalPrice += $gardenTotal;
                $details[] = "Garden Booking: {$dailyRate} x {$days} days = {$gardenTotal}";
            }

            $additionalServices = $request->additional_services ?: [];
            foreach ($additionalServices as $service) {
                if (!empty($service['type']) && !empty($service['price'])) {
                    $price = (float)$service['price'];
                    $totalPrice += $price;
                    $details[] = "Service ({$service['type']}): {$price}";
                }
            }
        }

        $discountPercentage = (float)$request->discount_percentage ?: 0;
        $discountAmount = ($totalPrice * $discountPercentage) / 100;
        $taxableAmount = $totalPrice - $discountAmount;
        $taxAmount = ($taxableAmount * $taxRate) / 100;
        $finalPrice = $taxableAmount + $taxAmount;

        return response()->json([
            'total_price' => $totalPrice,
            'discount_amount' => $discountAmount,
            'taxable_amount' => $taxableAmount,
            'tax_amount' => $taxAmount,
            'final_price' => $finalPrice,
            'details' => $details,
            'tax_rate' => $taxRate
        ]);
    }
}
