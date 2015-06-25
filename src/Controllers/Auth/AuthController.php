<?php
/**
 * User: mgalicz
 * Date: 2015.06.18.
 * Time: 11:58
 * Project: crud-tester
 */

namespace BlackfyreStudio\CRUD\Controllers\Auth;

use Illuminate\Routing\Controller;
use Auth;
use Input;
use Session;

class AuthController extends Controller
{
    public function loginPage() {
        return view('crud::login');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function startSession() {

        if (Input::has('email') && Input::has('password')) {
            $data = [
                'email'=>Input::get('email'),
                'password'=>Input::get('password')
            ];

            if (Auth::attempt($data,Input::has('remember'))) {
                Session::flash('message.success',trans('crud::messages.success.messages.user-signed-in'));
                return redirect()->intended(route('crud.home'));
            }

            Session::flash('message.error',trans('crud::messages.error.messages.sign-in.user-not-found'));

        } else {
            Session::flash('message.error',trans('crud::messages.error.messages.sign-in.user-not-found'));
        }

        return redirect(route('crud.login'));
    }

    public function destroySession() {

    }
}
