<?php

namespace App\Filament\Resources\Ruangans;

use App\Enums\HakAkses;
use App\Filament\Resources\Ruangans\Pages\CreateRuangan;
use App\Filament\Resources\Ruangans\Pages\EditRuangan;
use App\Filament\Resources\Ruangans\Pages\ListRuangans;
use App\Filament\Resources\Ruangans\Schemas\RuanganForm;
use App\Filament\Resources\Ruangans\Tables\RuangansTable;
use App\Models\Ruangan;
use BackedEnum;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class RuanganResource extends Resource
{
    protected static ?string $model = Ruangan::class;

    //Untuk Ganti Icon
    protected static string|BackedEnum|null $navigationIcon = LucideIcon::Building2;
    protected static ?string $navigationLabel = "Ruangan";
    protected static ?string $slug = "rooms";
    protected static ?string $breadcrumb = "Ruangan";
    protected static ?string $recordTitleAttribute = 'name';
    protected static string|UnitEnum|null $navigationGroup = "Inventaris";

    public static function canViewAny(): bool
    {
        return Auth::user()?->role == HakAkses::SUPERADMIN;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->role == HakAkses::SUPERADMIN;
    }
    public static function form(Schema $schema): Schema
    {
        return RuanganForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RuangansTable::configure($table);
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
            'index' => ListRuangans::route('/'),
            'create' => CreateRuangan::route('/create'),
            'edit' => EditRuangan::route('/{record}/edit'),
        ];
    }
}
