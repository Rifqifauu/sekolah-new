<?php

namespace App\Filament\Resources\Attendances\Pages;

use App\Filament\Resources\Attendances\AttendanceResource;
use App\Models\Attendance;
use Filament\Resources\Pages\Page;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Illuminate\Support\HtmlString;
use Filament\Resources\Pages\Concerns\InteractsWithRecord; // 1. Wajib tambahkan ini

class ViewAttendance extends Page implements HasTable
{
    use InteractsWithTable;
    use InteractsWithRecord; // 2. Gunakan trait ini agar halaman mengenali ID dari URL

    protected static string $resource = AttendanceResource::class;
    protected string $view = 'filament.resources.attendances.pages.view-attendance';


    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    public function getSubheading(): string|HtmlString|null
    {
        if ($this->record) {
            $formattedDate = Carbon::parse($this->record->date)->translatedFormat('d F Y');
            $namaKelas = $this->record->student->classroom->name ?? 'Tidak diketahui';

            return new HtmlString("Kelas: <b>{$namaKelas}</b> &nbsp;|&nbsp; Tanggal: <b>{$formattedDate}</b>");
        }

        return 'Data tidak ditemukan.';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // 5. Filter query berdasarkan Tanggal dan Kelas dari $this->record
                Attendance::query()
                    ->whereDate('date', $this->record->date)
                    ->whereHas('student', function ($query) {
                        $query->where('classroom_id', $this->record->student->classroom_id);
                    })
            )
            ->columns([
                TextColumn::make('student.name')
                    ->label('Nama Siswa')
                    ->searchable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'present' => 'Hadir',
                        'sick' => 'Sakit',
                        'permission' => 'Izin',
                        'late' => 'Telat',
                        'absent' => 'Tanpa Keterangan',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'present' => 'success',
                        'sick' => 'warning',
                        'permission' => 'info',
                        'late' => 'gray',
                        'absent' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('note')
                    ->label('Catatan')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Kosongkan karena sudah otomatis terfilter berdasarkan record aktif
            ])
            ->actions([
                Action::make('changeStatus')
                    ->label('Ubah Status')
                    ->icon('heroicon-o-check-circle')
                    ->color('warning')
                    ->form([
                        Select::make('status')
                            ->label('Status Kehadiran')
                            ->options([
                                'present' => 'Hadir',
                                'sick' => 'Sakit',
                                'permission' => 'Izin',
                                'late' => 'Telat',
                                'absent' => 'Tanpa Keterangan',
                            ])
                            ->required()
                            ->default(fn ($record) => $record->status),

                        Textarea::make('note')
                            ->label('Catatan')
                            ->placeholder('Masukkan catatan jika ada...')
                            ->nullable()
                            ->default(fn ($record) => $record->note),
                    ])
                    ->action(function ($record, array $data): void {
                        $record->update([
                            'status' => $data['status'],
                            'note' => $data['note'] ?? null,
                        ]);

                        Notification::make()
                            ->title('Berhasil')
                            ->body('Status dan catatan kehadiran berhasil diperbarui.')
                            ->success()
                            ->send();
                    }),
            ]);
    }
}
