<?php

namespace App\Filament\Resources;

use App\Models\Rtl;
use Filament\Forms;
use Filament\Tables;
use App\Models\Refleksi;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Textarea;
use App\Filament\Resources\RefleksiResource\Pages;
use Filament\Forms\Components\Actions\Action as FormAction;
use App\Filament\Resources\RefleksiResource\RelationManagers;

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
                        Forms\Components\Select::make('rtl_id')
                            ->label('Pilih RTL')
                            ->options(function () {
                                $userId = Auth::id();

                                return \App\Models\Rtl::whereHas('session', function ($query) use ($userId) {
                                    $query->where('user_id', $userId);
                                })
                                    ->pluck('isi_rtl', 'id');
                            })
                            ->live()
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('periode')
                            ->label('Periode')
                            ->maxLength(255),
                        Textarea::make('isi_refleksi')
                            ->label('Isi Refleksi')
                            ->live()
                            ->required()
                            ->columnSpan('full'),

                        Forms\Components\Actions::make([
                            FormAction::make('generateAi')
                                ->label('Generate Tanggapan AI')
                                ->icon('heroicon-o-sparkles')
                                ->action(function (callable $get, callable $set) {
                                    $refleksi = $get('isi_refleksi');

                                    if (! $refleksi) {
                                        return;
                                    }

                                    $observasi = Rtl::find($get('rtl_id'));

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
                                                'content' => 'Jawab langsung dalam bentuk paragraf berikan jawaban yang profesional dan objektif berikan saran tambahan jika di perlukan'
                                            ],
                                            [
                                                'role' => 'user',
                                                'content' => "Terdapat hasil obervasi sebagai berikut :" . $observasi->session->observasi->narasi_temuan ."\n\nKemudian user mendapatkan pon Rencana Tindak Lanjut berikut:$observasi->isi_rtl\n\nKemudian user memberikan hasil refleksi sebagai berikut: $refleksi\n\nSebagai pengawas sekolah yang profesional berikan tanggapan anda"
                                            ]
                                        ],
                                        'temperature' => 0.7,
                                    ]);

                                    $suggestJson = $suggestResponse->json();


                                    $set('ai_response', $suggestResponse->successful()
                                        ? $suggestJson['choices'][0]['message']['content']
                                        : '[Gagal memanggil API]');
                                })
                                ->disabled(fn(callable $get) => blank($get('isi_refleksi')) || blank($get('rtl_id')))
                                ->color(Color::Blue),
                        ]),
                        Forms\Components\Textarea::make('ai_response')
                            ->label('Tanggapan AI (Opsional)')
                            ->readOnly()
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
