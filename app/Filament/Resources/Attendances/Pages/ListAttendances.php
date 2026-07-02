<?php

namespace App\Filament\Resources\Attendances\Pages;

use App\Filament\Resources\Attendances\AttendanceResource; // Pastikan namespace ini benar sesuai struktur folder Anda
use App\Models\Classroom;
use Filament\Actions\CreateAction;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListAttendances extends ListRecords
{
    protected static string $resource = AttendanceResource::class;

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
