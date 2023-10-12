<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TvController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $queryParams = ['api_key' => config('services.tmdb.api'),];

        $popularTv = Http::withOptions(['query' => $queryParams],)
            ->get(config('services.tmdb.endpoint').'tv/popular')
            ->json()['results'];

        $topRatedTv = Http::withOptions(['query' => $queryParams],)
            ->get(config('services.tmdb.endpoint').'tv/top_rated')
            ->json()['results'];

        $genresArray = Http::withOptions(['query' => $queryParams])
            ->get(config('services.tmdb.endpoint').'genre/tv/list')
            ->json()['genres'];

        $genres = collect($genresArray)->mapWithKeys(function ($genre) {
            return [$genre['id'] => $genre['name']];
        });
        
        //dump($popularTv);

        return view('tv.index', [
            'popularTv' => $popularTv,
            'topRatedTv' => $topRatedTv,
            'genres' => $genres,
        ]);
    }

    public function show(string $id)
    {
        $tvshow = Http::withOptions([
            'query' => [
                'api_key' => config('services.tmdb.api'),
                'append_to_response' => 'credits,videos,images',
                //'language' => 'hu',
            ],
        ])->get(config('services.tmdb.endpoint').'tv/'.$id)->json();

        return view('tv.show', [
            'tvshow' => $tvshow,
        ]);
    }
}
