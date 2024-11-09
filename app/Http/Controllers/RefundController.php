<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Refund;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RefundController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $refunds = Refund::with('user')->paginate($perPage);
        return view('admin.refunds.index', compact('refunds'));
    }

    public function refundUser($userId)
    {
        $user = User::findOrFail($userId);

        DB::transaction(function () use ($user) {
            $totalRefundAmount = $user->participants()
                ->where('status', 1)
                ->whereNull('deleted_at')
                ->whereDoesntHave('winners')
                ->sum('contest.entry_price'); // Adjust based on actual contest price field

            // Create a refund record
            $refund = Refund::create([
                'user_id' => $user->id,
                'total_refund_amount' => $totalRefundAmount,
                'refund_status' => 'approved',
                'refund_date' => now(),
            ]);

            // Soft delete eligible participation records
            $user->participants()
                ->where('status', 1)
                ->whereNull('deleted_at')
                ->whereDoesntHave('winners')
                ->update(['deleted_at' => now()]);
        });

        return redirect()->route('refunds.index')->with('success', 'Refund approved and participation records soft deleted.');
    }

    public function searchUserForRefund(Request $request)
    {
        
        $phone = $request->input('phone');
        $user = User::where('phone', $phone)->first();

        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => 'User not found.'
            ], 422);
        }



        $minParticipationLimit = Setting::where('key', 'min_participation_limit_for_refund')->value('value');
        $totalParticipations = Participant::where('user_id', $user->id)
                                        ->where('status', 1)
                                        ->whereNull('deleted_at')
                                        ->count();

        $totalContests = Participant::where('user_id', $user->id)
                                    ->whereNull('deleted_at')
                                    ->distinct('contest_id')
                                    ->count();

        // Calculate the total refund amount by summing up entry prices for active participations
        $totalRefundAmount = Participant::where('user_id', $user->id)
                                        ->where('status', 1)
                                        ->whereNull('deleted_at')
                                        ->sum('entry_price');

        $eligibleForRefund = $totalParticipations >= $minParticipationLimit;
        
        return response()->json([
            'status' => 1,
            'user' => $user,
            'totalParticipations' => $totalParticipations,
            'totalContests' => $totalContests,
            'eligibleForRefund' => $eligibleForRefund,
            'totalRefundAmount' => $totalRefundAmount,
            'minParticipationLimit' => $minParticipationLimit
        ]);
    }

    public function store(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Retrieve the minimum participation limit setting
        $minParticipationLimit = Setting::where('key', 'min_participation_limit_for_refund')->value('value');

        // Count the user's total participations
        $totalParticipations = Participant::where('user_id', $user->id)
                                        ->where('status', 1)
                                        ->whereNull('deleted_at')
                                        ->count();

        // Check eligibility for refund
        if ($totalParticipations < $minParticipationLimit) {
            return redirect()->back()->with('error', 'User is not eligible for a refund.');
        }

        // Calculate the total refund amount by summing up entry prices for active participations
        $totalRefundAmount = Participant::where('user_id', $user->id)
                                        ->where('status', 1)
                                        ->whereNull('deleted_at')
                                        ->sum('entry_price');

        $totalContests = Participant::where('user_id', $user->id)
                                        ->whereNull('deleted_at')
                                        ->distinct('contest_id')
                                        ->count();

        // Create the refund record
        $refund = new Refund();
        $refund->user_id = $user->id;
        $refund->total_refund_amount = $totalRefundAmount;
        $refund->total_contests = $totalContests;
        $refund->total_participations = $totalParticipations;
        $refund->refund_status = 'approved'; // Initial status
        $refund->refund_date = now()->format('Y-m-d'); // Initial status
        $refund->save();

        // Soft delete the participant records
        Participant::where('user_id', $user->id)
                ->whereNull('deleted_at')
                ->update(['deleted_at' => now()]);

        return redirect()->back()->with('success', 'Refund approved and participant records soft-deleted.');
    }

}
