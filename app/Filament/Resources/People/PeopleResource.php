<?php

namespace App\Filament\Resources\People;

use App\Filament\Resources\People\Pages\CreatePeople;
use App\Filament\Resources\People\Pages\EditPeople;
use App\Filament\Resources\People\Pages\ListPeople;
use App\Filament\Resources\People\Schemas\PeopleForm;
use App\Filament\Resources\People\Tables\PeopleTable;
use App\Models\People;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PeopleResource extends Resource
{
    protected static ?string $model = People::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;
    protected static ?string $modelLabel = 'Data Guru & Siswa';
    protected static string | UnitEnum | null $navigationGroup = 'Pusat Informasi';



    public static function form(Schema $schema): Schema
    {
        return PeopleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PeopleTable::configure($table);
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
            'index' => ListPeople::route('/'),

        ];
    }
}
