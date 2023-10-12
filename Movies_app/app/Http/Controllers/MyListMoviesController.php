<?php

namespace App\Http\Controllers;

use App\Models\MyListMovie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MyListMoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = MyListMovie::all();
        $movieDetails = [];
        $genres = [];

        $genresArray = Http::withOptions([
            'query' => [
                'api_key' => config('services.tmdb.api'),
                //'language' => 'hu',
            ],
        ])->get(config('services.tmdb.endpoint').'genre/movie/list')->json()['genres'];

        $genres = collect($genresArray)->mapWithKeys(function ($genre) {
            return [$genre['id'] => $genre['name']];
        });

        foreach ($movies as $movie) {
            $movieId = $movie->movie_tvshow_id;

            $movieData = Http::withOptions([
                'query' => [
                    'api_key' => config('services.tmdb.api'),
                    'append_to_response' => 'credits,videos,images',
                    //'language' => 'hu',
                ],
            ])->get(config('services.tmdb.endpoint').'movie/'. $movieId)->json();

            $genreIds = collect($movieData['genres'])->pluck('id')->toArray();
            $movieData['genre_ids'] = $genreIds;

            $movieDetails[] = $movieData;
        }

        return view('mylist.index', [
            'movieDetails' => $movieDetails,
            'genres' => $genres,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'movie_tvshow_id' => 'required',
            'title' => 'required',
        ]);

        $existingMovie = MyListMovie::where('movie_tvshow_id', $validatedData['movie_tvshow_id'])->first();

        if ($existingMovie) {
            return redirect()->back()->with('message', 'This movie is already in your list.');
        }

        $movie = new MyListMovie();
        $movie->movie_tvshow_id = $validatedData['movie_tvshow_id'];
        $movie->save();

        return redirect()->back()->with('message', $validatedData['title'] . ' added to your list.');
    }

    /**
     * Display the specified resource.
     */
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

        return view('mylist.show', [
            'movieDetails' => $movieDetails,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        //dd($id);
        $movie = MyListMovie::where('movie_tvshow_id', '=', $id)->firstOrFail();
        //dd($movie);
        $movie->delete();

        return redirect()->route('mylist.index')->with('success', 'Movie successfully deleted from favorites.');
    }
}
