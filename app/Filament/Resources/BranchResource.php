<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BranchResource\Pages;
use App\Filament\Resources\BranchResource\RelationManagers;
use App\Models\Branch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Navigation\NavigationGroup;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;

    protected static ?string $navigationGroup = 'Master';

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Full Name') // Memberikan label agar lebih jelas
                    ->required()
                    ->maxLength(255)
                    ->rules(['string', 'min:3']), // Validasi panjang minimal

                Forms\Components\TextInput::make('phone')
                    ->label('Phone Number')
                    ->required()
                    ->maxLength(15) // Batasi panjang nomor telepon
                    ->rules(['regex:/^\+?[0-9]*$/', 'min:10']) // Validasi format nomor telepon

                    ->helperText('Format: +62 atau 08 diikuti angka tanpa spasi.'), // Informasi tambahan untuk pengguna

                Forms\Components\TextInput::make('email')
                    ->label('Email Address')
                    ->required()
                    ->email() // Validasi format email
                    ->maxLength(255)
                    ->rules(['string', 'email']),

                Forms\Components\TextInput::make('address')
                    ->label('Address')
                    ->required()
                    ->maxLength(255)
                    ->rules(['string', 'min:5']) // Validasi panjang minimal

                    ->helperText('Masukkan alamat lengkap.'),

                Forms\Components\TextInput::make('city')
                    ->label('City')
                    ->required()
                    ->maxLength(100) // Panjang maksimum lebih kecil jika nama kota umumnya pendek
                    ->rules(['string', 'min:3']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                static::getModel()::query()->orderBy('created_at', 'desc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListBranches::route('/'),
            // 'create' => Pages\CreateBranch::route('/create'),
            // 'edit' => Pages\EditBranch::route('/{record}/edit'),
        ];
    }
}
