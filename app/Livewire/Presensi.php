<?php

namespace App\Livewire;

use App\Models\Schedul;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Presensi extends Component
{
    public function render()
    {
        $schedule = Schedul::where('user_id', Auth::user()->id)->first();
        return view('livewire.presensi', [
            'schedule' => $schedule
        ]);
    }
}
