<?php

namespace SaturnPHP\Intel\Http\Controllers;
use Waterhole\Http\Controllers\Controller;
use Waterhole\Http\Middleware\MaybeRequireLogin;

class IntelController extends Controller
{
    public function __construct()
    {
        $this->middleware(MaybeRequireLogin::class)->only('intel');
    }


    public function intel()
    {
        return 'Hello World';
    }
}
