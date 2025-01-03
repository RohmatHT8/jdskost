<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomResource\Pages;
use App\Filament\Resources\RoomResource\RelationManagers;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationGroup = 'Master';

    protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Forms\Components\TextInput::make('number_room')
                        ->required()
                        ->maxLength(255)
                        ->unique(Room::class, 'number_room', ignoreRecord: true),
                    Forms\Components\Select::make('branch_id')
                        ->relationship('branch', 'name')
                        ->label('Branch')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->distinct()
                        ->disableOptionsWhenSelectedInSiblingRepeaterItems(),
                    Forms\Components\TextInput::make('price')
                        ->required()
                        ->numeric()
                        ->prefix('Rp'),
                    Forms\Components\FileUpload::make('image_room')
                        ->image()
                        ->required(),
                ])->columns(2)
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number_room')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image_room'),
                Tables\Columns\TextColumn::make('branch.name')
                    ->label('Branch')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('idr', true)
                    ->sortable(),
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
            'index' => Pages\ListRooms::route('/'),
            // 'create' => Pages\CreateRoom::route('/create'),
            // 'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }
}
