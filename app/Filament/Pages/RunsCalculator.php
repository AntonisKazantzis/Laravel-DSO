<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Page;

class RunsCalculator extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'tabler-calculator';

    protected static ?string $navigationLabel = 'Runs Calculator';

    protected static ?string $navigationGroup = 'Tools';

    protected static string $view = 'filament.pages.runs-calculator';

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
                    ->columns(4)
                    ->collapsible()
                    ->persistCollapsed()
                    ->id('section-details')
                    ->schema([
                        Forms\Components\Select::make('category')
                            ->options([
                                'travel_items' => 'Travel Items',
                                'event_travel_items' => 'Event Travel Items',
                                'pw_travel_items' => 'Parallel World Travel Items',
                            ])
                            ->live()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                if (filled($get('portal'))) {
                                    $this->resetValues($set);
                                }
                            }),

                        Forms\Components\Select::make('portal')
                            ->visible(fn (Get $get): bool => filled($get('category')))
                            ->options(fn (Get $get): array => match ($get('category')) {
                                'travel_items' => [
                                    1 => '1 Portal',
                                    5 => '5 Portal',
                                    10 => '10 Portal',
                                ],
                                'event_travel_items' => [
                                    1 => '1 Portal',
                                    5 => '5 Portal',
                                    10 => '10 Portal',
                                ],
                                'pw_travel_items' => [
                                    5 => '5 Portal',
                                    10 => '10 Portal',
                                    100 => '100 Portal',
                                ],
                                default => [],
                            })
                            ->live()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                if (filled($get('difficulty'))) {
                                    $category = $state;
                                    $portal = $get('portal');
                                    $difficulty = $get('difficulty');
                                    $amount = $get('amount');

                                    $this->setFragments($set, $category, $portal, $difficulty, $amount);
                                }
                            }),

                        Forms\Components\Select::make('difficulty')
                            ->visible(fn (Get $get): bool => filled($get('portal')))
                            ->options(fn (Get $get): array => match ($get('category')) {
                                'travel_items' => [
                                    0 => 'Normal',
                                    1 => 'Painful',
                                    2 => 'Excruciating',
                                    3 => 'Fatal',
                                    4 => 'Infernal',
                                    5 => 'Merciless',
                                    6 => 'Bloodshed',
                                ],
                                'event_travel_items' => [
                                    0 => 'Normal',
                                    1 => 'Painful',
                                    2 => 'Excruciating',
                                    3 => 'Fatal',
                                    4 => 'Infernal',
                                    5 => 'Merciless',
                                    6 => 'Bloodshed',
                                ],
                                'pw_travel_items' => [
                                    0 => 'Parallel World Infernal',
                                    1 => 'Parallel World Merciless',
                                    2 => 'Parallel World Bloodshed',
                                ],
                                default => [],
                            })
                            ->live()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $category = $get('category');
                                $portal = $get('portal');
                                $difficulty = $state;
                                $amount = $get('amount');

                                $this->setFragments($set, $category, $portal, $difficulty, $amount);
                            }),

                        Forms\Components\TextInput::make('amount')
                            ->default(1)
                            ->visible(fn (Get $get): bool => filled($get('difficulty')))
                            ->helperText("How many times you'll buy these portal.")
                            ->integer()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                if (filled($get('difficulty'))) {
                                    $category = $get('category');
                                    $portal = $get('portal');
                                    $difficulty = $get('difficulty');
                                    $amount = $state;

                                    $this->setFragments($set, $category, $portal, $difficulty, $amount);
                                }
                            }),
                    ]),

                Forms\Components\Section::make('Cost')
                    ->columns(4)
                    ->visible(fn (Get $get): bool => filled($get('difficulty')))
                    ->collapsible()
                    ->persistCollapsed()
                    ->id('section-cost')
                    ->schema([
                        Forms\Components\TextInput::make('realm_fragments')
                            ->readonly()
                            ->live()
                            ->default(0)
                            ->formatStateUsing(fn (string $state): string => number_format((int) $state))
                            ->columnSpan(1)
                            ->helperText("How many realm fragments it'll cost to buy these portal."),

                        Forms\Components\TextInput::make('andermants')
                            ->readonly()
                            ->live()
                            ->default(0)
                            ->formatStateUsing(fn (string $state): string => number_format((int) $state))
                            ->columnSpan(1)
                            ->helperText("How many andermants it'll cost to buy these portal."),

                        Forms\Components\TextInput::make('infernal_passages')
                            ->readonly()
                            ->live()
                            ->default(0)
                            ->formatStateUsing(fn (string $state): string => number_format((int) $state))
                            ->columnSpan(1)
                            ->helperText("How many infernal passages it'll cost in total."),

                        Forms\Components\TextInput::make('key_of_prowess')
                            ->readonly()
                            ->live()
                            ->default(0)
                            ->formatStateUsing(fn (string $state): string => number_format((int) $state))
                            ->columnSpan(1)
                            ->helperText("How many key of prowess it'll cost in total."),
                    ]),
            ])
            ->statePath('data');
    }

    // Set the fragments based on category, portal, difficulty, and amount.
    public function setFragments($set, $category, $portal, $difficulty, $amount)
    {
        // Initialize variables
        $realm_fragments = 0;
        $andermants = 0;
        $infernal_passages = 0;
        $key_of_prowess = 0;

        // Calculate total portal value
        $totalPortal = $portal * $amount;

        // Define fragment values based on category
        switch ($category) {
            case 'travel_items':
                // Define fragment values for travel items category
                $realm_fragments_map = [
                    4 => 1,
                    20 => 5,
                    40 => 10,
                ];

                $andermants_map = [
                    199 => 1,
                    995 => 5,
                    1990 => 10,
                ];

                $key_of_prowess_map = [
                    0 => 0,
                    1 => 1,
                    2 => 2,
                    3 => 3,
                    4 => 4,
                    6 => 5,
                    10 => 6,
                ];

                $portal_cost_map = [
                    1 => 0,
                    2 => 1,
                    3 => 2,
                    4 => 3,
                    5 => 4,
                    7 => 5,
                    9 => 6,
                ];

                $portal_cost = array_search($difficulty, $portal_cost_map);
                $key_of_prowess = array_search($difficulty, $key_of_prowess_map);

                if ($totalPortal >= 9 && $difficulty == 6) {
                    $infernal_passages = 10;
                }

                if ($totalPortal >= 2 && $difficulty !== 0) {
                    $keyOfProwessCount = round($totalPortal / $portal_cost);
                    $key_of_prowess *= $keyOfProwessCount;
                }

                break;
            case 'event_travel_items':
                // Define fragment values for event travel items category
                $realm_fragments_map = [
                    10 => 1,
                    49 => 5,
                    98 => 10,
                ];

                $andermants_map = [
                    499 => 1,
                    2495 => 5,
                    4990 => 10,
                ];

                $portal_cost_map = [
                    1 => 0,
                    1 => 1,
                    1 => 2,
                    2 => 3,
                    3 => 4,
                    3 => 5,
                    5 => 6,
                ];

                $portal_cost = array_search($difficulty, $portal_cost_map);

                if ($totalPortal >= 9 && $difficulty == 6) {
                    $infernal_passages = 10;
                }

                break;
            case 'pw_travel_items':
                // Define fragment values for PW travel items category
                $realm_fragments_map = [
                    8 => 5,
                    16 => 10,
                    130 => 100,
                ];

                $andermants_map = [
                    400 => 5,
                    770 => 10,
                    6300 => 100,
                ];

                $portal_cost_map = [
                    25 => 0,
                    25 => 1,
                    25 => 2,
                ];

                $portal_cost = array_search($difficulty, $portal_cost_map);

                if ($totalPortal >= 25 && $difficulty == 2) {
                    $infernal_passages = 15;
                }

                break;
        }

        // Calculate realm fragments and andermants
        $realm_fragments = array_search($portal, $realm_fragments_map);
        $andermants = array_search($portal, $andermants_map);
        $realm_fragments *= $amount;
        $andermants *= $amount;

        // Calculate infernal passages based on total portal count and difficulty
        $infernalPassageCount = round($totalPortal / $portal_cost);
        $infernal_passages *= $infernalPassageCount;

        // Set formatted fragment values
        $set('realm_fragments', number_format($realm_fragments));
        $set('andermants', number_format($andermants));
        $set('infernal_passages', number_format($infernal_passages));
        $set('key_of_prowess', number_format($key_of_prowess));
    }

    public function resetValues($set)
    {
        $set('portal', null);
        $set('difficulty', null);
        $set('amount', 1);
        $set('realm_fragments', 0);
        $set('andermants', 0);
        $set('infernal_passages', 0);
        $set('key_of_prowess', 0);
    }
}
