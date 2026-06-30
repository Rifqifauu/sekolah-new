<?php
namespace App\Filament\Widgets;

use App\Models\Subject;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class SubjectTable extends BaseWidget
{
    protected static ?string $heading = 'Daftar Mata Pelajaran';

    public function table(Table $table): Table
    {
        return $table
            ->query(Subject::query())
            ->columns([
                TextColumn::make('code')->label('Kode')->searchable(),
                TextColumn::make('name')->label('Nama Mapel')->searchable(),
                TextColumn::make('description')->label('Deskripsi')->limit(40),
            ])
            ->headerActions([
                CreateAction::make()
                    ->schema([
                        TextInput::make('code')->label('Kode')->required(),
                        TextInput::make('name')->label('Nama Mapel')->required(),
                        Textarea::make('description')->label('Deskripsi'),
                    ]),
            ])
            ->recordActions([
                EditAction::make()
                    ->schema([
                        TextInput::make('code')->label('Kode')->required(),
                        TextInput::make('name')->label('Nama Mapel')->required(),
                        Textarea::make('description')->label('Deskripsi'),
                    ]),
                DeleteAction::make(),
            ]);
    }
}
