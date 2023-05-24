<?php

namespace App\Http\Controllers;

use App\Models\Stall;
use App\Models\Customer;
use App\Models\Frame;
use App\Models\Market;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function showCustomer(Customer $customer, $marketId)
    {
        $market = Market::find($marketId);

        $customerFrames = $customer->frames()->where('market_id', $marketId)->get();
        $customerStalls = $customer->stalls()->where('market_id', $marketId)->get();

        $emptyFrames = Frame::where(['market_id' => $marketId, 'customer_id' => null])->get();
        $emptyStalls = Stall::where(['market_id' => $marketId, 'customer_id' => null])->get();

        return view('customers.show', compact(
            'customer',
            'market',
            'customerFrames',
            'customerStalls',
            'emptyStalls',
            'emptyFrames',
        ));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
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
            $frame->update($attributes);
            $customer->frames()->save($frame);

            foreach ($months as $month) {
                $paymentRequest = new Request([
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
            }

            return back()->with('success', 'Frame successfully assigned to customer');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }
    // ATTACH CAGE
    public function attachStall(Request $request, Customer $customer)
    {
        $stallIds = $request->stalls;

        try {
            foreach ($stallIds as $stallId) {
                $stall = Stall::find($stallId);
                $attributes['customer_id'] = $customer->id;
                $stall->update($attributes);
                $customer->stalls()->save($stall);
            }

            return back()->with('success', 'Stalls successfully assigned to customer');
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
            // $customer->frames()->save($frame);

            return back()->with('success', 'Frames successfully removed from customer');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }
    // DETACH CAGE
    public function detachStall(Customer $customer, $stallId)
    {
        try {
            $stall = Stall::find($stallId);
            $attributes['customer_id'] = null;
            $stall->update($attributes);
            // $customer->stalls()->save($stall);

            return back()->with('success', 'Stalls successfully removed from customer');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }
}
