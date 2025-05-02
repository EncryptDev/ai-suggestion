<?php

namespace App\Filament\Resources\ObservasiResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AiInsightsRelationManager extends RelationManager
{
    protected static string $relationship = 'aiInsights';

    protected static ?string $recordTitleAttribute = 'insight';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('insight')
                    ->label('Insight AI')
                    ->required()
                    ->columnSpan('full'),
                Forms\Components\Textarea::make('rekomendasi')
                    ->label('Rekomendasi AI')
                    ->columnSpan('full'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('insight')->label('Insight AI')->limit(50),
                Tables\Columns\TextColumn::make('rekomendasi')->label('Rekomendasi AI')->limit(50),
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