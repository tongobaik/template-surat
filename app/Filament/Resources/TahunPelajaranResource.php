<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Siswa;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\TahunPelajaran;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TahunPelajaranResource\Pages;
use App\Filament\Resources\TahunPelajaranResource\RelationManagers;

class TahunPelajaranResource extends Resource
{
    protected static ?string $model = TahunPelajaran::class;
    protected static ?string $label = 'Tahun Pelajaran';

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->label('Tahun Pelajaran')
                    ->helperText('Contoh: 2024/2025')
                    ->minLength(9)
                    ->maxLength(9)
                    ->required(),
                Forms\Components\Select::make('is_active')
                    ->label('Status')
                    ->options([
                        '0' => 'Nonaktif',
                        '1' => 'Aktif',
                    ])
                    ->native(false)
                    ->helperText('Aktifkan Tahun Pelajaran berlangsung.')
                    ->required(),
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
                        Tables\Columns\TextColumn::make('nama')
                            ->label('Tahun Pelajaran')
                            ->searchable(),
                        Tables\Columns\IconColumn::make('is_active')
                            ->label('Status')
                            ->boolean(),
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
                        // Tables\Filters\TrashedFilter::make()
                        //     ->visible(Auth::user()->is_admin === 'Administrator'),
                    ])
                    ->actions([
                        // Tables\Actions\ViewAction::make(),
                        Tables\Actions\EditAction::make()
                            ->visible(Auth::user()->is_admin === 'Administrator'),
                        Tables\Actions\DeleteAction::make()
                            ->visible(Auth::user()->is_admin === 'Administrator')
                    ])
                    ->bulkActions([
                        Tables\Actions\BulkActionGroup::make([
                            Tables\Actions\DeleteBulkAction::make(),
                            Tables\Actions\ForceDeleteBulkAction::make(),
                            Tables\Actions\RestoreBulkAction::make(),
                        ])
                            ->visible(Auth::user()->is_admin === 'Administrator'),
                    ]);
            } else {
                return $table->columns([]);
            }
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
                    'index' => Pages\ListTahunPelajarans::route('/'),
                ];
            }
        }
        return [
            'index' => Pages\ListTahunPelajarans::route('/'),
            'create' => Pages\CreateTahunPelajaran::route('/create'),
            'view' => Pages\ViewTahunPelajaran::route('/{record}'),
            'edit' => Pages\EditTahunPelajaran::route('/{record}/edit'),
        ];
    }
}