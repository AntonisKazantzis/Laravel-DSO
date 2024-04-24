<?php

namespace App\Filament\Admin\Resources;

use App\Enums\GemRarityEnum;
use App\Enums\GemTypeEnum;
use App\Filament\Admin\Resources\GemResource\Pages;
use App\Filament\Resources\GemResource as AppGemResource;
use App\Models\Gem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GemResource extends Resource
{
    protected static ?string $model = Gem::class;

    protected static ?string $navigationIcon = 'tabler-diamond';

    protected static ?string $navigationLabel = 'Gems';

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

                    Forms\Components\TextInput::make('value')
                        ->numeric()
                        ->required(),

                    Forms\Components\RichEditor::make('effect')
                        ->required(),

                    Forms\Components\Select::make('type')
                        ->options(GemTypeEnum::class)
                        ->required(),

                    Forms\Components\Select::make('rarity')
                        ->options(GemRarityEnum::class)
                        ->required(),

                    Forms\Components\TextInput::make('dust')
                        ->numeric()
                        ->required(),

                    Forms\Components\TextInput::make('andermant')
                        ->numeric()
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
        return AppGemResource::table($table)
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
            'index' => Pages\ListGems::route('/'),
            'create' => Pages\CreateGem::route('/create'),
            'view' => Pages\ViewGem::route('/{record}'),
            'edit' => Pages\EditGem::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
