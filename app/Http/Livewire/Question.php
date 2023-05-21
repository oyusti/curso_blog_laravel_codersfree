<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Question extends Component
{

    public $model;

    public function render()
    {
        return view('livewire.question');
    }
}
