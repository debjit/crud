<?php
/**
 * Created by IntelliJ IDEA.
 * User: mgalicz
 * Date: 4/1/2015
 * Time: 9:55 AM
 */

namespace BlackfyreStudio\CRUD\Controllers;


use Illuminate\Routing\Controller;

class DashboardController extends Controller {
    public function index() {
        return view('crud::layouts.dashboard');
    }
}