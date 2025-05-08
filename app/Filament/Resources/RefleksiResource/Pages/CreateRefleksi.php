<?php

namespace App\Filament\Resources\RefleksiResource\Pages;

use App\Filament\Resources\RefleksiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateRefleksi extends CreateRecord
{
    protected static string $resource = RefleksiResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();

        return $data;
    }
}
