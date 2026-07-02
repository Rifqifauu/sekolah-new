<?php

namespace App\Filament\Resources\Grades\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\GradeComponent;

class GradesTable
{
    public static function configure(Table $table): Table
    {
        $columns = [
            TextColumn::make('name')
                ->label('Nama Siswa')
                ->searchable()
                ->sortable(),
        ];

        $subjects = Subject::all();

        foreach ($subjects as $subject) {
                    $columns[] = TextColumn::make('subject_' . $subject->id)
                        ->label($subject->code)
                        ->getStateUsing(function (Model $record) use ($subject) {
                            $grades = Grade::query()
                                ->where('student_id', $record->id)
                                ->whereHas('gradeComponent', function ($query) use ($subject) {
                                    $query->where('subject_id', $subject->id);
                                })
                                ->with('gradeComponent')
                                ->get();

                            if ($grades->isEmpty()) {
                                return new HtmlString('<span class="text-gray-400 italic">-</span>');
                            }

                            $total = 0;
                            $details = [];

                            foreach ($grades as $grade) {
                                $total += $grade->score;
                                $name = $grade->gradeComponent->name;
                                $weight = $grade->gradeComponent->weight;

                                // Hitung kembali nilai dasar (nilai asli sebelum dikali persen)
                                // Menggunakan round untuk membuang desimal panjang jika ada
                                $rawScore = $weight > 0 ? round(($grade->score * 100) / $weight, 1) : 0;

                                // Format: Tugas: 85 x 30% = 25.5
                                $details[] = "{$name}: {$rawScore} x {$weight}% = {$grade->score}";
                            }

                            // Gabungkan dengan \n agar tooltip muncul rapi ke bawah (multi-line)
                            $tooltipText = htmlspecialchars(implode("\n", $details), ENT_QUOTES);

                            return new HtmlString('
                                <span
                                    x-data="{}"
                                    x-tooltip.raw="' . $tooltipText . '"
                                    class="cursor-help border-b-2 border-dotted border-gray-400 hover:text-primary-600 transition"
                                >
                                    <strong>' . $total . '</strong>
                                </span>
                            ');
                        });
                }
        return $table
            ->columns($columns)
            ->recordActions([
                Action::make('input_grades')
                    ->label('Input Nilai')
                    ->icon('heroicon-m-pencil-square')
                    ->button()
                    ->modalHeading(fn (Model $record) => 'Input Nilai: ' . $record->name)
                    ->modalWidth('md')
                    ->form([
                        Select::make('subject_id')
                            ->label('Mata Pelajaran')
                            ->options(Subject::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set, Model $record) {
                                if (!$state) return;

                                $existingGrades = Grade::where('student_id', $record->id)
                                    ->whereHas('gradeComponent', fn($q) => $q->where('subject_id', $state))
                                    ->with('gradeComponent')
                                    ->get();

                                foreach ($existingGrades as $grade) {
                                    $weight = $grade->gradeComponent->weight;
                                    $rawScore = $weight > 0 ? ($grade->score * 100 / $weight) : 0;
                                    $set("component_{$grade->grade_component_id}", $rawScore);
                                }
                            }),

                        Group::make()
                            ->schema(function (Get $get) {
                                $subjectId = $get('subject_id');

                                if (! $subjectId) {
                                    return [];
                                }

                                $components = GradeComponent::where('subject_id', $subjectId)->get();

                                return $components->map(function ($component) {
                                    return TextInput::make("component_{$component->id}")
                                        ->label("{$component->name} ({$component->weight}%)")
                                        ->numeric()
                                        ->minValue(1)
                                        ->maxValue(100)
                                        ->step('any');
                                })->toArray();
                            })
                    ])
                    ->action(function (array $data, Model $record) {
                        $activePeriod = \App\Models\AcademicPeriod::where('is_active', true)->first();

                        if (! $activePeriod) {
                            Notification::make()
                                ->title('Gagal menyimpan nilai')
                                ->body('Tidak ada Periode Akademik yang aktif saat ini.')
                                ->danger()
                                ->send();
                            return;
                        }

                        foreach ($data as $key => $rawScore) {
                            if (str_starts_with($key, 'component_') && $rawScore !== null) {
                                $componentId = str_replace('component_', '', $key);
                                $component = GradeComponent::find($componentId);

                                if ($component) {
                                    $finalScore = $rawScore * ($component->weight / 100);

                                    Grade::updateOrCreate(
                                        [
                                            'student_id' => $record->id,
                                            'grade_component_id' => $componentId,
                                            'academic_period_id' => $activePeriod->id,
                                        ],
                                        [
                                            'score' => $finalScore
                                        ]
                                    );
                                }
                            }
                        }

                        Notification::make()
                            ->title('Nilai berhasil disimpan!')
                            ->success()
                            ->send();
                    })
            ]);
    }
}
