<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\RelationManagers\PeopleRelationManager;
use App\Filament\Resources\ContractResource\Pages;
use App\Filament\Resources\ContractResource\Pages\ViewContract;
use App\Models\Client;
use App\Models\Contract;
use App\Models\Contractform;
use App\Models\Person;
use App\Models\standard;
use App\Traits\PersonFullName;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Get;
use Filament\Infolists\Infolist;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\HtmlString;
use Filament\Infolists;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\View;

class ContractResource extends Resource
{
    protected static ?string $model = Contract::class;
    protected static ?string $navigationLabel = 'Contratos';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Formatos M-17020 (UI)';

    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make()->columnSpanFull()
                    ->schema([
                        Step::make('Información General')
                            ->description('Partes y representantes')
                            ->schema([
                                Select::make('contract_type')
                                    ->label('Seleccione el tipo de contrato')
/*                                     ->options([
                                        'CONTRATO DE PRESTACIÓN DE SERVICIOS DE VERIFICACIÓN' => 'Contrato de Prestación de Servicios de Verificación',
                                    ]) */
                                    ->required()
                                    ->options(
                                        Contractform::query()
                                            ->where('is_active', true)
                                            ->orderBy('contract_type')
                                            ->pluck('contract_type', 'contract_type')
                                    )
                                    ->columns(1),
                                Select::make('client_id')
                                    ->label('Cliente')
                                    ->searchable()
                                    ->relationship('client', 'name')
                                    ->options(Client::query()->pluck('name', 'id'))
                                    ->live(),

                                Select::make('person_id')
                                    ->label('Representante Legal')
                                    ->searchable()
                                    ->options(
                                        fn(Get $get): SupportCollection =>
                                        $get('client_id')
                                            ? Person::query()
                                            ->where('personable_id', $get('client_id'))
                                            ->get()
                                            ->mapWithKeys(fn($person) => [$person->id => $person->fullname])
                                            : collect()
                                    )
                                    ->live()
                            ]),

                        Step::make('Declaraciones')
                            ->description('de las partes')
                            ->schema([
                                Placeholder::make('cambiar')
                                    ->label('La "UNIDAD DE INSPECCIÓN" declara:')
                                    ->columns(1)
                                    ->content('DECLARACIONES'),
                                Repeater::make('ui_statements')
                                    ->schema([
                                        RichEditor::make('statement')
                                            ->label('Declaración')
                                            ->required(),
                                    ])
                                    ->columns(1)
                                    ->addActionLabel('Agregar declaración de la unidad de inspección')
                                    ->addActionAlignment(Alignment::Start),
                                Placeholder::make('cambiar')
                                    ->label('El "CLIENTE" declara:')
                                    ->columns(1)
                                    ->content('DECLARACIONES'),
                                Repeater::make('client_statements')
                                    ->schema([
                                        RichEditor::make('statement')
                                            ->label('Declaración')
                                            ->required(),
                                    ])
                                    ->columns(1)
                                    ->addActionLabel('Agregar declaración del cliente')
                                    ->addActionAlignment(Alignment::Start),
                            ]),

                        Step::make('Cláusulas')
                            ->schema([
                                Repeater::make('clauses')
                                    ->schema([
                                        RichEditor::make('clauses')
                                            ->label('Cláusulas')
                                            ->columns(1)
                                            ->required(),

                                    ]),

                            ]),

                        Step::make('Normas')
                            ->schema([
                                Select::make('standards')
                                    ->multiple()
                                    /*                                     ->options(standard::all()->pluck('NOM', 'id')) */
                                    ->searchable()
                                    ->options(
                                        Standard::query()
                                            ->where('status', true) // filtra solo activos
                                            ->orderBy('NOM')
                                            ->pluck('NOM', 'id')
                                    ),

                            ]),
                        /*                         Step::make('Borrador')
                            ->schema([
                                Placeholder::make('')
                                ->content(function (Contract $record): string{
                                    return 'CONTRATO DE PRESTACIÓN DE SERVICIOS DE ACUERDO CON LAS NOM' . $record->title;
                                })
                            ]), */
                        /*                         Step::make('Firmas')
                            ->schema([
                                TextInput::make('firma_contratante')
                                    ->label('Firma Contratante')
                                    ->columns(1)
                                    ->required(),
                                TextInput::make('firma_contratista')
                                    ->label('Firma Contratista')
                                    ->columns(1)
                                    ->required(),
                            ]), */
                    ])->submitAction(new HtmlString('<button type="submit">Submit</button>')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client')
                    /*                     ->formatStateUsing(fn($state) => Client::find($state)?->name ?? 'Sin cliente') */
                    ->sortable()
                    ->searchable()
                    ->weight(FontWeight::Bold)
                    /*                     ->description(fn(Contract $record): string => (string) $record->client) */
                    ->wrap(true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListContracts::route('/'),
            'create' => Pages\CreateContract::route('/create'),
            'edit' => Pages\EditContract::route('/{record}/edit'),
            'custom' => Pages\Settings::route('/{record}/settings'),
            'view' => Pages\ViewContract::route('/{record}/view'),
            'view-contract' => Pages\ViewContractLayout::route('/{record}/layout'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ComponentsSection::make('UNIDAD DE INSPECCIÓN "NOMBRE" S.A. DE C.V.')
                    ->description('MEMBRETE DEL CONTRATO')
                    ->columns(1)
                    ->schema([
                        TextEntry::make('contract_type')
                            ->label('')
                            ->columnSpanFull()
                            ->alignment(Alignment::Center)
                            ->weight(FontWeight::Bold)
                            ->size('lg')
                            ->color('info'),
                        /*                             TextEntry::make('client_statements')
                            ->label('CLIENTE:')
                            ->columnSpanFull()
                            ->alignment(Alignment::Center), */

                        View::make('filament.infolists.components.box')
                            ->label('')
                            ->columnSpanFull(),
                        /*                         TextEntry::make('client')
                            ->label('NÚMERO DE CONTRATO')
                            ->alignment(Alignment::Right), */

                        /*                         TextEntry::make('standards')
                            ->label('')
                            ->columnSpanFull(), */
                    ]),
            ]);
    }
}
