<?php

namespace App\Filament\Resources\ObservasiResource\Pages;

use App\Filament\Resources\ObservasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListObservasis extends ListRecords
{
    protected static string $resource = ObservasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
