<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Market;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

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
     * Display the specified resource.
     *
     * @param  \App\Models\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function showMarket(Market $market)
    {

        $customers = Customer::whereDoesntHave('markets', function ($query) use ($market) {
            $query->where('market_id', $market->id);
        })->get();

        return view('markets.show', compact('market', 'customers'));
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
                'number' => ['required', 'unique:markets,number,NULL,id,deleted_at,NULL'],
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
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors())->withInput()->with('addMarketCollapse', true);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function putMarket(Request $request, Market $market)
    {
        try {
            $attributes = $this->validate($request, [
                'number' => 'required |unique:markets,number,' . $market->id,
                "name" => 'required',
                "ward" => 'required',
                "street" => 'required',
                "manager_name" => 'required',
                "manager_mobile" => 'required',
            ]);

            $attributes['size'] = $request->size ?? $market->size;

            $market->update($attributes);


            foreach ($market->sections as $sec) {
                $sec->delete();
            }
            foreach ($request->sections as $section) {

                $sectionAttr['name'] = $section;
                $sectionAttr['market_id'] = $market->id;
                $newSection = Section::create($sectionAttr);
                // dd($newSection->updated_at);
                $market->sections()->save($newSection);
            }
            return back()->with('success', "Market edited successful");
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors())->withInput()->with('editMarketModal', true);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }

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
    public function deleteMarket(Market $market)
    {
        $market->delete();

        return back()->with('success', 'Market deleted successful');
    }
}
