<?php

namespace App\Filament\Resources\StudentReports\Pages;

use App\Filament\Resources\StudentReports\StudentReportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Models\Classroom;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
class ListStudentReports extends ListRecords
{
    protected static string $resource = StudentReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
    public function getTabs(): array
    {

        $classrooms = Classroom::all();

        foreach ($classrooms as $classroom) {
            $tabs[$classroom->name] = Tab::make($classroom->name)
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('student.classroom', function ($query) use ($classroom) {
                    $query->where('id', $classroom->id);
                }));
        }

        return $tabs;
    }
}
