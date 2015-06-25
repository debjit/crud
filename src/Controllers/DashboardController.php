<?php
/**
 * Created by IntelliJ IDEA.
 * User: mgalicz
 * Date: 4/1/2015
 * Time: 9:55 AM
 */

namespace BlackfyreStudio\CRUD\Controllers;


use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {
    public function index() {

        $user = Auth::user()->roles;

        dd($user);

        return view('crud::layouts.dashboard');
    }
}