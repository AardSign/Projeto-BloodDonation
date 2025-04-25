<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Donor;

class HomeController extends Controller
{
    public function redirect()
    {
        if (Auth::id()) {
            if (Auth::user()->usertype == '0') {
                $donors = Donor::all();
                return view('user.home', compact('donors'));
            } else {
                return view('admin.home');
            }
        } else {
            return redirect()->back();
        }
    }


    public function index()
    {
        if (Auth::id()) {
            return redirect('home');
        } else {
            $donors = Donor::all();
            return view('user.home', compact('donors'));
        }
    }

    
    public function profileadmin()
    {
        return view('user.profileadmin');
    }
}

