<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OvertimeController extends Controller
{
    
    public function index()
    {
        $overtimes = [
            ['date'=>'2026-02-04','duration'=>'3h',   'description'=>'Stock take and inventory audit','status'=>'pending'],
            ['date'=>'2026-01-28','duration'=>'1.5h',  'description'=>'Kitchen deep clean after closing.','status'=>'approved'],
        ];
        $thisMonthOT = '12.5';

        return view('staff.overtime', compact('overtimes', 'thisMonthOT'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'work_date' => 'required|date',
            'duration'  => 'required|numeric|min:0.5|max:24',
            'reason'    => 'required|string|max:1000',
            'proof'     => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        return response()->json(['success'=>true,'message'=>'Overtime request submitted.']);
    }
}