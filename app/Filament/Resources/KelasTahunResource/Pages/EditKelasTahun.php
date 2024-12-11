<?php

namespace App\Filament\Resources\KelasTahunResource\Pages;

use App\Filament\Resources\KelasTahunResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKelasTahun extends EditRecord
{
    protected static string $resource = KelasTahunResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
