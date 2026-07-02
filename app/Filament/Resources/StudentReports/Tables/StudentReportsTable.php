<?php

namespace App\Filament\Resources\StudentReports\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Select;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\AcademicPeriod;
use App\Models\People;
use App\Models\StudentReport;

class StudentReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('academic_period_formatted')
                    ->label('Periode Akademik')
                    ->getStateUsing(function (StudentReport $record) {
                        $period = $record->academicPeriod;
                        if (!$period) return '-';

                        $semesterLabel = match ($period->semester) {
                            'odd' => 'Ganjil',
                            'even' => 'Genap',
                            default => $period->semester,
                        };

                        return "{$period->year} - {$semesterLabel}";
                    }),

                TextColumn::make('student.name')
                    ->label('Nama Siswa')
                    ->searchable(),

                // --- KOLOM PERINGKAT BARU ---
                TextColumn::make('rank')
                    ->label('Peringkat')
                    ->getStateUsing(function (StudentReport $record) {
                        // Gunakan static variable agar perhitungan hanya dilakukan 1x per kelas (Mencegah N+1 Query Problem lambat)
                        static $ranks = [];

                        // Kelompokkan peringkat berdasarkan periode akademik dan guru (wali kelas)
                        $cacheKey = $record->academic_period_id . '_' . $record->teacher_id;

                        if (!isset($ranks[$cacheKey])) {
                            // Ambil semua rapor di kelas dan periode yang sama
                            $allReportsInClass = StudentReport::where('academic_period_id', $record->academic_period_id)
                                ->where('teacher_id', $record->teacher_id)
                                ->get()
                                ->sortByDesc(fn ($report) => $report->average_score) // Urutkan dari nilai tertinggi
                                ->values();

                            // Map ID rapor menjadi peringkat (index + 1)
                            $ranks[$cacheKey] = $allReportsInClass->pluck('id')->flip()->map(fn($index) => $index + 1)->toArray();
                        }

                        // Kembalikan peringkat siswa saat ini, tambahkan prefix "Ke-"
                        $rankNumber = $ranks[$cacheKey][$record->id] ?? '-';
                        return "Ke-{$rankNumber}";
                    })
                    ->badge()
                    ->color('primary')
                    ->sortable(), // Opsional: kamu bisa coba sortable meski datanya dinamis

                TextColumn::make('average_score')
                    ->label('Rata-rata Nilai')
                    ->numeric(decimalPlaces: 2)
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        $state >= 80 => 'success',
                        $state >= 60 => 'warning',
                        default => 'danger',
                    }),

                TextColumn::make('present')
                    ->label('Hadir')
                    ->getStateUsing(fn (StudentReport $record) => $record->attendance_summary['present'] ?? 0)
                    ->badge()
                    ->color('success'),

                TextColumn::make('sick')
                    ->label('Sakit')
                    ->getStateUsing(fn (StudentReport $record) => $record->attendance_summary['sick'] ?? 0)
                    ->badge()
                    ->color('warning'),

                TextColumn::make('permission')
                    ->label('Izin')
                    ->getStateUsing(fn (StudentReport $record) => $record->attendance_summary['permission'] ?? 0)
                    ->badge()
                    ->color('info'),

                TextColumn::make('late')
                    ->label('Terlambat')
                    ->getStateUsing(fn (StudentReport $record) => $record->attendance_summary['late'] ?? 0)
                    ->badge()
                    ->color('warning'),

                TextColumn::make('absent')
                    ->label('Alpa')
                    ->getStateUsing(fn (StudentReport $record) => $record->attendance_summary['absent'] ?? 0)
                    ->badge()
                    ->color('danger'),

                TextColumn::make('status')
                    ->badge(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('generate_reports')
                    ->label('Generate Rapor Kelas')
                    ->icon('heroicon-o-document-duplicate')
                    ->color('primary')
                    ->modalHeading('Generate Rapor Massal per Kelas')
                    ->modalDescription('Pilih periode dan kelas. Sistem akan otomatis menetapkan Wali Kelas dan membuat rapor untuk semua siswa di kelas tersebut.')
                    ->form([
                        Select::make('academic_period_id')
                            ->label('Periode Akademik')
                            ->options(
                                AcademicPeriod::all()->mapWithKeys(function ($period) {
                                    $semesterLabel = match ($period->semester) {
                                        'odd' => 'Ganjil',
                                        'even' => 'Genap',
                                        default => $period->semester,
                                    };
                                    return [$period->id => "{$period->year} - {$semesterLabel}"];
                                })
                            )
                            ->required(),

                        Select::make('classroom_id')
                            ->label('Pilih Kelas')
                            ->options(\App\Models\Classroom::pluck('name', 'id'))
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $teacher = People::where('role', 'teacher')
                            ->where('classroom_id', $data['classroom_id'])
                            ->first();

                        if (!$teacher) {
                            Notification::make()
                                ->title('Gagal Generate')
                                ->body('Tidak ditemukan Guru/Wali Kelas untuk kelas yang dipilih. Pastikan data guru sudah di-assign ke kelas tersebut.')
                                ->danger()
                                ->send();
                            return;
                        }

                        $students = People::where('role', 'student')
                            ->where('classroom_id', $data['classroom_id'])
                            ->get();

                        $count = 0;

                        foreach ($students as $student) {
                            $report = StudentReport::firstOrCreate([
                                'student_id'         => $student->id,
                                'academic_period_id' => $data['academic_period_id'],
                            ], [
                                'teacher_id' => $teacher->id,
                                'status'     => 'pending',
                                'notes'      => null,
                            ]);

                            if ($report->wasRecentlyCreated) {
                                $count++;
                            }
                        }

                        Notification::make()
                            ->title('Berhasil Generate')
                            ->body("Sebanyak {$count} rapor baru berhasil dibuat untuk kelas tersebut.")
                            ->success()
                            ->send();
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            // --- NONAKTIFKAN PAGINATION (TAMPIL SEMUA DATA) ---
            ->paginated(false);
    }
}
