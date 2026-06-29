<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Pages\Page;
use Filament\Schemas\Schema; // Core Schema v5
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Grid;
use BackedEnum;

class WebsiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $title = 'Website Settings';

    protected string $view = 'filament.pages.website-settings';

    protected ?string $heading = 'Pengaturan Lengkap Website';

    public ?array $data = [];

    public function mount(): void
    {
        // Ambil semua data setting sekaligus
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        // Isi form dengan data yang sudah dikelompokkan berdasarkan key-nya masing-masing
        $this->form->fill($settings);
    }

    /**
     * Konfigurasi form murni menggunakan metode ->components() milik v5
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Settings')
                    ->tabs([

                        // TAB 1: HERO, IDENTITAS & BERANDA
                        Tabs\Tab::make('Hero & Beranda')
                            ->icon('heroicon-o-home')
                            ->schema([

                                // 💡 Tambahan Baru: Identitas Sekolah (Nama, Slogan, Logo)
                                Grid::make(3)->schema([
                                    TextInput::make('school_name')
                                        ->label('Nama Sekolah')
                                        ->required()
                                        ->placeholder('Contoh: SMP Negeri 1 Lorem Ipsum'),

                                    TextInput::make('school_slogan')
                                        ->label('Slogan Sekolah')
                                        ->placeholder('Contoh: Cerdas, Berkarakter, Berbudaya'),

                                    FileUpload::make('school_logo')
                                        ->label('Logo Sekolah')
                                        ->image()
                                        ->directory('site-identity')
                                        ->helperText('Format PNG transparan direkomendasikan.'),
                                ]),

                                // Pembatas Visual ke bagian Hero Content
                                Grid::make(1)->schema([
                                    TextInput::make('hero_title')
                                        ->label('Hero Title (Judul Utama)')
                                        ->required()
                                        ->placeholder('Contoh: Selamat Datang di SMA N 1 Coding'),

                                    Textarea::make('hero_description')
                                        ->label('Hero Description (Deskripsi Singkat)')
                                        ->rows(3),

                                    FileUpload::make('hero_images')
                                        ->label('Hero Images (Maksimal 3 Gambar)')
                                        ->image()
                                        ->multiple()
                                        ->maxFiles(3)
                                        ->directory('site-hero')
                                        ->helperText('Unggah hingga 3 gambar untuk slider beranda.'),
                                ]),
                            ]),

                        // TAB 2: PROFIL KEPALA SEKOLAH
                        Tabs\Tab::make('Sambutan Kepsek')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('kepsek_name')
                                        ->label('Nama Kepala Sekolah')
                                        ->placeholder('Contoh: Dr. John Doe, M.Kom'),

                                    FileUpload::make('kepsek_image')
                                        ->label('Foto Kepala Sekolah')
                                        ->image()
                                        ->directory('site-profil'),
                                ]),

                                RichEditor::make('kepsek_speech')
                                    ->label('Sambutan Kepala Sekolah')
                                    ->toolbarButtons([
                                        'blockquote', 'bold', 'bulletList', 'italic',
                                        'orderedList', 'redo', 'undo'
                                    ]),
                            ]),

                        // TAB 3: VISI, MISI & SEJARAH
                        Tabs\Tab::make('Visi, Misi & Sejarah')
                            ->icon('heroicon-o-academic-cap')
                            ->schema([
                                Grid::make(2)->schema([
                                    RichEditor::make('site_visi')
                                        ->label('Visi Sekolah'),
                                    RichEditor::make('site_misi')
                                        ->label('Misi Sekolah'),
                                ]),

                                Grid::make(2)->schema([
                                    RichEditor::make('history_content')
                                        ->label('Sejarah Sekolah')
                                        ->columnSpan(1),
                                    FileUpload::make('history_image')
                                        ->label('Foto/Gambar Sejarah')
                                        ->image()
                                        ->directory('site-sejarah')
                                        ->columnSpan(1),
                                ]),
                            ]),

                        // TAB 4: KONTAK & SOSIAL MEDIA
                        Tabs\Tab::make('Kontak & Sosmed')
                            ->icon('heroicon-o-chat-bubble-left-right')
                            ->schema([
                                Grid::make(2)->schema([
                                    Textarea::make('site_address')
                                        ->label('Alamat Lengkap')
                                        ->rows(3),

                                    Textarea::make('embed_map')
                                        ->label('Embed Google Map (Iframe)')
                                        ->placeholder('<iframe src="..."></iframe>')
                                        ->rows(3)
                                        ->helperText('Paste kode HTML iframe dari Google Maps di sini.'),
                                ]),

                                Grid::make(2)->schema([
                                    TextInput::make('site_phone')
                                        ->label('Nomor Telepon Sekolah')
                                        ->tel(),

                                    TextInput::make('whatsapp_number')
                                        ->label('Nomor WhatsApp (Gunakan format 62...)')
                                        ->tel(),
                                ]),

                                Grid::make(3)->schema([
                                    TextInput::make('social_instagram')
                                        ->label('Link Instagram')
                                        ->url()
                                        ->placeholder('https://instagram.com/username'),

                                    TextInput::make('social_facebook')
                                        ->label('Link Facebook')
                                        ->url()
                                        ->placeholder('https://facebook.com/page'),

                                    TextInput::make('social_tiktok')
                                        ->label('Link TikTok')
                                        ->url()
                                        ->placeholder('https://tiktok.com/@username'),
                                ]),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    /**
     * Proses Simpan Data
     */
    public function save(): void
    {
        $formData = $this->form->getState();

        foreach ($formData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? ""]
            );
        }

        Notification::make()
            ->title('Settings saved successfully!')
            ->success()
            ->send();
    }
}
