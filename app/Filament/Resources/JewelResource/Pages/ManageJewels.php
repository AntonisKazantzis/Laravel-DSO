<?php

namespace App\Filament\Resources\JewelResource\Pages;

use App\Filament\Resources\JewelResource;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Builder;

class ManageJewels extends ManageRecords
{
    protected static string $resource = JewelResource::class;

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
