<?php
namespace App\Filament\Pages;

use App\Filament\Widgets\PeriodeTable;
use App\Filament\Widgets\ClassroomTable;
use App\Filament\Widgets\SubjectTable;
use App\Filament\Widgets\GradeComponentTable;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Livewire;
use BackedEnum;

class PengaturanAkademik extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $title = 'Pengaturan Akademik';
    protected string $view = 'filament.pages.pengaturan-akademik';

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Pengaturan')
                ->tabs([
                    Tab::make('Periode')
                        ->icon('heroicon-o-calendar-days')
                        ->schema([
                            Livewire::make(PeriodeTable::class),
                        ]),
                    Tab::make('Kelas')
                        ->icon('heroicon-o-building-office-2')
                        ->schema([
                            Livewire::make(ClassroomTable::class),
                        ]),
                    Tab::make('Mapel')
                        ->icon('heroicon-o-book-open')
                        ->schema([
                            Livewire::make(SubjectTable::class),
                        ]),
                    Tab::make('Komponen Penilaian')
                    ->schema([
                    Livewire::make(GradeComponentTable::class),
                    ])
                ])
                ->persistTabInQueryString(),
        ]);
    }
}
