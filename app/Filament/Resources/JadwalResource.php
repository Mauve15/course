<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Jadwal;
use App\Models\Kelompok;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\JadwalResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\JadwalResource\RelationManagers;

class JadwalResource extends Resource
{
    protected static ?string $model = Jadwal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('kelompok_id')
                    ->label('Kelompok')
                    ->options(Kelompok::all()->pluck('nama_kelompok', 'id'))
                    ->required(),
                Forms\Components\Select::make('pengajar')
                    ->label('Pengajar')
                    ->options(User::where('role', 'pengajar')->pluck('name', 'id'))
                    ->required(),

                // Forms\Components\DatePicker::make('tanggal')
                //     ->required()
                //     ->label('Tanggal')
                //     ->native(false)
                //     ->displayFormat('d F Y'),
                // Forms\Components\TimePicker::make('jam')
                //     ->required()
                //     ->label('Jam')
                //     ->native(false)
                //     ->displayFormat('H:i'),
                Forms\Components\TextInput::make('materi')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('kelompok.nama_kelompok')->label('Kelompok')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('pengajarUser.name')->label('Pengajar'),

                Tables\Columns\TextColumn::make('materi')->label('Materi')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Dibuat'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListJadwals::route('/'),
            'create' => Pages\CreateJadwal::route('/create'),
            'edit' => Pages\EditJadwal::route('/{record}/edit'),
        ];
    }
}
