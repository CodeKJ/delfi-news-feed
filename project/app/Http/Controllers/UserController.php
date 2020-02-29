<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * UserController constructor.
     * Uses auth middleware to prevent unauthenticated access
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Profile settings view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile()
    {
        return view('profile');
    }

    /**
     * Profile update
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update()
    {
        // Define custom error messages.
        $messages = [
            'name.required'     => 'Vārds ir obligāts.',
            'name.max'          => 'Vārda maksimālais garums ir :max simboli.',
            'email.required'    => 'Epasts ir obligāts.',
            'email.email'       => 'Epasts nav pareizā formātā.',
            'email.unique'      => 'Lietotājs ar epastu :input jau eksistē.',
            'avatar.image'      => 'Nepareizs avatara attēla fails.',
            'avatar.mimes'      => 'Nepareizs avatara attēla fails.',
            'avatar.max'        => 'Parsniegts maksimālais avatara faila izmērs.',
        ];

        // Execute validation for defined POST fields. In case of error, redirect back profile page with validation error messages.
        $this->validate(request(), [
            'name'              =>  'required|max:100',
            'email'             =>  'required|email|unique:users,email,'.auth()->user()->id,
            'avatar'            =>  'image|mimes:jpg,jpeg,png,gif|max:2048',
            'default_channel'   =>  ['required', Rule::in(array_flip(config('services.delfi.channels')))],
            'default_paginate'  =>  ['required', Rule::in([5,10,15,20])],
        ], $messages);

        // Set user object as currently authenticated user.
        $user = auth()->user();

        // Update user data
        $user->name = request()->get('name');
        $user->email = request()->get('email');
        $user->default_channel = request()->get('default_channel');
        $user->default_paginate = request()->get('default_paginate');

        // Upload and save avatar if its provided.
        if (request()->hasFile('avatar')) {
            $image = request()->file('avatar');
            $user->uploadAvatar($image);
        }

        // Finally save user model.
        $user->save();

        // And redirect back to profile page with success message.
        request()->session()->flash('success', 'Profils atjaunots!');
        return back();
    }
}
