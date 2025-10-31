<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

class Settings extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static string $view = 'filament.pages.settings';
    protected static ?string $title = 'Settings';
    protected static ?string $navigationGroup = 'Other';

    public $name;
    public $email;
    public $password_awal;
    public $password;
    public $photo;
    public $namaToko;

    public function mount(): void
    {
        $user = Auth::user();

        $this->form->fill([
            'name'      => $user->name,
            'email'     => $user->email,
            'namaToko'  => $user->namaToko,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->label('Full Name')
                ->required(),

            TextInput::make('namaToko')
                ->label('Nama Toko')
                ->required(),

            TextInput::make('email')
                ->label('Email Address')
                ->email()
                ->required(),

            TextInput::make('password_awal')
                ->label('Password Awal')
                ->password()
                ->required()
                ->rule(function () {
                    return function (string $attribute, $value, \Closure $fail) {
                        // Validasi password awal terhadap password user login
                        if (! Hash::check($value, Auth::user()->password)) {
                            $fail('Password awal salah.');
                        }
                    };
                }),

            TextInput::make('password')
                ->label('Password Baru')
                ->password()
                ->nullable()
                ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                ->dehydrated(fn ($state) => filled($state)),
        ];
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        $user = Auth::user();

        // Cegah update jika password awal salah
        if (! Hash::check($data['password_awal'], $user->password)) {
            Notification::make()
                ->title('Password awal salah.')
                ->danger()
                ->send();

            return; // Hentikan proses
        }

        unset($data['password_awal']); // jangan simpan password_awal ke DB

        $user->update(array_filter($data));

        Notification::make()
            ->title('Profile updated successfully!')
            ->success()
            ->send();
    }
}
