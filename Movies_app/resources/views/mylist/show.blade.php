@extends('layouts.main')
@include('components/flash-message')
@section('content')
    <div class="movie-info border-b border-gray-800">
        <div class="container mx-auto px-4 py-16 flex flex-col md:flex-row">
            <img class="w-64 md:w-96" src="{{ 'https://image.tmdb.org/t/p/w500/' . $movieDetails['poster_path'] }}"
                alt="parasite">
            <div class="md:ml-24">
                <h2 class="text-4xl font-semibold"> {{ $movieDetails['title'] }} </h2>

                <div class="flex flex-wrap items-center text-gray-400 text-sm">
                    <span>
                        <svg class="fill-current text-orange-500 w-4" viewBox="0 0 24 24">
                            <g data-name="Layer 2">
                                <path
                                    d="M17.56 21a1 1 0 01-.46-.11L12 18.22l-5.1 2.67a1 1 0 01-1.45-1.06l1-5.63-4.12-4a1 1 0 01-.25-1 1 1 0 01.81-.68l5.7-.83 2.51-5.13a1 1 0 011.8 0l2.54 5.12 5.7.83a1 1 0 01.81.68 1 1 0 01-.25 1l-4.12 4 1 5.63a1 1 0 01-.4 1 1 1 0 01-.62.18z"
                                    data-name="star" />
                            </g>
                        </svg>
                    </span>
                    <span class="ml-1"> {{ $movieDetails['vote_average'] * 10 . '%' }} </span>
                    <span class="mx-2"> | </span>
                    <span> {{ $movieDetails['release_date'] }} </span>
                    <span class="mx-2"> | </span>
                    <span>
                        @foreach ($movieDetails['genres'] as $genre)
                            {{ $genre['name'] }} @if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </span>
                </div>

                <p class="text-gray-300 mt-8">
                    {{ $movieDetails['overview'] }}
                </p>
                <div class="mt-12">
                    <h4 class="text-white font-semibold"> Featured Cast </h4>
                    <div class="flex mt-4">
                        @foreach ($movieDetails['credits']['crew'] as $crew)
                            @if ($loop->index < 5)
                                <div class="mr-8">
                                    <div> {{ $crew['name'] }} </div>
                                    <div class="text-sm text-gray-400"> {{ $crew['job'] }} </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Néhány filmről kevés adat van, általában a régieknél, ezekkel gond van, hiányos adatok megjelenítése -->
                @if ($movieDetails['videos']['results'] != null)
                    <div class="mt-12 inline-block">
                        <a href="https://youtube.com/watch?v={{ $movieDetails['videos']['results'][0]['key'] }}"
                            target="_blank"
                            class="flex inline-flex items-center bg-white text-gray-900 rounded font-semibold px-5 py-4 hover:bg-slate-300 transition ease-in-out duration-150">
                            <svg class="w-6 fill-current" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M10 16.5l6-4.5-6-4.5v9zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z" />
                            </svg>
                            <span class="ml-2"> Play Trailer </span>
                        </a>
                    </div>
                @endif

                <div class="mt-12 inline-block">
                    <form method="POST" action="{{ route('mylist.destroy', ['id' => $movieDetails['id']]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="ml-6 flex inline-flex items-center bg-white text-gray-900 rounded font-semibold px-5 py-4 hover:bg-slate-300 transition ease-in-out duration-150 cursor-pointer delete-my-list-item">
                            <svg class="w-6 fill-current" viewBox="0 0 24 24">
                                <path d="M10 12V17" stroke="#000000" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M14 12V17" stroke="#000000" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M4 7H20" stroke="#000000" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M6 10V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V10"
                                    stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#000000"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span class="ml-2"> Delete from my list </span>
                        </button>
                    </form>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
    <!-- End movie details -->

    <div class="movie-cast
                            border-b border-gray-800">
        <div class="container mx-auto px-4 py-16">
            <h2 class="text-4xl font-semibold"> Cast </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                @foreach ($movieDetails['credits']['cast'] as $cast)
                    @if ($loop->index < 5)
                        @if ($cast['profile_path'] != null)
                            <div class="mt-8">
                                <a href="#">
                                    <img src="{{ 'https://image.tmdb.org/t/p/w300/' . $cast['profile_path'] }}"
                                        alt="cast{{ $loop->index }}"
                                        class="hover:opacity-75 transition ease-in-out duration-150">
                                </a>
                                <div class="mt-2">
                                    <a href="#" class="text-lg mt-2 hover:text-gray:300">
                                        {{ $cast['character'] }}
                                    </a>
                                    <div class="text-sm text-gray-400"> {{ $cast['original_name'] }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <!-- End movie-cast -->

    <div class="movie-images" x-data="{ isOpen: false, image: '' }">
        <div class="container mx-auto px-4 py-16">
            <h2 class="text-4xl font-semibold"> Movie Images </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                @foreach ($movieDetails['images']['backdrops'] as $image)
                    @if ($loop->index < 9)
                        <div class="mt-8">
                            <img src=" {{ 'https://image.tmdb.org/t/p/w500/' . $image['file_path'] }} "
                                alt="image{{ $loop->index }}"
                                class="hover:opacity-75 transition ease-in-out duration-150">
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <!-- End movie-images -->
@endsection
