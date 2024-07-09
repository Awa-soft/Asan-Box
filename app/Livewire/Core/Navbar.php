<?php

namespace App\Livewire\Core;

use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Navbar extends Component
{
    // toggle layout
    public function toggleLayout()
    {
        Session::put('layout.sidebar', !Session::get('layout.sidebar')??true);
    }

    // toggle sidebar
    public function render()
    {
        return view('livewire..core.navbar');
    }
}
