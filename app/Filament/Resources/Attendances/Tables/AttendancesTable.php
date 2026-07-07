<?php

namespace App\Filament\Resources\Attendances\Tables;

use App\Models\Classroom;
use App\Models\People;
use App\Models\Attendance;
use App\Models\AcademicPeriod;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Table;
use Livewire\Component;
use Carbon\Carbon;

class AttendancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->whereIn('attendances.id', function ($subQuery) {
                    $subQuery->selectRaw('MIN(attendances.id)')
                             ->from('attendances')
                             ->join('people', 'people.id', '=', 'attendances.student_id')
                             ->groupBy('attendances.date', 'people.classroom_id');
                });
            })
            // 1. TAMBAHKAN DEFAULT SORT DI SINI
            ->defaultSort('date', 'desc')
            ->columns([
                TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d F Y')
                    ->sortable(),

                TextColumn::make('student.classroom.name')
                    ->label('Kelas')
                    ->badge()
                    ->color('info'),

                // --- TAMBAHAN KOLOM REKAP ---

                TextColumn::make('present_count')
                    ->label('Hadir')
                    ->badge()
                    ->color('success')
                    ->getStateUsing(fn ($record) => Attendance::whereDate('date', $record->date)
                        ->whereHas('student', fn($q) => $q->where('classroom_id', $record->student->classroom_id))
                        ->where('status', 'present')
                        ->count()
                    ),

                TextColumn::make('sick_count')
                    ->label('Sakit')
                    ->badge()
                    ->color('warning')
                    ->getStateUsing(fn ($record) => Attendance::whereDate('date', $record->date)
                        ->whereHas('student', fn($q) => $q->where('classroom_id', $record->student->classroom_id))
                        ->where('status', 'sick')
                        ->count()
                    ),

                TextColumn::make('permission_count')
                    ->label('Izin')
                    ->badge()
                    ->color('info')
                    ->getStateUsing(fn ($record) => Attendance::whereDate('date', $record->date)
                        ->whereHas('student', fn($q) => $q->where('classroom_id', $record->student->classroom_id))
                        ->where('status', 'permission')
                        ->count()
                    ),

                TextColumn::make('late_count')
                    ->label('Telat')
                    ->badge()
                    ->color('gray')
                    ->getStateUsing(fn ($record) => Attendance::whereDate('date', $record->date)
                        ->whereHas('student', fn($q) => $q->where('classroom_id', $record->student->classroom_id))
                        ->where('status', 'late')
                        ->count()
                    ),

                TextColumn::make('absent_count')
                    ->label('Alpa')
                    ->badge()
                    ->color('danger')
                    ->getStateUsing(fn ($record) => Attendance::whereDate('date', $record->date)
                        ->whereHas('student', fn($q) => $q->where('classroom_id', $record->student->classroom_id))
                        ->where('status', 'absent')
                        ->count()
                    ),
            ])
            ->filters([
                // 2. TAMBAHKAN FILTER BULAN DAN TAHUN DI SINI
                Filter::make('bulan_tahun')
                    ->form([
                        Select::make('bulan')
                            ->label('Bulan')
                            ->options([
                                '01' => 'Januari',
                                '02' => 'Februari',
                                '03' => 'Maret',
                                '04' => 'April',
                                '05' => 'Mei',
                                '06' => 'Juni',
                                '07' => 'Juli',
                                '08' => 'Agustus',
                                '09' => 'September',
                                '10' => 'Oktober',
                                '11' => 'November',
                                '12' => 'Desember',
                            ]),
                        Select::make('tahun')
                            ->label('Tahun')
                            ->options(function () {
                                $currentYear = date('Y');
                                $years = range($currentYear - 3, $currentYear + 1);
                                return array_combine($years, $years);
                            })
                            ->default(date('Y')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['bulan'],
                                fn (Builder $query, $month): Builder => $query->whereMonth('attendances.date', $month)
                                                                              ->whereYear('attendances.date', $data['tahun'])
                            );
                    })
            ])
            ->headerActions([
                            \Filament\Actions\Action::make('generateAttendances')
                                ->label('Generate Kehadiran')
                                ->icon('heroicon-o-sparkles')
                                ->color('primary')
                                ->form([
                                    DatePicker::make('date')
                                        ->label('Tanggal')
                                        ->default(now())
                                        ->required(),

                                        Hidden::make('classroom_id')
                                            ->default(function (Component $livewire) {
                                                $activeTab = $livewire->activeTab;
                                                return \App\Models\Classroom::where('name', $activeTab)->value('id');
                                            })
                                            ->required(),
                                ])
                    ->action(function (array $data): void {
                        $classroomId = $data['classroom_id'];
                        $activePeriod = AcademicPeriod::where('is_active', true)->first();

                        if (! $activePeriod) {
                            Notification::make()
                                ->title('Gagal')
                                ->body('Tidak ada Periode Akademik yang berstatus aktif di database.')
                                ->danger()
                                ->send();
                            return;
                        }

                        $teacher = People::where('classroom_id', $classroomId)
                            ->where('role', 'teacher')
                            ->first();

                        if (! $teacher) {
                            Notification::make()
                                ->title('Gagal')
                                ->body('Tidak ada Guru yang terdaftar di kelas ini.')
                                ->danger()
                                ->send();
                            return;
                        }

                        $students = People::where('classroom_id', $classroomId)
                            ->where('role', 'student')
                            ->get();

                        if ($students->isEmpty()) {
                            Notification::make()
                                ->title('Perhatian')
                                ->body('Tidak ada data siswa di kelas ini.')
                                ->warning()
                                ->send();
                            return;
                        }

                        foreach ($students as $student) {
                            Attendance::firstOrCreate(
                                [
                                    'student_id' => $student->id,
                                    'date' => $data['date'],
                                    'academic_period_id' => $activePeriod->id,
                                ],
                                [
                                    'teacher_id' => $teacher->id,
                                    'status' => 'present',
                                    'note' => null,
                                ]
                            );
                        }

                        Notification::make()
                            ->title('Berhasil')
                            ->body('Data kehadiran berhasil di-generate.')
                            ->success()
                            ->send();
                    }),
            ])
            ->actions([
                ViewAction::make()
                    ->label('Lihat Detail')
                    ->color('primary'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
