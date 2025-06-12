<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\WhatsAppValidator;
use App\Mail\NewUserRegistered;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showForm()
    {
        return view('register');
    }
    public function showWelcome()
    {
        return view('welcome');
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('username')) {
                $exists = User::where('username', $request->username)->exists();
                return response()->json(['exists' => $exists]);
            }

            if ($request->has('email')) {
                $exists = User::where('email', $request->email)->exists();
                return response()->json(['exists' => $exists]);
            }
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'phone' => 'nullable|string|max:50',
            'whatsapp_number' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*\W).+$/',
            ],
            'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $validator->after(function ($validator) use ($request) {
        if ($request->filled('whatsapp_number')) {
            $result = WhatsAppValidator::validate($request->input('whatsapp_number'));
            if (!isset($result['status']) || $result['status'] !== 'valid') {
                $validator->errors()->add('whatsapp_number', __('auth.whatsapp_invalid'));
            }
        }
        });

        $validator->validate();
        $validated = $validator->validated();

        $user = new User();
        $user->name = $validated['name'];
        $user->username = $validated['username'];
        $user->phone = $validated['phone'];
        $user->whatsapp_number = $validated['whatsapp_number'];
        $user->address = $validated['address'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);

if ($request->hasFile('user_image')) {
            $imageName = time() . '.' . $request->user_image->extension();
            $request->user_image->move(public_path('images'), $imageName);
            $user->user_image = $imageName;
        }

        $user->save();
        Mail::to('rawanalnagary@gmail.com')->send(new NewUserRegistered($user->username));
        return redirect('/register')->with('success', __('auth.user_registered'));
    }
}