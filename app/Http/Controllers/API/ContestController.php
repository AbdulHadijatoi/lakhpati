<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\Comuna;
use App\Models\Contest;
use App\Models\Participant;
use App\Models\Population;
use App\Models\Sector;
use App\Models\TypeOfFault;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContestController extends AppBaseController {
    
    public function getAllContests() {
        $data = Contest::get();

        return $this->sendDataResponse($data);
    }
    
    public function userContests(Request $request) {
        $user = Auth::user();
        $data = Contest::with('participants.user')->whereHas('participants', function($query) use($user) {
                    $query->where('user_id', $user->id);
                })->get();

        return $this->sendDataResponse($data);
    }
    
    public function getTickets() {
        $user = Auth::user();
        $data = Participant::with('user','contest')
                ->where('user_id', $user->id)
                ->get();

        return $this->sendDataResponse($data);
    }
    
    public function contestDetail($contest_id) {
        $data = Contest::with('participants.user')->find($contest_id);

        return $this->sendDataResponse($data);
    }
    
    public function contestTickets($contest_id) {
        $data = Participant::with('user')->where('contest_id',$contest_id)->get();

        $tickets = [];
        foreach ($data as $key => $participant) {
            $tickets[$key]['ticket_number'] = $participant->id;
            $tickets[$key]['name'] = $participant->user?$participant->user->name: '';
            $tickets[$key]['phone'] = $participant->user?$participant->user->phone: '';
        }

        return $this->sendDataResponse($tickets);
    }
    
    public function contestWinners($contest_id) {
        $data = Contest::with('winners.participant.user')->where('id',$contest_id)->first();

        $winners = [];
        $winnersData = $data->winners;
        
        foreach ($winnersData as $key => $winner) {
            $winners[$key]['ticket_number'] = $winner->participant ? $winner->participant->id : '';
            $winners[$key]['is_winner'] = $winner->is_winner;
            // $winners[$key]['is_runner_up'] = $winner->is_runner_up;
            $winners[$key]['name'] = $winner->participant && $winner->participant->user ? $winner->participant->user->name : '';
            $winners[$key]['phone'] = $winner->participant && $winner->participant->user ? $winner->participant->user->phone : '';
        }

        return $this->sendDataResponse($winners);
    }
    
    public function participate(Request $request) {
        $request->validate([
            'contest_id' => 'required|exists:contests,id'
        ]);
    
        $user = Auth::user();
    
        // Check if the user has already participated in the contest
        $existingParticipation = Participant::where('user_id', $user->id)
                                            ->where('contest_id', $request->contest_id)
                                            ->first();
    
        if ($existingParticipation) {
            return $this->sendError('You have already participated in this contest.');
        }
    
        // Create a new participation record
        $participation = Participant::create([
            'user_id' => $user->id,
            'contest_id' => $request->contest_id,
        ]);
        $data = [
            'ticket_number' => $participation->id,
        ];

        return $this->sendDataResponse($data);
    }
    
    
}
