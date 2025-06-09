<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Student;
use App\Models\Kelompok;
use Filament\Forms\Form;
use App\Models\Registrasi;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RegistrasiResource\Pages;
use App\Filament\Resources\RegistrasiResource\RelationManagers;
use App\Models\Registration;

class RegistrasiResource extends Resource
{
    protected static ?string $model = Registration::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('student_id')
                    ->label('Siswa')
                    ->options(Student::all()->pluck('nama', 'id'))
                    ->required(),
                Forms\Components\Select::make('kelompok_id')
                    ->label('Kelompok')
                    ->options(Kelompok::all()->pluck('nama_kelompok', 'id'))
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'aktif' => 'aktif',
                        'belum aktif' => 'belum aktif',
                    ])
                    // ->default('aktif')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('student.nama')
                    ->label('Siswa')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kelompok.nama_kelompok')
                    ->label('Kelompok')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'aktif' => 'success',
                        'belum aktif' => 'gray',
                        default => 'secondary',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
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
            'index' => Pages\ListRegistrasis::route('/'),
            'create' => Pages\CreateRegistrasi::route('/create'),
            'edit' => Pages\EditRegistrasi::route('/{record}/edit'),
        ];
    }
}
