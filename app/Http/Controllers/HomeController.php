<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', [
            'requestPokenApi' => collect(Http::get('https://pokeapi.co/api/v2/pokemon?limit=21')->json()['results'])
        ]);
    }

    public function show($id) {
        return view('show', [
            'singleRestPokemon' => collect(Http::get("https://pokeapi.co/api/v2/pokemon/".$id."/")->json())
        ]);
    }
}
