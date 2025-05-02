<?php

namespace App\Filament\Resources\RefleksiResource\Pages;

use App\Filament\Resources\RefleksiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRefleksi extends EditRecord
{
    protected static string $resource = RefleksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
