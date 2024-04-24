<?php

namespace App\Filament\Resources\GemResource\Pages;

use App\Filament\Resources\GemResource;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Builder;

class ManageGems extends ManageRecords
{
    protected static string $resource = GemResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),

            'ruby' => Tab::make('Ruby')
                ->modifyQueryUsing(fn (Builder $query) => $query->byGemType('ruby')),

            'onyx' => Tab::make('Onyx')
                ->modifyQueryUsing(fn (Builder $query) => $query->byGemType('onyx')),

            'zircon' => Tab::make('Zircon')
                ->modifyQueryUsing(fn (Builder $query) => $query->byGemType('zircon')),

            'rhodolite' => Tab::make('Rhodolite')
                ->modifyQueryUsing(fn (Builder $query) => $query->byGemType('rhodolite')),

            'diamond' => Tab::make('Diamond')
                ->modifyQueryUsing(fn (Builder $query) => $query->byGemType('diamond')),

            'amethyst' => Tab::make('Amethyst')
                ->modifyQueryUsing(fn (Builder $query) => $query->byGemType('amethyst')),

            'cyanite' => Tab::make('Cyanite')
                ->modifyQueryUsing(fn (Builder $query) => $query->byGemType('cyanite')),

            'emerald' => Tab::make('Emerald')
                ->modifyQueryUsing(fn (Builder $query) => $query->byGemType('emerald')),
        ];
    }
}
