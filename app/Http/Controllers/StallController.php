<?php

namespace App\Http\Controllers;

use App\Models\Stall;
use App\Models\Market;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stalls = Stall::all();

        return view('stalls.index', compact('stalls'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stall  $stall
     * @return \Illuminate\Http\Response
     */
    public function showStall(Stall $stall)
    {
        return view('stalls.show', compact('stall'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postStall(Request $request)
    {
        try {
            $attributes = $this->validate($request, [
                'code' => ['required', 'unique:stalls,code,NULL,id,deleted_at,NULL,market_id,' . $request->input('market_id')],
                'location' => 'required',
                'type' => 'required',
                'market_id' => 'required',
            ]);

            $attributes['size'] = $request->size ?? "";
            $attributes['price'] = 15000;

            $stall = Stall::create($attributes);
            $market = Market::find($request->market_id);

            $market->stalls()->save($stall);

            return back()->with('success', "Stall added successfully");
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors())->withInput()->with('addStallCollapse', true);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stall  $stall
     * @return \Illuminate\Http\Response
     */
    public function putStall(Request $request, Stall $stall)
    {
        try {
            $attributes = $this->validate($request, [
                'code' => 'required | unique:stalls,code,' . $stall->id,
                'location' => 'required',
                'type' => 'required',
                'market_id' => 'required',
            ]);

            $attributes['size'] = $request->size ?? $stall->size;
            $attributes['price'] = 15000;

            $stall->update($attributes);
            $market = Market::find($request->market_id);

            $market->stalls()->save($stall);

            return back()->with('success', "Stall edited successfully");
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors())->withInput()->with('editStallModal', true);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stall  $stall
     * @return \Illuminate\Http\Response
     */
    public function deleteStall(Stall $stall)
    {
        $stall->delete();

        return back()->with('success', 'Stall deleted successful');
    }
}
