<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class BookingController extends Controller
{

    public function index(){
        $vehilces = Vehicle::all();
        return view('form',compact('vehilces'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'vehicle' => 'required|string',
            'booking_type' => 'required|in:full-day,half-day',
            'booking_date' => 'required|date',
            'booking_shift' => 'required_if:booking_type,half-day|in:morning,evening',
        ]);

        // Check if the vehicle is available for booking
        $existingBooking = Booking::where('vehicle', $validatedData['vehicle'])
            ->where('booking_date', $validatedData['booking_date'])
            ->first();

        if ($existingBooking) {
            // Case 1: Vehicle cannot be booked for a full day if it is booked for a half day on the same day
            if ($validatedData['booking_type'] === 'full-day' && $existingBooking->booking_type === 'half-day') {
                return redirect()->back()->withErrors(['vehicle' => 'Vehicle is already booked for a half day on the selected date.']);
            }

            // Case 2: If a vehicle is booked for a half day, it cannot be booked for a full day on the same day
            if ($validatedData['booking_type'] === 'full-day' && $existingBooking->booking_type === 'full-day') {
                return redirect()->back()->withErrors(['vehicle' => 'Vehicle is already booked for a full day on the selected date.']);
            }

            // Case 3: If a vehicle is booked for a half day morning, it can be booked for a half day evening on the same day
            if (
                $validatedData['booking_type'] === 'half-day' &&
                $existingBooking->booking_type === 'half-day' &&
                $existingBooking->booking_shift === 'morning' &&
                $validatedData['booking_shift'] === 'evening'
            ) {
                // Allow the booking
            } else {
                return redirect()->back()->withErrors(['vehicle' => 'Vehicle is already booked on the selected date.']);
            }
        }

        // Create a new booking record
        $booking = new Booking();
        $booking->name = $validatedData['name'];
        $booking->email = $validatedData['email'];
        $booking->phone = $validatedData['phone'];
        $booking->vehicle = $validatedData['vehicle'];
        $booking->booking_type = $validatedData['booking_type'];
        $booking->booking_date = $validatedData['booking_date'];
        $booking->booking_shift = $validatedData['booking_shift'] ?? null;
        $booking->save();

        return redirect()->back()->with('success', 'Vehicle is  booked on the selected date successfully.');
    }
}
