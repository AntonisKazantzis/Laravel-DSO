<?php

namespace App\Filament\Pages;

use App\Models\Gem;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\HtmlString;

class StatsCalculator extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'tabler-calculator';

    protected static ?string $navigationLabel = 'Stats Calculator';

    protected static ?string $navigationGroup = 'Tools';

    protected static string $view = 'filament.pages.stats-calculator';

    public ?array $dust = [];

    public ?array $backupState = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Buffs')
                    ->columnSpanFull()
                    ->collapsible()
                    ->persistCollapsed()
                    ->id('section-buffs')
                    ->schema([
                        Tabs::make('Buffs')
                            ->tabs([
                                Tabs\Tab::make('Jewels')
                                    ->schema([
                                        Forms\Components\CheckboxList::make('buffs')
                                            ->live()
                                            ->columnSpanFull()
                                            ->options([
                                                'jewel_of_rage' => 'Jewel of Rage (Legendary)',
                                                'jewel_of_dextrous_vigor' => 'Jewel of Rage (Legendary)',
                                                'jewel_of_ambidextrous_vigor' => 'Jewel of Rage (Legendary)',
                                                'jewel_of_vigor' => 'Jewel of Vigor (Legendary)',
                                                'jewel_of_eternal_scorn' => 'Jewel of Eternal Scorn (Legendary)',
                                                'jewel_of_encouragement' => 'Jewel of Encouragement (Legendary)',
                                                'jewel_of_contribution' => 'Jewel of Contribution (Legendary)',
                                                'jewel_of_amplified_healing' => 'Jewel of Amplified Healing (Legendary)',
                                                'jewel_of_lasting_health' => 'Jewel of Lasting Health (Legendary)',
                                                'jewel_of_revival_boon' => 'Jewel of Revival Boon (Legendary)',
                                                'jewel_of_converse' => 'Jewel of Converse (Legendary)',
                                                'jewel_of_vitality' => 'Jewel of Converse (Legendary)',
                                                'jewel_of_fortitude' => 'Jewel of Converse (Legendary)',
                                            ])
                                            ->descriptions([
                                                'jewel_of_rage' => new HtmlString('+30% critical value</br> +25% attack speed'),
                                                'jewel_of_dextrous_vigor' => '+4% damage when using one-handed weapons',
                                                'jewel_of_ambidextrous_vigor' => '+10% damage when using two-handed weapons',
                                                'jewel_of_vigor' => '+10% damage',
                                                'jewel_of_eternal_scorn' => '+ 15.00% critical value',
                                                'jewel_of_encouragement' => '+15% resource points',
                                                'jewel_of_contribution' => '+15% health points',
                                                'jewel_of_amplified_healing' => new HtmlString('+150% damage</br> +25% movement speed'),
                                                'jewel_of_lasting_health' => '+10% health regeneration',
                                                'jewel_of_revival_boon' => new HtmlString('+40% damage</br> +40% armor value'),
                                                'jewel_of_converse' => '+40% armor value',
                                                'jewel_of_vitality' => '+10% health points',
                                                'jewel_of_fortitude' => '+10% armor value',
                                            ])
                                            ->afterStateUpdated(function ($state, callable $get, callable $set, $old) {
                                                $buffs = [
                                                    'multiplication' => [
                                                        'jewel_of_rage' => ['critical_value' => 1.3, 'attacks_per_second' => 1.25],
                                                        'jewel_of_dextrous_vigor' => ['base_damage' => 1.04],
                                                        'jewel_of_ambidextrous_vigor' => ['base_damage' => 1.1],
                                                        'jewel_of_vigor' => ['base_damage' => 1.1],
                                                        'jewel_of_eternal_scorn' => ['critical_value' => 1.15],
                                                        'jewel_of_encouragement' => ['rage_points' => 1.03, 'mana_points' => 1.03, 'steam_points' => 1.03, 'concentration_points' => 1.03],
                                                        'jewel_of_contribution' => ['health_points' => 1.15],
                                                        'jewel_of_amplified_healing' => ['base_damage' => 2.5, 'movement_speed' => 1.25],
                                                        'jewel_of_lasting_health' => ['health_regeneration' => 1.1],
                                                        'jewel_of_revival_boon' => ['base_damage' => 1.4, 'armor_value' => 1.4],
                                                        'jewel_of_converse' => ['armor_value' => 1.4],
                                                        'jewel_of_vitality' => ['health_points' => 1.1],
                                                        'jewel_of_fortitude' => ['armor_value' => 1.1],
                                                    ],
                                                    'addition' => [],
                                                ];

                                                $this->applyBuff($state, $get, $set, $old, $buffs);
                                            })
                                            ->columns(3)
                                            ->gridDirection('row'),
                                    ]),

                                Tabs\Tab::make('Runes')
                                    ->schema([
                                        Forms\Components\CheckboxList::make('runes')
                                            ->live()
                                            ->columnSpanFull()
                                            ->options([
                                                'rune_of_devastation' => '5 Rune of Devastation (Legendary)',
                                                'rune_of_celerity' => '5 Rune of Celerity (Legendary)',
                                                'rune_of_regeneration' => '5 Rune of Regeneration (Legendary)',
                                                'rune_of_vitality' => '5 Rune of Vitality (Legendary)',
                                                'rune_of_vigor' => '5 Rune of Vigor (Legendary)',
                                                'rune_of_acceleration' => '5 Rune of Acceleration (Legendary)',
                                                'rune_of_fortitude' => '5 Rune of Fortitude (Legendary)',
                                                'rune_of_resilience' => '5 Rune of Resilience (Legendary)',
                                                'rune_of_materi_blessing' => '5 Rune of Materi Blessing (Legendary)',
                                                'rune_of_wisdom_seeker' => '5 Rune of The Wisdom Seeker (Legendary)',
                                                'rune_of_persistence' => '5 Rune of Persistence (Legendary)',
                                                'rune_of_efficacy' => '5 Rune of Efficacy (Legendary)',
                                                'rune_of_concentrated_solstice' => '5 Rune of Concentrated Solstice (Legendary)',
                                                'rune_of_concentrated_spring' => '5 Rune of Concentrated Spring (Legendary)',
                                                'rune_of_fire' => '5 Rune of Fire (Legendary)',
                                                'rune_of_lightning' => '5 Rune of Lightning (Legendary)',
                                                'rune_of_andermagic' => '5 Rune of Andermagic (Legendary)',
                                                'rune_of_ice' => '5 Rune of Ice (Legendary)',
                                                'rune_of_poison' => '5 Rune of Poison (Legendary)',
                                            ])
                                            ->descriptions([
                                                'rune_of_devastation' => '+32.5% critical value',
                                                'rune_of_celerity' => '+32.5% attack speed',
                                                'rune_of_regeneration' => '+32.5% health regeneration',
                                                'rune_of_vitality' => '+32.5% health points',
                                                'rune_of_vigor' => '+32.5% damage',
                                                'rune_of_acceleration' => '+32.5% movement speed',
                                                'rune_of_fortitude' => '+32.5% armor value',
                                                'rune_of_resilience' => '+32.5% all resistance values',
                                                'rune_of_materi_blessing' => '+150% to materi fragment drop stack size',
                                                'rune_of_wisdom_seeker' => '+150% to ancient wisdom drop stack size',
                                                'rune_of_persistence' => '+32.5% block value',
                                                'rune_of_efficacy' => '+32.5% resource points',
                                                'rune_of_concentrated_solstice' => new HtmlString('+32.5% health points</br> +32.5 ice resistance</br> +32.5% critical value'),
                                                'rune_of_concentrated_spring' => new HtmlString('+32.5% health points</br> +32.5 attack speed</br> +32.5% critical value'),
                                                'rune_of_fire' => '+32.5% fire resistance',
                                                'rune_of_lightning' => '+32.5% lightning resistance',
                                                'rune_of_andermagic' => '+32.5% andermagic resistance',
                                                'rune_of_ice' => '+32.5% ice resistance',
                                                'rune_of_poison' => '+32.5% poison resistance',
                                            ])
                                            ->afterStateUpdated(function ($state, callable $get, callable $set, $old) {
                                                $buffs = [
                                                    'multiplication' => [
                                                        'rune_of_devastation' => ['critical_value' => 1.325],
                                                        'rune_of_celerity' => ['attacks_per_second' => 1.325],
                                                        'rune_of_regeneration' => ['health_regeneration' => 1.325],
                                                        'rune_of_vitality' => ['health_points' => 1.325],
                                                        'rune_of_vigor' => ['base_damage' => 1.325],
                                                        'rune_of_acceleration' => ['movement_speed' => 1.325],
                                                        'rune_of_fortitude' => ['armor_value' => 1.325],
                                                        'rune_of_resilience' => ['ice' => 1.325, 'fire' => 1.325, 'andermagic' => 1.325, 'poison' => 1.325, 'lightning' => 1.325],
                                                        'rune_of_persistence' => ['block_value' => 1.325],
                                                        'rune_of_efficacy' => ['rage_points' => 1.325, 'mana_points' => 1.325, 'steam_points' => 1.325, 'concentration_points' => 1.325],
                                                        'rune_of_concentrated_solstice' => ['health_points' => 1.325, 'ice' => 1.325, 'critical_value' => 1.325],
                                                        'rune_of_concentrated_spring' => ['health_points' => 1.325, 'attacks_per_second' => 1.325, 'critical_value' => 1.325],
                                                        'rune_of_fire' => ['fire' => 1.325],
                                                        'rune_of_lightning' => ['lightning' => 1.325],
                                                        'rune_of_andermagic' => ['andermagic' => 1.325],
                                                        'rune_of_ice' => ['ice' => 1.325],
                                                        'rune_of_poison' => ['poison' => 1.325],
                                                    ],
                                                    'addition' => [
                                                        'rune_of_materi_blessing' => ['materi_fragment_drop_stack_size' => 150],
                                                        'rune_of_wisdom_seeker' => ['ancient_wisdom_drop_stack_size' => 150],
                                                    ],
                                                ];

                                                $this->applyBuff($state, $get, $set, $old, $buffs);
                                            })
                                            ->columns(3)
                                            ->gridDirection('row'),
                                    ]),

                                Tabs\Tab::make('Wisdom')
                                    ->schema([
                                        Forms\Components\CheckboxList::make('wisdom')
                                            ->live()
                                            ->columnSpanFull()
                                            ->options([
                                                'rising_vigor' => 'Health Points (60/60)',
                                                'vivacious_vitality' => 'Health Regeneration (60/60)',
                                                'depth_of_fury' => 'Resource Points (60/60)',
                                                'rising_power' => 'Damage (80/80)',
                                                'decisive_strike' => 'Critical Value (80/80)',
                                                'sturdy_shield' => 'Block Value (80/80)',
                                                'hard_as_a_rock' => 'Armor Value (80/80)',
                                                'elemental_protection' => 'Elemental Resistance Values (80/80)',
                                                'dextrous_smiting' => 'Damage when using one-handed weapons (60/60)',
                                                'dextrous_agility' => 'Attacks per second when using one-handed weapons (60/60)',
                                                'ambidextrous_smiting' => 'Damage when using two-handed weapons (60/60)',
                                                'ambidextrous_agility' => 'Attacks per second when using two-handed weapons (60/60)',
                                            ])
                                            ->descriptions([
                                                'rising_vigor' => '+195000 Health Points',
                                                'vivacious_vitality' => '+9900 Health Regeneration',
                                                'depth_of_fury' => '+60 Resource Points',
                                                'rising_power' => '+6000 Damage',
                                                'decisive_strike' => '+67600 Critical Value',
                                                'sturdy_shield' => '+67600 Block Value',
                                                'hard_as_a_rock' => '+43600 Armor Value',
                                                'elemental_protection' => '+43600 Elemental Resistance Values',
                                                'dextrous_smiting' => '+6000 Damage when using one-handed weapons',
                                                'dextrous_agility' => '+0.600 attack speed when using one-handed weapons',
                                                'ambidextrous_smiting' => '+12000 Damage when using two-handed weapons',
                                                'ambidextrous_agility' => '+0.300 attack speed when using two-handed weapons',
                                            ])
                                            ->afterStateUpdated(function ($state, callable $get, callable $set, $old) {
                                                $buffs = [
                                                    'multiplication' => [],
                                                    'addition' => [
                                                        'rising_vigor' => ['health_points' => 195000],
                                                        'vivacious_vitality' => ['health_regeneration' => 9900],
                                                        'depth_of_fury' => ['resource_points' => 60],
                                                        'rising_power' => ['base_damage' => 6000],
                                                        'decisive_strike' => ['critical_value' => 67600],
                                                        'sturdy_shield' => ['block_value' => 67600],
                                                        'hard_as_a_rock' => ['armor_value' => 43600],
                                                        'elemental_protection' => ['ice' => 43600, 'fire' => 43600, 'andermagic' => 43600, 'poison' => 43600, 'lightning' => 43600],
                                                        'dextrous_smiting' => ['base_damage' => 6000],
                                                        'dextrous_agility' => ['attacks_per_second' => 0.600],
                                                        'ambidextrous_smiting' => ['base_damage' => 12000],
                                                        'ambidextrous_agility' => ['attacks_per_second' => 0.300],
                                                    ],
                                                ];

                                                $this->applyBuff($state, $get, $set, $old, $buffs);
                                            })
                                            ->columns(3)
                                            ->gridDirection('row'),
                                    ]),

                                Tabs\Tab::make('Skills')
                                    ->schema([
                                        Forms\Components\CheckboxList::make('skills')
                                            ->live()
                                            ->columnSpanFull()
                                            ->options([
                                                'blood_mage' => 'Blood Mage',
                                                'furious_battle_cry' => 'Furious Battle Cry',
                                                'immovable_wall' => 'Immovable Wall',
                                                'dragon_hide' => 'Dragon Hide',
                                                'quick_striker' => 'Quick Striker',
                                                'engineer' => 'Engineer',
                                            ])
                                            ->descriptions([
                                                'blood_mage' => '+50% damage',
                                                'furious_battle_cry' => new HtmlString('+50% movement speed</br> +50% damage'),
                                                'immovable_wall' => '+70% armor',
                                                'dragon_hide' => new HtmlString('+70% armor value</br> +70% elemental resistance values'),
                                                'quick_striker' => '+50% attack speed',
                                                'engineer' => '+50% damage',
                                            ])
                                            ->afterStateUpdated(function ($state, callable $get, callable $set, $old) {
                                                $buffs = [
                                                    'multiplication' => [
                                                        'blood_mage' => ['base_damage' => 1.5],
                                                        'furious_battle_cry' => ['movement_speed' => 1.5, 'base_damage' => 1.5],
                                                        'immovable_wall' => ['armor_value' => 1.7],
                                                        'dragon_hide' => ['ice' => 1.14, 'fire' => 1.14, 'andermagic' => 1.14, 'poison' => 1.14, 'lightning' => 1.14, 'armor_value' => 1.7],
                                                        'quick_striker' => ['attacks_per_second' => 1.5],
                                                        'engineer' => ['attacks_per_second' => 1.5],
                                                    ],
                                                    'addition' => [],
                                                ];

                                                $this->applyBuff($state, $get, $set, $old, $buffs);
                                            })
                                            ->columns(3)
                                            ->gridDirection('row'),
                                    ]),

                                Tabs\Tab::make('Items')
                                    ->schema([
                                        Forms\Components\CheckboxList::make('Items')
                                            ->live()
                                            ->columnSpanFull()
                                            ->options([
                                                'mortis_set' => 'Mortis Set',
                                                'belt_of_zeal' => 'Belt of Zeal',
                                                'gloves_of_zeal' => 'Gloves of Zeal',
                                                'ring_of_zeal' => 'Ring of Zeal',
                                            ])
                                            ->descriptions([
                                                'mortis_set' => new HtmlString('+500% damage</br> -250% health points'),
                                                'belt_of_zeal' => new HtmlString('+20% damage</br> +10% attack speed'),
                                                'ring_of_zeal' => '+20% critical value',
                                                'gloves_of_zeal' => new HtmlString('+15% all resistance values</br> +15% armor value'),
                                            ])
                                            ->afterStateUpdated(function ($state, callable $get, callable $set, $old) {
                                                $buffs = [
                                                    'multiplication' => [
                                                        'mortis_set' => ['base_damage' => 5, 'health_points' => 1 / 2.5],
                                                        'belt_of_zeal' => ['base_damage' => 1.2, 'attacks_per_second' => 1.1],
                                                        'ring_of_zeal' => ['critical_value' => 1.18],
                                                        'gloves_of_zeal' => ['ice' => 1.03, 'fire' => 1.03, 'andermagic' => 1.03, 'poison' => 1.03, 'lightning' => 1.03, 'armor_value' => 1.15],
                                                    ],
                                                    'addition' => [],
                                                ];

                                                $this->applyBuff($state, $get, $set, $old, $buffs);
                                            })
                                            ->columns(3)
                                            ->gridDirection('row'),
                                    ]),

                                Tabs\Tab::make('Potions')
                                    ->schema([
                                        Forms\Components\CheckboxList::make('potions')
                                            ->live()
                                            ->columnSpanFull()
                                            ->options([
                                                'advanced_physic_of_vitality' => 'Advanced Physic of Vitality',
                                                'advanced_physic_of_vigor' => 'Advanced Physic of Vigor',
                                                'advanced_physic_of_fortitude' => 'Advanced Physic of Fortitude',
                                                'advanced_physic_of_determination' => 'Advanced Physic of Determination',
                                                'advanced_physic_of_celerity' => 'Advanced Physic of Celerity',
                                                'advanced_physic_of_precision' => 'Advanced Physic of Precision',
                                                'tonic_of_vitality' => 'Tonic of Vitality',
                                                'tonic_of_vigor' => 'Tonic of Vigor',
                                                'tonic_of_fortitude' => 'Tonic of Precision',
                                                'tonic_of_determination' => 'Tonic of Precision',
                                                'tonic_of_celerity' => 'Tonic of Precision',
                                                'tonic_of_precision' => 'Tonic of Precision',
                                            ])
                                            ->descriptions([
                                                'advanced_physic_of_vitality' => '+18% health points',
                                                'advanced_physic_of_vigor' => '+18% damage',
                                                'advanced_physic_of_fortitude' => '+18% armor value',
                                                'advanced_physic_of_determination' => '+18% block value',
                                                'advanced_physic_of_celerity' => '+18% attack speed',
                                                'advanced_physic_of_precision' => '+18% critical value',
                                                'tonic_of_vitality' => '+156,068 health points',
                                                'tonic_of_vigor' => '+10,496 damage',
                                                'tonic_of_fortitude' => '+5,559 armor value',
                                                'tonic_of_determination' => '+6,516 block value',
                                                'tonic_of_celerity' => '+10,496 attack speed',
                                                'tonic_of_precision' => '+10,496 critical value',
                                            ])
                                            ->afterStateUpdated(function ($state, callable $get, callable $set, $old) {
                                                $buffs = [
                                                    'multiplication' => [
                                                        'advanced_physic_of_vitality' => ['health_points' => 1.18],
                                                        'advanced_physic_of_vigor' => ['base_damage' => 1.18],
                                                        'advanced_physic_of_fortitude' => ['armor_value' => 1.18],
                                                        'advanced_physic_of_determination' => ['block_value' => 1.18],
                                                        'advanced_physic_of_celerity' => ['attacks_per_second' => 1.18],
                                                        'advanced_physic_of_precision' => ['critical_value' => 1.18],
                                                    ],
                                                    'addition' => [
                                                        'tonic_of_vitality' => ['health_points' => 10496],
                                                        'tonic_of_vigor' => ['base_damage' => 10496],
                                                        'tonic_of_fortitude' => ['armor_value' => 10496],
                                                        'tonic_of_determination' => ['block_value' => 10496],
                                                        'tonic_of_celerity' => ['attacks_per_second' => 10496],
                                                        'tonic_of_precision' => ['critical_value' => 10496],
                                                    ],
                                                ];

                                                $this->applyBuff($state, $get, $set, $old, $buffs);
                                            })
                                            ->columns(3)
                                            ->gridDirection('row'),
                                    ]),

                                Tabs\Tab::make('Essences')
                                    ->schema([
                                        Forms\Components\CheckboxList::make('essences')
                                            ->live()
                                            ->columnSpanFull()
                                            ->options([
                                                'essence_of_vigor_common' => 'Essence of Vigor (Common)',
                                                'essence_of_vigor_improved' => 'Essence of Vigor (Improved)',
                                                'essence_of_vigor_magic' => 'Essence of Vigor (Magic)',
                                                'essence_of_vigor_extraordinary' => 'Essence of Vigor (Extraordinary)',
                                                'essence_of_vigor_legendary' => 'Essence of Vigor (Legendary)',
                                                'oddcandy_ammo' => 'Oddcandy Ammo (Legendary)',
                                                'blazing_essence_of_vigor' => 'Blazing Essence of Vigor (Legendary)',
                                            ])
                                            ->descriptions([
                                                'essence_of_vigor_common' => '+25% damage',
                                                'essence_of_vigor_improved' => '+50% damage',
                                                'essence_of_vigor_magic' => '+100% damage',
                                                'essence_of_vigor_extraordinary' => '+200% damage',
                                                'essence_of_vigor_legendary' => '+300% damage',
                                                'oddcandy_ammo' => '+400% damage',
                                                'blazing_essence_of_vigor' => '+600% damage',
                                            ])
                                            ->afterStateUpdated(function ($state, callable $get, callable $set, $old) {
                                                $buffs = [
                                                    'multiplication' => [
                                                        'essence_of_vigor_common' => ['base_damage' => 1.25],
                                                        'essence_of_vigor_improved' => ['base_damage' => 1.60],
                                                        'essence_of_vigor_magic' => ['base_damage' => 2],
                                                        'essence_of_vigor_extraordinary' => ['base_damage' => 3],
                                                        'essence_of_vigor_legendary' => ['base_damage' => 4],
                                                        'oddcandy_ammo' => ['base_damage' => 5],
                                                        'blazing_essence_of_vigor' => ['base_damage' => 7],
                                                    ],
                                                    'addition' => [],
                                                ];

                                                $this->applyBuff($state, $get, $set, $old, $buffs);
                                            })
                                            ->columns(3)
                                            ->gridDirection('row'),
                                    ]),

                                Tabs\Tab::make('Pets')
                                    ->schema([
                                        Forms\Components\CheckboxList::make('pets')
                                            ->columnSpanFull()
                                            ->options([
                                                'bearach_doll' => 'Bearach Doll',
                                                'arachna_doll' => 'Arachna Doll',
                                                'dragan_doll' => 'Dragan Doll',
                                                'gold_fairy' => 'Gold Fairy',
                                                'mortis_doll' => 'Mortis Doll',
                                                'sargon_doll' => 'Sargon Doll',
                                                'unleashed_sargon_doll' => 'Unleashed Sargon Doll',
                                                'cake_meanie' => 'Cake Meanie',
                                                'mortis_and_skeledragon_doll' => 'Mortis and Skeledragon Doll',
                                                'collectors_bag_effect' => "Collector's Bag Effect",
                                            ])
                                            ->descriptions([
                                                'bearach_doll' => '+27,5% damage',
                                                'arachna_doll' => '+30% critical value',
                                                'dragan_doll' => new HtmlString('+16% attack speed</br> +16% damage'),
                                                'gold_fairy' => new HtmlString('+26% damage</br> +10% movement speed'),
                                                'mortis_doll' => new HtmlString('+30% attack speed</br> +30% resource points</br> +30% damage'),
                                                'sargon_doll' => new HtmlString('+30% block value</br> +30% movement speed'),
                                                'unleashed_sargon_doll' => new HtmlString('+30% damage</br> +30% armor value'),
                                                'cake_meanie' => new HtmlString('+14% damage</br> +16% critical value</br> +12% attack speed'),
                                                'mortis_and_skeledragon_doll' => new HtmlString('+30% critical value</br> +30% andermagic resistance'),
                                                'collectors_bag_effect' => new HtmlString('+33% health points</br> +15% all resistance values</br> +6% damage</br> +2% block value'),
                                            ])
                                            ->live()
                                            ->afterStateUpdated(function ($state, callable $get, callable $set, $old) {
                                                $buffs = [
                                                    'multiplication' => [
                                                        'bearach_doll' => ['base_damage' => 1.275],
                                                        'arachna_doll' => ['critical_value' => 1.3],
                                                        'dragan_doll' => ['attacks_per_second' => 1.16, 'base_damage' => 1.16],
                                                        'gold_fairy' => ['base_damage' => 1.26, 'movement_speed' => 1.1],
                                                        'mortis_doll' => ['attacks_per_second' => 1.3, 'rage_points' => 1.3, 'mana_points' => 1.3, 'steam_points' => 1.3, 'concentration_points' => 1.3, 'base_damage' => 1.3],
                                                        'sargon_doll' => ['block_value' => 1.3, 'movement_speed' => 1.1],
                                                        'unleashed_sargon_doll' => ['base_damage' => 1.3, 'armor_value' => 1.3],
                                                        'cake_meanie' => ['base_damage' => 1.14, 'critical_value' => 1.16, 'attacks_per_second' => 1.12],
                                                        'mortis_and_skeledragon_doll' => ['critical_value' => 1.3, 'andermagic' => 1.3],
                                                        'collectors_bag_effect' => ['health_points' => 1.33, 'ice' => 1.3, 'fire' => 1.3, 'andermagic' => 1.3, 'poison' => 1.3, 'lightning' => 1.3, 'base_damage' => 1.6, 'block_value' => 1.02],
                                                    ],
                                                    'addition' => [],
                                                ];

                                                $this->applyBuff($state, $get, $set, $old, $buffs);
                                            })
                                            ->columns(3)
                                            ->gridDirection('row'),
                                    ]),

                                Tabs\Tab::make('Other')
                                    ->schema([
                                        Forms\Components\CheckboxList::make('other')
                                            ->live()
                                            ->columnSpanFull()
                                            ->options([
                                                'uncontrollable_rage' => 'Uncontrollable Rage',
                                            ])
                                            ->descriptions([
                                                'uncontrollable_rage' => '+100% damage (buff from 4.0 attack speed)',
                                            ])
                                            ->afterStateUpdated(function ($state, callable $get, callable $set, $old) {
                                                $buffs = [
                                                    'multiplication' => [
                                                        'uncontrollable_rage' => ['base_damage' => 2],
                                                    ],
                                                    'addition' => [],
                                                ];

                                                $this->applyBuff($state, $get, $set, $old, $buffs);
                                            })
                                            ->columns(3)
                                            ->gridDirection('row'),
                                    ]),
                            ])
                            ->columns(3)
                            ->persistTab()
                            ->contained(false)
                            ->id('buffs-tab'),
                    ]),

                Forms\Components\Section::make('Gems')
                    ->columnSpanFull()
                    ->collapsible()
                    ->persistCollapsed()
                    ->id('section-gems')
                    ->schema([
                        Tabs::make('Gems')
                            ->columnSpanFull()
                            ->tabs([
                                Tabs\Tab::make('Amulet')
                                    ->columns(2)
                                    ->schema($this->createGemTabSchema('amulet', 10)),

                                Tabs\Tab::make('Cape')
                                    ->columns(2)
                                    ->schema($this->createGemTabSchema('cape', 10)),

                                Tabs\Tab::make('Belt')
                                    ->columns(2)
                                    ->schema($this->createGemTabSchema('belt', 10)),

                                Tabs\Tab::make('Ring 1')
                                    ->columns(2)
                                    ->schema($this->createGemTabSchema('ring', 10)),

                                Tabs\Tab::make('Ring 2')
                                    ->columns(2)
                                    ->schema($this->createGemTabSchema('ring', 10)),

                                Tabs\Tab::make('Adornment')
                                    ->columns(2)
                                    ->schema($this->createGemTabSchema('adornment', 10)),

                                Tabs\Tab::make('Hand 1')
                                    ->columns(2)
                                    ->schema($this->createGemTabSchema('hand', 10)),

                                Tabs\Tab::make('Hand 2')
                                    ->columns(2)
                                    ->schema($this->createGemTabSchema('hand', 10)),

                                Tabs\Tab::make('Helmet')
                                    ->columns(2)
                                    ->schema($this->createGemTabSchema('helmet', 10)),

                                Tabs\Tab::make('Shoulders')
                                    ->columns(2)
                                    ->schema($this->createGemTabSchema('shoulders', 10)),

                                Tabs\Tab::make('Torso')
                                    ->columns(2)
                                    ->schema($this->createGemTabSchema('torso', 10)),

                                Tabs\Tab::make('Gloves')
                                    ->columns(2)
                                    ->schema($this->createGemTabSchema('gloves', 10)),

                                Tabs\Tab::make('Boots')
                                    ->columns(2)
                                    ->schema($this->createGemTabSchema('boots', 10)),
                            ])
                            ->columns(3)
                            ->persistTab()
                            ->contained(false)
                            ->id('gems-tab'),
                    ]),

                Forms\Components\Section::make('Class')
                    ->columnSpanFull()
                    ->collapsible()
                    ->persistCollapsed()
                    ->id('section-class')
                    ->schema([
                        Tabs::make('Class')
                            ->columnSpanFull()
                            ->tabs([
                                Tabs\Tab::make('Dragonknight')
                                    ->schema($this->createClassTabSchema('Dragonknight', [$this, 'createClassFields'], 'dragonknight')),

                                Tabs\Tab::make('Spellweaver')
                                    ->schema($this->createClassTabSchema('Spellweaver', [$this, 'createClassFields'], 'spellweaver')),

                                Tabs\Tab::make('Ranger')
                                    ->schema($this->createClassTabSchema('Ranger', [$this, 'createClassFields'], 'ranger')),

                                Tabs\Tab::make('Steam Mechanicus')
                                    ->schema($this->createClassTabSchema('Steam Mechanicus', [$this, 'createClassFields'], 'steam_mechanicus')),
                            ])
                            ->columns(3)
                            ->persistTab()
                            ->contained(false)
                            ->id('class-tab'),
                    ]),
            ])
            ->columns(3)
            ->statePath('dust');
    }

    public function getGems(): array
    {
        return Cache::remember('gems', now()->addHours(1), function () {
            return Gem::pluck('name', 'id')->toArray();
        });
    }

    public function getItems(): array
    {
        return Cache::remember('items', now()->addHours(1), function () {
            return Item::pluck('name', 'id')->toArray();
        });
    }

    public function updateGemAttributes($state, $get, $set, $old)
    {
        $gem = $state ? Gem::find($state) : Gem::find($old);

        switch ($gem->type->value) {
            case 'ruby':
                $attributes = ['ranger_base_damage', 'dragonknight_base_damage', 'spellweaver_base_damage', 'steam_mechanicus_base_damage'];
                break;
            case 'onyx':
                $attributes = ['ranger_critical_value', 'dragonknight_critical_value', 'spellweaver_critical_value', 'steam_mechanicus_critical_value'];
                break;
            case 'zircon':
                $attributes = ['ranger_attacks_per_second', 'dragonknight_attacks_per_second', 'spellweaver_attacks_per_second', 'steam_mechanicus_attacks_per_second'];
                break;
            case 'rhodolite':
                $attributes = ['ranger_movement_speed', 'dragonknight_movement_speed', 'spellweaver_movement_speed', 'steam_mechanicus_movement_speed'];
                break;
            case 'diamond':
                $attributes = ['ranger_all_resistance_values', 'dragonknight_all_resistance_values', 'spellweaver_all_resistance_values', 'steam_mechanicus_all_resistance_values'];
                break;
            case 'diamond_fire':
                $attributes = ['ranger_fire', 'dragonknight_fire', 'spellweaver_fire', 'steam_mechanicus_fire'];
                break;
            case 'diamond_ice':
                $attributes = ['ranger_ice', 'dragonknight_ice', 'spellweaver_ice', 'steam_mechanicus_ice'];
                break;
            case 'diamond_andermagic':
                $attributes = ['ranger_andermagic', 'dragonknight_andermagic', 'spellweaver_andermagic', 'steam_mechanicus_andermagic'];
                break;
            case 'diamond_poison':
                $attributes = ['ranger_poison', 'dragonknight_poison', 'spellweaver_poison', 'steam_mechanicus_poison'];
                break;
            case 'diamond_lightning':
                $attributes = ['ranger_lightning', 'dragonknight_lightning', 'spellweaver_lightning', 'steam_mechanicus_lightning'];
                break;
            case 'amethyst':
                $attributes = ['ranger_health_points', 'dragonknight_health_points', 'spellweaver_health_points', 'steam_mechanicus_health_points'];
                break;
            case 'cyanite':
                $attributes = ['ranger_armor_value', 'dragonknight_armor_value', 'spellweaver_armor_value', 'steam_mechanicus_armor_value'];
                break;
            case 'emerald':
                $attributes = ['ranger_block_value', 'dragonknight_block_value', 'spellweaver_block_value', 'steam_mechanicus_block_value'];
                break;
            default:
                $attributes = [];
        }

        $floatFields = [
            'zircon',
            'rhodolite',
        ];

        $attributeValues = [];
        foreach ($attributes as $attribute) {
            // Remove commas and convert to integer
            $attributeValues[$attribute] = in_array($gem->type->value, $floatFields) ? (float) $get($attribute) : (int) str_replace(',', '', $get($attribute));
        }

        // If $state is not set, subtract $gem->value from each attribute
        if (! $state) {
            foreach ($attributeValues as &$value) {
                $value -= $gem->value;
            }
            unset($value); // Unset the reference
        } elseif (! filled(array_filter($attributeValues))) {
            // If any attribute is not set, initialize all attributes with $gem->value
            foreach ($attributes as $attribute) {
                $attributeValues[$attribute] = $gem->value;
            }
        } else {
            // Otherwise, add $gem->value to each attribute
            foreach ($attributeValues as &$value) {
                $value += $gem->value;
            }
            unset($value); // Unset the reference
        }

        // Format the result and set it in the state
        foreach ($attributeValues as $attribute => $value) {
            $formatted_value = in_array($gem->type->value, $floatFields) ? number_format($value, 3) : number_format($value, 0);
            $set($attribute, $formatted_value);
        }
    }

    public function createGemSelectComponent($tabName, $slotNumber)
    {
        return Forms\Components\Select::make("{$tabName}_gem_slot_{$slotNumber}")
            ->label("Gem Slot {$slotNumber}")
            ->options($this->getGems())
            ->searchable()
            ->optionsLimit(1)
            ->searchPrompt('Start typing to search for gems...')
            ->searchingMessage('Searching gems...')
            ->noSearchResultsMessage('No gems found...')
            ->live()
            ->afterStateUpdated(function ($state, callable $get, callable $set, $old) {
                $this->updateGemAttributes($state, $get, $set, $old);
            });
    }

    public function createGemTabSchema($tabName, $numberOfSlots)
    {
        $schema = [];
        for ($i = 1; $i <= $numberOfSlots; $i++) {
            $fieldKey = "{$tabName}_gem_slot_{$i}";
            $schema[] = $this->createGemSelectComponent($tabName, $i)->key($fieldKey);
        }

        return $schema;
    }

    public function createClassTabSchema($tabName, $fieldsFunction, $characterClassName)
    {
        $schema = [];
        $fields = $fieldsFunction($characterClassName);
        foreach ($fields as $sectionName => $sectionFields) {
            $schema[] = $this->createClassSectionSchema($sectionName, $sectionFields);
        }

        return $schema;
    }

    public function createClassSectionSchema($sectionName, $fields)
    {
        return Forms\Components\Section::make($sectionName)
            ->columns(2)
            ->schema($fields);
    }

    public function updateFields(callable $get, callable $set, array $fields)
    {
        foreach ($fields as $field => $multiplier) {
            $base_damage = (int) str_replace(',', '', $get($field));
            $set($field, number_format($base_damage * $multiplier));
        }
    }

    public function calculatePercentage($value)
    {
        // Define the percentage mapping
        $percentageMap = [
            317441 => 80.00,
            100 => 0.03,
            250 => 0.06,
            500 => 0.13,
            750 => 0.19,
            1000 => 0.25,
            2500 => 0.63,
            5000 => 1.26,
            7500 => 1.89,
            10000 => 2.52,
            25000 => 6.30,
            50000 => 12.60,
            75000 => 18.90,
            100000 => 25.20,
            125000 => 31.50,
            150000 => 37.80,
            175000 => 44.10,
            200000 => 50.40,
            225000 => 56.70,
            250000 => 63.00,
            275000 => 69.30,
            300000 => 75.60,
        ];

        // Find the closest value in the array to the given value
        $closestValue = null;
        $closestPercentage = null;
        foreach ($percentageMap as $mapValue => $percentage) {
            if ($closestValue === null || abs($value - $mapValue) < abs($value - $closestValue)) {
                $closestValue = $mapValue;
                $closestPercentage = $percentage;
            }
        }

        // Calculate the percentage based on the closest value
        $percentage = ($value / $closestValue) * $closestPercentage;

        return $percentage;
    }

    public function applyBuff($state, $get, $set, $old, $buffs)
    {
        // Get the last item from $state
        $lastItem = end($state);

        // Append the last item from $state to $backupState only if it's not already in the backupState
        if (! in_array($lastItem, $this->backupState)) {
            array_push($this->backupState, $lastItem);
        }

        // Determine which set of buffs to use based on $state or $old
        // $currentState = is_array($state) ? end($state) : $state;
        // $currentOld = is_array($old) ? end($old) : $old;
        $currentBackupOld = is_array($this->backupState) ? end($this->backupState) : $this->backupState;

        // Filter out empty values from $state and $this->backupState before performing array_diff
        $state = array_filter($state);
        $this->backupState = array_filter($this->backupState);

        // Perform array_diff after filtering out empty values
        $removedItem = array_diff($this->backupState, $state);
        $this->backupState = array_diff($this->backupState, $removedItem);

        $countRemovedItem = empty($removedItem) ? 0 : count($removedItem);
        $countState = empty($state) ? 0 : count($state);

        // Adjusted logic to handle multiple items in $removedItem
        if ($countState > 1) {
            if ($countRemovedItem > 1) {
                // array_reverse($removedItem);
                array_pop($removedItem);
            }
            $removedItemKey = end($removedItem);
            $currentBackupOldKey = $currentBackupOld;
        } else {
            $removedItemKey = end($removedItem);
            $currentBackupOldKey = $currentBackupOld;
        }

        if (isset($buffs['multiplication'][$removedItemKey]) || isset($buffs['multiplication'][$currentBackupOldKey])) {
            $case = isset($buffs['multiplication'][$removedItemKey]) ? $buffs['multiplication'][$removedItemKey] : $buffs['multiplication'][$currentBackupOldKey];
        } else {
            $case = isset($buffs['addition'][$removedItemKey]) ? $buffs['addition'][$removedItemKey] : $buffs['addition'][$currentBackupOldKey];
        }

        $floatFields = [
            'attacks_per_second',
            'movement_speed',
            'health_points_regeneration',
            'concentration_regeneration',
            'mana_regeneration',
            'steam_regeneration',
        ];

        // Iterate over each field and its multiplier in the current case
        foreach ($case as $fieldSuffix => $multiplier) {
            foreach (['ranger_', 'dragonknight_', 'spellweaver_', 'steam_mechanicus_'] as $prefix) {
                $fullFieldName = $prefix.$fieldSuffix; // Generate the full field name

                // Get the current field value
                $fieldValue = $get($fullFieldName);

                // Convert field value to float if it's in $floatFields, else to integer
                $fieldValue = in_array($fieldSuffix, $floatFields) ? (float) $fieldValue : (int) str_replace(',', '', $fieldValue);

                // Apply or revert the buff to the field based on custom variables
                if (isset($buffs['multiplication'][$removedItemKey]) || isset($buffs['multiplication'][$currentBackupOldKey])) {
                    // Apply multiplication buff
                    $updatedValue = isset($buffs['multiplication'][$removedItemKey]) ? $fieldValue / $multiplier : $fieldValue * $multiplier;
                } else {
                    // Apply addition buff
                    $updatedValue = isset($buffs['addition'][$removedItemKey]) ? $fieldValue - $multiplier : $fieldValue + $multiplier;
                }

                // Format the updated value and set it
                $formattedValue = in_array($fieldSuffix, $floatFields) ? number_format($updatedValue, 3) : number_format($updatedValue, 0);
                $set($fullFieldName, $formattedValue);
            }
        }
    }

    // Define the function to create fields
    public function createClassFields($characterClassName)
    {
        $fields = [
            'Offensive Values' => [
                Forms\Components\TextInput::make("{$characterClassName}_base_damage")
                    ->label('Base Damage')
                    ->live()
                    ->columnSpanFull()
                    ->default(fn (Get $get): int => match ($characterClassName) {
                        'dragonknight' => 16800,
                        'spellweaver' => 50400,
                        'ranger' => 29400,
                        'steam_mechanicus' => 38640,
                        default => 0,
                    })
                    ->formatStateUsing(fn (string $state): string => number_format((int) $state))
                    ->readonly(),

                Forms\Components\TextInput::make("{$characterClassName}_attacks_per_second")
                    ->label('Attacks Per Second')
                    ->live()
                    ->columnSpanFull()
                    ->default(1)
                    ->formatStateUsing(fn ($state) => number_format((float) $state, 3, '.', ''))
                    ->readonly(),

                Forms\Components\TextInput::make("{$characterClassName}_critical_value")
                    ->label('Critical Value')
                    ->live()
                    ->columnSpan(1)
                    ->default(0)
                    ->formatStateUsing(fn (string $state): string => number_format((int) $state))
                    ->readonly(),

                Forms\Components\TextInput::make("{$characterClassName}_movement_speed")
                    ->label('Movement Speed')
                    ->live()
                    ->columnSpanFull()
                    ->default(5)
                    ->formatStateUsing(fn ($state) => number_format((float) $state, 3, '.', ''))
                    ->readonly(),
            ],
            'Defensive Values' => [
                Forms\Components\TextInput::make("{$characterClassName}_health_points")
                    ->label('Health Points')
                    ->live()
                    ->columnSpanFull()
                    ->default(fn (Get $get): int => match ($characterClassName) {
                        'dragonknight' => 450000,
                        'spellweaver' => 150000,
                        'ranger' => 345000,
                        'steam_mechanicus' => 262500,
                        default => 0,
                    })
                    ->formatStateUsing(fn (string $state): string => number_format((int) $state))
                    ->readonly(),

                Forms\Components\TextInput::make("{$characterClassName}_health_points_regeneration")
                    ->label('Health Points Regeneration')
                    ->live()
                    ->columnSpanFull()
                    ->default(0)
                    ->formatStateUsing(fn ($state) => number_format((float) $state, 2, '.', ''))
                    ->readonly(),

                Forms\Components\TextInput::make("{$characterClassName}_block_value")
                    ->label('Block Value')
                    ->live()
                    ->columnSpan(1)
                    ->default(0)
                    ->formatStateUsing(fn (string $state): string => number_format((int) $state))
                    ->readonly(),

                Forms\Components\TextInput::make("{$characterClassName}_critical_value_percentage")
                    ->label('Percentage Value')
                    ->live()
                    ->columnSpan(1)
                    ->default(0)
                    ->formatStateUsing(fn (string $state): string => number_format((float) $state, 2).'%')
                    ->readonly(),

                Forms\Components\TextInput::make("{$characterClassName}_armor_value")
                    ->label('Armor Value')
                    ->live()
                    ->columnSpan(1)
                    ->default(0)
                    ->formatStateUsing(fn (string $state): string => number_format((int) $state))
                    ->readonly(),

                Forms\Components\TextInput::make("{$characterClassName}_armor_value_percentage")
                    ->label('Percentage Value')
                    ->live()
                    ->columnSpan(1)
                    ->default(0)
                    ->formatStateUsing(fn (string $state): string => number_format((float) $state, 2).'%')
                    ->readonly(),

                Forms\Components\TextInput::make("{$characterClassName}_fire_value")
                    ->label('Fire')
                    ->live()
                    ->columnSpan(1)
                    ->default(0)
                    ->formatStateUsing(fn (string $state): string => number_format((int) $state))
                    ->readonly(),

                Forms\Components\TextInput::make("{$characterClassName}_fire_value_percentage")
                    ->label('Percentage Value')
                    ->live()
                    ->columnSpan(1)
                    ->default(0)
                    ->formatStateUsing(fn (string $state): string => number_format((float) $state, 2).'%')
                    ->readonly(),

                Forms\Components\TextInput::make("{$characterClassName}_ice_value")
                    ->label('Ice')
                    ->live()
                    ->columnSpan(1)
                    ->default(0)
                    ->formatStateUsing(fn (string $state): string => number_format((int) $state))
                    ->readonly(),

                Forms\Components\TextInput::make("{$characterClassName}_ice_value_percentage")
                    ->label('Percentage Value')
                    ->live()
                    ->columnSpan(1)
                    ->default(0)
                    ->formatStateUsing(fn (string $state): string => number_format((float) $state, 2).'%')
                    ->readonly(),

                Forms\Components\TextInput::make("{$characterClassName}_lightning_value")
                    ->label('Lightning')
                    ->live()
                    ->columnSpan(1)
                    ->default(0)
                    ->formatStateUsing(fn (string $state): string => number_format((int) $state))
                    ->readonly(),

                Forms\Components\TextInput::make("{$characterClassName}_lightning_value_percentage")
                    ->label('Percentage Value')
                    ->live()
                    ->columnSpan(1)
                    ->default(0)
                    ->formatStateUsing(fn (string $state): string => number_format((float) $state, 2).'%')
                    ->readonly(),

                Forms\Components\TextInput::make("{$characterClassName}_andermagic_value")
                    ->label('Andermagic')
                    ->live()
                    ->columnSpan(1)
                    ->default(0)
                    ->formatStateUsing(fn (string $state): string => number_format((int) $state))
                    ->readonly(),

                Forms\Components\TextInput::make("{$characterClassName}_andermagic_value_percentage")
                    ->label('Percentage Value')
                    ->live()
                    ->columnSpan(1)
                    ->default(0)
                    ->formatStateUsing(fn (string $state): string => number_format((float) $state, 2).'%')
                    ->readonly(),

                Forms\Components\TextInput::make("{$characterClassName}_poison_value")
                    ->label('Poison')
                    ->live()
                    ->columnSpan(1)
                    ->default(0)
                    ->formatStateUsing(fn (string $state): string => number_format((int) $state))
                    ->readonly(),

                Forms\Components\TextInput::make("{$characterClassName}_poison_value_percentage")
                    ->label('Percentage Value')
                    ->live()
                    ->columnSpan(1)
                    ->default(0)
                    ->formatStateUsing(fn (string $state): string => number_format((float) $state, 2).'%')
                    ->readonly(),
            ],
            'Other Values' => [
                Forms\Components\TextInput::make("{$characterClassName}_xp_gain")
                    ->label('Xp Gain')
                    ->live()
                    ->columnSpanFull()
                    ->default(100)
                    ->formatStateUsing(fn (string $state): string => number_format((int) $state))
                    ->readonly(),

                Forms\Components\TextInput::make("{$characterClassName}_honor_gain")
                    ->label('Honor Gain')
                    ->live()
                    ->columnSpanFull()
                    ->default(100)
                    ->formatStateUsing(fn (string $state): string => number_format((int) $state))
                    ->readonly(),

                Forms\Components\TextInput::make("{$characterClassName}_andermant_drop_stack_size")
                    ->label('Andermant Drop Stack Size')
                    ->live()
                    ->columnSpanFull()
                    ->default(0)
                    ->formatStateUsing(fn (string $state): string => number_format((int) $state))
                    ->readonly(),

                Forms\Components\TextInput::make("{$characterClassName}_coin_drop_stack_size")
                    ->label('Coin Drop Stack Size')
                    ->live()
                    ->columnSpanFull()
                    ->default(0)
                    ->formatStateUsing(fn (string $state): string => number_format((int) $state))
                    ->readonly(),

                Forms\Components\TextInput::make("{$characterClassName}_ancient_wisdom_drop_stack_size")
                    ->label('Ancient Wisdom Drop Stack Size')
                    ->live()
                    ->columnSpanFull()
                    ->default(0)
                    ->formatStateUsing(fn (string $state): string => number_format((int) $state))
                    ->readonly(),

                Forms\Components\TextInput::make("{$characterClassName}_materi_fragment_drop_stack_size")
                    ->label('Materi Fragment Drop Stack Size')
                    ->live()
                    ->columnSpanFull()
                    ->default(0)
                    ->formatStateUsing(fn (string $state): string => number_format((int) $state))
                    ->readonly(),
            ],
        ];

        // Add additional fields based on $characterClassName
        switch ($characterClassName) {
            case 'ranger':
                array_splice($fields['Offensive Values'], 3, 0, [
                    Forms\Components\TextInput::make("{$characterClassName}_critical_value_percentage")
                        ->label('Percentage Value')
                        ->live()
                        ->columnSpan(1)
                        ->default(0)
                        ->formatStateUsing(fn (string $state): string => number_format((float) $state, 2).'%')
                        ->readonly(),

                    Forms\Components\TextInput::make("{$characterClassName}_concentration_points")
                        ->label('Concentration Points')
                        ->live()
                        ->columnSpanFull()
                        ->default(100)
                        ->formatStateUsing(fn (string $state): string => number_format((int) $state))
                        ->readonly(),

                    Forms\Components\TextInput::make("{$characterClassName}_concentration_regeneration")
                        ->label('Concentration Regeneration')
                        ->live()
                        ->columnSpanFull()
                        ->default(0)
                        ->formatStateUsing(fn ($state) => number_format((float) $state, 2, '.', ''))
                        ->readonly(),
                ]);
                break;
            case 'dragonknight':
                array_splice($fields['Offensive Values'], 3, 0, [
                    Forms\Components\TextInput::make("{$characterClassName}_critical_value_percentage")
                        ->label('Percentage Value')
                        ->live()
                        ->columnSpan(1)
                        ->default(0)
                        ->formatStateUsing(fn (string $state): string => number_format((float) $state, 2).'%')
                        ->readonly(),

                    Forms\Components\TextInput::make("{$characterClassName}_rage_points")
                        ->label('Rage Points')
                        ->live()
                        ->columnSpanFull()
                        ->default(100)
                        ->formatStateUsing(fn (string $state): string => number_format((int) $state))
                        ->readonly(),
                ]);
                break;
            case 'spellweaver':
                array_splice($fields['Offensive Values'], 3, 0, [
                    Forms\Components\TextInput::make("{$characterClassName}_critical_value_percentage")
                        ->label('Percentage Value')
                        ->live()
                        ->columnSpan(1)
                        ->default(0)
                        ->formatStateUsing(fn (string $state): string => number_format((float) $state, 2).'%')
                        ->readonly(),

                    Forms\Components\TextInput::make("{$characterClassName}_mana_points")
                        ->label('Mana Points')
                        ->live()
                        ->columnSpanFull()
                        ->default(100)
                        ->formatStateUsing(fn (string $state): string => number_format((int) $state))
                        ->readonly(),

                    Forms\Components\TextInput::make("{$characterClassName}_mana_regeneration")
                        ->label('Mana Regeneration')
                        ->live()
                        ->columnSpanFull()
                        ->default(0)
                        ->formatStateUsing(fn ($state) => number_format((float) $state, 2, '.', ''))
                        ->readonly(),
                ]);
                break;
            case 'steam_mechanicus':
                array_splice($fields['Offensive Values'], 3, 0, [
                    Forms\Components\TextInput::make("{$characterClassName}_critical_value_percentage")
                        ->label('Percentage Value')
                        ->live()
                        ->columnSpan(1)
                        ->default(0)
                        ->formatStateUsing(fn (string $state): string => number_format((float) $state, 2).'%')
                        ->readonly(),

                    Forms\Components\TextInput::make("{$characterClassName}_steam_points")
                        ->label('Steam Points')
                        ->live()
                        ->columnSpanFull()
                        ->default(100)
                        ->formatStateUsing(fn (string $state): string => number_format((int) $state))
                        ->readonly(),

                    Forms\Components\TextInput::make("{$characterClassName}_steam_regeneration")
                        ->label('Steam Regeneration')
                        ->live()
                        ->columnSpanFull()
                        ->default(0)
                        ->formatStateUsing(fn ($state) => number_format((float) $state, 2, '.', ''))
                        ->readonly(),
                ]);
                break;
            default:
                break;
        }

        return $fields;
    }
}
