<?php
namespace App\Filament\Widgets;

use App\Models\Classroom;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\TextInput;

class ClassroomTable extends BaseWidget
{
    protected static ?string $heading = 'Daftar Kelas';

    public function table(Table $table): Table
    {
        return $table
            ->query(Classroom::query())
            ->columns([
                TextColumn::make('name')->label('Nama Kelas')->searchable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->schema([
                        TextInput::make('name')->label('Nama Kelas')->required(),
                    ]),
            ])
            ->recordActions([
                EditAction::make()
                    ->schema([
                        TextInput::make('name')->label('Nama Kelas')->required(),
                    ]),
                DeleteAction::make(),
            ]);
    }
}
