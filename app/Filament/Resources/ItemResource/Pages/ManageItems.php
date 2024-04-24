<?php

namespace App\Filament\Resources\ItemResource\Pages;

use App\Filament\Resources\ItemResource;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Builder;

class ManageItems extends ManageRecords
{
    protected static string $resource = ItemResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),

            'dragonknight' => Tab::make('Dragonknight')
                ->modifyQueryUsing(fn (Builder $query) => $query->byCharacterClass('dragonknight')),

            'spellweaver' => Tab::make('Spellweaver')
                ->modifyQueryUsing(fn (Builder $query) => $query->byCharacterClass('spellweaver')),

            'ranger' => Tab::make('Ranger')
                ->modifyQueryUsing(fn (Builder $query) => $query->byCharacterClass('ranger')),

            'steam_mechanicus' => Tab::make('Steam Mechanicus')
                ->modifyQueryUsing(fn (Builder $query) => $query->byCharacterClass('steam_mechanicus')),
        ];
    }
}
