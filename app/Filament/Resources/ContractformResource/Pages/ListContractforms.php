<?php

namespace App\Filament\Resources\ContractformResource\Pages;

use App\Filament\Resources\ContractformResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContractforms extends ListRecords
{
    protected static string $resource = ContractformResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
