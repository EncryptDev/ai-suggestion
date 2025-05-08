<?php

namespace App\Filament\Resources\CoachingSessionResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\CoachingSessionResource;
use App\Models\Observasi;

class CreateCoachingSession extends CreateRecord
{
    protected static string $resource = CoachingSessionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;
        $data['pengawas_id'] = Observasi::find($data['observasi_id'])->pengawas_id;

        return $data;
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
