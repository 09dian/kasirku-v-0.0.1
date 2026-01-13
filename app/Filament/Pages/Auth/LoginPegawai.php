<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login;
use Filament\Forms\Components\TextInput;
use Filament\Actions\Action;
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
     * TAMBAH TOMBOL DI SAMPING LOGIN
     */
    protected function getFormActions(): array
    {
        return [
            $this->getAuthenticateFormAction(),

            Action::make('admin')
                ->label('Admin')
                ->color('gray')
                ->url('/admin/login') // ganti jika route admin berbeda
               ,
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
