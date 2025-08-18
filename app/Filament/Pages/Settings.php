<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Settings extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static string $view = 'filament.pages.settings';
    protected static ?string $title = 'Settings';
    protected static ?string $navigationGroup = 'Account';

    public $name;
    public $email;
    public $password;
    public $photo;

    public function mount(): void
    {
        $user = Auth::user();

        $this->form->fill([
            'name'  => $user->name,
            'email' => $user->email,
            'photo' => $user->photo ?? null,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Full Name')
                ->required(),

            Forms\Components\TextInput::make('email')
                ->label('Email Address')
                ->email()
                ->required(),

            Forms\Components\FileUpload::make('photo')
                ->label('Profile Photo')
                ->image()
                ->disk('public')
                ->directory('avatars')
                ->nullable(),

            Forms\Components\TextInput::make('password')
                ->label('New Password')
                ->password()
                ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                ->dehydrated(fn ($state) => filled($state))
                ->nullable(),
        ];
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        $user = Auth::user();
        $user->update(array_filter($data));

        Notification::make()
            ->title('Profile updated successfully!')
            ->success()
            ->send();
    }
}
