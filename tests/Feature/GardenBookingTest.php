<?php

namespace Tests\Feature;

use App\Models\ContentSetting;
use App\Models\GardenBooking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GardenBookingTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        
        // Setup default content settings needed for Garden Bookings
        ContentSetting::updateOrCreate(['key' => 'garden_price_per_day'], ['value' => 30000]);
        ContentSetting::updateOrCreate(['key' => 'tax_percentage'], ['value' => 10]);
    }

    public function test_guest_can_submit_garden_booking_successfully()
    {
        $response = $this->from(route('home') . '#garden')->post(route('garden.store'), [
            'guest_name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '0712345678',
            'check_in' => now()->addDays(5)->format('Y-m-d'),
            'check_out' => now()->addDays(7)->format('Y-m-d'), 
            'guests' => 50,
            'special_requirements' => 'Need evening lighting setup'
        ]);

        $response->assertRedirect(route('home') . '#garden');
        $response->assertSessionHas('garden_success');

        $this->assertDatabaseHas('garden_bookings', [
            'guest_name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'guests' => 50,
            'status' => 'pending'
        ]);
        
        // 3 days (5th, 6th, 7th) * 30000 = 90000
        $booking = GardenBooking::first();
        $this->assertEquals(90000, $booking->total_price);
        $this->assertEquals(9000, $booking->tax_amount); // 10% tax
        $this->assertEquals(99000, $booking->final_price);
    }

    public function test_overlapping_garden_booking_dates_are_rejected()
    {
        // Create an existing booking
        GardenBooking::create([
            'guest_name' => 'Existing Guest',
            'email' => 'existing@example.com',
            'check_in' => now()->addDays(5)->format('Y-m-d'),
            'check_out' => now()->addDays(10)->format('Y-m-d'),
            'guests' => 100,
            'status' => 'approved' // Active booking
        ]);

        // Attempt overlapping booking (partially overlaps)
        $response = $this->from(route('home') . '#garden')->post(route('garden.store'), [
            'guest_name' => 'New Guest',
            'email' => 'new@example.com',
            'check_in' => now()->addDays(8)->format('Y-m-d'),
            'check_out' => now()->addDays(12)->format('Y-m-d'),
            'guests' => 50,
        ]);

        $response->assertRedirect(route('home') . '#garden');
        $response->assertSessionHas('garden_error');

        $this->assertDatabaseCount('garden_bookings', 1); // No new booking created
    }

    public function test_admin_can_view_and_approve_garden_booking()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $booking = GardenBooking::create([
            'guest_name' => 'Pending Guest',
            'email' => 'pending@example.com',
            'check_in' => now()->addDays(15)->format('Y-m-d'),
            'check_out' => now()->addDays(16)->format('Y-m-d'),
            'guests' => 30,
            'status' => 'pending'
        ]);

        // View Index
        $response = $this->actingAs($admin)->get(route('admin.garden-bookings.index'));
        $response->assertStatus(200);
        $response->assertSee('Pending Guest');

        // Approve Booking
        $updateResponse = $this->from(route('admin.garden-bookings.show', $booking))->actingAs($admin)->put(route('admin.garden-bookings.update', $booking), [
            'status' => 'approved',
            'advance_amount' => 10000,
        ]);

        $updateResponse->assertRedirect(route('admin.garden-bookings.show', $booking));
        
        $booking->refresh();
        $this->assertEquals('approved', $booking->status);
        $this->assertEquals(10000, $booking->advance_amount);
    }
}
