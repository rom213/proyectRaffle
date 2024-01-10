<?php

namespace App\Filament\Resources\ProgressbarResource\Pages;

use App\Filament\Resources\ProgressbarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProgressbars extends ListRecords
{
    protected static string $resource = ProgressbarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
