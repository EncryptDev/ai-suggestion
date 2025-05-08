<?php

namespace App\Filament\Resources\CoachingSessionResource\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\Placeholder;
use App\Filament\Resources\CoachingSessionResource;

class ViewCoachingSession extends ViewRecord
{
    protected static string $resource = CoachingSessionResource::class;

    /**
     * Override the form schema shown in the ViewRecord page.
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            Placeholder::make('narasi')
                ->label('Narasi Temuan')
                ->content(fn($record) => $record->observasi->narasi_temuan ?? '-'),
            Placeholder::make('user_name')
                ->label('Kepala Sekolah / Guru')
                ->content(fn($record) => $record->user?->name ?? '-'),
            TextInput::make('tanggal')
                ->label('Tanggal Sesi')
                ->disabled(),
            Placeholder::make('topik_diskusi')
                ->content(fn($record) => $record->topik_diskusi ?? '-')
                ->label('Topik Diskusi'),
            Placeholder::make('hasil_refleksi')
                ->content(fn($record) => $record->hasil_refleksi ?? '-')
                ->label('Hasil Refleksi'),
        ];
    }
}
