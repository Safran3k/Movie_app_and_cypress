<div class="relative mt-3 md:mt-0" x-data="{ isOpen: true }" @click.away="isOpen = false">
    <input wire:model.debounce.500ms="search"
        class="bg-gray-800 rounded-full w-64 px-4 pl-8 py-1 focus:outline-none focus:shadow-outline text-sm"
        type="text" placeholder="Search" @focus="isOpen = true" @keydown.escape.window="isOpen = false" id="search-input">
    <div class="absolute top-0">
        <svg class="fill-current text-gray-500 w-4 mt-2 ml-2" viewBox="0 0 24 24">
            <path class="heroicon-ui"
                d="M16.32 14.9l5.39 5.4a1 1 0 01-1.42 1.4l-5.38-5.38a8 8 0 111.41-1.41zM10 16a6 6 0 100-12 6 6 0 000 12z" />
        </svg>
    </div>

    <div wire:loading class="spinner top-0 right-0 mr-4 mt-3"></div>

    @if (strlen($search) >= 2)
        <div class="absolute bg-zinc-700 rounded w-64 mt-4 text-sm dropdown-item" x-show.transition.opacity="isOpen"
            @keydown.escape.window="isOpen = false">
            @if ($searchResults->count() > 0)
                <ul>
                    @foreach ($searchResults as $result)
                        <li class="border-b bg-zinc-600">
                            <a href="{{ route('movies.show', $result['id']) }}"
                                class="block hover:bg-zinc-600 px-3 py-3 flex items-center">
                                @if ($result['poster_path'])
                                    <img class="w-8"
                                        src="https://image.tmdb.org/t/p/w92/{{ $result['poster_path'] }}"
                                        alt="poster">
                                @else
                                    <img class="w-8" src="https://via.placeholder.com/50x75" alt="poster">
                                @endif
                                @if ($result['title'] != null)
                                    <span class="ml-4"> {{ $result['title'] }} </span>
                                @else
                                    <span class="ml-4"> {{ $result['name'] }} </span>
                                @endif

                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="py-3 px-3 no-result-message">
                    No results for {{ $search }}
                </div>
            @endif
        </div>
    @endif
</div>
