<?php
/**
 *  This file is part of the BlackfyreStudio CRUD package which is a recreation of the Krafthaus Bauhaus package.
 *  Copyright (C) 2016. Galicz Miklós <galicz.miklos@blackfyre.ninja>.
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License along
 *  with this program; if not, write to the Free Software Foundation, Inc.,
 *  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */
namespace BlackfyreStudio\CRUD\Controllers\Auth;

use Auth;
use Illuminate\Routing\Controller;
use Input;
use Session;

/**
 * Class AuthController.
 */
class AuthController extends Controller
{
    /**
     * @var string
     */
    protected $loginPath = '/login';

    /**
     * @var string
     */
    protected $redirectPath = '/';

    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->loginPath = \Config::get('crud.uri').'/login';
        $this->redirectPath = \Config::get('crud.uri').'/';
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loginPage()
    {
        return view('crud::login');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function startSession()
    {
        if (Input::has('email') && Input::has('password')) {
            $data = [
                'email'    => Input::get('email'),
                'password' => Input::get('password'),
            ];

            if (Auth::attempt($data, Input::has('remember'))) {
                Session::flash('message.success', trans('crud::messages.success.messages.sign-in.user-signed-in'));

                return redirect()->intended(route('crud.home'));
            }

            Session::flash('message.error', trans('crud::messages.error.sign-in.user-not-found'));
        } else {
            Session::flash('message.error', trans('crud::messages.error.sign-in.user-not-found'));
        }

        return redirect(route('crud.login'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroySession()
    {
        Auth::logout();
        Session::flash('message.success', trans('crud::messages.success.messages.sign-out.user-signed-out'));

        return redirect()->intended(route('crud.login'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showPasswordChange() {
        return view('crud::layouts.pwd-change');
    }


    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword() {

        if (Input::has('original') && Input::has('password') && Input::has('password_confirmation')) {

            if (\Hash::check(Input::get('original'), Auth::user()->getAuthPassword())) {

                if (Input::get('password') === Input::get('password_confirmation')) {

                    Auth::user()->fill([
                        'password'=> \Hash::make(Input::get('password'))
                    ])->save();

                    Session::flash('message.success', trans('crud::messages.success.messages.pwd-change.changed'));
                    return redirect()->intended(route('crud.home'));

                } else {
                    Session::flash('message.error', trans('crud::messages.error.messages.pwd-change.no-match'));
                    return redirect()->intended(route('crud.auth.pwd-change'));
                }

            } else {
                Session::flash('message.error', trans('crud::messages.error.messages.pwd-change.invalid-original'));
                return redirect()->intended(route('crud.auth.pwd-change'));
            }

        } else {
            Session::flash('message.error', trans('crud::messages.error.messages.pwd-change.fields-missing'));
            return redirect()->intended(route('crud.auth.pwd-change'));
        }

    }
}
