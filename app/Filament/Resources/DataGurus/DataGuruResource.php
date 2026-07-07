<?php

namespace App\Filament\Resources\DataGurus;

use App\Filament\Resources\DataGurus\Pages\CreateDataGuru;
use App\Filament\Resources\DataGurus\Pages\EditDataGuru;
use App\Filament\Resources\DataGurus\Pages\ListDataGurus;
use App\Filament\Resources\DataGurus\Schemas\DataGuruForm;
use App\Filament\Resources\DataGurus\Tables\DataGurusTable;
use App\Models\People;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
class DataGuruResource extends Resource
{
    protected static ?string $model = People::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;
    protected static ?string $modelLabel = 'Data Guru dan Staff';
    protected static string | UnitEnum | null $navigationGroup = 'Civitas';
    public static function form(Schema $schema): Schema
    {
        return DataGuruForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DataGurusTable::configure($table);
    }

    public static function canAccess(): bool
        {
            return auth()->user()?->is_admin === true;
        }
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', ['teacher','staff']);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDataGurus::route('/'),

        ];
    }
}
