<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{

    protected static ?string $navigationGroup = 'Master Data';

    public static function getNavigationSort(): ?int
    {
        return 2;
    }
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //card
                Forms\Components\Card::make()
                    ->schema([

                        //image
                        Forms\Components\FileUpload::make('image')
                            ->label('Product Image')
                            ->placeholder('Product Image')
                            ->required(),

                        //title
                        Forms\Components\TextInput::make('title')
                            ->label('Product Title')
                            ->placeholder('Product Title')
                            ->required(),

                        Forms\Components\Grid::make(3)->schema([

                            //category
                            Forms\Components\Select::make('category_id')
                                ->label('Category')
                                ->relationship('category', 'name')
                                ->required(),

                            //price
                            Forms\Components\TextInput::make('price')
                                ->label('Price')
                                ->placeholder('Price')
                                ->required(),

                            //weight
                            Forms\Components\TextInput::make('weight')
                                ->label('Weight')
                                ->placeholder('Weight')
                                ->required(),
                        ]),

                        //description
                        Forms\Components\RichEditor::make('description')
                            ->label('Product Description')
                            ->placeholder('Product Description')
                            ->required(),

                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->circular(),
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('category.name')->searchable(),
                Tables\Columns\TextColumn::make('price')->numeric(decimalPlaces: 0)->money('IDR', locale: 'id'),
                Tables\Columns\TextColumn::make('description')->html()->limit(50),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
