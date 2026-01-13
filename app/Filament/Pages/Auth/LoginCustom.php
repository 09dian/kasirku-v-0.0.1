<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Actions\Action;
use Illuminate\Validation\ValidationException;

class LoginCustom extends Login
{
    /* ================= GUARD ================= */

    protected function getAuthGuard(): string
    {
        // WAJIB: pastikan login ini hanya untuk admin
        return 'admin';
    }

    /* ================= REDIRECT ================= */

    protected function getRedirectUrl(): string
    {
        // Paksa selalu ke admin panel
        return '/admin';
    }

    /* ================= AUTH PROCESS ================= */

    public function authenticate(): ?LoginResponse
    {
        // Hapus intended URL agar tidak lompat ke /pegawai/login
        session()->forget('url.intended');

        return parent::authenticate();
    }

    /* ================= FORM ================= */

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getLoginFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getRememberFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getLoginFormComponent(): Component
    {
        return TextInput::make('login')
            ->label('Nama Pengguna atau Email')
            ->required()
            ->dehydrated() // PENTING agar masuk ke $data
            ->autofocus();
    }

    /* ================= CREDENTIAL ================= */

    protected function getCredentialsFromFormData(array $data): array
    {
        $login = $data['login'] ?? null;

        if (! $login) {
            $this->throwFailureValidationException();
        }

        $loginType = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'name';

        return [
            $loginType => $login,
            'password' => $data['password'],
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.password' => 'Username / Email atau password salah',
        ]);
    }

    /* ================= TOMBOL ================= */

    protected function getFormActions(): array
    {
        return [
            // Tombol Login
            $this->getAuthenticateFormAction(),

            // Tombol ke Pegawai
            Action::make('pegawai')
                ->label('Masuk Pegawai')
                ->icon('heroicon-o-user')
                ->color('info')
                ->url('/pegawai'),
        ];
    }
}
