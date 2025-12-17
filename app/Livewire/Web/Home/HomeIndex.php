<?php

namespace App\Livewire\Web\Home;

use Livewire\Attributes\Layout;
use Livewire\Component;

class HomeIndex extends Component
{
    #[Layout('web.layouts.app')]
    public function render()
    {
        return view('livewire.web.home.home-index');
    }
}
