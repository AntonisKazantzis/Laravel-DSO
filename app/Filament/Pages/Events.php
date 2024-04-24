<?php

namespace App\Filament\Pages;

use App\Livewire\OnGoingEvents;
use App\Livewire\UpcomingEvents;
use Filament\Pages\Page;

class Events extends Page
{
    protected static ?string $navigationIcon = 'tabler-calendar-event';

    protected static ?string $navigationLabel = 'Events';

    protected static ?string $navigationGroup = 'News';

    protected static string $view = 'filament.pages.events';

    public function getHeaderWidgetsColumns(): int|array
    {
        return 1;
    }

    public function getHeaderWidgets(): array
    {
        return [
            OnGoingEvents::class,
            UpcomingEvents::class,
        ];
    }
}
