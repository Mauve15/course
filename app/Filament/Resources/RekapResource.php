<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Rekap;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\RekapResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RekapResource\RelationManagers;

class RekapResource extends Resource
{
    protected static ?string $model = Rekap::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('student_id')
                    ->label('Siswa')
                    ->relationship('student', 'nama')
                    ->required()
                    ->searchable(),

                Select::make('jadwal_id')
                    ->label('Jadwal')
                    ->relationship('jadwal', 'id') // atau bisa custom tampilkan kelompok & guru
                    ->required(),

                Select::make('absen')
                    ->options([
                        'hadir' => 'Hadir',
                        'izin' => 'Izin',
                        'alfa' => 'Alfa',
                    ])
                    ->required(),

                TextInput::make('score')
                    ->numeric()
                    ->required(),

                TextInput::make('materi')->required(),

                Textarea::make('keterangan')->rows(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.nama')->label('Siswa')->searchable(),
                TextColumn::make('jadwal.kelompok.nama_kelompok')->label('Kelompok'),
                TextColumn::make('materi'),
                TextColumn::make('absen'),
                TextColumn::make('score'),
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
            'index' => Pages\ListRekaps::route('/'),
            'create' => Pages\CreateRekap::route('/create'),
            'edit' => Pages\EditRekap::route('/{record}/edit'),
        ];
    }
}
