<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContestController extends AppBaseController {
    
    public function index(Request $request) {
        return view('admin.contests.list');
    }
    
    public function view($id = null) {
        return view('admin.contests.view');
    }

    public function create(Request $request) {
        return view('admin.contests.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'winner_prize' => 'required',
            'runner_up_prize' => 'required',
            'total_winners' => 'required|integer',
            'total_runner_ups' => 'required|integer',
            'participants_limit' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'entry_fee' => 'required|numeric',
        ]);

        // Create contest
        $contest = Contest::create([
            'winner_prize' => $request->winner_prize,
            'runner_up_prize' => $request->runner_up_prize,
        ]);

        // Create contest details
        $contest->contestDetails()->create([
            'total_winners' => $request->total_winners,
            'total_runner_ups' => $request->total_runner_ups,
            'participants_limit' => $request->participants_limit,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'entry_fee' => $request->entry_fee,
        ]);

        // Redirect back with success message or to a different route
        return redirect()->route('listContests')->with('success', 'Contest created successfully!');
    }
    
    public function edit($id = null) {
        return view('admin.contests.edit');
    }
    
    public function update(Request $request, $id = null) {
        return view('admin.contests.list');
    }
    
    public function delete($id = null) {
        return view('admin.contests.list');
    }
}