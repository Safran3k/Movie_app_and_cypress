<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MoviesController extends Controller
{
    // ENPOINT: https://api.themoviedb.org/3/

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $queryParams = ['api_key' => config('services.tmdb.api'), /*'language' => 'hu',*/];

        $popularMovies = Http::withOptions(['query' => $queryParams],)
            ->get(config('services.tmdb.endpoint').'movie/popular')->json()['results'];

        $genresArray = Http::withOptions(['query' => $queryParams],)
            ->get(config('services.tmdb.endpoint').'genre/movie/list')->json()['genres'];
        
        //dump($genresArray);
        $genres = collect($genresArray)->mapWithKeys(function ($genre) {
            return [$genre['id'] => $genre['name']];
        });
        //dump($genres);

        $nowPlayingMovies = Http::withOptions(['query' => $queryParams],)
            ->get(config('services.tmdb.endpoint').'movie/now_playing')->json()['results'];

        return view('movies.index', [
            'popularMovies' => $popularMovies,
            'genres' => $genres,
            'nowPlayingMovies' => $nowPlayingMovies,
        ]);
    }

    public function show(string $id)
    {
        $movieDetails = Http::withOptions([
            'query' => [
                'api_key' => config('services.tmdb.api'),
                'append_to_response' => 'credits,videos,images',
                //'language' => 'hu',
            ],
        ])->get(config('services.tmdb.endpoint').'movie/'.$id)->json();

        //dump($movieDetails);

        return view('movies.show', [
            'movieDetails' => $movieDetails,
        ]);
    }
}
