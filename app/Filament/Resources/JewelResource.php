<?php

namespace App\Filament\Resources;

use App\Enums\JewelRarityEnum;
use App\Filament\Resources\JewelResource\Pages;
use App\Models\Jewel;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JewelResource extends Resource
{
    protected static ?string $model = Jewel::class;

    protected static ?string $navigationIcon = 'tabler-diamond';

    protected static ?string $navigationLabel = 'Jewels';

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
                        ->hidden(fn (Jewel $record): bool => $record->image_path == null)
                        ->square(),

                    Infolists\Components\TextEntry::make('name'),

                    Infolists\Components\TextEntry::make('rarity')
                        ->badge()
                        ->formatStateUsing(fn (JewelRarityEnum $state): string => ucwords($state->value))
                        ->color(fn (JewelRarityEnum $state): string => [
                            'common' => 'gray',
                            'improved' => 'green',
                            'magic' => 'blue',
                            'extraordinary' => 'purple',
                            'legendary' => 'orange',
                            'mythic' => 'red',
                        ][$state->value]),

                    Infolists\Components\TextEntry::make('dust')
                        ->numeric(),

                    Infolists\Components\TextEntry::make('effect')
                        ->columnSpanFull(),

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

                Tables\Columns\TextColumn::make('rarity')
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn (JewelRarityEnum $state): string => ucwords($state->value))
                    ->color(fn (JewelRarityEnum $state): string => [
                        'common' => 'gray',
                        'improved' => 'green',
                        'magic' => 'blue',
                        'extraordinary' => 'purple',
                        'legendary' => 'orange',
                        'mythic' => 'red',
                    ][$state->value])
                    ->toggleable(),

                Tables\Columns\TextColumn::make('effect')
                    ->sortable()
                    ->wrap()
                    ->html()
                    ->markdown()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('dust')
                    ->tooltip(fn (Jewel $record): string => number_format($record->dust))
                    ->formatStateUsing(function (Jewel $record): string {
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
                //
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
            'index' => Pages\ManageJewels::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
