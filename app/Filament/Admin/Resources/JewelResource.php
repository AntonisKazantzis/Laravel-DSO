<?php

namespace App\Filament\Admin\Resources;

use App\Enums\JewelRarityEnum;
use App\Filament\Admin\Resources\JewelResource\Pages;
use App\Filament\Resources\JewelResource as AppJewelResource;
use App\Models\Jewel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JewelResource extends Resource
{
    protected static ?string $model = Jewel::class;

    protected static ?string $navigationIcon = 'tabler-diamond';

    protected static ?string $navigationLabel = 'Jewels';

    protected static ?string $navigationGroup = 'Inventory';

    public static function form(Form $form): Form
    {
        return $form->schema(static::getFormSchema());
    }

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Details')
                ->columns(2)
                ->collapsible()
                ->schema([
                    Forms\Components\FileUpload::make('image_path')
                        ->label('')
                        ->image()
                        ->preserveFilenames()
                        ->imageEditor(),

                    Forms\Components\TextInput::make('name')
                        ->required(),

                    Forms\Components\Select::make('rarity')
                        ->options(JewelRarityEnum::class)
                        ->required(),

                    Forms\Components\TextInput::make('dust')
                        ->numeric()
                        ->required(),

                    Forms\Components\RichEditor::make('effect')
                        ->columnSpanFull()
                        ->required(),

                ])->columnSpanFull(),

            Forms\Components\Section::make('Costs')
                ->columns(3)
                ->collapsible()
                ->schema([
                    Forms\Components\KeyValue::make('selling_cost')
                        ->addable(false)
                        ->deletable(false)
                        ->editableKeys(false)
                        ->nullable(),

                    Forms\Components\KeyValue::make('upgrading_cost')
                        ->addable(false)
                        ->deletable(false)
                        ->editableKeys(false)
                        ->nullable(),

                    Forms\Components\KeyValue::make('melting_cost')
                        ->addable(false)
                        ->deletable(false)
                        ->editableKeys(false)
                        ->nullable(),

                ])->columnSpanFull(),
        ];
    }

    public static function table(Table $table): Table
    {
        return AppJewelResource::table($table)
            ->recordAction('edit')
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
            'index' => Pages\ListJewels::route('/'),
            'create' => Pages\CreateJewel::route('/create'),
            'view' => Pages\ViewJewel::route('/{record}'),
            'edit' => Pages\EditJewel::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
