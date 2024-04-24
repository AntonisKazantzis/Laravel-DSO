<?php

namespace App\Providers;

use BladeUI\Icons\Factory;
use Illuminate\Support\ServiceProvider;

final class BladeTablerIconsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->callAfterResolving(Factory::class, function (Factory $factory) {
            $factory->add('tabler', [
                'path' => __DIR__.'/../../resources/svg/tabler',
                'prefix' => 'tabler',
            ]);
        });
    }
}
