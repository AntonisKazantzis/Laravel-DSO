<?php

namespace App\Filament\Pages;

use App\Models\Gem;
use App\Models\Jewel;
use App\Models\Rune;
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
                    ->columns(3)
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

                                if ($state === 'opal') {
                                    $amount = $get('amount');
                                    $this->setOpalDustValues($set, $amount);
                                }
                            }),

                        Forms\Components\Select::make('item')
                            ->visible(fn(Get $get): bool => filled($get('type')) && $get('type') !== 'opal')
                            ->options(fn(Get $get): array=> match ($get('type')) {
                                'gem' => Gem::pluck('name', 'id')->toArray(),
                                'jewel' => Jewel::pluck('name', 'id')->toArray(),
                                'rune' => Rune::pluck('name', 'id')->toArray(),
                                default => [],
                            })
                            ->searchable()
                            ->searchPrompt(fn(Get $get): string => match ($get('type')) {
                                'gem' => 'Start typing to search for gems...',
                                'jewel' => 'Start typing to search for jewels...',
                                'rune' => 'Start typing to search for runes...',
                                default => '',
                            })
                            ->searchingMessage(fn(Get $get): string => match ($get('type')) {
                                'gem' => 'Searching gems...',
                                'jewel' => 'Searching jewels...',
                                'rune' => 'Searching runes...',
                                default => '',
                            })
                            ->noSearchResultsMessage(fn(Get $get): string => match ($get('type')) {
                                'gem' => 'No gems found...',
                                'jewel' => 'No jewels found...',
                                'rune' => 'No runes found...',
                                default => '',
                            })
                            ->optionsLimit(5)
                            ->live()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $amount = $get('amount');

                                switch ($get('type')) {
                                    case 'gem':
                                        $object = Gem::find($state);
                                        break;
                                    case 'jewel':
                                        $object = Jewel::find($state);
                                        break;
                                    case 'rune':
                                        $object = Rune::find($state);
                                        break;
                                    default:
                                        $object = [];
                                }

                                $this->setGemDustValues($set, $object, $amount);
                            }),

                        Forms\Components\TextInput::make('amount')
                            ->default(1)
                            ->visible(fn(Get $get): bool => filled($get('item')) || $get('type') === 'opal')
                            ->integer()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $item = $get('item');

                                switch ($get('type')) {
                                    case 'gem':
                                        $object = Gem::find($item);
                                        break;
                                    case 'jewel':
                                        $object = Jewel::find($item);
                                        break;
                                    case 'rune':
                                        $object = Rune::find($item);
                                        break;
                                    default:
                                        $object = [];
                                }

                                $get('type') === 'opal' ? $this->setOpalDustValues($set, $state) : $this->setGemDustValues($set, $object, $state);
                            }),
                    ]),

                Forms\Components\Section::make('Costs')
                    ->columnSpanFull()
                    ->hidden(fn(Get $get): bool => filled($get('type')) && $get('type') === 'opal')
                    ->collapsible()
                    ->persistCollapsed()
                    ->id('section-costs')
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

                Forms\Components\Section::make('Costs')
                    ->columns(3)
                    ->visible(fn(Get $get): bool => filled($get('type')) && $get('type') === 'opal')
                    ->collapsible()
                    ->persistCollapsed()
                    ->id('section-costs')
                    ->schema([
                        Forms\Components\TextInput::make('royal')
                            ->readonly()
                            ->live()
                            ->default(0)
                            ->formatStateUsing(fn(string $state): string => number_format((int) $state))
                            ->columnSpan(1)
                            ->helperText("How much dust it'll cost to upgrade to trapezoid."),

                        Forms\Components\TextInput::make('trapezoid')
                            ->readonly()
                            ->live()
                            ->default(0)
                            ->formatStateUsing(fn(string $state): string => number_format((int) $state))
                            ->columnSpan(1)
                            ->helperText("How much dust it'll cost to upgrade to Refined Trapezoid."),

                        Forms\Components\TextInput::make('refined_trapezoid')
                            ->readonly()
                            ->live()
                            ->default(0)
                            ->formatStateUsing(fn(string $state): string => number_format((int) $state))
                            ->columnSpan(1)
                            ->helperText("How much dust it'll cost to upgrade to Brilliant Trapezoid."),

                        Forms\Components\TextInput::make('brilliant_trapezoid')
                            ->readonly()
                            ->live()
                            ->default(0)
                            ->formatStateUsing(fn(string $state): string => number_format((int) $state))
                            ->columnSpan(1)
                            ->helperText("How much dust it'll cost to upgrade to Exquisite Trapezoid."),

                        Forms\Components\TextInput::make('exquisite_trapezoid')
                            ->readonly()
                            ->live()
                            ->default(0)
                            ->formatStateUsing(fn(string $state): string => number_format((int) $state))
                            ->columnSpan(1)
                            ->helperText("How much dust it'll cost to upgrade to Imperial."),

                        Forms\Components\TextInput::make('imperial')
                            ->readonly()
                            ->live()
                            ->default(0)
                            ->formatStateUsing(fn(string $state): string => number_format((int) $state))
                            ->columnSpan(1)
                            ->helperText("How much dust it'll cost to upgrade to Refined Imperial."),

                        Forms\Components\TextInput::make('refined_imperial')
                            ->readonly()
                            ->live()
                            ->default(0)
                            ->formatStateUsing(fn(string $state): string => number_format((int) $state))
                            ->columnSpan(1)
                            ->helperText("How much dust it'll cost to upgrade to Brilliant Imperial."),

                        Forms\Components\TextInput::make('brilliant_imperial')
                            ->readonly()
                            ->live()
                            ->default(0)
                            ->formatStateUsing(fn(string $state): string => number_format((int) $state))
                            ->columnSpan(1)
                            ->helperText("How much dust it'll cost to upgrade to Exquisite Imperial."),

                        Forms\Components\TextInput::make('exquisite_imperial')
                            ->readonly()
                            ->live()
                            ->default(0)
                            ->formatStateUsing(fn(string $state): string => number_format((int) $state))
                            ->columnSpan(1)
                            ->helperText("How much dust it'll cost to upgrade to Exquisite Imperial."),
                    ]),
            ])
            ->statePath('data');
    }

    public function setGemDustValues($set, $object, $amount)
    {
        $set('upgrade_dust', number_format($object->dust * $amount));
        $set('melt_dust', number_format(($object->dust / 2) * $amount));
    }

    public function setOpalDustValues($set, $amount)
    {
        /* $upgradeToNextDust = [
            4500 => 'royal',
            7875 => 'trapezoid',
            12375 => 'refined_trapezoid',
            18000 => 'brilliant_trapezoid',
            24750 => 'exquisite_trapezoid',
            32625 => 'imperial',
            41625 => 'refined_imperial',
            51750 => 'brilliant_imperial',
            63000 => 'exquisite_imperial',
        ];

        $upgradeToMaxDust = [
            193500 => 'royal',
            189000 => 'trapezoid',
            181125 => 'refined_trapezoid',
            168750 => 'brilliant_trapezoid',
            150750 => 'exquisite_trapezoid',
            126000 => 'imperial',
            93375 => 'refined_imperial',
            51750 => 'brilliant_imperial',
            0 => 'exquisite_imperial',
        ];

        $create_opal_dust = array_search($object, $createDust);
        $upgrade_opal_dust = array_search($object, $upgradeDust);

        $set('create_opal_dust', number_format($create_opal_dust * $amount));
        $set('upgrade_opal_dust', number_format($upgrade_opal_dust * $amount)); */

        $opals = [
            'royal' => 4500,
            'trapezoid' => 7875,
            'refined_trapezoid' => 12375,
            'brilliant_trapezoid' => 18000,
            'exquisite_trapezoid' => 24750,
            'imperial' => 32625,
            'refined_imperial' => 41625,
            'brilliant_imperial' => 51750,
            'exquisite_imperial' => 0,
        ];

        foreach ($opals as $opal => $dust) {
            $set($opal, number_format($dust * $amount));
        }
    }

    public function resetValues($set)
    {
        $set('item', null);
        $set('amount', 1);
        $set('upgrade_dust', 0);
        $set('melt_dust', 0);
        $set('royal', 0);
        $set('trapezoid', 0);
        $set('refined_trapezoid', 0);
        $set('brilliant_trapezoid', 0);
        $set('exquisite_trapezoid', 0);
        $set('imperial', 0);
        $set('refined_imperial', 0);
        $set('brilliant_imperial', 0);
        $set('exquisite_imperial', 0);
    }
}
