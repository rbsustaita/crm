<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SolicitudeResource\Pages;
use App\Filament\Resources\SolicitudeResource\RelationManagers;
use App\Models\Solicitude;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SolicitudeResource extends Resource
{
    protected static ?string $model = Solicitude::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('numero_solicitud')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('client_id')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('fecha_solicitud')
                    ->required(),
                Forms\Components\TextInput::make('norma_aplicable')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('servicio_solicitado')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('direccion_fiscal')
                    ->required()
                    ->maxLength(300),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('numero_solicitud')
                    ->searchable(),
                Tables\Columns\TextColumn::make('client_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_solicitud')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('norma_aplicable')
                    ->searchable(),
                Tables\Columns\TextColumn::make('servicio_solicitado')
                    ->searchable(),
                Tables\Columns\TextColumn::make('direccion_fiscal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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
            'index' => Pages\ListSolicitudes::route('/'),
            'create' => Pages\CreateSolicitude::route('/create'),
            'edit' => Pages\EditSolicitude::route('/{record}/edit'),
        ];
    }
}
