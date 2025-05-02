<?php

namespace App\Filament\Resources\RtlResource\Pages;

use App\Filament\Resources\RtlResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRtls extends ListRecords
{
    protected static string $resource = RtlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
