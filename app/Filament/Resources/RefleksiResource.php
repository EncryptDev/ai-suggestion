<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RefleksiResource\Pages;
use App\Filament\Resources\RefleksiResource\RelationManagers;
use App\Models\Refleksi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RefleksiResource extends Resource
{
    protected static ?string $model = Refleksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?string $navigationGroup = 'Refleksi';
    protected static ?int $navigationSort = 7;

    protected static ?string $navigationLabel = 'Refleksi';
    protected static ?string $pluralLabel = 'Refleksi';
    protected static ?string $label = 'Refleksi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Formulir Refleksi')
                    ->description('Masukkan refleksi Anda.')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Pengguna')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('periode')
                            ->label('Periode')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('isi_refleksi')
                            ->label('Isi Refleksi')
                            ->required()
                            ->columnSpan('full'),
                        Forms\Components\Textarea::make('ai_response')
                            ->label('Tanggapan AI (Opsional)')
                            ->columnSpan('full'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pengguna')
                    ->searchable(),
                Tables\Columns\TextColumn::make('periode')
                    ->label('Periode'),
                Tables\Columns\TextColumn::make('isi_refleksi')
                    ->label('Isi Refleksi')
                    ->limit(50),
                Tables\Columns\TextColumn::make('ai_response')
                    ->label('Tanggapan AI')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRefleksis::route('/'),
            'create' => Pages\CreateRefleksi::route('/create'),
            'edit' => Pages\EditRefleksi::route('/{record}/edit'),
        ];
    }
}