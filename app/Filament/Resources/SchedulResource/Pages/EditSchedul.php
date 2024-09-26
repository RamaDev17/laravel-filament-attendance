<?php

namespace App\Filament\Resources\SchedulResource\Pages;

use App\Filament\Resources\SchedulResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSchedul extends EditRecord
{
    protected static string $resource = SchedulResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
