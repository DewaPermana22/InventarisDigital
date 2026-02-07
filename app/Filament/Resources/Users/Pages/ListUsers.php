<?php

namespace App\Filament\Resources\Users\Pages;

use App\Enums\HakAkses;
use App\Filament\Resources\Users\UserResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    public function getHeading(): string|Htmlable
    {
        return 'Data Pengguna';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Data pengguna yang terdaftar dalam sistem';
    }
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambah Pengguna')->icon(Heroicon::Plus)
                ->color(Color::Indigo),
            Action::make('export-data-prngguna')
                ->label("Export Data Pengguna")
                ->color('success')
                ->icon(Heroicon::OutlinedPrinter)
                ->requiresConfirmation()
                ->modalHeading('Export Data Pengguna')
                ->modalIcon(Heroicon::Printer)
                ->modalDescription('Pilih role yang ingin diexport atau export semua data pengguna')
                ->form([
                    Select::make('role')
                        ->label('Filter Role')
                        ->options(
                            collect(['' => 'Semua Role'])
                                ->merge(
                                    collect(HakAkses::cases())
                                        ->mapWithKeys(fn($case) => [$case->value => $case->label()])
                                )
                        )
                        ->default('')
                        ->native(false)
                        ->placeholder('Pilih role (opsional)'),
                ])
                ->modalSubmitActionLabel('Ya, Export')
                ->action(function (array $data) {
                    $role = $data['role'] ?? '';

                    // Notifikasi langsung (popup)
                    Notification::make()
                        ->success()
                        ->title('Export Berhasil')
                        ->body('File data pengguna sedang diunduh.')
                        ->duration(3000)
                        ->send();

                    // Notifikasi ke database
                    $filterText = $role ? 'Role: ' . ucfirst($role) : 'Semua Role';
                    Notification::make()
                        ->success()
                        ->title('Data Pengguna berhasil di export')
                        ->body("Anda telah mengexport Data Pengguna ({$filterText}) pada " . now()->format('d-m-Y H:i'))
                        ->icon(Heroicon::OutlinedDocumentText)
                        ->actions([
                            Action::make('view')
                                ->button()
                                ->color(Color::Indigo)
                                ->label('Download Lagi')
                                ->url(route('export.users', ['role' => $role]))
                                ->openUrlInNewTab(),
                        ])
                        ->sendToDatabase(Auth::user());

                    return redirect()->route('export.users', ['role' => $role]);
                })
        ];
    }
}
