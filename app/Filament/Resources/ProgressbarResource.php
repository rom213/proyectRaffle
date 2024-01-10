<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgressbarResource\Pages;
use App\Filament\Resources\ProgressbarResource\RelationManagers;
use App\Models\Progressbar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProgressbarResource extends Resource
{
    protected static ?string $model = Progressbar::class;

    protected static ?string $navigationIcon = 'heroicon-o-battery-50';
    protected static ?string $navigationGroup = 'bussines';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('status')
                ->required()
                ->maxLength(255)
                ->default('0'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('status'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListProgressbars::route('/'),
            'create' => Pages\CreateProgressbar::route('/create'),
            'edit' => Pages\EditProgressbar::route('/{record}/edit'),
        ];
    }
}
