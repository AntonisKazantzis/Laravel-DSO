<?php

namespace App\Filament\Admin\Resources\GemResource\Pages;

use App\Filament\Admin\Resources\GemResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListGems extends ListRecords
{
    protected static string $resource = GemResource::class;

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
