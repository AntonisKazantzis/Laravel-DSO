<?php

namespace App\Providers;

use Filament\Forms;
use Filament\Tables;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Forms\Components\Select::configureUsing(function ($component): void {
            if (method_exists($component, 'native')) {
                $component->native(false);
            }
        });

        Tables\Filters\SelectFilter::configureUsing(function ($filter): void {
            if (method_exists($filter, 'native')) {
                $filter->native(false);
            }
        });

        Forms\Components\Component::configureUsing(function ($component): void {
            if (method_exists($component, 'native')) {
                $component->native(false);
            }
        });

        Tables\Actions\ViewAction::configureUsing(function (Tables\Actions\ViewAction $action): void {
            $action
                ->button()
                ->hiddenLabel()
                ->tooltip('View');
        });

        Tables\Actions\EditAction::configureUsing(function (Tables\Actions\EditAction $action): void {
            $action
                ->button()
                ->hiddenLabel()
                ->tooltip('Edit');
        });

        Tables\Actions\DeleteAction::configureUsing(function (Tables\Actions\DeleteAction $action): void {
            $action
                ->button()
                ->hiddenLabel()
                ->tooltip('Delete');
        });

        Tables\Actions\ReplicateAction::configureUsing(function (Tables\Actions\ReplicateAction $action): void {
            $action
                ->button()
                ->hiddenLabel()
                ->tooltip('Replicate');
        });
    }
}
