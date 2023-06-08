<?php

namespace App\Http\Controllers;

use App\Models\Stall;
use App\Models\Customer;
use App\Models\Frame;
use App\Models\FrameIn;
use App\Models\FrameOut;
use App\Models\Market;
use App\Models\Message;
use App\Models\Payment;
use App\Models\StallIn;
use App\Models\StallOut;
use App\Services\MessagingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{

    public function index()
    {
        if (Auth::user()->market_id) {
            return back()->with('error', "Access dinied! Unauthorized user.");
        }
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }



    public function showCustomer(Request $request, Customer $customer, $marketId)
    {

        if (Auth::user()->market_id && Auth::user()->market_id != $marketId) {
            return back()->with('error', "Access dinied! Unauthorized user.");
        }
        $market = Market::find($marketId);

        $customerFrames = $customer->frames()->where('market_id', $marketId)->get();
        $customerStalls = $customer->stalls()->where('market_id', $marketId)->get();

        $emptyFrames = Frame::where(['market_id' => $marketId, 'customer_id' => null])->get();
        $emptyStalls = Stall::where(['market_id' => $marketId, 'customer_id' => null])->get();

        $payments = Payment::where(['market_id' => $marketId, 'customer_id' => $customer->id])->get();

        $frameSelectedYear = $request->get('frameSelectedYear', date('Y'));
        $selectedFrameId = $request->get('selectedFrameId', $customerFrames->first()->id??0);

        $stallSelectedYear = $request->get('stallSelectedYear', date('Y'));
        $selectedStallId = $request->get('selectedStallId', $customerFrames->first()->id??0);

        return view('customers.show', compact(
            'customer',
            'market',
            'customerFrames',
            'customerStalls',
            'emptyStalls',
            'emptyFrames',
            'payments',
            'frameSelectedYear',
            'stallSelectedYear',
            'selectedFrameId',
            'selectedStallId',
        ));
    }
    public function showCustomerAdminView(Customer $customer)
    {

        if (Auth::user()->market_id) {
            return back()->with('error', "Access dinied! Unauthorized user.");
        }

        $customerMarkets = $customer->markets()->get();
        $customerFrames = $customer->frames()->get();
        $customerStalls = $customer->stalls()->get();

        return view('customers.admin_show', compact(
            'customer',
            'customerMarkets',
            'customerFrames',
            'customerStalls',
        ));
    }


    public function postCustomer(Request $request)
    {
        $photoPath = null;
        try {
            $attributes = $this->validate($request, [
                'nida' => ['required', 'unique:customers,nida,NULL,id,deleted_at,NULL'],
                "first_name" => 'required',
                "last_name" => 'required',
                "mobile" => 'required',
                'photo' => 'required',

            ]);
            $now = Carbon::now()->format('Ymd-His');

            if ($request->hasFile('photo')) {

                $photoPath = $request->file('photo')->storeAs(
                    '/images',
                    'profile-img-' . $now . '.' . $request->file('photo')->getClientOriginalExtension(),
                    'public'
                );
            } else

                return back()->with('error', 'Please make sure you upload customer profile picture.')->withInput()->with('addCustomerCollapse', true);
            $attributes['photo'] = $photoPath;
            $attributes['address'] = $request->address ?? "";
            $attributes['middle_name'] = $request->middle_name ?? "";

            $customer = Customer::create($attributes);
            $customer->markets()->attach($request->market_id);

            return back()->with('success', "Customer added successful");
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors())->withInput()->with('addCustomerCollapse', true);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }


    public function putCustomer(Request $request, Customer $customer)
    {
        try {
            $attributes = $this->validate($request, [
                'nida' => 'required |unique:customers,nida,' . $customer->id,
                "first_name" => 'required',
                "last_name" => 'required',
                "mobile" => 'required',
            ]);

            $customerPhotoToDelete = $customer->photo;

            $now = Carbon::now()->format('Ymd-His');

            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->storeAs(
                    '/images',
                    'profile-img-' . $now . '.' . $request->file('photo')->getClientOriginalExtension(),
                    'public'
                );
                // Storage::disk('public')->delete($customerPhotoToDelete);
            } else {
                $photoPath = $customer->photo;
            }
            Storage::disk('public')->move($customer->photo, $photoPath);

            $attributes['middle_name'] = $request->middle_name ?? $customer->middle_name;
            $attributes['address'] = $request->address ?? $customer->address;
            $attributes['photo'] = $photoPath ?? $customer->photo;

            $customer->update($attributes);

            return back()->with('success', "Customer edited successful");
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors())->withInput()->with('editCustomerModal', true);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }


    public function deleteCustomer(Customer $customer)
    {
        $customer->delete();

        return back()->with('success', 'Customer deleted successful');
    }

    // ADD CUSTOMER TO MARKET
    public function addCustomerToMarket(Request $request, Market $market)
    {
        $customer = Customer::find($request->customer_id);
        $customer->markets()->attach($market);

        return back()->with('success', 'Customer successfully added to this market');
    }

    // REMOVE CUSTOMER FROM MARKET
    public function removeCustomerFromMarket(Request $request, Customer $customer)
    {
        $customer->markets()->detach($request->market_id);

        return back()->with('success', 'Customer successfully removed from this market');
    }


    // ATTACH FRAME
    public function attachFrame(Request $request, Customer $customer)
    {
        $months = $request->months;
        try {
            $frame = Frame::find($request->frame_id);
            $attributes['customer_id'] = $customer->id;
            $attributes['business'] = $request->business ?? "";
            $attributes['entry_date'] = now();
            $attributes['user_id'] = Auth::user()->id;

            $frame->update($attributes);
            $customer->frames()->save($frame);

            foreach ($months as $month) {
                $paymentRequest = new Request([
                    "stall_id" => "",
                    "frame_id" => $frame->id,
                    "customer_id" => $customer->id,
                    "date" => now(),
                    "amount" => $frame->price,
                    'market_id' => $frame->market_id,
                    'month' => $month,
                    'year' => date('Y'),
                    "receipt_number" => $request->receipt_number,
                ]);
                $paymentController = new PaymentController();
                $payment = null;
                $paymentResponse = $paymentController->postPayment($paymentRequest);

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
            }

            return back()->with('success', 'Frame successfully assigned to customer');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }
    // ATTACH STALL
    public function attachStall(Request $request, Customer $customer)
    {
        $months = $request->months;
        try {
            $stall = Stall::find($request->stall_id);
            $attributes['customer_id'] = $customer->id;
            $attributes['business'] = $request->business ?? "";
            $attributes['entry_date'] = now();
            $attributes['user_id'] = Auth::user()->id ;

            $stall->update($attributes);
            $customer->stalls()->save($stall);

            foreach ($months as $month) {
                $paymentRequest = new Request([
                    "frame_id" => "",
                    "stall_id" => $stall->id,
                    "customer_id" => $customer->id,
                    "date" => now(),
                    "amount" => $stall->price,
                    'market_id' => $stall->market_id,
                    'month' => $month,
                    'year' => date('Y'),
                    "receipt_number" => $request->receipt_number,
                ]);
                $paymentController = new PaymentController();
                $payment = null;
                $paymentResponse = $paymentController->postPayment($paymentRequest);

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
            }

            return back()->with('success', 'Stall successfully assigned to customer');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }

    // DETACH FRAME
    public function detachFrame(Customer $customer, $frameId)
    {
        try {
            $frame = Frame::find($frameId);
            $attributes['customer_id'] = null;
            $frame->update($attributes);

            $frameOutAttr = [
                'entry_date'  => now(),
                "frame_id" => $frame->id,
                "customer_id" => $customer->id,
                'user_id'  => Auth::user()->id,
                'leaving_date' => now(),
            ];
            $frameOut = FrameOut::create($frameOutAttr);

            $oldFrameIns = FrameIn::where(['frame_id' => $frame->id, 'customer_id' => $customer->id, 'is_active' => true])->get();
            foreach ($oldFrameIns as $oldFrameIn) {

                $oldFrameInAttr['is_active'] = false;
                $oldFrameIn->update($oldFrameInAttr);
            }

            return back()->with('success', 'Frames successfully removed from customer');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }
    // DETACH STALL
    public function detachStall(Customer $customer, $stallId)
    {
        try {
            $stall = Stall::find($stallId);
            $attributes['customer_id'] = null;
            $stall->update($attributes);

            $stallOutAttr = [
                'entry_date'  => now(),
                "stall_id" => $stall->id,
                "customer_id" => $customer->id,
                'user_id'  => Auth::user()->id,
                'leaving_date' => now(),
            ];
            $stallOut = StallOut::create($stallOutAttr);

            $oldStallIns = StallIn::where(['stall_id' => $stall->id, 'customer_id' => $customer->id, 'is_active' => true])->get();
            foreach ($oldStallIns as $oldStallIn) {

                $oldStallInAttr['is_active'] = false;
                $oldStallIn->update($oldStallInAttr);
            }

            return back()->with('success', 'Stalls successfully removed from customer');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }
    public function sendMessage(Request $request, Customer $customer)
    {
        try {
            $messagingService = new MessagingService();
            $sendMessageResponse = $messagingService->sendMessage($customer->mobile, $request->body);

            if ($sendMessageResponse['status'] == "Sent") {

                $attributes['category'] = 'Reminder';
                $attributes['date'] = Carbon::now();
                $attributes['msg'] = $sendMessageResponse['msg'];
                $attributes['mobile'] = $sendMessageResponse['mobile'];
                $attributes['customer_id'] = $customer->id;

                $message = Message::create($attributes);
                $customer->messages()->save($message);

                return back()->with('success', 'Message sent successful');
            } else {
                return back()->with('error', 'Message not sent, crosscheck your inputs');
            }
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
