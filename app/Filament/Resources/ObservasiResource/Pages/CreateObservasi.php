<?php

namespace App\Filament\Resources\ObservasiResource\Pages;

use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ObservasiResource;

class CreateObservasi extends CreateRecord
{
    protected static string $resource = ObservasiResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['pengawas_id'] = Auth::user()->id;

        return $data;
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
