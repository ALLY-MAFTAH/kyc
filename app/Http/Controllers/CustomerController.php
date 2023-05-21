<?php

namespace App\Http\Controllers;

use App\Models\Cage;
use App\Models\Customer;
use App\Models\Frame;
use App\Models\Market;
use Illuminate\Http\Request;
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
        $customerCages = $customer->cages()->where('market_id', $marketId)->get();

        $emptyFrames = Frame::where(['market_id' => $marketId, 'customer_id' => null])->get();
        $emptyCages = Cage::where(['market_id' => $marketId, 'customer_id' => null])->get();

        return view('customers.show', compact(
            'customer',
            'market',
            'customerFrames',
            'customerCages',
            'emptyCages',
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
        try {
            $attributes = $this->validate($request, [
                'nida' => ['required', 'unique:customers,nida,NULL,id,deleted_at,NULL'],
                "first_name" => 'required',
                "last_name" => 'required',
                "mobile" => 'required',
            ]);

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

            $attributes['middle_name'] = $request->middle_name ?? $customer->middle_name;
            $attributes['address'] = $request->address ?? $customer->address;

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
        $frameIds = $request->frames;

        try {
            foreach ($frameIds as $frameId) {
                $frame = Frame::find($frameId);
                $attributes['customer_id'] = $customer->id;
                $frame->update($attributes);
                $customer->frames()->save($frame);
            }

            return back()->with('success', 'Frames successfully assigned to customer');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }
    // ATTACH CAGE
    public function attachCage(Request $request, Customer $customer)
    {
        $cageIds = $request->cages;

        try {
            foreach ($cageIds as $cageId) {
                $cage = Cage::find($cageId);
                $attributes['customer_id'] = $customer->id;
                $cage->update($attributes);
                $customer->cages()->save($cage);
            }

            return back()->with('success', 'Cages successfully assigned to customer');
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
    public function detachCage(Customer $customer, $cageId)
    {
        try {
            $cage = Cage::find($cageId);
            $attributes['customer_id'] = null;
            $cage->update($attributes);
            // $customer->cages()->save($cage);

            return back()->with('success', 'Cages successfully removed from customer');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }
}
