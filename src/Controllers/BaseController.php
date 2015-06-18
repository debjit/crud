<?php
/**
 * User: mgalicz
 * Date: 2015.06.18.
 * Time: 12:01
 * Project: crud-tester
 */

 namespace BlackfyreStudio\CRUD\Controllers;

 use Illuminate\Foundation\Bus\DispatchesJobs;
 use Illuminate\Routing\Controller as OriginController;
 use Illuminate\Foundation\Validation\ValidatesRequests;

 abstract class BaseController extends OriginController {
     use DispatchesJobs, ValidatesRequests;
 }