<?php

namespace App\Filament\Resources;

use App\Enums\productTypeEnum;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';
    protected static ?string $navigationGroup = 'Shop';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Group::make()->schema([

                    Forms\Components\Section::make()->schema([
                        Forms\Components\TextInput::make('name'),
                        Forms\Components\TextInput::make('slug'),
                        Forms\Components\MarkdownEditor::make('description')->columnSpan('full')

                    ])->columns(2),
                    Forms\Components\Section::make('Pricing & Inventory')->schema([
                        Forms\Components\TextInput::make('sku'),
                        Forms\Components\TextInput::make('price'),
                        Forms\Components\TextInput::make('quantity'),
                        Forms\Components\Select::make('productType')->options([
                            'downloadable' =>productTypeEnum::DOWNLOADABLE->value,
                            'deliverable' =>productTypeEnum::DELIVERABLE->value,
                        ]),


                    ])->columns(2)

                ]),
                Forms\Components\Group::make()->schema([

                    Forms\Components\Section::make('Status')->schema([
                        Forms\Components\Toggle::make('isVisible'),
                        Forms\Components\Toggle::make('isFeatured'),
                        Forms\Components\DatePicker::make('publishedAt')->columnSpan('full')

                    ]),
                    Forms\Components\Section::make('Image')->schema([
                        Forms\Components\FileUpload::make('image'),

                    ])->collapsible(),
                    Forms\Components\Section::make('Association')->schema([
                        Forms\Components\Select::make('brand_id')->relationship('brand', 'name'),

                    ]),

                ])


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //

                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('brand.name'),
                Tables\Columns\IconColumn::make('isVisible')->boolean(),
                Tables\Columns\TextColumn::make('price'),
                Tables\Columns\TextColumn::make('quantity'),
                Tables\Columns\TextColumn::make('publishedAt'),
                Tables\Columns\TextColumn::make('productType'),

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
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
