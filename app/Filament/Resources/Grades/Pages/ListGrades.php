<?php

namespace App\Filament\Resources\Grades\Pages;

use App\Filament\Resources\Grades\GradeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use App\Models\Classroom;

class ListGrades extends ListRecords
{
    protected static string $resource = GradeResource::class;

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
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('classroom', function ($query) use ($classroom) {
                    $query->where('id', $classroom->id);
                }));
        }

        return $tabs;
    }
}
