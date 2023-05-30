<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    public function index()
    {
        if (Auth::user()->market_id) {
            return back()->with('error', "Access dinied! Unauthorized user.");
        }
        $payments = Payment::all();

        return view('payments.index', compact('payments'));
    }

    public function managerIndex()
    {

        $payments = Payment::where('market_id', Auth::user()->market_id)->get();

        return view('payments.manager_index', compact('payments'));
    }


    public function postPayment(Request $request)
    {
        try {
            $attributes = $this->validate($request, [
                "customer_id" => 'required',
                "date" => 'required',
                "amount" => 'required',
                'market_id' => 'required',
                'month' => 'required',
                'year' => 'required',
                "receipt_number" => 'required',
            ]);
            if ($request->frame_id) {
                $attributes['frame_id'] = $request->frame_id;
            }
            if ($request->stall_id) {
                $attributes['stall_id'] = $request->stall_id;
            }

            $payment = Payment::create($attributes);

            return ['status' => true, 'data' => $payment];
        } catch (\Throwable $th) {
            return ['status' => false, 'data' => $th->getMessage()];
        }
    }
    public function putPayment(Request $request, Payment $payment)
    {
        try {
            $attributes = $this->validate($request, [
                'date' => 'required',
                'amount' => 'required',
                'receipt_number' => 'required',
                'vehicle_id' => 'required',
                'sticker_id' => 'required',
                'business_id' => 'required',
            ]);

            $payment->update($attributes);

            return redirect()->back()->with('success', 'You have successful edited payment');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
