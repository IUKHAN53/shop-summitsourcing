<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $alibaba = new \App\Services\AlibabaService();
        $params = [];
        $url = $alibaba->generateUrl($params);
        $response  = $alibaba->getResponse($params);
        dd($url,$response);
        return view('frontend.home');
    }
}
