<?php

namespace App\Filament\Pages;
use App\Models\Post;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Pages\Page;

class History extends Page
{
    protected static ?string $navigationGroup = 'Other';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $title = 'History Transaksi';
    protected static string $view = 'filament.pages.history';



    public function table(Table $table): Table
{
    return $table
        ->columns([
            // ...
        ])
        ->actions([
            Action::make('feature')
                ->action(function (Post $record) {
                    $record->is_featured = true;
                    $record->save();
                })
                ->hidden(fn (Post $record): bool => $record->is_featured),
            Action::make('unfeature')
                ->action(function (Post $record) {
                    $record->is_featured = false;
                    $record->save();
                })
                ->visible(fn (Post $record): bool => $record->is_featured),
        ])
        ->bulkActions([
            BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
        ]);
}
}
