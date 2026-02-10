<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceFee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = ServiceFee::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('car_segment', 'like', "%{$search}%")
                  ->orWhere('full_report_fee', 'like', "%{$search}%")
                  ->orWhere('booking_amount', 'like', "%{$search}%");
            });
        }

        if ($status !== null && in_array($status, ['0', '1'])) {
            $query->where('status', $status);
        }

        $sortBy = $request->input('sort_by', 'id');
        $sortDirection = $request->input('sort_direction', 'asc');
        $allowedSorts = ['id', 'car_segment', 'full_report_fee', 'booking_amount', 'status', 'created_at'];

        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'id';
        }
        $sortDirection = strtolower($sortDirection) === 'asc' ? 'asc' : 'desc';

        $fees = $query->orderBy($sortBy, $sortDirection)->paginate(10);

        $fees->appends(array_merge($request->query(), [
            'search' => $search,
            'status' => $status,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection
        ]));

        return view('admin.service-fees.index', compact('fees', 'sortBy', 'sortDirection', 'search', 'status'));
    }

    public function create()
    {
        return view('admin.service-fees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'car_segment'     => ['required', 'string', 'max:255', Rule::unique('service_fees', 'car_segment')],
            'full_report_fee' => ['required', 'numeric', 'min:0', 'max:99999'],
            'booking_amount'  => ['required', 'numeric', 'min:0', 'max:99999'],
            'status'          => ['nullable'], 
        ]);

        // Logic fix: Check the actual value since hidden input always sends the key
        $validatedData['status'] = $request->input('status') == '1' ? 1 : 0;

        $serviceFee = ServiceFee::create($validatedData);

        return redirect()->route('admin.service-fees.show', $serviceFee)
            ->with('success', 'Service fee created successfully for ' . $validatedData['car_segment']);
    }

    public function show(ServiceFee $serviceFee)
    {
        return view('admin.service-fees.show', compact('serviceFee'));
    }

    public function edit(ServiceFee $serviceFee)
    {
        return view('admin.service-fees.edit', compact('serviceFee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceFee $serviceFee)
    {
        $validatedData = $request->validate([
            'car_segment'     => [
                'required', 
                'string', 
                'max:255', 
                Rule::unique('service_fees', 'car_segment')->ignore($serviceFee->id)
            ],
            'full_report_fee' => ['required', 'numeric', 'min:0', 'max:99999'],
            'booking_amount'  => ['required', 'numeric', 'min:0', 'max:99999'],
            'status'          => ['nullable'],
        ]);

        // Logic fix: Use boolean conversion for the incoming string "0" or "1"
        $validatedData['status'] = $request->input('status') == '1' ? 1 : 0;

        $serviceFee->update($validatedData);

        return redirect()->route('admin.service-fees.show', $serviceFee)
            ->with('success', 'Service fee updated successfully: ' . $serviceFee->car_segment);
    }

    public function destroy(ServiceFee $serviceFee)
    {
        try {
            $segmentName = $serviceFee->car_segment;
            $serviceFee->delete();
            
            return redirect()->route('admin.service-fees.index')
                ->with('success', 'Service fee for ' . $segmentName . ' deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.service-fees.index')
                ->with('error', 'Failed to delete service fee: ' . $e->getMessage());
        }
    }
}