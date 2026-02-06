<?php

namespace App\Filament\Imports;

use App\Models\Person;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;



class PersonImporter extends Importer
{
    protected static ?string $model = Person::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->example('juan')
                ->label('nombre')
                ->requiredMapping()
                ->rules(['required', 'max:100'])
                ->fillRecordUsing(function (Person $record, string $state): void {
                    $record->name = mb_strtolower($state);
                }),
            ImportColumn::make('middle_name')
                ->example('perez')
                ->label('apellido paterno')
                ->requiredMapping()
                ->rules(['required', 'max:50'])
                ->fillRecordUsing(function (Person $record, string $state): void {
                    $record->middle_name = mb_strtolower($state);
                }),
            ImportColumn::make('last_name')
                ->example('lopez')
                ->label('apellido materno')
                ->requiredMapping()
                ->rules(['required', 'max:50'])
                ->fillRecordUsing(function (Person $record, string $state): void {
                    $record->last_name = mb_strtolower($state);
                }),
            ImportColumn::make('email')
                ->example('juan.perez@example.com')
                ->label('correo electrónico')
                ->requiredMapping()
                ->rules(['required', 'email', 'max:255'])
            /*                 ->fillRecordUsing(function (Person $record, string $state): void {
                    $record->email = strtolower($state);
                }) */,
            ImportColumn::make('phone')
                ->example('1234567890')
                ->label('teléfono')
                ->rules(['max:255']),

            ImportColumn::make('rfc')
                ->example('ABC123456789')
                ->label('RFC')
                //Esta regla permite ingresar solo RFC's válidos de personas físicas, acepta mayusc y minusc.
                ->rules(['size:13', 'regex:/^[A-ZÑ&]{3,4}[0-9]{6}[A-Z0-9]{3}$/i'])
                //Transforma las minúsculas a mayúsculas antes de guardar
                ->fillRecordUsing(function (Person $record, string $state): void {
                    $record->rfc = strtoupper($state);
                }),

            ImportColumn::make('personable_type')
                ->label('personable_type'),

            ImportColumn::make('personable_id')
                ->label('personable_id'),
        ];
    }

    public function resolveRecord(): ?Person
    {
        return Person::firstOrNew([
            //     // Update existing records, matching them by `$this->data['column_name']`
            'email' => $this->data['email'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your person import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }

    public function getJobBatchName(): ?string
    {
        return 'Importación de Personas';
    }
}
