<?php

namespace App\Filament\Resources;

use App\Enums\CharacterClassEnum;
use App\Enums\ItemRarityEnum;
use App\Enums\ItemTypeEnum;
use App\Filament\Resources\ItemResource\Pages;
use App\Models\Item;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'tabler-sword';

    protected static ?string $navigationLabel = 'Items';

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
                        ->hidden(fn (Item $record): bool => $record->image_path == null)
                        ->square(),

                    Infolists\Components\TextEntry::make('name'),

                    Infolists\Components\TextEntry::make('level')
                        ->numeric(),

                    Infolists\Components\TextEntry::make('rarity')
                        ->badge()
                        ->formatStateUsing(fn (ItemRarityEnum $state): string => ucwords($state->value))
                        ->color(fn (ItemRarityEnum $state): string => [
                            'common' => 'gray',
                            'improved' => 'green',
                            'magic' => 'blue',
                            'extraordinary' => 'purple',
                            'legendary' => 'orange',
                            'unique' => 'amber',
                            'mythic' => 'red',
                        ][$state->value]),

                    Infolists\Components\TextEntry::make('class')
                        ->badge()
                        ->formatStateUsing(fn (CharacterClassEnum $state): string => ucwords(str_replace('_', ' ', $state->value)))
                        ->color(fn (CharacterClassEnum $state): string => [
                            'dragonknight' => 'amber',
                            'spellweaver' => 'sky',
                            'ranger' => 'green',
                            'steam_mechanicus' => 'stone',
                        ][$state->value]),

                    Infolists\Components\TextEntry::make('type')
                        ->badge()
                        ->formatStateUsing(fn (ItemTypeEnum $state): string => ucwords(str_replace('_', ' ', $state->value)))
                        ->color('neutral'),

                    Infolists\Components\TextEntry::make('description')
                        ->markdown()
                        ->html(),

                    Infolists\Components\KeyValueEntry::make('base_values'),

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
                    ->formatStateUsing(fn (string $state): string => ucwords(str_replace('_', ' ', $state)))
                    ->toggleable(),

                Tables\Columns\TextColumn::make('level')
                    ->searchable()
                    ->sortable()
                    ->numeric()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('rarity')
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn (ItemRarityEnum $state): string => ucwords($state->value))
                    ->color(fn (ItemRarityEnum $state): string => [
                        'common' => 'gray',
                        'improved' => 'green',
                        'magic' => 'blue',
                        'extraordinary' => 'purple',
                        'legendary' => 'orange',
                        'unique' => 'amber',
                        'mythic' => 'red',
                    ][$state->value])
                    ->toggleable(),

                Tables\Columns\TextColumn::make('class')
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn (CharacterClassEnum $state): string => ucwords($state->value))
                    ->color(fn (CharacterClassEnum $state): string => [
                        'dragonknight' => 'amber',
                        'spellweaver' => 'sky',
                        'ranger' => 'green',
                        'steam_mechanicus' => 'stone',
                    ][$state->value])
                    ->toggleable(),

                Tables\Columns\TextColumn::make('type')
                    ->sortable()
                    ->badge()
                    ->color('neutral')
                    ->formatStateUsing(fn (ItemTypeEnum $state): string => ucwords(str_replace('_', ' ', $state->value)))
                    ->toggleable(),

                Tables\Columns\TextColumn::make('description')
                    ->sortable()
                    ->wrap()
                    ->html()
                    ->markdown()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('base_values')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),

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
                    ->options(ItemTypeEnum::class),

                Tables\Filters\SelectFilter::make('Rarity')
                    ->options(ItemRarityEnum::class),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modalWidth('5xl'),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageItems::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
