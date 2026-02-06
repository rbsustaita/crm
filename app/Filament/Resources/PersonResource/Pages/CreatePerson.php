<?php

namespace App\Filament\Resources\PersonResource\Pages;

use App\Filament\Resources\PersonResource;
use App\Filament\Imports\PersonImporter;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Actions as ComponentsActions;
use Filament\Resources\Pages\CreateRecord;

class CreatePerson extends CreateRecord
{
    protected static string $resource = PersonResource::class;
    protected static ?string $title = 'Nuevo Contacto';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ImportAction::make()
                ->importer(PersonImporter::class)
                ->color('success')
                ->requiresConfirmation(),
        ];
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Person registered';
    }

}
