<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\Participant;
use App\Models\Winner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContestController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $contests = Contest::with('contestDetails')
                    ->when($search, function ($query) use ($search) {
                        $query->where('winner_prize', 'like', "%$search%");
                    })
                    ->paginate($perPage);

        return view('admin.contests.list', compact('contests'));
    }

    public function show($id)
    {
        $contest = Contest::with("contestDetails")->find($id);
        abort_if(!$contest, 404, "Contest not found");

        return view('admin.contests.show', compact('contest'));
    }

    public function create()
    {
        return view('admin.contests.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'winner_prize' => 'required|string',
            'status' => 'required|string',
            'second_winner_prize' => 'required|integer',
            'third_winner_prize' => 'required|integer',
            'total_winners' => 'required|integer',
            'total_second_winners' => 'required|integer',
            'total_third_winners' => 'required|integer',
            'entry_fee' => 'required|numeric',
            'draw_date' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Fields for the contests table
        $contestData = $request->only([
            'title', 'winner_prize', 'status', 'description', 
            'draw_date', 'second_winner_prize', 'third_winner_prize'
        ]);

        // Fields for the contest_details table
        $contestDetailsData = $request->only([
            'total_winners', 'start_date', 'end_date', 'entry_fee', 
            'total_second_winners', 'total_third_winners'
        ]);

        // Create Contest
        $contest = Contest::create($contestData);

        // Create related ContestDetails
        $contest->contestDetails()->create($contestDetailsData);

        return redirect()->route('listContests')->with('success', 'Contest created successfully!');
    }



    public function edit($id)
    {
        $contest = Contest::with("contestDetails")->find($id);
        abort_if(!$contest, 404, "Contest not found");

        return view('admin.contests.edit', compact('contest'));
    }

    public function update(Request $request, $id)
    {
        $contest = Contest::with("contestDetails")->find($id);
        abort_if(!$contest, 404, "Contest not found");

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'winner_prize' => 'required|string',
            'status' => 'required|string',
            'second_winner_prize' => 'required|integer',
            'third_winner_prize' => 'required|integer',
            'total_winners' => 'required|integer',
            'total_second_winners' => 'required|integer',
            'total_third_winners' => 'required|integer',
            'entry_fee' => 'required|numeric',
            'draw_date' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Fields for the contests table
        $contestData = $request->only([
            'title', 'winner_prize', 'status', 'description', 
            'draw_date', 'second_winner_prize', 'third_winner_prize'
        ]);

        // Fields for the contest_details table
        $contestDetailsData = $request->only([
            'total_winners', 'start_date', 'end_date', 'entry_fee', 
            'total_second_winners', 'total_third_winners'
        ]);

        // Update Contest
        $contest->update($contestData);

        // Update related ContestDetails
        if ($contest->contestDetails) {
            $contest->contestDetails->update($contestDetailsData);
        } else {
            // If no existing details, create new
            $contest->contestDetails()->create($contestDetailsData);
        }

        return redirect()->route('listContests')->with('success', 'Contest updated successfully!');
    }


    public function confirmDelete($id)
    {
        $contest = Contest::with("contestDetails")->find($id);
        abort_if(!$contest, 404, "Contest not found");

        return view('admin.contests.confirm-delete', compact('contest'));
    }

    public function destroy($id)
    {
        $contest = Contest::find($id);
        abort_if(!$contest, 404, "Contest not found");

        $contest->contestDetails()->delete();
        $contest->delete();

        return redirect()->route('listContests')->with('success', 'Contest deleted successfully!');
    }
}
