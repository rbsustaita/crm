<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AddressResource\Pages;
use App\Filament\Resources\AddressResource\RelationManagers;
use App\Models\Address;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AddressResource extends Resource
{

    protected static ?string $model = Address::class;
    protected static ?string $navigationLabel = 'Direcciones';
    protected static ?string $navigationIcon = 'heroicon-c-building-office-2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('tipo_de_domicilio')
                    ->datalist([
                        'DOMICILIO FISCAL',
                        'DOMICILIO LABORAL',
                        'DOMICILIO DE INSPECCIÓN',
                        'OTRO',
                    ])
                    ->label('Tipo de domicilio')
                    ->required()
                    ->maxLength(50)
                    ->default(null),
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
                    ->default(null)
                    ->afterStateUpdated(fn($state, callable $set) => $set('nombre_vialidad', mb_strtoupper($state)))
                    ->live(onBlur: true),
                TextInput::make('numero_exterior')
                    ->label('Núm. Ext.')
                    ->required()
                    ->maxLength(10)
                    ->default(null)
                    ->afterStateUpdated(fn($state, callable $set) => $set('numero_exterior', mb_strtoupper($state)))
                    ->live(onBlur: true),
                TextInput::make('numero_interior')
                    ->label('Núm. Int.')
                    ->maxLength(10)
                    ->default(null)
                    ->afterStateUpdated(fn($state, callable $set) => $set('numero_interior', mb_strtoupper($state)))
                    ->live(onBlur: true),
                TextInput::make('colonia')
                    ->maxLength(100)
                    ->default(null)
                    ->afterStateUpdated(fn($state, callable $set) => $set('colonia', mb_strtoupper($state)))
                    ->live(onBlur: true),
                /*                 TextInput::make('localidad')
                    ->maxLength(50)
                    ->default(null)
                    ->afterStateUpdated(fn($state, callable $set) => $set('localidad', mb_strtoupper($state)))
                    ->live(onBlur: true), */
                TextInput::make('municipio')
                    ->label('Municipio o Alcaldía')
                    ->maxLength(50)
                    ->default(null)
                    ->afterStateUpdated(fn($state, callable $set) => $set('municipio', mb_strtoupper($state)))
                    ->live(onBlur: true),
                TextInput::make('entidad')
                    ->label('Entidad Federativa')
                    ->maxLength(50)
                    ->default(null)
                    ->afterStateUpdated(fn($state, callable $set) => $set('entidad', mb_strtoupper($state)))
                    ->live(onBlur: true),
                TextInput::make('codigo_postal')
                    ->label('Código Postal')
                    ->required()
                    /*                    ->numeric() */
                    ->minLength(5)
                    ->maxLength(5)
                    ->rules(['regex:/^\d{5}$/']),
                /*                 TextInput::make('país', 'pais_nombre')
                    ->maxLength(50)
                    ->default(null)
                    ->afterStateUpdated(fn($state, callable $set) => $set('pais_nombre', mb_strtoupper($state)))
                    ->live(onBlur: true), */
                TextInput::make('pais_nombre')
                    ->datalist([
                        'MÉXICO',
                    ])
                    ->label('País')
                    ->required()
                    ->maxLength(50)
                    ->default('MÉXICO'),
                Textarea::make('referencias')
                    ->helperText('Información adicional para localizar el domicilio. Ejemplo: entre calles, frente a, cerca de, etc.')
                    ->maxLength(255)
                    ->default(null)
                    ->afterStateUpdated(fn($state, callable $set) => $set('referencias', mb_strtoupper($state)))
                    ->live(onBlur: true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAddresses::route('/'),
            'create' => Pages\CreateAddress::route('/create'),
            'edit' => Pages\EditAddress::route('/{record}/edit'),
        ];
    }
}
