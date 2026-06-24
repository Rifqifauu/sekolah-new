<?php

namespace App\Filament\Resources\GradeComponents\Pages;

use App\Filament\Resources\GradeComponents\GradeComponentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGradeComponent extends EditRecord
{
    protected static string $resource = GradeComponentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
