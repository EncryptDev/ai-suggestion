<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CoachingSessionResource\Pages;
use App\Filament\Resources\CoachingSessionResource\RelationManagers;
use App\Models\CoachingSession;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CoachingSessionResource extends Resource
{
    protected static ?string $model = CoachingSession::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Coaching';
    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = 'Coaching Session';
    protected static ?string $pluralLabel = 'Coaching Session';
    protected static ?string $label = 'Coaching Session';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Sesi Coaching')
                    ->description('Masukkan detail sesi coaching.')
                    ->schema([
                        Forms\Components\Select::make('pengawas_id')
                            ->label('Pengawas')
                            ->relationship('pengawas', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('observasi_id')
                            ->label('Observasi')
                            ->relationship('observasi', 'narasi_temuan')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('kepsek_id')
                            ->label('Kepala Sekolah')
                            ->relationship('kepsek', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\DatePicker::make('tanggal')
                            ->label('Tanggal Sesi')
                            ->required(),
                        Forms\Components\Textarea::make('topik_diskusi')
                            ->label('Topik Diskusi')
                            ->required()
                            ->columnSpan('full'),
                        Forms\Components\Textarea::make('hasil_refleksi')
                            ->label('Hasil Refleksi')
                            ->columnSpan('full'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pengawas.name')
                    ->label('Pengawas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kepsek.name')
                    ->label('Kepala Sekolah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal Sesi')
                    ->date(),
                Tables\Columns\TextColumn::make('topik_diskusi')
                    ->label('Topik Diskusi')
                    ->limit(50),
                Tables\Columns\TextColumn::make('hasil_refleksi')
                    ->label('Hasil Refleksi')
                    ->limit(50),
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

    public static function getRelations(): array
    {
        return [
            RelationManagers\RtlsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCoachingSessions::route('/'),
            'create' => Pages\CreateCoachingSession::route('/create'),
            'edit' => Pages\EditCoachingSession::route('/{record}/edit'),
        ];
    }
}

