<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ObservasiResource\Pages;
use App\Filament\Resources\ObservasiResource\RelationManagers;
use App\Models\Observasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ObservasiResource extends Resource
{
    protected static ?string $model = Observasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-eye';
    protected static ?string $navigationGroup = 'Observasi';
    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Observasi';
    protected static ?string $pluralLabel = 'Observasi';
    protected static ?string $label = 'Observasi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Observasi')
                    ->description('Masukkan detail observasi.')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Pengawas')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('sekolah_id')
                            ->label('Sekolah')
                            ->relationship('sekolah', 'nama_sekolah')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\DatePicker::make('tanggal')
                            ->label('Tanggal Observasi')
                            ->required(),
                        Forms\Components\Textarea::make('narasi_temuan')
                            ->label('Narasi Temuan')
                            ->required()
                            ->columnSpan('full'),
                        Forms\Components\FileUpload::make('file_pendukung')
                            ->label('File Pendukung (Opsional)')
                            ->directory('observasi_files')
                            ->preserveFilenames()
                            ->nullable(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pengawas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sekolah.nama_sekolah')
                    ->label('Sekolah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal Observasi')
                    ->date(),
                Tables\Columns\TextColumn::make('narasi_temuan')
                    ->label('Narasi Temuan')
                    ->limit(50),
                Tables\Columns\TextColumn::make('file_pendukung')
                    ->label('File Pendukung'),
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
            RelationManagers\AiInsightsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListObservasis::route('/'),
            'create' => Pages\CreateObservasi::route('/create'),
            'edit' => Pages\EditObservasi::route('/{record}/edit'),
        ];
    }
}