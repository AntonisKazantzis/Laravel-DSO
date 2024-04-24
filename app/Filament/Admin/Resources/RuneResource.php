<?php

namespace App\Filament\Admin\Resources;

use App\Enums\RuneRarityEnum;
use App\Filament\Admin\Resources\RuneResource\Pages;
use App\Filament\Resources\RuneResource as AppRuneResource;
use App\Models\Rune;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RuneResource extends Resource
{
    protected static ?string $model = Rune::class;

    protected static ?string $navigationIcon = 'tabler-diamond';

    protected static ?string $navigationLabel = 'Runes';

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
                        ->options(RuneRarityEnum::class)
                        ->required(),

                    Forms\Components\TextInput::make('dust')
                        ->numeric()
                        ->required(),

                    Forms\Components\RichEditor::make('effect')
                        ->columnSpanFull()
                        ->required(),

                ])->columnSpanFull(),

            Forms\Components\Section::make('Buy Cost')
                ->columns(3)
                ->collapsible()
                ->schema([
                    Forms\Components\TextInput::make('andermant')
                        ->numeric(),

                    Forms\Components\TextInput::make('draken')
                        ->numeric(),

                    Forms\Components\TextInput::make('materi_fragment')
                        ->numeric(),

                    Forms\Components\TextInput::make('glided_clover')
                        ->numeric(),

                ])->columnSpanFull(),

            Forms\Components\Section::make('Workbench Cost')
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
        return AppRuneResource::table($table)
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRunes::route('/'),
            'create' => Pages\CreateRune::route('/create'),
            'view' => Pages\ViewRune::route('/{record}'),
            'edit' => Pages\EditRune::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
