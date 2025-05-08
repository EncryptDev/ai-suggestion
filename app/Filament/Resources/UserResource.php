<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Enums\RoleEnum;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn($state) => bcrypt($state))
                    ->hiddenOn('edit'),
                Forms\Components\Select::make('role')
                    ->options([
                        'pengawas' => 'Pengawas',
                        'kepsek' => 'Kepala Sekolah',
                        'guru' => 'Guru',
                    ])
                    ->required(),
                Forms\Components\Select::make('sekolah_id')
                    ->relationship('sekolah', 'nama_sekolah')
                    ->searchable()
                    ->preload()
                    ->label('Sekolah'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('role'),
                Tables\Columns\TextColumn::make('sekolah.nama_sekolah')->label('Sekolah')->searchable(),
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

    public static function getEloquentQuery(): Builder
    {

        return parent::getEloquentQuery()
            ->where('creator_id', Auth::id())->orderByDesc('created_at');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return Auth::user()->role === RoleEnum::PENGAWAS;
    }
}
