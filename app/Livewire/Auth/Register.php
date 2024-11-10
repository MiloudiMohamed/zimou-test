<?php

namespace App\Livewire\Auth;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    public function render(): View
    {
        return view('livewire.auth.register');
    }
}
