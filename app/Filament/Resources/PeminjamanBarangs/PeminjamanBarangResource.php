<?php

namespace App\Filament\Resources\PeminjamanBarangs;

use App\Enums\HakAkses;
use App\Enums\StatusPeminjaman;
use App\Filament\Resources\PeminjamanBarangs\Pages\CreatePeminjamanBarang;
use App\Filament\Resources\PeminjamanBarangs\Pages\ListPeminjamanBarangs;
use App\Filament\Resources\PeminjamanBarangs\Pages\ViewPeminjamanBarang;
use App\Filament\Resources\PeminjamanBarangs\Schemas\PeminjamanBarangForm;
use App\Filament\Resources\PeminjamanBarangs\Tables\PeminjamanBarangsTable;
use App\Models\PeminjamanBarang;
use BackedEnum;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class PeminjamanBarangResource extends Resource
{
    protected static ?string $model = PeminjamanBarang::class;
    protected static string|UnitEnum|null $navigationGroup = "Aktivitas";
    protected static string|BackedEnum|null $navigationIcon = LucideIcon::PackagePlus;

    public static function canViewAny(): bool
    {
        return Auth::user()?->role == HakAkses::USER;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->role == HakAkses::USER;
    }

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return PeminjamanBarangForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PeminjamanBarangsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getRecordUrl($record): ?string
    {
        return static::getUrl('view', ['record' => $record]);
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereIn('status', StatusPeminjaman::active());
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPeminjamanBarangs::route('/'),
            'create' => CreatePeminjamanBarang::route('/create'),
            'view' => ViewPeminjamanBarang::route('/{record}'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
