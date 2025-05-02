<?php

namespace App\Filament\Resources\CoachingSessionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class RtlsRelationManager extends RelationManager
{
    protected static string $relationship = 'rtls';

    protected static ?string $recordTitleAttribute = 'isi_rtl';

    protected static ?string $emptyStateHeading = 'Tidak Ada Rencana Tindak Lanjut';
    protected static ?string $emptyStateDescription = 'Buat Rencana Tindak Lanjut pertama untuk sesi ini.';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('isi_rtl')
                    ->label('Deskripsi RTL')
                    ->required()
                    ->columnSpan('full'),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'belum' => 'Belum Dilaksanakan',
                        'proses' => 'Sedang Dilaksanakan',
                        'selesai' => 'Selesai Dilaksanakan',
                    ])
                    ->required(),
                Forms\Components\DatePicker::make('tenggat')
                    ->label('Tanggal Tenggat'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('isi_rtl')->label('Deskripsi RTL')->limit(50),
                Tables\Columns\TextColumn::make('status')->label('Status'),
                Tables\Columns\TextColumn::make('tenggat')->label('Tanggal Tenggat')->date(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
