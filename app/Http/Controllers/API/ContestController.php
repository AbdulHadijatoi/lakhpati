<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\Comuna;
use App\Models\Contest;
use App\Models\Population;
use App\Models\Sector;
use App\Models\TypeOfFault;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

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
    
}
