<?php

namespace App\Filament\Admin\Resources\JewelResource\Pages;

use App\Filament\Admin\Resources\JewelResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateJewel extends CreateRecord
{
    protected static string $resource = JewelResource::class;

    public function getHeading(): string|Htmlable
    {
        return __('Create Jewel');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('create');
    }
}
