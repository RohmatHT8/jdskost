<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserRoomResource\Pages;
use App\Filament\Resources\UserRoomResource\RelationManagers;
use App\Models\Room;
use App\Models\UserRoom;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserRoomResource extends Resource
{
    protected static ?string $model = UserRoom::class;

    protected static ?string $navigationGroup = 'Transaction';

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('User')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('status')
                    ->options([
                        'in' => 'In',
                        'out' => 'Out',
                        'book' => 'Book',
                    ])
                    ->label('Status')
                    ->required()
                    ->reactive(), // React terhadap perubahan nilai

                Forms\Components\Select::make('room_id')
                    ->relationship('room', 'number_room')
                    ->label('Number Room')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->reactive() // React terhadap perubahan nilai status
                    ->options(function (callable $get) {
                        // Ambil nilai status
                        $status = $get('status');

                        if ($status === 'in') {
                            // return \App\Models\Room::where('status', 'available')->pluck('number_room', 'id');
                        } elseif ($status === 'out') {
                            // return \App\Models\Room::where('status', 'occupied')->pluck('number_room', 'id');
                        } elseif ($status === 'book') {
                            return \App\Models\Room::pluck('number_room', 'id');
                        }

                        return [];
                    }),

                Forms\Components\DatePicker::make('date_in')
                    ->label('Date In')
                    ->required(),

                Forms\Components\DatePicker::make('date_out')
                    ->label('Date Out'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                static::getModel()::query()->orderBy('created_at', 'desc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('room.number_room')
                    ->label('Room Number')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_in')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_out')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
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
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListUserRooms::route('/'),
        ];
    }
}
