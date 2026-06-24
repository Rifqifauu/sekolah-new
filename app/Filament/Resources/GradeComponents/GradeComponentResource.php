<?php

namespace App\Filament\Resources\GradeComponents;

use App\Filament\Resources\GradeComponents\Pages\CreateGradeComponent;
use App\Filament\Resources\GradeComponents\Pages\EditGradeComponent;
use App\Filament\Resources\GradeComponents\Pages\ListGradeComponents;
use App\Filament\Resources\GradeComponents\Schemas\GradeComponentForm;
use App\Filament\Resources\GradeComponents\Tables\GradeComponentsTable;
use App\Models\GradeComponent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GradeComponentResource extends Resource
{
    protected static ?string $model = GradeComponent::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return GradeComponentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GradeComponentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGradeComponents::route('/'),
            'create' => CreateGradeComponent::route('/create'),
            'edit' => EditGradeComponent::route('/{record}/edit'),
        ];
    }
}
