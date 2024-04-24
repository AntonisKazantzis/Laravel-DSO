<?php

namespace App\Filament\Resources\RuneResource\Pages;

use App\Filament\Resources\RuneResource;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Builder;

class ManageRunes extends ManageRecords
{
    protected static string $resource = RuneResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),

            'common' => Tab::make('Common')
                ->modifyQueryUsing(fn (Builder $query) => $query->byRuneRarity('common')),

            'improved' => Tab::make('Improved')
                ->modifyQueryUsing(fn (Builder $query) => $query->byRuneRarity('improved')),

            'magic' => Tab::make('Magic')
                ->modifyQueryUsing(fn (Builder $query) => $query->byRuneRarity('magic')),

            'extraordinary' => Tab::make('Extraordinary')
                ->modifyQueryUsing(fn (Builder $query) => $query->byRuneRarity('extraordinary')),

            'legendary' => Tab::make('Legendary')
                ->modifyQueryUsing(fn (Builder $query) => $query->byRuneRarity('legendary')),

            'unique' => Tab::make('Unique')
                ->modifyQueryUsing(fn (Builder $query) => $query->byRuneRarity('unique')),
        ];
    }
}
