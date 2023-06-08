<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


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

    public function postFramePayment(Request $request)
    {
        $customerName = Customer::find($request->customer_id)->first_name . ' ' . Customer::find($request->customer_id)->middle_name . ' ' . Customer::find($request->customer_id)->last_name;
        try {
            $attributes = $this->validate($request, [
                "customer_id" => 'required',
                "date" => 'required',
                "amount" => 'required',
                'market_id' => 'required',
                'month' => 'required',
                'year' => 'required',
                "receipt_number" => 'required',
                'frame_id' => [
                    Rule::unique('payments')
                        ->where(function ($query) use ($request) {
                            return $query->where('customer_id', $request->customer_id)
                                ->where('year', $request->year)
                                ->where('month', $request->month);
                        })
                        ->ignore('id'), // Add the ID of the current payment being updated (if applicable)
                ],
            ]);

            if ($request->frame_id) {
                $attributes['frame_id'] = $request->frame_id;
            }

            $payment = Payment::create($attributes);

            return ['status' => true, 'data' => $payment];
        } catch (\Illuminate\Validation\ValidationException $exception) {
            $errors = $exception->validator->errors();

            if ($errors->has('frame_id')) {
                return ['status' => false, 'data' => 'The frame is already paid for ' . $request->month . ' ' . $request->year . ' by customer: ' . $customerName];
            }

            return ['status' => false, 'data' => $errors->all()];
        } catch (\Throwable $th) {
            return ['status' => false, 'data' => $th->getMessage()];
        }
    }
    public function postStallPayment(Request $request)
    {
        $customerName = Customer::find($request->customer_id)->first_name . ' ' . Customer::find($request->customer_id)->middle_name . ' ' . Customer::find($request->customer_id)->last_name;
        try {
            $attributes = $this->validate($request, [
                "customer_id" => 'required',
                "date" => 'required',
                "amount" => 'required',
                'market_id' => 'required',
                'month' => 'required',
                'year' => 'required',
                "receipt_number" => 'required',
                'stall_id' => [
                    Rule::unique('payments')
                        ->where(function ($query) use ($request) {
                            return $query->where('customer_id', $request->customer_id)
                                ->where('year', $request->year)
                                ->where('month', $request->month);
                        })
                        ->ignore('id'), // Add the ID of the current payment being updated (if applicable)
                ],
            ]);

            if ($request->stall_id) {
                $attributes['stall_id'] = $request->stall_id;
            }

            $payment = Payment::create($attributes);

            return ['status' => true, 'data' => $payment];
        } catch (\Illuminate\Validation\ValidationException $exception) {
            $errors = $exception->validator->errors();

            if ($errors->has('stall_id')) {
                return ['status' => false, 'data' => 'The stall is already paid for ' . $request->month . ' ' . $request->year . ' by customer: ' . $customerName];
            }

            return ['status' => false, 'data' => $errors->all()];
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
