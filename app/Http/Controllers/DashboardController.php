<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

         $user = Auth::user();
         $user->assignRole('Super.Admin');


        return Inertia::render('Dashboard', [
            'filters' => $request->all('search', 'order'),


        ]);
    }
}
