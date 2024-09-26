<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SchedulResource\Pages;
use App\Filament\Resources\SchedulResource\RelationManagers;
use App\Models\Schedul;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class SchedulResource extends Resource
{
    protected static ?string $model = Schedul::class;

    protected static ?string $navigationIcon = 'heroicon-s-calendar-days';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->required()
                                    ->unique(),
                                Forms\Components\Select::make('shift_id')
                                    ->relationship('shift', 'name')
                                    ->required(),
                                Forms\Components\Select::make('office_id')
                                    ->relationship('office', 'name')
                                    ->required(),
                                Forms\Components\Toggle::make('is_wfa')
                                    ->label('WFA')
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $is_super_admin = Auth::user()->hasRole('super_admin');
                if (!$is_super_admin) {
                    $query->where('user_id', Auth::user()->id);
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                Auth::user()->hasRole('super_admin')
                    ? Tables\Columns\ToggleColumn::make('is_wfa')
                        ->label('WFA')
                    : Tables\Columns\IconColumn::make('is_wfa')
                        ->label('WFA'),
                Tables\Columns\TextColumn::make('shift.name')
                    ->description(fn (Schedul $record): string => $record->shift->start_time . ' - ' . $record->shift->end_time)
                    ->sortable(),
                // Tables\Columns\TextColumn::make('shift.start_time')
                //     ->label('Start Time'),
                // Tables\Columns\TextColumn::make('shift.end_time')
                //     ->label('End Time'),
                Tables\Columns\TextColumn::make('office.name')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListScheduls::route('/'),
            'create' => Pages\CreateSchedul::route('/create'),
            'edit' => Pages\EditSchedul::route('/{record}/edit'),
        ];
    }
}
