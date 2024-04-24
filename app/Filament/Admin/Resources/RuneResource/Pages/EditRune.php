<?php

namespace App\Filament\Admin\Resources\RuneResource\Pages;

use App\Filament\Admin\Resources\RuneResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRune extends EditRecord
{
    protected static string $resource = RuneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
