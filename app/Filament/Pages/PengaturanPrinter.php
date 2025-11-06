<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Pages\Page;
use Filament\Actions\Action;
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
    protected function getHeaderActions(): array
    {
        return [
            Action::make('cekPrinter')
                ->label('Cek Printer')
                ->icon('heroicon-o-printer')
                ->color('primary')
                ->requiresConfirmation()
                ->action(function () {
                    $this->cekPrinter();
                }),
        ];
    }
 public function cekPrinter(): void
    {
        // Ambil data printer dari file JSON
        if (!Storage::exists('printer.json')) {
            Notification::make()
                ->title('File pengaturan printer tidak ditemukan!')
                ->danger()
                ->send();
            return;
        }

        $data = json_decode(Storage::get('printer.json'), true);
        $printerName = $data['printer_name'] ?? '(tidak terdeteksi)';

        // Simulasi pengecekan koneksi printer
        $isConnected = !empty($printerName); // misalnya dicek apakah ada nama printer

        if ($isConnected) {
            Notification::make()
                ->title("Printer \"$printerName\" terdeteksi dan siap digunakan")
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Printer tidak terdeteksi')
                ->danger()
                ->send();
        }
    }

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

        // Baca file lama
        $oldData = [];
        if (Storage::exists('printer.json')) {
            $oldData = json_decode(Storage::get('printer.json'), true);
        }

        $oldLogo = $oldData['logo'] ?? null;
        $newLogo = $data['logo'] ?? null;

        // Hapus logo lama jika berbeda
        if (!empty($oldLogo) && $oldLogo !== $newLogo) {
            // pastikan path hanya 'logos/nama_file' tanpa '/storage/'
            $oldLogoPath = str_replace('storage/', '', $oldLogo);

            if (Storage::disk('public')->exists($oldLogoPath)) {
                Storage::disk('public')->delete($oldLogoPath);
            }
        }

        // Simpan konfigurasi printer
        Storage::put('printer.json', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        Notification::make()->title('Pengaturan printer berhasil disimpan!')->success()->send();
    }

    protected function getFormActions(): array
    {
        return [Forms\Components\Actions\Action::make('save')->label('Simpan')->button()->submit('save')];
    }

    protected static string $view = 'pengaturan-printer';
}
