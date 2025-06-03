<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Student;
use Filament\Forms\Form;
use App\Models\Pembayaran;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PembayaranResource\Pages;
use App\Filament\Resources\PembayaranResource\RelationManagers;

class PembayaranResource extends Resource
{
    protected static ?string $model = Pembayaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('student_id')
                    ->label('Siswa')
                    ->options(Student::all()->pluck('nama', 'id'))
                    ->required(),
                Forms\Components\DatePicker::make('bulan')
                    ->required()
                    ->displayFormat('F Y'),
                Forms\Components\TextInput::make('nominal')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('status')
                    ->options([
                        'lunas' => 'Lunas',
                        'belum' => 'Belum Lunas',
                    ])
                    ->default('belum')
                    ->required(),
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
                Tables\Columns\TextColumn::make('bulan')->label('Bulan')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('nominal')->label('Nominal')->money('idr', true),
                Tables\Columns\TextColumn::make('status')
                    ->formatStateUsing(fn($state) => [
                        'lunas' => 'Lunas',
                        'belum' => 'Belum Lunas',
                    ][$state] ?? $state)
                    ->badge() // opsional: jika ingin tampilan seperti badge
                    ->color(fn($state) => match ($state) {
                        'lunas' => 'success',
                        'belum' => 'warning',
                        default => 'gray',
                    })
                    ->label('Status'),

                Tables\Columns\TextColumn::make('keterangan')->label('Keterangan'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Tanggal Bayar'),
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
            'index' => Pages\ListPembayarans::route('/'),
            'create' => Pages\CreatePembayaran::route('/create'),
            'edit' => Pages\EditPembayaran::route('/{record}/edit'),
        ];
    }
}
