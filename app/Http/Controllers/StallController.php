<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Stall;
use App\Models\Market;
use App\Models\StallIn;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class StallController extends Controller
{

    public function index()
    {
        if (Auth::user()->market_id) {
            return back()->with('error', "Access dinied! Unauthorized user.");
        }
        $stalls = Stall::all();

        return view('stalls.index', compact('stalls'));
    }


    public function showStall(Stall $stall)
    {
        return view('stalls.show', compact('stall'));
    }


    public function postStall(Request $request)
    {
        $newCode = $request->newCode;
        try {
            $market = Market::find($request->market_id);
            for ($i = 0; $i < $request->count; $i++) {

                $newRequest = $request->merge(['code' => $newCode]);

                $attributes = $this->validate($newRequest, [
                    'code' => ['required', 'unique:stalls,code,NULL,id,deleted_at,NULL,market_id,' . $request->input('market_id')],
                    'type' => 'required',
                    'location' => 'required',
                    'market_id' => 'required',
                ]);

                $attributes['size'] = $request->size ?? "";
                $attributes['price'] = $market->stall_price;

                $stall = Stall::create($attributes);

                $market->stalls()->save($stall);
                $newCode++;
            }
            return back()->with('success', "Stalls added successfully");
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors())->withInput()->with('addStallCollapse', true);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }


    public function putStall(Request $request, Stall $stall)
    {
        try {
            $market = Market::find($request->market_id);
            $attributes = $this->validate($request, [
                'code' => 'required | unique:stalls,code,' . $stall->id,
                'location' => 'required',
                'type' => 'required',
            ]);
            $attributes['business'] = $request->business ?? $stall->business;
            $attributes['size'] = $request->size ?? $stall->size;
            $attributes['price'] = $market->stall_price;

            $stall->update($attributes);

            return back()->with('success', "Stall edited successfully");
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors())->withInput()->with('editStallModal', true);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }
    public function renewStall(Request $request)
    {
        $months = $request->months;
        foreach ($months as $month) {

            try {
                $stall = Stall::find($request->stall_id);
                $customer = Customer::find($request->customer_id);
                $paymentRequest = new Request([
                    "stall_id" => $request->stall_id,
                    "customer_id" => $request->customer_id,
                    "date" => now(),
                    "amount" => $stall->price,
                    'market_id' => $stall->market_id,
                    'month' => $month,
                    'year' => $request->year,
                    "receipt_number" => $request->receipt_number,
                ]);
                $paymentController = new PaymentController();
                $payment = null;
                $paymentResponse = $paymentController->postStallPayment($paymentRequest);

                if ($paymentResponse['status'] == true) {
                    $payment = $paymentResponse['data'];
                    $customer->payments()->save($payment);
                    $stall->payments()->save($payment);
                    $stall->market->payments()->save($payment);
                } else {
                    return back()->with('error', $paymentResponse['data'])->withInput();
                }
                $stallInAttr = [
                    'entry_date'  => now(),
                    "stall_id" => $stall->id,
                    "customer_id" => $customer->id,
                    'user_id'  => Auth::user()->id,
                    'business'  => $request->business ?? "",
                    "payment_id" => $payment->id,
                ];

                $stallIn = StallIn::create($stallInAttr);
                $payment->stallIn()->save($stallIn);
                $user=User::find(Auth::user()->id);
                $user->stallIns()->save($stallIn);
            } catch (\Throwable $th) {
                return back()->with('error', $th->getMessage());
            }
        }
        return back()->with('success', 'Payment recorded successful');
    }


    public function deleteStall(Stall $stall)
    {
        $stall->delete();

        return back()->with('success', 'Stall deleted successful');
    }
}
