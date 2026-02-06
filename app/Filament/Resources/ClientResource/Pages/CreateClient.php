<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateClient extends CreateRecord
{
    protected static string $resource = ClientResource::class;

    protected function beforeCreate(): void
    {
        // ...
    }

    protected function getCreatedNotification(): ?Notification
    {
    return Notification::make()
        ->success()
        ->title('Cliente registrado')
        ->body('El cliente ha sido creado exitosamente. Despúes de esto, podrás agregar contactos relacionados.');
    }
}
