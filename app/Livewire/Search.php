<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;

class Search extends Component
{
    #[Url]
    public $search;

    public function updatedSearch($value)
    {
        $this->dispatch('searchUpdated', $value)->to(Homepage::class);
    }
    public function render()
    {
        return view('livewire.search');
    }
}
