<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarInspection;
use Illuminate\Http\Request;

class CarInspectionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = CarInspection::with('payments');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_mobile', 'like', "%{$search}%")
                  ->orWhere('vehicle_name', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $inspections = $query->latest()->paginate(15);

        return view('admin.car-inspections.index', compact('inspections', 'search', 'status'));
    }

    // CHANGE: Changed $inspection to $car_inspection to match Laravel's auto-binding
    public function show(CarInspection $car_inspection)
    {
        $car_inspection->load('payments');
        
        // We pass it to the view as 'inspection' so you don't have to change your Blade file
        return view('admin.car-inspections.show', ['inspection' => $car_inspection]);
    }

    // CHANGE: Changed $inspection to $car_inspection
    public function destroy(CarInspection $car_inspection)
    {
        $car_inspection->delete();
        return redirect()->route('admin.car-inspections.index')->with('success', 'Inspection record deleted.');
    }
}