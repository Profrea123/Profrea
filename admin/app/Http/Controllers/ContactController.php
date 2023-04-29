<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function contact()
    {
        return view('contact.contact');
    }

    public function about()
    {
        return view('contact.about');
    }


}
