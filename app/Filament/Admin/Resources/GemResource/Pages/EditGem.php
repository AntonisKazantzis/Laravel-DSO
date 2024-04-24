<?php

namespace App\Filament\Admin\Resources\GemResource\Pages;

use App\Filament\Admin\Resources\GemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGem extends EditRecord
{
    protected static string $resource = GemResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
