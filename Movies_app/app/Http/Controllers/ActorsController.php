<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ViewModels\ActorsViewModel;
use Illuminate\Support\Facades\Http;

class ActorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($page = 1)
    {
        $queryParams = ['api_key' => config('services.tmdb.api'),];

        $popularActors = Http::withOptions(['query' => $queryParams],)
            ->get(config('services.tmdb.endpoint').'person/popular?page='.$page)->json()['results'];

            
        $viewModel = new ActorsViewModel($popularActors, $page);

        return view('actors.index', $viewModel);
    }
}
