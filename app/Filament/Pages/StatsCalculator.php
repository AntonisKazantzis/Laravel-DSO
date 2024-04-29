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
                                                'blood_mage' => 'Blood Mage (Spellweaver)',
                                                'wolf' => 'Wolf (Ranger)',
                                                'furious_battle_cry' => 'Furious Battle Cry (Dragonknight)',
                                                'immovable_wall' => 'Immovable Wall (Dragonknight)',
                                                'dragon_hide' => 'Dragon Hide (Dragonknight)',
                                                'quick_striker' => 'Quick Striker (Dragonknight)',
                                                'engineer' => 'Engineer (Steam Mechanicus)',
                                            ])
                                            ->descriptions([
                                                'blood_mage' => '+50% damage',
                                                'wolf' => '+25% damage',
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
                                                        'wolf' => ['base_damage' => 1.25],
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
        // Find the appropriate gem based on the state or old value
        $gem = $state ? Gem::find($state) : Gem::find($old);
        $gemType = $gem->type->value; // Get the type of the gem

        // Define mapping of gem types to their corresponding attributes
        $attributeMap = [
            'ruby' => ['ranger_base_damage', 'dragonknight_base_damage', 'spellweaver_base_damage', 'steam_mechanicus_base_damage'],
            'onyx' => ['ranger_critical_value', 'dragonknight_critical_value', 'spellweaver_critical_value', 'steam_mechanicus_critical_value'],
            'zircon' => ['ranger_attacks_per_second', 'dragonknight_attacks_per_second', 'spellweaver_attacks_per_second', 'steam_mechanicus_attacks_per_second'],
            'rhodolite' => ['ranger_movement_speed', 'dragonknight_movement_speed', 'spellweaver_movement_speed', 'steam_mechanicus_movement_speed'],
            'diamond' => ['ranger_all_resistance_values', 'dragonknight_all_resistance_values', 'spellweaver_all_resistance_values', 'steam_mechanicus_all_resistance_values'],
            'diamond_fire' => ['ranger_fire', 'dragonknight_fire', 'spellweaver_fire', 'steam_mechanicus_fire'],
            'diamond_ice' => ['ranger_ice', 'dragonknight_ice', 'spellweaver_ice', 'steam_mechanicus_ice'],
            'diamond_andermagic' => ['ranger_andermagic', 'dragonknight_andermagic', 'spellweaver_andermagic', 'steam_mechanicus_andermagic'],
            'diamond_poison' => ['ranger_poison', 'dragonknight_poison', 'spellweaver_poison', 'steam_mechanicus_poison'],
            'diamond_lightning' => ['ranger_lightning', 'dragonknight_lightning', 'spellweaver_lightning', 'steam_mechanicus_lightning'],
            'amethyst' => ['ranger_health_points', 'dragonknight_health_points', 'spellweaver_health_points', 'steam_mechanicus_health_points'],
            'cyanite' => ['ranger_armor_value', 'dragonknight_armor_value', 'spellweaver_armor_value', 'steam_mechanicus_armor_value'],
            'emerald' => ['ranger_block_value', 'dragonknight_block_value', 'spellweaver_block_value', 'steam_mechanicus_block_value'],
        ];

        // Get the attributes for the current gem type or default to an empty array
        $attributes = $attributeMap[$gemType] ?? [];

        // Define fields that should be treated as float values
        $floatFields = ['zircon', 'rhodolite'];

        // Initialize an array to store attribute values
        $attributeValues = [];

        // Loop through each attribute and convert its value to integer or float
        foreach ($attributes as $attribute) {
            $value = in_array($gemType, $floatFields) ? (float) str_replace(',', '', $get($attribute)) : (int) str_replace(',', '', $get($attribute));
            $attributeValues[$attribute] = $value;
        }

        // Adjust attribute values based on state and gem value
        if (! $state || ! filled(array_filter($attributeValues))) {
            // If state is not set or any attribute is not set, initialize all attributes with the gem value
            $defaultValue = $gem->value;
            $attributeValues = array_fill_keys($attributes, $defaultValue);
        } elseif ($state) {
            // If state is set, add gem value to each attribute
            foreach ($attributeValues as &$value) {
                $value += $gem->value;
            }
            unset($value); // Unset the reference
        } else {
            // If state is not set, subtract gem value from each attribute
            foreach ($attributeValues as &$value) {
                $value -= $gem->value;
            }
            unset($value); // Unset the reference
        }

        // Format the result and set it in the state
        foreach ($attributeValues as $attribute => $value) {
            // Format the value based on the field type
            $formatted_value = in_array($gemType, $floatFields) ? number_format($value, 3) : number_format($value, 0);
            // Set the formatted value in the state
            $set($attribute, $formatted_value);
        }
    }

    private function createGemSelectComponent($tabName, $slotNumber)
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
        // Initialize an empty array to store the schema
        $schema = [];

        // Loop through each slot in the gem tab
        for ($i = 1; $i <= $numberOfSlots; $i++) {
            // Generate a unique field key for each slot
            $fieldKey = "{$tabName}_gem_slot_{$i}";

            // Create a gem select component for the current slot and add it to the schema
            $schema[] = $this->createGemSelectComponent($tabName, $i)->key($fieldKey);
        }

        return $schema;
    }

    public function createClassTabSchema($tabName, $fieldsFunction, $characterClassName)
    {
        // Initialize an empty array to store the schema
        $schema = [];

        // Retrieve the fields for the specified character class using the provided function
        $fields = $fieldsFunction($characterClassName);

        // Iterate over each section of fields and create a section schema
        foreach ($fields as $sectionName => $sectionFields) {
            $schema[] = $this->createClassSectionSchema($sectionName, $sectionFields);
        }

        return $schema;
    }

    public function createClassSectionSchema($sectionName, $fields)
    {
        // Create a section schema with the given section name, split into two columns, and containing the provided fields
        return Forms\Components\Section::make($sectionName)
            ->columns(2)
            ->schema($fields);
    }

    public function updateFields(callable $get, callable $set, array $fields)
    {
        // Iterate over each field and its corresponding multiplier
        foreach ($fields as $field => $multiplier) {
            // Retrieve the current value of the field and convert it to an integer
            $base_damage = (int) str_replace(',', '', $get($field));

            // Multiply the base damage by the multiplier and format the result
            $set($field, number_format($base_damage * $multiplier));
        }
    }

    public function calculatePercentage($value, $fieldSuffix)
    {
        // Define the percentage mapping for different field suffixes
        switch ($fieldSuffix) {
            case 'critical_value':
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
                break;
            case 'block_value':
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
                break;
            case 'armor_value':
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
                break;
            case 'fire_value':
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
                break;
            case 'ice_value':
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
                break;
            case 'lightning_value':
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
                break;
            case 'andermagic_value':
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
                break;
            case 'poison_value':
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
                break;
            default:
                $percentageMap = [0 => 00.00];
                break;
        }

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

        // Round the percentage to two decimal places
        $rounded = round($percentage, 2);

        // Format the result as a percentage string
        $result = $rounded.'%';

        return $result;
    }

    public function applyBuff($state, $get, $set, $old, $buffs)
    {
        // Get the last item from $state
        $lastItem = end($state);

        // Append the last item from $state to $backupState only if it's not already in the backupState
        if (! in_array($lastItem, $this->backupState)) {
            array_push($this->backupState, $lastItem);
        }

        // Get the current backup state key
        // $currentState = is_array($state) ? end($state) : $state;
        // $currentOld = is_array($old) ? end($old) : $old;
        $currentBackupOld = is_array($this->backupState) ? end($this->backupState) : $this->backupState;

        // Filter out empty values from $state and $this->backupState before performing array_diff
        $state = array_filter($state);
        $this->backupState = array_filter($this->backupState);

        // Perform array_diff after filtering out empty values
        $removedItem = array_diff($this->backupState, $state);
        $this->backupState = array_diff($this->backupState, $removedItem);

        // Get the count of removed items and current state items
        $countRemovedItem = empty($removedItem) ? 0 : count($removedItem);
        $countState = empty($state) ? 0 : count($state);

        // Adjusted logic to handle multiple items in $removedItem
        if ($countState > 1) {
            if ($countRemovedItem > 1) {
                array_pop($removedItem);
            }
            $removedItemKey = end($removedItem);
            $currentBackupOldKey = $currentBackupOld;
        } else {
            $removedItemKey = end($removedItem);
            $currentBackupOldKey = $currentBackupOld;
        }

        // Determine the case (multiplication or addition) based on removed item or current backup old key
        if (isset($buffs['multiplication'][$removedItemKey]) || isset($buffs['multiplication'][$currentBackupOldKey])) {
            $case = isset($buffs['multiplication'][$removedItemKey]) ? $buffs['multiplication'][$removedItemKey] : $buffs['multiplication'][$currentBackupOldKey];
        } else {
            $case = isset($buffs['addition'][$removedItemKey]) ? $buffs['addition'][$removedItemKey] : $buffs['addition'][$currentBackupOldKey];
        }

        // Define field types requiring float or percentage conversion
        $floatFields = [
            'attacks_per_second',
            'movement_speed',
            'health_points_regeneration',
            'concentration_regeneration',
            'mana_regeneration',
            'steam_regeneration',
        ];

        $percentageFields = [
            'critical_value',
            'block_value',
            'armor_value',
            'fire_value',
            'ice_value',
            'lightning_value',
            'andermagic_value',
            'poison_value',
        ];

        // Iterate over each field and its multiplier in the current case
        foreach ($case as $fieldSuffix => $multiplier) {
            foreach (['ranger_', 'dragonknight_', 'spellweaver_', 'steam_mechanicus_'] as $prefix) {
                // Generate the full field name
                $fullFieldName = $prefix.$fieldSuffix;
                $fullPercentageFieldValue = in_array($fieldSuffix, $percentageFields) ? "{$fullFieldName}_percentage" : '';

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
                $percentageValue = $this->calculatePercentage($updatedValue, $fieldSuffix);

                $set($fullFieldName, $formattedValue);
                $set($fullPercentageFieldValue, $percentageValue);
            }
        }
    }

    public function createClassFields($characterClassName)
    {
        $defaultBaseDamage = match ($characterClassName) {
            'dragonknight' => 16800,
            'spellweaver' => 50400,
            'ranger' => 29400,
            'steam_mechanicus' => 38640,
            default => 0,
        };

        $defaultHealthPoints = match ($characterClassName) {
            'dragonknight' => 450000,
            'spellweaver' => 150000,
            'ranger' => 345000,
            'steam_mechanicus' => 262500,
            default => 0,
        };

        $fields = [
            'Offensive Values' => [
                $this->createTextInput("{$characterClassName}_base_damage", 'Base Damage', $defaultBaseDamage),
                $this->createTextInput("{$characterClassName}_attacks_per_second", 'Attacks Per Second', 1.000),
                $this->createTextInput("{$characterClassName}_critical_value", 'Critical Value', 0, 1),
                $this->createTextInput("{$characterClassName}_movement_speed", 'Movement Speed', 5.000),
            ],
            'Defensive Values' => [
                $this->createTextInput("{$characterClassName}_health_points", 'Health Points', $defaultHealthPoints),
                $this->createTextInput("{$characterClassName}_health_points_regeneration", 'Health Points Regeneration', 0),
                $this->createTextInput("{$characterClassName}_block_value", 'Block Value', 0, 1),
                $this->createTextInput("{$characterClassName}_block_value_percentage", 'Percentage Value', 0.00, 1),
                $this->createTextInput("{$characterClassName}_armor_value", 'Armor Value', 0, 1),
                $this->createTextInput("{$characterClassName}_armor_value_percentage", 'Percentage Value', 0.00, 1),
                $this->createTextInput("{$characterClassName}_fire_value", 'Fire', 0, 1),
                $this->createTextInput("{$characterClassName}_fire_value_percentage", 'Percentage Value', 0.00, 1),
                $this->createTextInput("{$characterClassName}_ice_value", 'Ice', 0, 1),
                $this->createTextInput("{$characterClassName}_ice_value_percentage", 'Percentage Value', 0.00, 1),
                $this->createTextInput("{$characterClassName}_lightning_value", 'Lightning', 0, 1),
                $this->createTextInput("{$characterClassName}_lightning_value_percentage", 'Percentage Value', 0.00, 1),
                $this->createTextInput("{$characterClassName}_andermagic_value", 'Andermagic', 0, 1),
                $this->createTextInput("{$characterClassName}_andermagic_value_percentage", 'Percentage Value', 0.00, 1),
                $this->createTextInput("{$characterClassName}_poison_value", 'Poison', 0, 1),
                $this->createTextInput("{$characterClassName}_poison_value_percentage", 'Percentage Value', 0.00, 1),
            ],
            'Other Values' => [
                $this->createTextInput("{$characterClassName}_xp_gain", 'Xp Gain', 100),
                $this->createTextInput("{$characterClassName}_honor_gain", 'Honor Gain', 100),
                $this->createTextInput("{$characterClassName}_andermant_drop_stack_size", 'Andermant Drop Stack Size', 0),
                $this->createTextInput("{$characterClassName}_coin_drop_stack_size", 'Coin Drop Stack Size', 0),
                $this->createTextInput("{$characterClassName}_ancient_wisdom_drop_stack_size", 'Ancient Wisdom Drop Stack Size', 0),
                $this->createTextInput("{$characterClassName}_materi_fragment_drop_stack_size", 'Materi Fragment Drop Stack Size', 0),
            ],
        ];

        // Add additional fields based on $characterClassName
        switch ($characterClassName) {
            case 'ranger':
                array_splice($fields['Offensive Values'], 3, 0, [
                    $this->createTextInput("{$characterClassName}_critical_value_percentage", 'Percentage Value', 0.00, 1),
                    $this->createTextInput("{$characterClassName}_concentration_points", 'Concentration Points', 100),
                    $this->createTextInput("{$characterClassName}_concentration_regeneration", 'Concentration Regeneration', 0),
                ]);
                break;
            case 'dragonknight':
                array_splice($fields['Offensive Values'], 3, 0, [
                    $this->createTextInput("{$characterClassName}_critical_value_percentage", 'Percentage Value', 0.00, 1),
                    $this->createTextInput("{$characterClassName}_rage_points", 'Rage Points', 100),
                ]);
                break;
            case 'spellweaver':
                array_splice($fields['Offensive Values'], 3, 0, [
                    $this->createTextInput("{$characterClassName}_critical_value_percentage", 'Percentage Value', 0.00, 1),
                    $this->createTextInput("{$characterClassName}_mana_points", 'Mana Points', 100),
                    $this->createTextInput("{$characterClassName}_mana_regeneration", 'Mana Regeneration', 0),
                ]);
                break;
            case 'steam_mechanicus':
                array_splice($fields['Offensive Values'], 3, 0, [
                    $this->createTextInput("{$characterClassName}_critical_value_percentage", 'Percentage Value', 0.00, 1),
                    $this->createTextInput("{$characterClassName}_steam_points", 'Steam Points', 100),
                    $this->createTextInput("{$characterClassName}_steam_regeneration", 'Steam Regeneration', 0),
                ]);
                break;
            default:
                break;
        }

        return $fields;
    }

    private function createTextInput($name, $label, $defaultValue, $columnSpan = 2)
    {
        $decimalPlaces = ($label === 'Attacks Per Second' || $label === 'Movement Speed') ? 3 : 2;

        return Forms\Components\TextInput::make($name)
            ->label($label)
            ->live()
            ->columnSpan($columnSpan)
            ->default($defaultValue)
            ->formatStateUsing(fn ($state) => is_float($state) ? number_format((float) $state, $decimalPlaces, '.', '') : number_format((int) $state));
    }
}
