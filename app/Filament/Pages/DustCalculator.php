<?php

namespace App\Filament\Pages;

use App\Enums\GemRarityEnum;
use App\Enums\GemTypeEnum;
use App\Enums\JewelRarityEnum;
use App\Enums\OpalRarityEnum;
use App\Enums\RuneRarityEnum;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Page;

class DustCalculator extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'tabler-calculator';

    protected static ?string $navigationLabel = 'Dust Calculator';

    protected static ?string $navigationGroup = 'Tools';

    protected static string $view = 'filament.pages.dust-calculator';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Details')
                    ->columns(5)
                    ->collapsible()
                    ->persistCollapsed()
                    ->id('section-details')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->options([
                                'gem' => 'Gem',
                                'jewel' => 'Jewel',
                                'rune' => 'Rune',
                                'opal' => 'Opal',
                            ])
                            ->live()
                            ->afterStateUpdated(function ($state, callable $get, callable $set, $old) {
                                if (filled($get('item')) || $old === 'opal') {
                                    $this->resetValues($set);
                                }
                            }),

                        Forms\Components\Select::make('item')
                            ->visible(fn(Get $get): bool => filled($get('type')) && $get('type') !== 'opal')
                            ->options(fn(Get $get): array=> match ($get('type')) {
                                'gem' => GemTypeEnum::toArrayFormatted(),
                                'jewel' => JewelRarityEnum::getJewels(),
                                'rune' => RuneRarityEnum::getRunes(),
                                default => [],
                            })
                            ->live(),

                        Forms\Components\Select::make('from')
                            ->visible(fn(Get $get): bool => filled($get('item')) || $get('type') === 'opal')
                            ->options(fn(Get $get): array=> match ($get('type')) {
                                'gem' => GemRarityEnum::toArrayUcwords($get('item')),
                                'jewel' => JewelRarityEnum::toArrayUcwords(),
                                'rune' => RuneRarityEnum::toArrayUcwords(),
                                'opal' => OpalRarityEnum::toArrayUcwords(),
                                default => [],
                            })
                            ->live()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                if (filled($get('to'))) {
                                    $set('to', null);
                                }
                            }),

                        Forms\Components\Select::make('to')
                            ->visible(fn(Get $get): bool => filled($get('item')) || $get('type') === 'opal')
                            ->options(fn(Get $get): array=> match ($get('type')) {
                                'gem' => $this->sliceItems(GemRarityEnum::toArrayUcwords($get('item')), $get('from')),
                                'jewel' => $this->sliceItems(JewelRarityEnum::toArrayUcwords(), $get('from')),
                                'rune' => $this->sliceItems(RuneRarityEnum::toArrayUcwords(), $get('from')),
                                'opal' => $this->sliceItems(OpalRarityEnum::toArrayUcwords(), $get('from')),
                                default => [],
                            })
                            ->live()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $value = $get('item');
                                $from = $get('from');
                                $to = $get('to');
                                $amount = $get('amount');

                                $this->setDust($get, $set, $value, $from, $to, $amount);
                            }),

                        Forms\Components\TextInput::make('amount')
                            ->default(1)
                            ->visible(fn(Get $get): bool => filled($get('to')))
                            ->integer()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $value = $get('item');
                                $from = $get('from');
                                $to = $get('to');
                                $amount = $state;

                                $this->setDust($get, $set, $value, $from, $to, $amount);
                            }),
                    ]),

                Forms\Components\Section::make('Cost')
                    ->columnSpanFull()
                    ->visible(fn(Get $get): bool => filled($get('to')))
                    ->collapsible()
                    ->persistCollapsed()
                    ->id('section-cost')
                    ->schema([
                        Forms\Components\TextInput::make('upgrade_dust')
                            ->readonly()
                            ->live()
                            ->default(0)
                            ->formatStateUsing(fn(string $state): string => number_format((float) $state))
                            ->columnSpan(1)
                            ->helperText("How much dust it'll cost to upgrade."),

                        Forms\Components\TextInput::make('melt_dust')
                            ->readonly()
                            ->live()
                            ->default(0)
                            ->formatStateUsing(fn(string $state): string => number_format((float) $state))
                            ->columnSpan(1)
                            ->helperText("How much dust it'll give when melted."),
                    ]),
            ])
            ->statePath('data');
    }

    public function sliceItems(array $items, ?string $from): array
    {
        if ($from === null) {
            return [];
        }

        $keys = array_keys($items);
        $index = array_search($from, $keys);

        if ($index === 0) {
            $items = array_slice($items, 1, null, true);
            return $items;
        }

        if ($index === false || $index === 0) {
            return $items;
        }

        $result = array_slice($items, $index, null, true);

        return dd($result);
    }

    public function setDust($get, $set, ?string $value, $from, $to, $amount)
    {
        switch ($get('type')) {
            case 'gem':
                $dust = GemTypeEnum::getDust($value);
                break;
            case 'jewel':
                $dust = JewelRarityEnum::getDust($value);
                break;
            case 'rune':
                $dust = RuneRarityEnum::getDust($value);
                break;
            case 'opal':
                $dust = OpalRarityEnum::getDust();
                break;
            default:
                $dust = [];
                break;
        }

        $keys = array_keys($dust);
        $fromIndex = array_search($from, $keys);
        $toIndex = array_search($to, $keys);

        $relevantKeys = array_slice($keys, $fromIndex, $toIndex - $fromIndex);

        $totalDust = 0;
        foreach ($relevantKeys as $key) {
            $totalDust += $dust[$key];
        }
        $totalDust *= $amount;


        $set('upgrade_dust', number_format($totalDust));
        $set('melt_dust', number_format($totalDust / 2));
    }

    public function resetValues($set)
    {
        $set('item', null);
        $set('from', null);
        $set('to', null);
        $set('amount', 1);
        $set('upgrade_dust', 0);
        $set('melt_dust', 0);
    }
}
