<?php

namespace App\Http\Controllers;

use App\Models\Market;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $markets = Market::all();

        $users = User::all();

        return view('users.index', compact('users', 'markets'));
    }
    public function showUser(Request $request, User $user)
    {
        $markets = Market::all();

        return view('users.show', compact('user', 'markets'));
    }
    public function postUser(Request $request)
    {
        try {

            $attributes = $this->validate($request, [
                'name' => 'required',
                'email' => 'required |unique:users,email,except,id',
                'mobile' => 'required',
            ]);

            $attributes['password'] = Hash::make($request->default_password);
            $attributes['market_id'] = $request->market_id ?? "";

            $user = User::create($attributes);

            return ['status' => true, 'data' => $user];
        } catch (\Throwable $th) {
            return ['status' => false, 'data' => $th->getMessage()];
        }
    }

    public function putUser(Request $request, User $user)
    {
        // dd($request->all());

        try {
            $attributes = $this->validateWithBag('update', $request, [
                'name' => 'required',
                'mobile' => 'required',
                'email' => ['sometimes', Rule::unique('users')->ignore($user->id)->whereNull('deleted_at')],
                'market_id' => ['sometimes', 'exists:markets,id'],
            ]);

            $user->update($attributes);

            return back()->with('success', 'User edited successful');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function toggleStatus(Request $request, User $user)
    {
        try {
            $attributes = $this->validate($request, [
                'status' => ['required', 'boolean'],
            ]);

            $user->update($attributes);

            return back()->with('success', 'You have successfully updated user status');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    public function deleteUser(User $user)
    {
        try {

            $user->delete();

            return back()->with('success', 'User deleted successful');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
