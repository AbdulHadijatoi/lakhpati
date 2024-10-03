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
        $data = Contest::whereHas('participants', function($query) use($user) {
                    $query->where('user_id', $user->id);
                })->get();

        return $this->sendDataResponse($data);
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
        Participant::create([
            'user_id' => $user->id,
            'contest_id' => $request->contest_id,
        ]);
    
        return $this->sendSuccess('Success!');
    }
    
    
}
