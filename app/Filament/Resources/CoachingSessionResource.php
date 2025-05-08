<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Enums\RoleEnum;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CoachingSession;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CoachingSessionResource\Pages;
use App\Filament\Resources\CoachingSessionResource\RelationManagers;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

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
                        Forms\Components\Select::make('observasi_id')
                            ->label('Observasi')
                            ->relationship(
                                name: 'observasi',
                                titleAttribute: 'narasi_temuan',
                                modifyQueryUsing: fn(Builder $query) => $query->where('user_id', Auth::id())
                            )
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
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Kepala Sekolah/Guru')
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
                Tables\Actions\ViewAction::make()
                    ->form([
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


                    ]),

                Tables\Actions\EditAction::make()
                    ->visible(fn () => Auth::user()->role !== RoleEnum::PENGAWAS),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn () => Auth::user()->role !== RoleEnum::PENGAWAS),
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('user', function($q){
                $q->where('creator_id', Auth::id());
            })->orderByDesc('created_at');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCoachingSessions::route('/'),
            'create' => Pages\CreateCoachingSession::route('/create'),
            'edit' => Pages\EditCoachingSession::route('/{record}/edit'),
            // 'view' => Pages\ViewCoachingSession::route('{record}/view'),
        ];
    }

    public static function canCreate(): bool
    {
        return Auth::user()->role !== RoleEnum::PENGAWAS;
    }
}
