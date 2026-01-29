<?php

namespace App\Filament\Resources\DataPengembalians;

use App\Enums\HakAkses;
use App\Enums\StatusPeminjaman;
use App\Filament\Resources\DataPengembalians\Pages\CreateDataPengembalian;
use App\Filament\Resources\DataPengembalians\Pages\EditDataPengembalian;
use App\Filament\Resources\DataPengembalians\Pages\ListDataPengembalians;
use App\Filament\Resources\DataPengembalians\Pages\ViewDataPengembalian;
use App\Filament\Resources\DataPengembalians\Schemas\DataPengembalianForm;
use App\Filament\Resources\DataPengembalians\Schemas\DataPengembalianInfolist;
use App\Filament\Resources\DataPengembalians\Tables\DataPengembaliansTable;
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

class DataPengembalianResource extends Resource
{
    protected static ?string $model = PeminjamanBarang::class;

    protected static ?int $navigationSort = 1;
    public static function canViewAny(): bool
    {
        return Auth::user()?->role == HakAkses::ADMIN;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->role == HakAkses::ADMIN;
    }

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::ArchiveRestore;

    protected static string|UnitEnum|null $navigationGroup = "Aktivitas";
    protected static ?string $navigationLabel = "Pengembalian Barang";
    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $label = "Pengembalian Barang";

    public static function form(Schema $schema): Schema
    {
        return DataPengembalianForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DataPengembalianInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DataPengembaliansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDataPengembalians::route('/'),
            'view' => ViewDataPengembalian::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('status', StatusPeminjaman::MENUNGGU_VERIFIKASI)
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
