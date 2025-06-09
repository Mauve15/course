<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudent extends EditRecord
{
    protected static string $resource = StudentResource::class;
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['user']['role']) && $this->record->user) {
            $this->record->user->update([
                'role' => $data['user']['role'],
            ]);
        }

        // Hapus nested 'user' dari data Student, karena tidak perlu disimpan langsung ke tabel students
        unset($data['user']);

        return $data;
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
