<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('brand_id')
                    ->required()
                    ->numeric(),
                TextInput::make('model')
                    ->required(),
                Select::make('cpu_brand')
                    ->options(['Intel' => 'Intel', 'AMD' => 'A m d'])
                    ->required(),
                TextInput::make('cpu_model'),
                TextInput::make('ram_gb')
                    ->required()
                    ->numeric()
                    ->default(8),
                TextInput::make('storage_gb')
                    ->required()
                    ->numeric()
                    ->default(256),
                TextInput::make('gpu'),
                TextInput::make('price')
                    ->numeric()
                    ->prefix('$'),
            ]);
    }
}
