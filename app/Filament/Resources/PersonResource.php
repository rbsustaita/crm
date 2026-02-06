<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PersonResource\Pages;
use Filament\Resources\Pages\Page;
use App\Filament\Resources\PersonResource\RelationManagers;
use App\Models\Client;
use App\Models\Person;
use App\Rules\ValidRfc;
use Filament\Forms;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Pages\SubNavigationPosition;
use Filament\Support\Enums\IconPosition;

class PersonResource extends Resource
{
    protected static ?string $model = Person::class;

    protected static ?string $navigationIcon = 'heroicon-m-user-group';
    protected static ?string $navigationGroup = 'People Management';
    protected static ?string $navigationLabel = 'Personas';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información personal')
                    ->columns(3)
                    ->schema([
                        TextInput::make('name')
                            ->translateLabel('name') // Equivalent to `label(__('name'))`
                            ->label('Nombre')
                            ->required()
                            ->maxLength(100)
                            ->regex('/^[\pL\s]+$/u')
                            ->afterStateUpdated(fn($state, callable $set) => $set('name', mb_strtolower($state)))
                            ->validationMessages([
                                'regex' => 'El campo :attribute solo puede contener letras y espacios.',
                            ]),
                        TextInput::make('middle_name')
                            ->label('Apellido Paterno')
                            ->required()
                            ->maxLength(50)
                            ->regex('/^[\pL\s]+$/u')
                            ->afterStateUpdated(fn($state, callable $set) => $set('middle_name', mb_strtolower($state)))
                            ->validationMessages([
                                'regex' => 'El campo :attribute solo puede contener letras y espacios.',
                            ]),
                        TextInput::make('last_name')
                            ->label('Apellido Materno')
                            ->required()
                            ->maxLength(50)
                            ->regex('/^[\pL\s]+$/u')
                            ->afterStateUpdated(fn($state, callable $set) => $set('last_name', mb_strtolower($state)))
                            ->validationMessages([
                                'regex' => 'El campo :attribute solo puede contener letras y espacios.',
                            ]),
                        TextInput::make('email')
                            ->required()
                            ->label('Correo electrónico')
                            ->email()
                            ->unique(Person::class, 'email', fn($record) => $record)
                            ->maxLength(255)
                            ->afterStateUpdated(fn($state, callable $set) => $set('email', mb_strtolower($state))),
                        TextInput::make('phone')
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
                        TextInput::make('rfc')
                            ->label('RFC')
                            ->nullable()
                            ->alphaNum()
                            ->length(13)
                            /*                             ->afterStateUpdated(fn($state, callable $set) => $set('rfc', mb_strtoupper($state)))
                            ->validationMessages([
                                'alpha_num' => 'El campo :attribute solo puede contener letras y números.',
                                'length' => 'El campo :attribute debe tener exactamente 13 caracteres.',
                            ]), */
                            ->afterStateUpdated(fn($state, callable $set) => $set('tax_id', mb_strtoupper($state)))
                            ->rule(new ValidRfc())
                            ->live(onBlur: true),
                        /*                         Select::make('tipo_persona')
                            ->label('Tipo de Persona')
                            ->options([
                                'contacto_cliente' => 'Cliente',
                                'empleado' => 'Empleado',
                                'contacto_proveedor' => 'Proveedor',
                            ])
                            ->required(), */
                        /*                         Select::make('personable_type')
                            ->label('Asociar a')
                            ->options([
                                Client::class
                            ]), */
                        MorphToSelect::make('personable')
                            ->label('Relacionado con')
                            ->types([
                                MorphToSelect\Type::make(Client::class)
                                    ->titleAttribute('name'),
                            ])
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live(),

                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('FullName') // Accessor in the Model
                    ->label('Nombre completo')
                    ->searchable(['middle_name', 'last_name', 'name',])
                    ->sortable(['middle_name']),
                TextColumn::make('email')
                    ->icon('heroicon-m-envelope')
                    ->iconPosition(IconPosition::After) // `IconPosition::Before` or `IconPosition::After`
                    ->label('Correo Electrónico')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Teléfono')
                    ->searchable(),
                TextColumn::make('rfc')
                    ->label('RFC')
                    ->searchable(),
                TextColumn::make('client.name')
                    ->label('Cliente')
                    ->searchable()
            ])
            ->defaultSort('created_at', 'desc')
            ->persistSortInSession()
            ->searchPlaceholder('Search (Nombre)')
            ->searchDebounce('750ms')
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
            'index' => Pages\ListPeople::route('/'),
            'create' => Pages\CreatePerson::route('/create'),
            'view' => Pages\ViewPerson::route('/{record}'),
            'edit' => Pages\EditPerson::route('/{record}/edit'),
        ];
    }

    //Se agregó un sub-menú al recurso Persona
    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\ViewPerson::class,
            Pages\EditPerson::class,
        ]);
    }
}
