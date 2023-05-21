<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use App\Models\Market;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FrameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $frames = Frame::all();

        return view('frames.index', compact('frames'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Frame  $frame
     * @return \Illuminate\Http\Response
     */
    public function showFrame(Frame $frame)
    {
        return view('frames.show', compact('frame'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postFrame(Request $request)
    {
        try {
            $attributes = $this->validate($request, [
                'number' => ['required', 'unique:frames,number,NULL,id,deleted_at,NULL,market_id,' . $request->input('market_id')],
                'location' => 'required',
                'market_id' => 'required',
            ]);

            $attributes['size'] = $request->size ?? "";
            $attributes['price'] = 40000;

            $frame = Frame::create($attributes);
            $market = Market::find($request->market_id);

            $market->frames()->save($frame);

            return back()->with('success', "Frame added successfully");
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors())->withInput()->with('addFrameCollapse', true);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Frame  $frame
     * @return \Illuminate\Http\Response
     */
    public function putFrame(Request $request, Frame $frame)
    {
        try {
            $attributes = $this->validate($request, [
                'number' => ['required', 'unique:frames,number,NULL,' . $frame->id . ',deleted_at,NULL,market_id,' . $request->input('market_id')],
                'location' => 'required',
                'market_id' => 'required',
            ]);

            $attributes['size'] = $request->size ?? $frame->size;
            $attributes['price'] = 40000;

            $frame->update($attributes);
            $market = Market::find($request->market_id);

            $market->frames()->save($frame);

            return back()->with('success', "Frame edited successfully");
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors())->withInput()->with('editFrameModal', true);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Frame  $frame
     * @return \Illuminate\Http\Response
     */
    public function deleteFrame(Frame $frame)
    {
        $frame->delete();

        return back()->with('success', 'Frame deleted successful');
    }
}
