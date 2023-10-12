@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-4 pt-16">
        <div class="popular-tv">
            <h2 class="uppercase tracking-wider text-white-500 text-lg font-semibold"> Popular Shows </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8" id="popular-tv-shows-container">

                @foreach ($popularTv as $tvshow)
                    <x-tv-card :tvshow="$tvshow" :genres="$genres" />
                @endforeach

            </div>

            <div class="top-rated-shows py-24">
                <h2 class="uppercase tracking-wider text-white-500 text-lg font-semibold"> Top Rated Shows </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8"
                    id="top-rated-tv-shows-container">

                    @foreach ($topRatedTv as $tvshow)
                        <x-tv-card :tvshow="$tvshow" :genres="$genres" />
                    @endforeach

                </div>
            </div>
        </div>
    @endsection
