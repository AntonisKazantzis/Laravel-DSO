<?php

namespace App\Filament\Admin\Resources\GemResource\Pages;

use App\Filament\Admin\Resources\GemResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateGem extends CreateRecord
{
    protected static string $resource = GemResource::class;

    public function getHeading(): string|Htmlable
    {
        return __('Create Gem');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('create');
    }
}
