<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;



class SearchDropdown extends Component
{
    public $search = '';

    public function render()
    {
        $searchResults = [];

        if (strlen($this->search) >= 2) {
            $searchResults = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.tmdb.bearer'),
            ])->get(config('services.tmdb.endpoint').'search/movie?query='.$this->search)->json()['results'];
        }
        
        //dump($searchResults);
        
        return view('livewire.search-dropdown', [
            'searchResults' => collect($searchResults)->take(7),
        ]);
    }
}
