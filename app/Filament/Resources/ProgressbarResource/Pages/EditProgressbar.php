<?php

namespace App\Filament\Resources\ProgressbarResource\Pages;

use App\Filament\Resources\ProgressbarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProgressbar extends EditRecord
{
    protected static string $resource = ProgressbarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
