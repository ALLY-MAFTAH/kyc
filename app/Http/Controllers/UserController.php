<?php

namespace App\Http\Controllers;

use App\Models\Market;
use App\Models\User;
use App\Services\MessagingService;
use Carbon\Carbon;
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
    public function addUser(Request $request)
    {
        $market = Market::find($request->market_id);
        $userRequest = $request->merge(['default_password' => $market->default_password]);

        $userController = new UserController();

        $userResponse = $userController->postUser($userRequest);

        if ($userResponse['status'] == true) {
            $user = $userResponse['data'];

            $body = "Hello " . $user->name . " \n" . "Your login credentials are: Email: " . $user->email . ", Password: " . $user->market->default_password . ". You are recommended to change this default password as soon as posible.";
            $messagingService = new MessagingService();
            $sendMessageResponse = $messagingService->sendMessage($user->mobile, $body);

            if ($sendMessageResponse['status'] == "Sent") {

                // $attributes['category'] = 'Info';
                // $attributes['date'] = Carbon::now();
                // $attributes['msg'] = $sendMessageResponse['msg'];
                // $attributes['mobile'] = $sendMessageResponse['mobile'];
                // $attributes['customer_id'] = $customer->id;

                // $message = Message::create($attributes);
                // $customer->messages()->save($message);

                return back()->with('success', 'User added successful');
            } else {
                return back()->with('error', 'User registered successful, but message not sent, crosscheck your inputs');
            }
        } else {
            return back()->with('error', $userResponse['data'])->withInput();
        }
    }
    public function postUser(Request $request)
    {

        try {

            $attributes = $this->validate($request, [
                'name' => 'required',
                'email' => 'required |unique:users,email,except,id',
                'is_manager' => 'required',
                'mobile' => 'required',
                'market_id' => 'required',
            ]);

            $attributes['password'] = Hash::make($request->default_password);

            $user = User::create($attributes);
            return ['status' => true, 'data' => $user];
        } catch (\Throwable $th) {
            return ['status' => false, 'data' => $th->getMessage()];
        }
    }

    public function putUser(Request $request, User $user)
    {

        try {
            $attributes = $this->validateWithBag('update', $request, [
                'name' => 'required',
                'mobile' => 'required',
                // 'is_manager' => 'required',
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

            return back()->with('success', 'User status updated successfull');
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
