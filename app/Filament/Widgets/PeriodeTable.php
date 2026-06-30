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
use Illuminate\Database\Eloquent\Model;

class PeriodeTable extends BaseWidget
{
    protected static ?string $heading = 'Periode Akademik';

    public function table(Table $table): Table
    {
        return $table
            ->query(AcademicPeriod::query()->orderByDesc('year'))
            ->columns([
                TextColumn::make('year')->label('Tahun Akademik'),
                TextColumn::make('semester')->label('Semester'),
                IconColumn::make('is_active')->boolean()->label('Aktif'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->schema([
                        TextInput::make('year')->label('Tahun Akademik')->required(),
                        TextInput::make('semester')->label('Semester')->required(),
                        Toggle::make('is_active')->label('Jadikan Aktif'),
                    ])
                    ->using(function (array $data): Model {
                        if ($data['is_active'] ?? false) {
                            AcademicPeriod::query()->update(['is_active' => false]);
                        }
                        return AcademicPeriod::create($data);
                    }),
            ])
            ->recordActions([
                EditAction::make()
                    ->schema([
                        TextInput::make('year')->label('Tahun Akademik')->required(),
                        TextInput::make('semester')->label('Semester')->required(),
                        Toggle::make('is_active')->label('Jadikan Aktif'),
                    ])
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
}
