<?php

namespace App\Http\Controllers;

use App\Models\Stall;
use App\Models\Market;
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


    public function deleteStall(Stall $stall)
    {
        $stall->delete();

        return back()->with('success', 'Stall deleted successful');
    }
}
