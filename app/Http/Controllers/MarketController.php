<?php

namespace App\Http\Controllers;

use App\Models\Market;
use App\Models\Section;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $markets = Market::all();

        return view('markets.index', compact('markets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function postMarket(Request $request)
    {

        try {
            $attributes = $this->validate($request, [
                'number' => ['required', 'unique:markets'],
                "name" => 'required',
                "ward" => 'required',
                "street" => 'required',
                "manager_name" => 'required',
                "manager_mobile" => 'required',
            ]);

            $attributes['size'] = $request->size ?? "";

            $market = Market::create($attributes);

            foreach ($request->sections as $section) {
                $sectionAttr['name'] = $section;
                $sectionAttr['market_id'] = $market->id;
                $newSection = Section::create($sectionAttr);
                // dd($newSection->updated_at);
                $market->sections()->save($newSection);
            }
            return back()->with('success', "Market created successful");
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
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
     * @param  \App\Models\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function show(Market $market)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function edit(Market $market)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Market $market)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function destroy(Market $market)
    {
        //
    }
}
