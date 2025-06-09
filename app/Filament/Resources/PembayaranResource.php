<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Student;
use Filament\Forms\Form;
use App\Models\Pembayaran;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PembayaranResource\Pages;

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

                Forms\Components\Select::make('bulan')
                    ->label('Bulan')
                    ->options([
                        '01' => 'Januari',
                        '02' => 'Februari',
                        '03' => 'Maret',
                        '04' => 'April',
                        '05' => 'Mei',
                        '06' => 'Juni',
                        '07' => 'Juli',
                        '08' => 'Agustus',
                        '09' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('nominal')
                    ->required()
                    ->numeric(),

                Forms\Components\Select::make('status')
                    ->label('Status')
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
                Tables\Columns\TextColumn::make('bulan')
                    ->label('Bulan')
                    ->formatStateUsing(fn($state) => match ($state) {
                        '01' => 'Januari',
                        '02' => 'Februari',
                        '03' => 'Maret',
                        '04' => 'April',
                        '05' => 'Mei',
                        '06' => 'Juni',
                        '07' => 'Juli',
                        '08' => 'Agustus',
                        '09' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('nominal')->label('Nominal')->money('idr', true),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => [
                        'lunas' => 'Lunas',
                        'belum' => 'Belum Lunas',
                    ][$state] ?? $state)
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'lunas' => 'success',
                        'belum' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('keterangan')->label('Keterangan'),
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal Bayar')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
