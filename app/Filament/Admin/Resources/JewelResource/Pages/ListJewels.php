<?php

namespace App\Filament\Admin\Resources\JewelResource\Pages;

use App\Filament\Admin\Resources\JewelResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListJewels extends ListRecords
{
    protected static string $resource = JewelResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('Create Gem')),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),

            'common' => Tab::make('Common')
                ->modifyQueryUsing(fn (Builder $query) => $query->byJewelRarity('common')),

            'improved' => Tab::make('Improved')
                ->modifyQueryUsing(fn (Builder $query) => $query->byJewelRarity('improved')),

            'magic' => Tab::make('Magic')
                ->modifyQueryUsing(fn (Builder $query) => $query->byJewelRarity('magic')),

            'extraordinary' => Tab::make('Extraordinary')
                ->modifyQueryUsing(fn (Builder $query) => $query->byJewelRarity('extraordinary')),

            'legendary' => Tab::make('Legendary')
                ->modifyQueryUsing(fn (Builder $query) => $query->byJewelRarity('legendary')),

            'mythic' => Tab::make('Mythic')
                ->modifyQueryUsing(fn (Builder $query) => $query->byJewelRarity('mythic')),
        ];
    }
}
