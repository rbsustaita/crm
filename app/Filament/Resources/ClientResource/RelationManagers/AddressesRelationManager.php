<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('tipo_vialidad')
                    ->datalist([
                        'CALLE',
                        'AVENIDA',
                        'BOULEVARD',
                        'CARRETERA',
                        'CALZADA',
                        'CAMINO',
                        'PRIVADA',
                        'ANDADOR',
                        'PROLONGACION',
                        'CIRCUITO',
                        'PASEO',
                        'EJE VIAL',
                        'LIBRAMIENTO',
                        'VIADUCTO',
                        'CALLEJON',
                        'SENDERO',
                    ])
                    ->label('Tipo de vialidad')
                    ->required()
                    ->maxLength(50)
                    ->default(null),
                TextInput::make('nombre_vialidad')
                    ->label('Nombre de la vialidad')
                    ->required()
                    ->maxLength(100)
                    ->default(null),
                TextInput::make('numero_exterior')
                    ->label('Núm. Ext.')
                    ->required()
                    ->maxLength(10)
                    ->default(null),
                TextInput::make('numero_interior')
                    ->label('Núm. Int.')
                    ->maxLength(10)
                    ->default(null),
                TextInput::make('colonia')
                    ->maxLength(100)
                    ->default(null),
                TextInput::make('localidad')
                    ->maxLength(50)
                    ->default(null),
                TextInput::make('alcaldia_municipio')
                    ->maxLength(50)
                    ->default(null),
                TextInput::make('ciudad')
                    ->maxLength(50)
                    ->default(null),
                TextInput::make('estado')
                    ->maxLength(50)
                    ->default(null),
                TextInput::make('codigo_postal')
                    ->label('Código Postal')
                    ->required()
                    /*                    ->numeric() */
                    ->minLength(5)
                    ->maxLength(5)
                    ->rules(['regex:/^\d{5}$/']),

                TextInput::make('país', 'pais_nombre')
                    ->maxLength(50)
                    ->default(null),
                Textarea::make('referencias')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('tipo_de_domicilio')
                    ->searchable(),
                TextColumn::make('tipo_vialidad')
                    ->searchable(),
                TextColumn::make('nombre_vialidad')
                    ->searchable(),
                TextColumn::make('numero_exterior')
                    ->searchable(),
                TextColumn::make('numero_interior')
                    ->searchable(),
                TextColumn::make('colonia')
                    ->searchable(),
                TextColumn::make('localidad')
                    ->searchable(),
                TextColumn::make('municipio')
                    ->searchable(),
                TextColumn::make('ciudad')
                    ->searchable(),
                TextColumn::make('estado')
                    ->searchable(),
                TextColumn::make('codigo_postal')
                    ->searchable(),
                TextColumn::make('pais_nombre')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('referencias')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
