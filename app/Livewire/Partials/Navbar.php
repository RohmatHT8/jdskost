<?php

namespace App\Livewire\Partials;

use App\Livewire\Homepage;
use App\Models\Branch;
use Livewire\Component;

class Navbar extends Component
{
    
    public $selected_categories=[];
    public $selected_branch;

    public function updatedSelectedBranch($value) {
        $this->dispatch('selectedBranchUpdate', $value)->to(Homepage::class);
    }
    public function updatedSelectedCategories($value)
    {
        $this->dispatch('selectedCategoriesUpdated', $this->selected_categories)->to(Homepage::class);
    }

    public function render()
    {
        
        $branches = Branch::select('name', 'id')->get();
        return view('livewire.partials.navbar', ['branches' => $branches]);
    }
}
