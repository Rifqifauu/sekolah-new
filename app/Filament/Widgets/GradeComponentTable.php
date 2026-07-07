<?php

namespace App\Filament\Widgets;

use App\Models\GradeComponent;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter; // Tambahkan import ini di atas
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Model;

class GradeComponentTable extends BaseWidget
{
    // Mengubah judul widget
    protected static ?string $heading = 'Daftar Komponen Nilai';

    public function table(Table $table): Table
    {
        return $table
            ->query(GradeComponent::query())
            ->columns([
                TextColumn::make('subject.name')
                    ->label('Mata Pelajaran')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Nama Komponen')
                    ->searchable(),

                TextColumn::make('weight')
                    ->label('Bobot (%)')
                    ->suffix('%')
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->schema($this->getFormSchema()),
            ])
            ->recordActions([
                EditAction::make()
                    ->schema($this->getFormSchema()),
                DeleteAction::make(),
            ])
            ->filters([
            SelectFilter::make('subject_id')
                            ->label('Pilih Mata Pelajaran')
                            ->relationship('subject', 'name')
                            ->searchable()
                            ->preload(),
            ]);
    }


    protected function getFormSchema(): array
    {
        return [
            Select::make('subject_id')
                ->label('Mata Pelajaran')
                ->relationship('subject', 'name') // Mengambil data dari relasi subject
                ->required()
                ->searchable()
                ->preload(),

            TextInput::make('name')
                ->label('Nama Komponen (Contoh: UTS, UAS, Harian)')
                ->required()
                ->maxLength(255),

                TextInput::make('weight')
                    ->label('Bobot Nilai')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(100)
                    ->suffix('%')
                    ->rules([
                        // Hapus tulisan 'Get' di depan '$get' pada baris di bawah ini:
                        fn ($get, ?Model $record) => function (string $attribute, $value, \Closure $fail) use ($get, $record) {
                            $subjectId = $get('subject_id');

                            if (!$subjectId) return;

                            $existingQuery = GradeComponent::where('subject_id', $subjectId);

                            if ($record) {
                                $existingQuery->where('id', '!=', $record->id);
                            }

                            $currentTotalWeight = $existingQuery->sum('weight');
                            $newTotalWeight = $currentTotalWeight + (int) $value;

                            if ($newTotalWeight > 100) {
                                $sisaBobot = 100 - $currentTotalWeight;
                                $fail("Total bobot tidak boleh lebih dari 100%. Sisa bobot untuk mata pelajaran ini hanya {$sisaBobot}%.");
                            }
                        },
                    ]),
        ];
    }
}
