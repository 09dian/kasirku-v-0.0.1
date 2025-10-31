<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;

class PengaturanPrinter extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-printer';
    protected static ?string $navigationLabel = 'Pengaturan Printer';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $title = 'Pengaturan Printer';
    protected static ?int $navigationSort = 10;

    public $printer_name;
    public $paper_size;
    public $port;
    public $logo;

    public function mount(): void
    {
        // Ambil data pengaturan dari file (opsional)
        if (Storage::disk('local')->exists('printer.json')) {
            $data = json_decode(Storage::get('printer.json'), true);
            $this->form->fill($data);
        }
    }

    protected function getFormSchema(): array
    {
        return [
            FileUpload::make('logo')
                ->label('Logo Toko / Printer Maximal: 1MB')
                ->image()
                ->directory('logos') // disimpan di storage/app/public/logos
                ->imagePreviewHeight('100')
                ->maxSize(1024)
                ->openable()
                ->downloadable()
                ->columnSpanFull(),

            Forms\Components\TextInput::make('printer_name')->label('Nama Printer')->placeholder('Contoh: EPSON TM-T82')->required(),

            Forms\Components\TextInput::make('port')->label('Port / Device')->placeholder('Contoh: COM3 atau USB001')->required(),

            Forms\Components\Select::make('paper_size')
                ->label('Ukuran Kertas')
                ->options([
                    '58mm' => '58 mm',
                    '80mm' => '80 mm',
                    'A4' => 'A4',
                ])
                ->default('80mm'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();
        // logo
        if (!empty($this->oldLogo) && $this->oldLogo !== ($data['logo'] ?? null)) {
            if (Storage::disk('local')->exists($this->oldLogo)) {
                Storage::disk('local')->delete($this->oldLogo);
            }
        }

        // Simpan pengaturan ke file lokal private
        Storage::put('printer.json', json_encode($data, JSON_PRETTY_PRINT));

        Notification::make()->title('Pengaturan printer berhasil disimpan!')->success()->send();
    }

    protected function getFormActions(): array
    {
        return [Forms\Components\Actions\Action::make('save')->label('Simpan')->button()->submit('save')];
    }

    protected static string $view = 'pengaturan-printer';
}
