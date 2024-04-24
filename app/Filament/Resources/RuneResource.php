<?php

namespace App\Filament\Resources;

use App\Enums\RuneRarityEnum;
use App\Filament\Resources\RuneResource\Pages;
use App\Models\Rune;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RuneResource extends Resource
{
    protected static ?string $model = Rune::class;

    protected static ?string $navigationIcon = 'tabler-diamond';

    protected static ?string $navigationLabel = 'Runes';

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
                        ->hidden(fn (Rune $record): bool => $record->image_path == null)
                        ->square(),

                    Infolists\Components\TextEntry::make('name'),

                    Infolists\Components\TextEntry::make('rarity')
                        ->badge()
                        ->formatStateUsing(fn (RuneRarityEnum $state): string => ucwords($state->value))
                        ->color(fn (RuneRarityEnum $state): string => [
                            'common' => 'gray',
                            'improved' => 'green',
                            'magic' => 'blue',
                            'extraordinary' => 'purple',
                            'legendary' => 'orange',
                            'unique' => 'yellow',
                        ][$state->value]),

                    Infolists\Components\TextEntry::make('dust')
                        ->numeric(),

                    Infolists\Components\TextEntry::make('effect')
                        ->columnSpanFull(),

                ])->columnSpanFull(),

            Infolists\Components\Fieldset::make('Buy Cost')
                ->columns(3)
                ->schema([
                    Infolists\Components\TextEntry::make('draken'),

                    Infolists\Components\TextEntry::make('materi_fragment'),

                    Infolists\Components\TextEntry::make('gilded_clover'),

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
                    ->formatStateUsing(fn (RuneRarityEnum $state): string => ucwords($state->value))
                    ->color(fn (RuneRarityEnum $state): string => [
                        'common' => 'gray',
                        'improved' => 'green',
                        'magic' => 'blue',
                        'extraordinary' => 'purple',
                        'legendary' => 'orange',
                        'unique' => 'yellow',
                    ][$state->value])
                    ->toggleable(),

                Tables\Columns\TextColumn::make('effect')
                    ->sortable()
                    ->wrap()
                    ->html()
                    ->markdown()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('dust')
                    ->tooltip(fn (Rune $record): string => number_format($record->dust))
                    ->formatStateUsing(function (Rune $record): string {
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

                Tables\Columns\TextColumn::make('andermant')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                Tables\Columns\TextColumn::make('draken')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                Tables\Columns\TextColumn::make('materi_fragment')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                Tables\Columns\TextColumn::make('gilded_clover')
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
            'index' => Pages\ManageRunes::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
