<?php

namespace App\Filament\Resources\RefleksiResource\Pages;

use App\Filament\Resources\RefleksiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRefleksis extends ListRecords
{
    protected static string $resource = RefleksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
