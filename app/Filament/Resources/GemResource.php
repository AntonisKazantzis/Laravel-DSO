<?php

namespace App\Filament\Resources;

use App\Enums\GemRarityEnum;
use App\Enums\GemTypeEnum;
use App\Filament\Resources\GemResource\Pages;
use App\Models\Gem;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GemResource extends Resource
{
    protected static ?string $model = Gem::class;

    protected static ?string $navigationIcon = 'tabler-diamond';

    protected static ?string $navigationLabel = 'Gems';

    protected static ?string $navigationGroup = 'Inventory';

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema(static::getInfolistSchema());
    }

    public static function getInfolistSchema(): array
    {
        return [
            Infolists\Components\Fieldset::make('Details')
                ->schema([
                    Infolists\Components\ImageEntry::make('image_path')
                        ->label('')
                        ->hidden(fn (Gem $record): bool => $record->image_path == null)
                        ->square(),

                    Infolists\Components\TextEntry::make('name'),

                    Infolists\Components\TextEntry::make('type')
                        ->badge()
                        ->formatStateUsing(fn (GemTypeEnum $state): string => ucwords(str_replace('_', ' ', $state->value)))
                        ->color(fn (GemTypeEnum $state): string => [
                            'ruby' => 'red',
                            'onyx' => 'gray',
                            'zircon' => 'yellow',
                            'rhodolite' => 'pink',
                            'diamond' => 'slate',
                            'diamond_fire' => 'amber',
                            'diamond_ice' => 'sky',
                            'diamond_andermagic' => 'indigo',
                            'diamond_lightning' => 'yellow',
                            'diamond_poison' => 'green',
                            'amethyst' => 'purple',
                            'cyanite' => 'cyan',
                            'emerald' => 'emerald',
                        ][$state->value]),

                    Infolists\Components\TextEntry::make('rarity')
                        ->badge()
                        ->formatStateUsing(fn (GemRarityEnum $state): string => ucwords(str_replace('_', ' ', $state->value)))
                        ->color('neutral'),

                    Infolists\Components\TextEntry::make('effect'),

                    Infolists\Components\TextEntry::make('value')
                        ->numeric(),

                    Infolists\Components\TextEntry::make('dust')
                        ->numeric(),

                    Infolists\Components\TextEntry::make('andermant')
                        ->numeric(),

                ])->columnSpanFull(),

            Infolists\Components\Fieldset::make('Workbench Cost')
                ->columns(3)
                ->schema([
                    Infolists\Components\KeyValueEntry::make('selling_cost'),

                    Infolists\Components\KeyValueEntry::make('upgrading_cost'),

                    Infolists\Components\KeyValueEntry::make('melting_cost'),

                ])->columnSpanFull(),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('')
                    ->checkFileExistence(false)
                    ->square(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('type')
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn (GemTypeEnum $state): string => ucwords(str_replace('_', ' ', $state->value)))
                    ->color(fn (GemTypeEnum $state): string => [
                        'ruby' => 'red',
                        'onyx' => 'gray',
                        'zircon' => 'yellow',
                        'rhodolite' => 'pink',
                        'diamond' => 'slate',
                        'diamond_fire' => 'amber',
                        'diamond_ice' => 'sky',
                        'diamond_andermagic' => 'indigo',
                        'diamond_lightning' => 'yellow',
                        'diamond_poison' => 'green',
                        'amethyst' => 'purple',
                        'cyanite' => 'cyan',
                        'emerald' => 'emerald',
                    ][$state->value])
                    ->toggleable(),

                Tables\Columns\TextColumn::make('rarity')
                    ->sortable()
                    ->badge()
                    ->color('neutral')
                    ->formatStateUsing(fn (GemRarityEnum $state): string => ucwords(str_replace('_', ' ', $state->value)))
                    ->toggleable(),

                Tables\Columns\TextColumn::make('effect')
                    ->sortable()
                    ->wrap()
                    ->html()
                    ->markdown()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('dust')
                    ->tooltip(fn (Gem $record): string => number_format($record->dust))
                    ->formatStateUsing(function (Gem $record): string {
                        $dust = $record->dust;
                        $suffixes = ['', 'K', 'M', 'B', 'T'];
                        $index = 0;

                        while ($dust >= 1000) {
                            $dust /= 1000;
                            $index++;
                        }

                        return round($dust, 1).$suffixes[$index];
                    })
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('selling_cost')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                Tables\Columns\TextColumn::make('upgrading_cost')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                Tables\Columns\TextColumn::make('melting_cost')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('Type')
                    ->options(GemTypeEnum::class),

                Tables\Filters\SelectFilter::make('Rarity')
                    ->options(GemRarityEnum::class),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modalWidth('5xl'),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageGems::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
