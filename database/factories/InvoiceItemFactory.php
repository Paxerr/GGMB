<?php

namespace Database\Factories;

use App\Models\FeeRate;
use App\Models\FeeType;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InvoiceItem>
 */
class InvoiceItemFactory extends Factory
{
    protected $model = InvoiceItem::class;

    public function definition(): array
    {
        $qty = fake()->numberBetween(30, 60);
        $price = 3500;

        return [
            'InvoiceId' => Invoice::factory(),
            'FeeTypeId' => FeeType::factory(),
            'FeeRateId' => FeeRate::factory(),
            'Quantity' => $qty,
            'UnitPrice' => $price,
            'Amount' => $qty * $price,
        ];
    }
}
