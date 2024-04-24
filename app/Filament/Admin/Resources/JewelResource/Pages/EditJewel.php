<?php

namespace App\Filament\Admin\Resources\JewelResource\Pages;

use App\Filament\Admin\Resources\JewelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJewel extends EditRecord
{
    protected static string $resource = JewelResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
