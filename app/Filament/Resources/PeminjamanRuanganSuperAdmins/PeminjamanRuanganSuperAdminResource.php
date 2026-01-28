<?php

namespace App\Filament\Resources\PeminjamanRuanganSuperAdmins;

use App\Enums\HakAkses;
use App\Filament\Resources\PeminjamanRuanganSuperAdmins\Pages\CreatePeminjamanRuanganSuperAdmin;
use App\Filament\Resources\PeminjamanRuanganSuperAdmins\Pages\EditPeminjamanRuanganSuperAdmin;
use App\Filament\Resources\PeminjamanRuanganSuperAdmins\Pages\ListPeminjamanRuanganSuperAdmins;
use App\Filament\Resources\PeminjamanRuanganSuperAdmins\Schemas\PeminjamanRuanganSuperAdminForm;
use App\Filament\Resources\PeminjamanRuanganSuperAdmins\Tables\PeminjamanRuanganSuperAdminsTable;
use App\Models\PeminjamanBarang;
use App\Models\PeminjamanRuanganSuperAdmin;
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

class PeminjamanRuanganSuperAdminResource extends Resource
{
    protected static ?string $model = PeminjamanBarang::class;
    protected static ?int $navigationSort = 5;
    protected static string|BackedEnum|null $navigationIcon = LucideIcon::HousePlus;
    // protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::ClipboardDocumentList;

   public static function canViewAny(): bool
    {
        return Auth::user()?->role == HakAkses::SUPERADMIN;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->role == HakAkses::SUPERADMIN;
    }

    protected static ?string $navigationLabel = "Peminjaman Ruang";

    protected static string|UnitEnum|null $navigationGroup = "Peminjaman";
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return PeminjamanRuanganSuperAdminForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PeminjamanRuanganSuperAdminsTable::configure($table);
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
            'index' => ListPeminjamanRuanganSuperAdmins::route('/'),
            'create' => CreatePeminjamanRuanganSuperAdmin::route('/create'),
            'edit' => EditPeminjamanRuanganSuperAdmin::route('/{record}/edit'),
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
