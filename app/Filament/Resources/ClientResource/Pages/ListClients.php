<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use App\Models\Client;
use Filament\Actions;
use Filament\Pages\Page;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ListClients extends ListRecords
{
    protected static string $resource = ClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Clients')
                ->icon('heroicon-m-user-group')
                ->badge(Client::query()->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn(Builder $query) => $query->withoutGlobalScopes([SoftDeletingScope::class])),
            'active' => Tab::make('Active Clients')
                ->icon('heroicon-s-user')
                ->badge(Client::query()->where('active', true)->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('active', true)),
            'inactive' => Tab::make('Inactive Clients')
                ->icon('heroicon-o-user')
                ->badge(Client::query()->where('active', false)->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('active', false)),
        ];
    }
}
