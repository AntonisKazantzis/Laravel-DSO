<?php

namespace App\Filament\Admin\Resources\JewelResource\Pages;

use App\Filament\Admin\Resources\JewelResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewJewel extends ViewRecord
{
    protected static string $resource = JewelResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
