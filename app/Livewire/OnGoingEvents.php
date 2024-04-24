<?php

namespace App\Livewire;

use App\Models\EventCalendar;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class OnGoingEvents extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->heading(__('On Going Events'))
            ->query(
                EventCalendar::query()
                    ->where('start_time', '<=', now())
                    ->where('end_time', '>=', now())
                    ->where('is_active', true)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->wrap()
                    ->html()
                    ->markdown(),

                Tables\Columns\TextColumn::make('start_time')
                    ->since()
                    ->description(fn (EventCalendar $record): string => $record->start_time->format('Y-m-d H:i')),

                Tables\Columns\TextColumn::make('end_time')
                    ->since()
                    ->description(fn (EventCalendar $record): string => $record->end_time->format('Y-m-d H:i')),
            ])
            ->paginated(false);
    }
}
