<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RtlResource\Pages;
use App\Filament\Resources\RtlResource\RelationManagers;
use App\Models\Rtl;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RtlResource extends Resource
{
    protected static ?string $model = Rtl::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static ?string $navigationGroup = 'Coaching';
    protected static ?int $navigationSort = 6;

    protected static ?string $navigationLabel = 'Rencana Tindak Lanjut';
    protected static ?string $pluralLabel = 'Rencana Tindak Lanjut';
    protected static ?string $label = 'Rencana Tindak Lanjut';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Rencana Tindak Lanjut (RTL)')
                    ->description('Masukkan detail rencana tindak lanjut.')
                    ->schema([
                        Forms\Components\Select::make('session_id')
                            ->label('Sesi Coaching')
                            ->relationship('session', 'tanggal')
                            ->searchable()
                            ->preload()
                            ->required(),
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
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('session.tanggal')
                    ->label('Tanggal Sesi')
                    ->date(),
                Tables\Columns\TextColumn::make('isi_rtl')
                    ->label('Deskripsi RTL')
                    ->limit(50),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status'),
                Tables\Columns\TextColumn::make('tenggat')
                    ->label('Tanggal Tenggat')
                    ->date(),
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
            'index' => Pages\ListRtls::route('/'),
            'create' => Pages\CreateRtl::route('/create'),
            'edit' => Pages\EditRtl::route('/{record}/edit'),
        ];
    }
}