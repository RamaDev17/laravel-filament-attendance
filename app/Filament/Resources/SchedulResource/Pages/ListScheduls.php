<?php

namespace App\Filament\Resources\SchedulResource\Pages;

use App\Filament\Resources\SchedulResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListScheduls extends ListRecords
{
    protected static string $resource = SchedulResource::class;

    protected function getHeaderActions(): array
    {
        $is_super_admin = Auth::user()->hasRole('super_admin');
        return [
            !$is_super_admin ? Actions\Action::make('Presensi')
                ->url(route('presensi'))
                ->color('warning')
            : Actions\CreateAction::make()
        ];
    }
}
