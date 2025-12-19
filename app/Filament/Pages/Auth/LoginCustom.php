<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Actions\Action;
use Illuminate\Validation\ValidationException;

class LoginCustom extends Login
{
    /* ================= FORM ================= */

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([$this->getLoginFormComponent(), $this->getPasswordFormComponent(), $this->getRememberFormComponent()])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getLoginFormComponent(): Component
    {
        return TextInput::make('login')->label('Nama Pengguna atau Email')->required()->autofocus();
    }

    /* ================= LOGIN ================= */

    protected function getCredentialsFromFormData(array $data): array
    {
        $loginType = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        return [
            $loginType => $data['login'],
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
            // TOMBOL SIGN IN (WAJIB)
            $this->getAuthenticateFormAction(),

            // TOMBOL MASUK SEBAGAI PEGAWAI
            Action::make('pegawai')->label('Masuk Pegawai')
            ->icon('heroicon-o-user')->color('info')->url('/pegawai'),
        ];
    }
}
