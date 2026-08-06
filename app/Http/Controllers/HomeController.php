<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $totalItems = Item::count();
        $availableItems = Item::where('status', 'tersedia')->count();
        
        return view('home', compact('totalItems', 'availableItems'));
    }
}
