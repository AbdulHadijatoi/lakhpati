<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ParticipantController extends Controller
{
    public function index(Request $request)
    {
        $participants = Participant::with('user', 'contest.contestDetails')->paginate(10);

        return view('admin.participants.index', compact('participants'));
    }

}
