<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Kalau sudah login, langsung lempar ke home masing-masing role
        if ($request->user()) {
            return redirect($request->user()->homeUrl());
        }

        $totalItems = Item::count();
        $availableItems = Item::where('status', 'tersedia')->count();

        return view('home', compact('totalItems', 'availableItems'));
    }
}
