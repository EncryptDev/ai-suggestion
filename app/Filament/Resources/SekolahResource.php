<?php

namespace App\Filament\Resources;

use App\Enums\RoleEnum;
use App\Filament\Resources\SekolahResource\Pages;
use App\Filament\Resources\SekolahResource\RelationManagers;
use App\Models\Sekolah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SekolahResource extends Resource
{
    protected static ?string $model = Sekolah::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationGroup = 'Data Sekolah';
    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Sekolah';
    protected static ?string $pluralLabel = 'Sekolah';
    protected static ?string $label = 'Sekolah';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_sekolah')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('npsn')
                    ->maxLength(255),
                Forms\Components\Select::make('jenjang')
                    ->options([
                        'SD' => 'SD',
                        'SMP' => 'SMP',
                        'SMA' => 'SMA',
                        'SMK' => 'SMK',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('wilayah')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_sekolah')->searchable(),
                Tables\Columns\TextColumn::make('npsn')->searchable(),
                Tables\Columns\TextColumn::make('jenjang'),
                Tables\Columns\TextColumn::make('wilayah')->searchable(),
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
            RelationManagers\UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSekolahs::route('/'),
            'create' => Pages\CreateSekolah::route('/create'),
            'edit' => Pages\EditSekolah::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {

        return parent::getEloquentQuery()
           ->where('creator_id', Auth::id())->orderByDesc('created_at');
    }

    public static function canAccess(): bool
    {
        return Auth::user()->role === RoleEnum::PENGAWAS;
    }
}
