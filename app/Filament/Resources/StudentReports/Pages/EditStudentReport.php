<?php

namespace App\Filament\Resources\StudentReports\Pages;

use App\Filament\Resources\StudentReports\StudentReportResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStudentReport extends EditRecord
{
    protected static string $resource = StudentReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
