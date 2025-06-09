<?php

namespace App\Filament\Resources\RegistrasiResource\Pages;

use Filament\Actions;
use App\Models\Pembayaran;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\RegistrasiResource;

class EditRegistrasi extends EditRecord
{
    protected static string $resource = RegistrasiResource::class;
    protected function afterSave(): void
    {
        if ($this->record->status === 'aktif') {
            // Cek jika pembayaran belum ada untuk student ini
            $exists = Pembayaran::where('student_id', $this->record->student_id)->exists();
            if (!$exists) {
                Pembayaran::create([
                    'student_id' => $this->record->student_id,
                    'bulan' => date('Y-m'),
                    'nominal' => 100000,
                    'status' => 'belum',
                    'keterangan' => 'Pembayaran otomatis saat aktivasi',
                ]);
            }
        }
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
