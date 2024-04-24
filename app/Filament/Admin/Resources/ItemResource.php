<?php

namespace App\Filament\Admin\Resources;

use App\Enums\CharacterClassEnum;
use App\Enums\ItemRarityEnum;
use App\Enums\ItemTypeEnum;
use App\Filament\Admin\Resources\ItemResource\Pages;
use App\Filament\Resources\ItemResource as AppItemResource;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'tabler-sword';

    protected static ?string $navigationLabel = 'Items';

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

                    Forms\Components\TextInput::make('level')
                        ->required()
                        ->numeric(),

                    Forms\Components\Select::make('rarity')
                        ->options(ItemRarityEnum::class)
                        ->required(),

                    Forms\Components\Select::make('class')
                        ->options(CharacterClassEnum::class)
                        ->required(),

                    Forms\Components\Select::make('type')
                        ->options(ItemTypeEnum::class)
                        ->required(),

                    Forms\Components\RichEditor::make('description')
                        ->required(),

                    Forms\Components\KeyValue::make('base_values')
                        ->addable(false)
                        ->deletable(false)
                        ->editableKeys(false)
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
        return AppItemResource::table($table)
            ->recordAction('view')
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'view' => Pages\ViewItem::route('/{record}'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
