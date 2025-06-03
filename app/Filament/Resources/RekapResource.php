<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Rekap;
use App\Models\Jadwal;
use App\Models\Student;
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
                Forms\Components\Select::make('student_id')
                    ->label('Siswa')
                    ->options(Student::all()->pluck('nama', 'id'))
                    ->required(),
                Forms\Components\Select::make('jadwal_id')
                    ->label('Jadwal')
                    ->options(Jadwal::all()->pluck('materi', 'id'))
                    ->required(),
                Forms\Components\TextInput::make('absen')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('score')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('keterangan')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('student.nama')->label('Siswa')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('jadwal.materi')->label('Materi')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('absen')->label('Absen'),
                Tables\Columns\TextColumn::make('score')->label('Nilai'),
                Tables\Columns\TextColumn::make('keterangan')->label('Keterangan'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Tanggal'),
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
