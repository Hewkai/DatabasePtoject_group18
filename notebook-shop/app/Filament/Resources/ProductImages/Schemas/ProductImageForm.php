<?php

namespace App\Filament\Resources\ProductImages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductImageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('product_id')
                    ->required()
                    ->numeric(),
                TextInput::make('url')
                    ->url()
                    ->required(),
                Toggle::make('is_primary')
                    ->required(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
