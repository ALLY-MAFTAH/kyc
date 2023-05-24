<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }
    public function postPayment(Request $request)
    {
        try {
            $attributes = $this->validate($request, [
                "frame_id" => 'required',
                "customer_id" => 'required',
                "date" => 'required',
                "amount" => 'required',
                'market_id' => 'required',
                'month' => 'required',
                'year' => 'required',
                "receipt_number" => 'required',
            ]);

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

            alert()->success('You have successful edited payment');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
