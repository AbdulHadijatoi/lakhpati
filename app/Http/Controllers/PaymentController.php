<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $payments = Payment::with(['user','contest'])
                    // ->when($search, function ($query) use ($search) {
                    //     $query->where('winner_prize', 'like', "%$search%")
                    //           ->orWhere('runner_up_prize', 'like', "%$search%");
                    // })
                    ->paginate($perPage);

        return view('admin.payments.index', compact('payments'));
    }

}
