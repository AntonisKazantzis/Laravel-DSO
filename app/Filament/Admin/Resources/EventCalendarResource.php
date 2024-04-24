<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\EventCalendarResource\Pages;
use App\Models\EventCalendar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class EventCalendarResource extends Resource
{
    protected static ?string $model = EventCalendar::class;

    protected static ?string $navigationIcon = 'tabler-calendar-event';

    protected static ?string $navigationLabel = 'Event Calendar';

    protected static ?string $navigationGroup = 'Events';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\TimePicker::make('start_time')
                    ->required()
                    ->different('end_time'),

                Forms\Components\TimePicker::make('end_time')
                    ->required()
                    ->different('start_time'),

                Forms\Components\Toggle::make('is_active')
                    ->helperText('Toggle this whether the event is active or not.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('start_time')
                    ->sortable()
                    ->toggleable()
                    ->since()
                    ->description(fn (EventCalendar $record): string => $record->end_time->format('Y-m-d H:i')),

                Tables\Columns\TextColumn::make('end_time')
                    ->sortable()
                    ->toggleable()
                    ->since()
                    ->description(fn (EventCalendar $record): string => $record->end_time->format('Y-m-d H:i')),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->sortable()
                    ->toggleable()
                    ->beforeStateUpdated(function ($record, $state) {
                        // Runs before the state is saved to the database.
                    })
                    ->afterStateUpdated(function ($record, $state) {
                        // Runs after the state is saved to the database.
                    }),
            ])
            ->filters([
                Tables\Filters\Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('start_time'),
                        Forms\Components\DatePicker::make('end_time'),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when($data['start_time'], fn (Builder $query, $date): Builder => $query->whereDate('start_time', '>=', $date))
                        ->when($data['end_time'], fn (Builder $query, $date): Builder => $query->whereDate('start_time', '<=', $date)))
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['start_time'] ?? null) {
                            $indicators['start_time'] = 'Created from '.Carbon::parse($data['start_time'])->toFormattedDateString();
                        }

                        if ($data['end_time'] ?? null) {
                            $indicators['end_time'] = 'Created until '.Carbon::parse($data['end_time'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->placeholder('Active events'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),

                Tables\Actions\EditAction::make(),

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageEventCalendars::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
