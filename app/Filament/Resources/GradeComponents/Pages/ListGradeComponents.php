<?php

namespace App\Filament\Resources\GradeComponents\Pages;

use App\Filament\Resources\GradeComponents\GradeComponentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGradeComponents extends ListRecords
{
    protected static string $resource = GradeComponentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
