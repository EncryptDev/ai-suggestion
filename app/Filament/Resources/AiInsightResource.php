<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Enums\RoleEnum;
use Filament\Forms\Form;
use App\Models\AiInsight;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\AiInsightResource\Pages;
use App\Filament\Resources\AiInsightResource\RelationManagers;
use Illuminate\Database\Eloquent\Builder;

class AiInsightResource extends Resource
{
    protected static ?string $model = AiInsight::class;

    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';
    protected static ?string $navigationGroup = 'Observasi';
    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'AI Insight';
    protected static ?string $pluralLabel = 'AI Insight';
    protected static ?string $label = 'AI Insight';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Analisis AI')
                    ->description('Masukkan hasil analisis dan rekomendasi AI.')
                    ->schema([
                        Forms\Components\Select::make('observasi_id')
                            ->label('Observasi')
                            ->relationship('observasi', 'tanggal') // Bisa disesuaikan tampilannya
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Textarea::make('insight')
                            ->label('Insight AI')
                            ->required()
                            ->columnSpan('full'),
                        Forms\Components\Textarea::make('rekomendasi')
                            ->label('Rekomendasi AI')
                            ->columnSpan('full'),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('observasi.tanggal')
                    ->label('Tanggal Observasi')
                    ->date(),
                Tables\Columns\TextColumn::make('insight')
                    ->label('Insight AI')
                    ->limit(50),
                Tables\Columns\TextColumn::make('rekomendasi')
                    ->label('Rekomendasi AI')
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

    public static function getEloquentQuery(): Builder
    {

        return parent::getEloquentQuery()
            ->whereHas('observasi.user', function($q){
                $q->where('creator_id', Auth::id());
            })->orderByDesc('created_at');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAiInsights::route('/'),
            'create' => Pages\CreateAiInsight::route('/create'),
            'edit' => Pages\EditAiInsight::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return Auth::user()->role === RoleEnum::PENGAWAS;
    }
}
