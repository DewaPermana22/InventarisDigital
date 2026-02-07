<?php

namespace App\Filament\Resources\VerifikasiDendas;

use App\Enums\HakAkses;
use App\Enums\StatusPeminjaman;
use App\Filament\Resources\VerifikasiDendas\Pages\CreateVerifikasiDenda;
use App\Filament\Resources\VerifikasiDendas\Pages\EditVerifikasiDenda;
use App\Filament\Resources\VerifikasiDendas\Pages\ListVerifikasiDendas;
use App\Filament\Resources\VerifikasiDendas\Schemas\VerifikasiDendaForm;
use App\Filament\Resources\VerifikasiDendas\Tables\VerifikasiDendasTable;
use App\Models\PeminjamanBarang;
use App\Models\VerifikasiDenda;
use BackedEnum;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class VerifikasiDendaResource extends Resource
{
    protected static ?string $model = PeminjamanBarang::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::BadgeCheck;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return VerifikasiDendaForm::configure($schema);
    }

    protected static ?string $slug = "fine-verifications";
    protected static ?int $navigationSort = 2;
    protected static string|UnitEnum|null $navigationGroup = "Aktivitas Peminjaman";
    protected static ?string $navigationLabel = "Verifikasi Denda";

    public static function table(Table $table): Table
    {
        return VerifikasiDendasTable::configure($table);
    }

    public static function canViewAny(): bool
    {
        return Auth::user()?->role == HakAkses::ADMIN;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->role == HakAkses::ADMIN;
    }

    protected static ?string $label = "Verifikasi Denda";

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVerifikasiDendas::route('/'),
        ];
    }

     public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereIn('status', StatusPeminjaman::verifikasi())
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
