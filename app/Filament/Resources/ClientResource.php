<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Models\Client;
use App\Helpers\Traits\RfcTrait;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ToggleColumn;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;
    protected static ?string $navigationLabel = 'Clientes';
    protected static ?string $navigationGroup = 'Clients Management';
    protected static ?string $navigationIcon = 'heroicon-c-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('RFC del Cliente')
                    ->columns(3)
                    ->schema([
                        TextInput::make('tax_id')
                            ->label('Ingresa el RFC del cliente')
                            ->required()
                            ->reactive()
                            ->minLength(12)
                            ->maxLength(13)
                            ->debounce(1000)
                            ->default(fn($record) => mb_strtoupper($record?->tax_id))
                            ->afterStateUpdated(function ($set, $get, ?string $state) {
                                $set('tax_id', mb_strtoupper($state));

                                if (!RfcTrait::rfcValido($state)) {
                                    $set('rfc_invalido', true);
                                    $set('tipo_persona', null);
                                    $set('entidad_existente', null);
                                    return;
                                }

                                $set('rfc_invalido', false);
                                $set('tipo_persona', RfcTrait::tipoDePersonaPorRfc($state));
                                $set('entidad_existente', RfcTrait::rfcExisteEn($state, 'client', 'tax_id'));
                            }),

                        Hidden::make('rfc_invalido')
                            ->dehydrated(false),
                        Hidden::make('entidad_existente')
                            ->dehydrated(false),

                        Section::make('RFC inválido')
                            ->visible(fn($get) => $get('rfc_invalido') === true)
                            ->description('❌ El RFC ingresado no es válido.'),

                        Section::make('Entidad existente')
                            ->visible(fn($get) => $get('entidad_existente') === true && $get('rfc_invalido') === false)
                            ->description('⚠️ Esta entidad ya está registrada.'),

                        TextInput::make('tipo_persona')
                            ->label('Tipo de persona')
                            ->disabled()
                            ->dehydrated(true)
                            ->default(fn($record) => $record?->tipo_persona),
                    ]),

                // 🔥 Sección separada y reactiva
                Section::make('Información del cliente')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre del cliente')
                            ->required()
                            ->maxLength(150)
                            ->afterStateUpdated(fn($state, callable $set) => $set('name', mb_strtoupper($state)))
                            ->live(onBlur: true),

                        TextInput::make('trade_name')
                            ->label('Nombre comercial')
                            ->required()
                            ->maxLength(150)
                            ->afterStateUpdated(fn($state, callable $set) => $set('trade_name', mb_strtoupper($state)))
                            ->live(onBlur: true),

                        Select::make('sector')
                            ->options([
                                'Primario' => 'Extractivo',
                                'Secundario' => 'Transformación',
                                'Terciario' => 'Servicios',
                                'Cuaternario' => 'Conocimiento y Tecnología',
                                'Otros' => 'Otros',
                            ])
                            ->label('Sector económico al que pertenece')
                            ->live(),

                        Select::make('sub_category')
                            ->label('Subcategoría')
                            ->required()
                            ->options(fn(Get $get): array => match ($get('sector')) {
                                'Primario' => [
                                    'Agricultura' => 'Agricultura',
                                    'Ganadería' => 'Ganadería',
                                    'Silvicultura' => 'Silvicultura',
                                    'Pesca_y_acuicultura' => 'Pesca y acuicultura',
                                    'Minería' => 'Minería',
                                    'Otros' => 'Otros',
                                ],
                                'Secundario' => [
                                    'Industria_alimentaria' => 'Industria alimentaria',
                                    'Textil_y_confección' => 'Textil y confección',
                                    'Industria_química' => 'Industria química',
                                    'Industria metalúrgica' => 'Industria metalúrgica',
                                    'Industria automotriz' => 'Industria automotriz',
                                    'Industria_electrónica_y_eléctrica' => 'Industria electrónica y eléctrica',
                                    'Industria_de_la_construcción' => 'Industria de la construcción',
                                    'Industria_maderera_y_papelera' => 'Industria maderera y papelera',
                                    'Industria_del_vidrio_y_cerámica' => 'Industria del vidrio y cerámica',
                                    'Otros' => 'Otros',

                                ],
                                'Terciario' => [
                                    'Comercio' => 'Comercio',
                                    'Transporte_y_logística' => 'Transporte y logística',
                                    'Servicios_financieros' => 'Servicios financieros',
                                    'Turismo_y_hostelería' => 'Turismo y hostelería',
                                    'Salud' => 'Salud',
                                    'Educación' => 'Educación',
                                    'medios_de_comunicación_y_entretenimiento' => 'Medios de comunicación y entretenimiento',
                                    'Otros' => 'Otros',
                                ],
                                'Cuaternario' => [
                                    'Tecnologías_de_la_información' => 'Tecnologías de la información',
                                    'Investigación_y_desarrollo_(I+D)' => 'Investigación y desarrollo (I+D)',
                                    'Consultoría_y_servicios_profesionales' => 'Consultoría y servicios profesionales',
                                    'servicios_creativos_y_culturales' => 'Servicios creativos y culturales',
                                ],
                                'Otros' => [
                                    'Otros' => 'Otros'
                                ],
                                default => [],
                            }),
                        TextInput::make('website')
                            ->label('Sitio web')
                            ->suffixIcon('heroicon-m-globe-alt')
                            ->maxLength(100)
                            ->nullable()
                            ->live(onBlur: true),
                    ])
                    ->visible(function ($get, $livewire) {
                        $modoEdicion = $livewire instanceof \Filament\Resources\Pages\EditRecord;
                        return $modoEdicion || (
                            $get('rfc_invalido') === false && $get('entidad_existente') === false
                        );
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('trade_name'),
                Tables\Columns\TextColumn::make('tax_id'),
                /*                 Tables\Columns\TextColumn::make('address_id'),
                Tables\Columns\TextColumn::make('industry'),
                Tables\Columns\TextColumn::make('website'), */
                ToggleColumn::make('active')
                    ->label('¿Activo?')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    /*                     ->offColor('danger') */
                    ->inline(false),
                /*                 Tables\Columns\TextColumn::make('active')
                    ->label('¿Activo?')
                    ->color(fn(string $state): string => match ($state) {
                        '1' => 'success',
                        '0' => 'warning',
                        default => 'gray',
                    }), */
                Tables\Columns\TextColumn::make('person_count')->counts('person')->label('No. de Contactos'),
                /*                 Tables\Columns\TextColumn::make('person.fullname')->label('Contactos'), */
                Tables\Columns\TextColumn::make('created_at')->label('Fecha de Creación')
                    ->dateTime('d/m/Y H:i:s')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')->label('Fecha de Actualización')
                    ->dateTime('d/m/Y H:i:s')
                    ->toggleable(),
            ])

            ->filters([
                Tables\Filters\TernaryFilter::make('active')->label('¿Activo?'),
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
            ClientResource\RelationManagers\PeopleRelationManager::class,
            ClientResource\RelationManagers\AddressesRelationManager::class,

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
