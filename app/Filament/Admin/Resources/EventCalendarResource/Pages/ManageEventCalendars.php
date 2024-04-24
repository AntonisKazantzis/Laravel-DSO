<?php

namespace App\Filament\Admin\Resources\EventCalendarResource\Pages;

use App\Filament\Admin\Resources\EventCalendarResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEventCalendars extends ManageRecords
{
    protected static string $resource = EventCalendarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New event'),
        ];
    }
}
