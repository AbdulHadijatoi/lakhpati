<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\Participant;
use App\Models\Winner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WinnerController extends Controller
{
    public function index(Request $request, $contest_id)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $winners = Winner::with(['contest','participant'])
                    ->when($search, function ($query) use ($search) {
                        $query->whereHas('participant',function($q) use ($search) {
                            $q->whereHas('user', function($query) use ($search) {
                                $query->whereHas('name', 'like', "%$search%");
                            });
                        });
                    })
                    ->where('contest_id', $contest_id)
                    ->paginate($perPage);

        return view('admin.winners.index', compact('winners'));
    }

    public function announceWinners($contestId)
    {

        $contest = Contest::with('contestDetails')->findOrFail($contestId);
        $totalWinners = $contest->contestDetails->total_winners;
        $totalSecondWinners = $contest->contestDetails->total_second_winners;
        $totalThirdWinners = $contest->contestDetails->total_third_winners;

        // Check if winners have already been announced
        if ($contest->winners_announced) {
            return redirect()->back()->with('error', 'Winners have already been announced for this contest.');
        }

        // Get all eligible participants for this contest
        $participants = Participant::where('contest_id', $contestId)->inRandomOrder()->get();

        if ($participants->count() < ($totalWinners + $totalSecondWinners + $totalThirdWinners)) {
            return redirect()->back()->with('error', 'Not enough participants for the total winners.');
        }

        // Assign first, second, and third winners
        $firstWinners = $participants->take($totalWinners);
        $secondWinners = $participants->skip($totalWinners)->take($totalSecondWinners);
        $thirdWinners = $participants->skip($totalWinners + $totalSecondWinners)->take($totalThirdWinners);

        foreach ($firstWinners as $winner) {
            Winner::create([
                'contest_id' => $contestId,
                'participant_id' => $winner->id,
                'is_winner' => true,
            ]);
        }

        foreach ($secondWinners as $winner) {
            Winner::create([
                'contest_id' => $contestId,
                'participant_id' => $winner->id,
                'is_second_winner' => true,
            ]);
        }

        foreach ($thirdWinners as $winner) {
            Winner::create([
                'contest_id' => $contestId,
                'participant_id' => $winner->id,
                'is_third_winner' => true,
            ]);
        }

        // Update contest status to "closed" and set winners_announced to true
        $contest->update(['status' => 'closed', 'winners_announced' => 1]);

        return redirect()->back()->with('success', 'Winners have been announced successfully!');
    }
}
