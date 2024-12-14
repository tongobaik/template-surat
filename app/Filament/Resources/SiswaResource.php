<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Siswa;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Filters\TrashedFilter;
use App\Filament\Resources\SiswaResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SiswaResource\RelationManagers;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;
    protected static ?string $label = 'Siswa';
    protected static ?string $recordTitleAttribute = 'nama';
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Biodata Siswa')
                    ->description('Sesuaikan dengan Data Ijazah SD/MI.')
                    ->icon('heroicon-m-user')
                    ->iconColor('primary')
                    ->schema([
                        Forms\Components\Select::make('kelas_id')
                            ->label('Kelas')
                            ->relationship('kelas', 'nama')
                            ->disabled(Auth::user()->is_admin === 'Siswa')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Lengkap')
                            ->required(),
                        Forms\Components\Select::make('jenis_kelamin')
                            ->label('Jenis Kelamin')
                            ->options([
                                'Laki-Laki' => 'Laki-Laki',
                                'Perempuan' => 'Perempuan',
                            ])
                            ->native(false)
                            ->required(),
                        Forms\Components\TextInput::make('tempat_lahir')
                            ->label('Tempat Lahir')
                            ->required(fn($record) => $record !== null),
                        Forms\Components\DatePicker::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->maxDate(now())
                            ->required(fn($record) => $record !== null),
                        Forms\Components\TextInput::make('nama_ayah')
                            ->label('Nama Ayah Kandung')
                            ->required(fn($record) => $record !== null),
                        Forms\Components\TextInput::make('nama_ibu')
                            ->label('Nama Ibu Kandung')
                            ->required(fn($record) => $record !== null),
                        Forms\Components\TextInput::make('nisn')
                            ->label('Nomor Induk Siswa Nasional (NISN)')
                            ->required(fn($record) => $record !== null),
                        Forms\Components\TextInput::make('nik')
                            ->label('Nomor Induk Kependudukan')
                            ->helperText('Sesuaikan dengan data Kartu Keluarga.')
                            ->maxLength(16)
                            ->minLength(16)
                            ->required(fn($record) => $record !== null),
                    ])->columns(2),
                Section::make('Unggah File')
                    ->description('Ukuran maksimal unggah : 10 MB/File.')
                    ->icon('heroicon-m-photo')
                    ->iconColor('primary')
                    ->schema([
                        FileUpload::make('file_foto')
                            ->label('Foto Formal')
                            ->image()
                            ->fetchFileInformation(false)
                            ->imageEditor()
                            ->downloadable(true)
                            ->imageEditorAspectRatios([
                                null,
                                '1:1',
                                '4:3',
                                '3:4',
                            ])
                            ->directory(fn() => 'img/' . Auth::user()->username . '/foto')
                            ->maxSize(10240)
                            ->minSize(10)
                            ->required(),
                        FileUpload::make('file_kk')
                            ->label('Kartu Keluarga')
                            ->directory('img/kk')
                            ->image()
                            ->fetchFileInformation(false)
                            ->downloadable(true)
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                null,
                                '1:1',
                                '4:3',
                                '3:4',
                            ])
                            ->directory(fn() => 'img/' . Auth::user()->username . '/kk')
                            ->maxSize(10240)
                            ->minSize(10)
                            ->required(),
                        FileUpload::make('file_ijazah')
                            ->label('Ijazah SD/MI')
                            ->directory('img/ijazah')
                            ->fetchFileInformation(false)
                            // ->image()
                            // ->imageEditor()
                            // ->imageEditorAspectRatios([
                            //     null,
                            //     '1:1',
                            //     '4:3',
                            //     '3:4',
                            // ])
                            ->directory(fn() => 'img/' . Auth::user()->username . '/ijazah')
                            ->maxSize(10240)
                            ->minSize(10)
                            ->downloadable(true)
                            ->required(),
                    ])->columns(3),

                Section::make('Verifikasi Data')
                    ->description('Harap periksa kembali data yang telah diisi!')
                    ->icon('heroicon-m-check-badge')
                    ->iconColor('primary')
                    ->schema([
                        Forms\Components\Checkbox::make('status_verval')
                            ->label('Verifikasi')
                            ->helperText(new HtmlString('<strong>Biodata yang saya kirim adalah benar dan dapat dipertanggung jawabkan!</strong><br/>Centang jika data sudah benar.'))
                            ->required(fn() => Auth::user()->is_admin !== 'Administrator'/* && fn($record) => $record !== */)
                        // ->hidden(Auth::user()->is_admin === 'Administrator'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        if (Auth::check()) {
            $user = Auth::user();
            $siswa = Siswa::where('nisn', $user->username)->first();
            if ($siswa && $user->is_active || $user->is_admin === 'Administrator') {
                return $table
                    ->columns([
                        Tables\Columns\IconColumn::make('status_verval')
                            ->label('Status Verval')
                            ->boolean(),
                        Tables\Columns\ImageColumn::make('file_foto')
                            ->label('Foto')
                            ->circular()
                            ->defaultImageUrl('/favicon.ico'),
                        Tables\Columns\TextColumn::make('kelas.nama')
                            ->label('Kelas')
                            ->sortable(),
                        Tables\Columns\TextColumn::make('nama')
                            ->label('Nama Lengkap')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('nisn')
                            ->label('NISN')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('nik')
                            ->visible(Auth::user()->is_admin === 'Administrator')
                            ->label('NIK')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('tempat_lahir')
                            ->label('Tempat Lahir')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->date('d-m-Y')
                            ->sortable(),
                        Tables\Columns\TextColumn::make('jenis_kelamin')
                            ->label('Jenis Kelamin')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('nama_ayah')
                            ->label('Nama Ayah Kandung')
                            ->visible(Auth::user()->is_admin === 'Administrator')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('nama_ibu')
                            ->label('Nama Ibu Kandung')
                            ->visible(Auth::user()->is_admin === 'Administrator')
                            ->searchable(),

                        Tables\Columns\TextColumn::make('deleted_at')
                            ->dateTime()
                            ->sortable()
                            ->toggleable(isToggledHiddenByDefault: true),
                        Tables\Columns\TextColumn::make('created_at')
                            ->dateTime()
                            ->sortable()
                            ->toggleable(isToggledHiddenByDefault: true),
                        Tables\Columns\TextColumn::make('updated_at')
                            ->dateTime()
                            ->sortable()
                            ->toggleable(isToggledHiddenByDefault: true),
                    ])
                    ->filters([
                        TrashedFilter::make()
                            ->visible(Auth::user()->is_admin === 'Administrator'),
                        SelectFilter::make('kelas_id')
                            ->label('Kelas')
                            ->relationship('kelas', 'nama'),
                        SelectFilter::make('status_verval')
                            ->label('Status Verifikasi')
                            ->options([
                                1 => 'Verifikasi',
                                0 => 'Belum Verifikasi'
                            ])
                    ])
                    ->actions([
                        ActionGroup::make([
                            // Tables\Actions\ViewAction::make(),
                            Tables\Actions\EditAction::make(),
                            Tables\Actions\DeleteAction::make()
                        ])
                            ->visible(Auth::user()->is_admin === 'Administrator')
                    ], position: ActionsPosition::BeforeColumns)
                    ->bulkActions([
                        Tables\Actions\BulkActionGroup::make([
                            Tables\Actions\DeleteBulkAction::make(),
                            Tables\Actions\ForceDeleteBulkAction::make(),
                            Tables\Actions\RestoreBulkAction::make(),
                        ])
                            ->visible(Auth::user()->is_admin === 'Administrator'),
                    ]);
            }
            return $table
                ->columns([]);
        }
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        if (Auth::check()) {
            $user = Auth::user();
            $siswa = Siswa::where('nisn', $user->username)->first();
            if ($siswa && $user->is_active || $user->is_admin === 'Administrator') {
                return [
                    'index' => Pages\ListSiswas::route('/'),
                ];
            }
        }
        return [
            'index' => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'view' => Pages\ViewSiswa::route('/{record}'),
            'edit' => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }



    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes(
                [
                    SoftDeletingScope::class,
                ]
            );
    }
}
