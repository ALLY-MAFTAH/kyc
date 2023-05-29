<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Frame;
use App\Models\Market;
use App\Models\Section;
use App\Models\Stall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class MarketController extends Controller
{

    public function index()
    {
        $markets = Market::all();

        return view('markets.index', compact('markets'));
    }


    public function showMarket(Market $market)
    {
        $lastFrameRow = Frame::where('market_id', $market->id)
            ->latest('created_at')
            ->latest('id')
            ->first();
        $lastFrameCode = $lastFrameRow ? $lastFrameRow->code : $market->code . "/FRM/000";
        $newFrameCode = ++$lastFrameCode;

        $lastStallRow = Stall::where('market_id', $market->id)
            ->latest('created_at')
            ->latest('id')
            ->first();
        $lastStallCode = $lastStallRow ? $lastStallRow->code : $market->code . "/STL/000";
        $newStallCode = ++$lastStallCode;

        $customers = Customer::whereDoesntHave('markets', function ($query) use ($market) {
            $query->where('market_id', $market->id);
        })->get();

        return view('markets.show', compact('market', 'customers', 'newFrameCode', 'newStallCode'));
    }


    public function postMarket(Request $request)
    {
        try {
            $attributes = $this->validate($request, [
                'code' => ['required', 'unique:markets,code,NULL,id,deleted_at,NULL'],
                "name" => 'required',
                "ward" => 'required',
                "email" => 'required',
                "sub_ward" => 'required',
                "manager_name" => 'required',
                "manager_mobile" => 'required',
                "stall_price" => 'required',
                "frame_price" => 'required',
                "default_password" => 'required',
            ]);

            $attributes['size'] = $request->size ?? "";

            $market = Market::create($attributes);

            foreach ($request->sections as $section) {
                $sectionAttr['name'] = $section;
                $sectionAttr['market_id'] = $market->id;
                $newSection = Section::create($sectionAttr);

                $market->sections()->save($newSection);
            }

            $userRequest = new Request([
                "name" => $request->manager_name,
                "mobile" => $request->manager_mobile,
                "email" => $request->email,
                "password" => $request->default_password,
                'market_id' => $market->id,
            ]);
            $userController = new UserController();
            $user = null;
            $userResponse = $userController->postUser($userRequest);

            if ($userResponse['status'] == true) {
                $user = $userResponse['data'];
                $market->user()->save($user);
            } else {
                return back()->with('error', $userResponse['data'])->withInput();
            }

            return back()->with('success', "Market created successful");
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors())->withInput()->with('addMarketCollapse', true);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }


    public function putMarket(Request $request, Market $market)
    {
        try {
            $attributes = $this->validate($request, [
                'code' => 'required |unique:markets,code,' . $market->id,
                "name" => 'required',
                "ward" => 'required',
                "sub_ward" => 'required',
                "frame_price" => 'required',
                "stall_price" => 'required',
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

                $market->sections()->save($newSection);
            }
            return back()->with('success', "Market edited successful");
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors())->with('error', $exception->getMessage())->withInput()->with('editMarketModal', true);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }

    public function update(Request $request, Market $market)
    {
        //
    }


    public function deleteMarket(Market $market)
    {
        $market->delete();

        return back()->with('success', 'Market deleted successful');
    }
}
