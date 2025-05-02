<?php

namespace App\Filament\Resources\ObservasiResource\Pages;

use App\Filament\Resources\ObservasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditObservasi extends EditRecord
{
    protected static string $resource = ObservasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
