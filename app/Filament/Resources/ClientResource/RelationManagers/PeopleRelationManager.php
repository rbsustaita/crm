<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use App\Models\Person;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class PeopleRelationManager extends RelationManager

{
    protected static ?string $title = 'Contactos';
    protected static string $relationship = 'person';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(100)
                    ->regex('/^[\pL\s]+$/u')
                    ->afterStateUpdated(fn($state, callable $set) => $set('name', mb_strtolower($state)))
                    ->validationMessages([
                        'regex' => 'El campo :attribute solo puede contener letras y espacios.',
                    ]),
                Forms\Components\TextInput::make('middle_name')
                    ->label('Apellido Paterno')
                    ->required()
                    ->maxLength(50)
                    ->regex('/^[\pL\s]+$/u')
                    ->afterStateUpdated(fn($state, callable $set) => $set('middle_name', mb_strtolower($state)))
                    ->validationMessages([
                        'regex' => 'El campo :attribute solo puede contener letras y espacios.',
                    ]),
                Forms\Components\TextInput::make('last_name')
                    ->label('Apellido Materno')
                    ->required()
                    ->maxLength(50)
                    ->regex('/^[\pL\s]+$/u')
                    ->afterStateUpdated(fn($state, callable $set) => $set('last_name', mb_strtolower($state)))
                    ->validationMessages([
                        'regex' => 'El campo :attribute solo puede contener letras y espacios.',
                    ]),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->label('Correo electrónico')
                    ->email()
                    ->unique(Person::class, 'email', fn($record) => $record)
                    ->maxLength(255)
                    ->afterStateUpdated(fn($state, callable $set) => $set('email', mb_strtolower($state))),
                Forms\Components\TextInput::make('phone')
                    ->required()
                    ->label('Teléfono')
                    ->tel()
                    ->nullable()
                    ->length(10)
                    ->regex('/^\d{10}$/')
                    ->validationMessages([
                        'tel' => 'El campo :attribute debe ser un número de teléfono válido.',
                        'length' => 'El campo :attribute debe tener exactamente 10 dígitos.',
                    ]),
                Forms\Components\TextInput::make('rfc')
                    ->required()
                    ->label('RFC')
                    ->nullable()
                    ->alphaNum()
                    ->length(13)
                    ->afterStateUpdated(fn($state, callable $set) => $set('rfc', mb_strtoupper($state)))
                    ->validationMessages([
                        'alpha_num' => 'El campo :attribute solo puede contener letras y números.',
                        'length' => 'El campo :attribute debe tener exactamente 13 caracteres.',
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('fullname')->label('Nombre'),
                /*                 Tables\Columns\TextColumn::make('name')->label('Nombre'),
                Tables\Columns\TextColumn::make('middle_name')->label('Apellido Paterno'),
                Tables\Columns\TextColumn::make('last_name')->label('Apellido Materno'), */
                Tables\Columns\TextColumn::make('email')->label('Correo Electrónico'),
                Tables\Columns\TextColumn::make('phone')->label('Teléfono'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Agregar contacto')
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Se agregó un nuevo contacto')
                            ->body('El contacto ha sido creado exitosamente.'),
                    )
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
