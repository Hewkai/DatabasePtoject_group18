<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('brand_id')
                    ->numeric(),
                TextEntry::make('model'),
                TextEntry::make('cpu_brand')
                    ->badge(),
                TextEntry::make('cpu_model')
                    ->placeholder('-'),
                TextEntry::make('ram_gb')
                    ->numeric(),
                TextEntry::make('storage_gb')
                    ->numeric(),
                TextEntry::make('gpu')
                    ->placeholder('-'),
                TextEntry::make('price')
                    ->money()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
