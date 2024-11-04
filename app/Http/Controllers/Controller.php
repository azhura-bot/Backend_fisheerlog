<?php

namespace App\Http\Controllers;

class Controller
{
    public function showLoginForm()
    {
        return view('Admin.Login'); 
    }
}
