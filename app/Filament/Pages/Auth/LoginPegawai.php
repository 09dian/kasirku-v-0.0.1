<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login;
use Filament\Forms\Components\TextInput;
use Illuminate\Validation\ValidationException;

class LoginPegawai extends Login
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        TextInput::make('login')
                            ->label('Nama atau Email Pegawai')
                            ->required()
                            ->autofocus(),

                        $this->getPasswordFormComponent(),
                        $this->getRememberFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    /**
     * LOGIN PAKAI NAMA ATAU EMAIL
     */
    protected function getCredentialsFromFormData(array $data): array
    {
        $field = filter_var($data['login'], FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'nama';

        return [
            $field => $data['login'],
            'password' => $data['password'],
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.password' => 'Nama / Email atau password pegawai salah',
        ]);
    }
}
