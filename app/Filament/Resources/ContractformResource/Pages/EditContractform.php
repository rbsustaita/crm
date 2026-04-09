<?php

namespace App\Filament\Resources\ContractformResource\Pages;

use App\Filament\Resources\ContractformResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContractform extends EditRecord
{
    protected static string $resource = ContractformResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
