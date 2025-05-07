<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Observasi;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use App\Filament\Resources\ObservasiResource\Pages;
use App\Filament\Resources\ObservasiResource\RelationManagers;
use App\Models\AiInsight;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Http;

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
                        Forms\Components\TextInput::make('prompt')
                            ->name('prompt')
                            ->label('Prompt Untuk Ai')
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
                Action::make('generate')
                    ->label('Generate')
                    ->icon('heroicon-o-sparkles')
                    ->action(function ($record, Action $action) {
                        $ai = AiInsight::where('observasi_id', $record->id)->first();

                        if ($ai) {
                            Notification::make()
                                ->title('Gagal Generate')
                                ->body('Observasi ini sudah pernah dibuatkan ai inshigts sebelumnya')
                                ->warning()
                                ->send();

                            $action->halt();
                        }
                        $apiKey = env('OPENAI_API_KEY');

                        //suggestion Generate AI
                        $suggestResponse = Http::withHeaders([
                            'Authorization' => "Bearer {$apiKey}",
                            'Content-Type' => 'application/json',
                        ])->post('https://api.openai.com/v1/chat/completions', [
                            'model' => 'gpt-3.5-turbo',
                            'messages' => [
                                [
                                    'role' => 'system',
                                    'content' => 'langsung jawab semua pertanyaan dalam format poin-poin. Jangan gunakan paragraf langsung jawab poin per poin'
                                ],
                                [
                                    'role' => 'user',
                                    'content' => $record->propmt . "\n\n" . $record->narasi_temuan
                                ]
                            ],
                            'temperature' => 0.7,
                        ]);

                        $suggestJson = $suggestResponse->json();


                        $summarizeContent =  Http::withHeaders([
                            'Authorization' => "Bearer {$apiKey}",
                            'Content-Type' => 'application/json',
                        ])->post('https://api.openai.com/v1/chat/completions', [
                            'model' => 'gpt-3.5-turbo',
                            'messages' => [
                                [
                                    'role' => 'system',
                                    'content' => 'Jawab langsung to the point sajikan jawaban dalam paragraf yang ringkas tapi mencakup semua isi pertanyaan'
                                ],
                                [
                                    'role' => 'user',
                                    'content' => 'Ringkas pernyataan ini dalam sebuah paragraf' . "\n\nPernyataan:" . $record->narasi_temuan
                                ]
                            ],
                            'temperature' => 0.7,
                        ]);

                        $summarizeJson = $summarizeContent->json();


                        AiInsight::create([
                            'observasi_id' => $record->id,
                            'insight' => $summarizeJson['choices'][0]['message']['content'],
                            'rekomendasi' => $suggestJson['choices'][0]['message']['content'],
                        ]);


                        $action->success();

                        Notification::make()
                            ->title('Berhasil Generate')
                            ->body('Saran berhasil di generate oleh AI silahkan lihat pada AI Insshigts')
                            ->success()
                            ->send();
                    })
                    // ->requiresConfirmation()
                    ->disabled(fn($record) => $record->generated_at !== null) // Opsional: disable jika sudah digenerate
                    ->color(Color::Blue),

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
