<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function index()
    {
        return view('leave-request');
    }

    public function store(Request $request)
    {
        return response()->json([
            'message' => 'Leave request submitted'
        ]);
    }
}