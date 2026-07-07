<?php

namespace App\Filament\Resources\DataSiswas;

use App\Filament\Resources\DataSiswas\Pages\CreateDataSiswa;
use App\Filament\Resources\DataSiswas\Pages\EditDataSiswa;
use App\Filament\Resources\DataSiswas\Pages\ListDataSiswas;
use App\Filament\Resources\DataSiswas\Schemas\DataSiswaForm;
use App\Filament\Resources\DataSiswas\Tables\DataSiswasTable;
use App\Models\People;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Table;

class DataSiswaResource extends Resource
{
    protected static ?string $model = People::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;
    protected static ?string $modelLabel = 'Data Siswa';
    protected static string | UnitEnum | null $navigationGroup = 'Civitas';
    public static function form(Schema $schema): Schema
    {
        return DataSiswaForm::configure($schema);
    }
    public static function canAccess(): bool
        {
            return auth()->user()?->is_admin === true;
        }

    public static function table(Table $table): Table
    {
        return DataSiswasTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', 'student');
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
            'index' => ListDataSiswas::route('/'),

        ];
    }
}
