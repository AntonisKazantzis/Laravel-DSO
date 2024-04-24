<?php

namespace App\Filament\Admin\Resources\RuneResource\Pages;

use App\Filament\Admin\Resources\RuneResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListRunes extends ListRecords
{
    protected static string $resource = RuneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

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
