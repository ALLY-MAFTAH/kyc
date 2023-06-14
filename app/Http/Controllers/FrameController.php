<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Frame;
use App\Models\FrameIn;
use App\Models\Market;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class FrameController extends Controller
{

    public function index()
    {
        if (Auth::user()->market_id) {
            return back()->with('error', "Access dinied! Unauthorized user.");
        }
        $frames = Frame::all();

        return view('frames.index', compact('frames'));
    }


    public function showFrame(Frame $frame)
    {
        return view('frames.show', compact('frame'));
    }


    public function postFrame(Request $request)
    {
        $newCode = $request->newCode;
        try {
            $market = Market::find($request->market_id);
            for ($i = 0; $i < $request->count; $i++) {

                $newRequest = $request->merge(['code' => $newCode]);

                $attributes = $this->validate($newRequest, [
                    'code' => ['required', 'unique:frames,code,NULL,id,deleted_at,NULL,market_id,' . $request->input('market_id')],
                    'location' => 'required',
                    'market_id' => 'required',
                ]);

                $attributes['size'] = $request->size ?? "";
                $attributes['price'] = $market->frame_price;

                $frame = Frame::create($attributes);

                $market->frames()->save($frame);
                $newCode++;
            }
            return back()->with('success', "Frames added successfully");
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors())->withInput()->with('addFrameCollapse', true);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }


    public function putFrame(Request $request, Frame $frame)
    {
        try {
            $market = Market::find($request->market_id);
            $attributes = $this->validate($request, [
                'code' => 'required | unique:frames,code,' . $frame->id,
                'location' => 'required',
            ]);

            $attributes['business'] = $request->business ?? $frame->business;
            $attributes['size'] = $request->size ?? $frame->size;
            $attributes['price'] =  $market->frame_price;

            $frame->update($attributes);

            return back()->with('success', "Frame edited successfully");
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors())->withInput()->with('editFrameModal', true);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }
    public function renewFrame(Request $request)
    {
        $months = $request->months;
        foreach ($months as $month) {

            try {
                $frame = Frame::find($request->frame_id);
                $customer = Customer::find($request->customer_id);
                $paymentRequest = new Request([
                    "frame_id" => $request->frame_id,
                    "customer_id" => $request->customer_id,
                    "date" => now(),
                    "amount" => $frame->price,
                    'market_id' => $frame->market_id,
                    'month' => $month,
                    'year' => $request->year,
                    "receipt_number" => $request->receipt_number,
                ]);
                $paymentController = new PaymentController();
                $payment = null;
                $paymentResponse = $paymentController->postFramePayment($paymentRequest);

                if ($paymentResponse['status'] == true) {
                    $payment = $paymentResponse['data'];
                    $customer->payments()->save($payment);
                    $frame->payments()->save($payment);
                    $frame->market->payments()->save($payment);
                } else {
                    return back()->with('error', $paymentResponse['data'])->withInput();
                }
                $frameInAttr = [
                    'entry_date'  => now(),
                    "frame_id" => $frame->id,
                    "customer_id" => $customer->id,
                    'user_id'  => Auth::user()->id,
                    'business'  => $request->business ?? "",
                    "payment_id" => $payment->id,
                ];
                $frameIn = FrameIn::create($frameInAttr);
                $payment->frameIn()->save($frameIn);
                $user=User::find(Auth::user()->id);
                $user->frameIns()->save($frameIn);
            } catch (\Throwable $th) {
                return back()->with('error', $th->getMessage());
            }
        }
        return back()->with('success', 'Payment recorded successful');
    }

    public function deleteFrame(Frame $frame)
    {
        $frame->delete();

        return back()->with('success', 'Frame deleted successful');
    }
}
