<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContractformResource\Pages;
use App\Filament\Resources\ContractformResource\RelationManagers;
use App\Models\Contractform;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContractformResource extends Resource
{
    protected static ?string $model = Contractform::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Tipo de Contrato')
                        ->schema([
                            Forms\Components\TextInput::make('contract_type')
                                ->label('Tipo de Contrato')
                                ->required()
                                ->maxLength(255),
                        ])
                        ->columns(2),
                    Wizard\Step::make('Datos del Contrato')
                        ->schema([
                            Forms\Components\TextInput::make('identifier')
                                ->label('Identificador')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('review')
                                ->label('Revisión')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\DatePicker::make('effective_date')
                                ->label('Fecha de Vigencia')
                                ->required(),
                        ])->columns(3),
                    Wizard\Step::make('Declaraciones')
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
                    Wizard\Step::make('Cláusulas')
                        ->schema([
                            Repeater::make('clauses')
                                ->schema([
                                    Forms\Components\TextInput::make('title')
                                        ->label('Título de la Cláusula')
                                        ->required()
                                        ->maxLength(255),
                                    RichEditor::make('content')
                                        ->label('Contenido de la Cláusula')
                                        ->required(),
                                ])
                                ->columns(1)
                                ->addActionLabel('Agregar cláusula')
                                ->addActionAlignment(Alignment::Start),
                        ])
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('contract_type')->label('Tipo de Contrato')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('identifier')->label('Identificador')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('review')->label('Revisión')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('effective_date')->label('Fecha de Vigencia')->sortable(),
                Tables\Columns\BooleanColumn::make('is_active')->label('Activo')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Creado')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('updated_at')->label('Actualizado')->dateTime()->sortable(),
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
            'index' => Pages\ListContractforms::route('/'),
            'create' => Pages\CreateContractform::route('/create'),
            'edit' => Pages\EditContractform::route('/{record}/edit'),
        ];
    }
}
