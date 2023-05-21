<?php

namespace App\Http\Controllers;

use App\Models\Cage;
use App\Models\Market;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cages = Cage::all();

        return view('cages.index', compact('cages'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cage  $cage
     * @return \Illuminate\Http\Response
     */
    public function showCage(Cage $cage)
    {
        return view('cages.show', compact('cage'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postCage(Request $request)
    {
        try {
            $attributes = $this->validate($request, [
                'number' => ['required', 'unique:cages,number,NULL,id,deleted_at,NULL,market_id,' . $request->input('market_id')],
                'location' => 'required',
                'type' => 'required',
                'market_id' => 'required',
            ]);

            $attributes['size'] = $request->size ?? "";
            $attributes['price'] = 15000;

            $cage = Cage::create($attributes);
            $market = Market::find($request->market_id);

            $market->cages()->save($cage);

            return back()->with('success', "Cage added successfully");
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors())->withInput()->with('addCageCollapse', true);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cage  $cage
     * @return \Illuminate\Http\Response
     */
    public function putCage(Request $request, Cage $cage)
    {
        try {
            $attributes = $this->validate($request, [
                'number' => 'required | unique:cages,number,' . $cage->id,
                'location' => 'required',
                'type' => 'required',
                'market_id' => 'required',
            ]);

            $attributes['size'] = $request->size ?? $cage->size;
            $attributes['price'] = 15000;

            $cage->update($attributes);
            $market = Market::find($request->market_id);

            $market->cages()->save($cage);

            return back()->with('success', "Cage edited successfully");
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors())->withInput()->with('editCageModal', true);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cage  $cage
     * @return \Illuminate\Http\Response
     */
    public function deleteCage(Cage $cage)
    {
        $cage->delete();

        return back()->with('success', 'Cage deleted successful');
    }
}
