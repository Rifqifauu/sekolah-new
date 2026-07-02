<?php

namespace App\Filament\Widgets;

use App\Models\AcademicPeriod;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;

class PeriodeTable extends BaseWidget
{
    protected static ?string $heading = 'Periode Akademik';

    public function table(Table $table): Table
    {
        return $table
            ->query(AcademicPeriod::query()->orderByDesc('year'))
            ->columns([
                TextColumn::make('year')
                    ->label('Tahun Akademik')
                    ->searchable(),

                // Mengubah tampilan 'odd'/'even' menjadi 'Ganjil'/'Genap' di tabel
                TextColumn::make('semester')
                    ->label('Semester')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'odd' => 'Ganjil',
                        'even' => 'Genap',
                        default => $state,
                    }),

                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Aktif'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->schema($this->getFormSchema())
                    ->using(function (array $data): Model {
                        if ($data['is_active'] ?? false) {
                            AcademicPeriod::query()->update(['is_active' => false]);
                        }
                        return AcademicPeriod::create($data);
                    }),
            ])
            ->recordActions([
                EditAction::make()
                    ->schema($this->getFormSchema())
                    ->using(function (AcademicPeriod $record, array $data): Model {
                        if (($data['is_active'] ?? false) && ! $record->is_active) {
                            AcademicPeriod::query()
                                ->where('id', '!=', $record->id)
                                ->update(['is_active' => false]);
                        }
                        $record->update($data);
                        return $record;
                    }),
                DeleteAction::make(),
            ]);
    }

    /**
     * Skema form dengan label Indonesia tetapi value Database English (odd/even)
     */
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('year')
                ->label('Tahun Akademik (Contoh: 2023/2024)')
                ->required(),

            // 'key' adalah yang disimpan ke DB, 'value' adalah yang dilihat user
            Select::make('semester')
                ->label('Semester')
                ->options([
                    'odd' => 'Ganjil',
                    'even' => 'Genap',
                ])
                ->required(),

            Toggle::make('is_active')
                ->label('Jadikan Aktif'),
        ];
    }
}
