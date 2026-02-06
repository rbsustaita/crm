<?php

namespace App\Filament\Resources\PersonResource\Pages;

use App\Filament\Resources\PersonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPerson extends EditRecord
{
    protected static string $resource = PersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    /*     protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    } */

    protected function getRedirectUrl(): string //Redirige al view del registro editado
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
