<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use App\Models\Market;
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


    public function deleteFrame(Frame $frame)
    {
        $frame->delete();

        return back()->with('success', 'Frame deleted successful');
    }
}
