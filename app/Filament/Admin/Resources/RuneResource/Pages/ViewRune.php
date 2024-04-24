<?php

namespace App\Filament\Admin\Resources\RuneResource\Pages;

use App\Filament\Admin\Resources\RuneResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRune extends ViewRecord
{
    protected static string $resource = RuneResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
