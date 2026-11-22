<?php

namespace App\DTOs;

use App\Http\Requests\Invoice\StoreInvoiceRequest;

readonly class InvoiceDTO
{
    /**
     * @param  array<int, array{fee_type_id: int, quantity: float, unit_price: float, amount: float}>  $items
     */
    public function __construct(
        public int $apartmentId,
        public string $billingPeriod,
        public float $totalAmount,
        public string $dueDate,
        public string $status = 'PENDING',
        public ?int $createdByUserId = null,
        public array $items = [],
    ) {}

    public static function fromStoreRequest(StoreInvoiceRequest $request, int $userId): self
    {
        $rawItems = (array) $request->validated('items', []);
        $items = [];
        $total = 0.0;

        foreach ($rawItems as $item) {
            if (isset($item['selected']) && (! $item['selected'] || $item['selected'] === '0')) {
                continue;
            }
            $qty = (float) ($item['quantity'] ?? $item['qty'] ?? 1);
            $price = (float) ($item['unit_price'] ?? $item['price'] ?? 0);
            $amount = (float) ($item['amount'] ?? ($qty * $price));
            $total += $amount;

            $items[] = [
                'fee_type_id' => (int) ($item['fee_type_id'] ?? 1),
                'quantity' => $qty,
                'unit_price' => $price,
                'amount' => $amount,
            ];
        }

        if ($request->filled('total_amount')) {
            $total = (float) $request->validated('total_amount');
        }

        return new self(
            apartmentId: (int) $request->validated('ApartmentId'),
            billingPeriod: (string) $request->validated('BillingPeriod'),
            totalAmount: $total,
            dueDate: (string) $request->validated('DueDate'),
            status: 'PENDING',
            createdByUserId: $userId,
            items: $items,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toModelArray(): array
    {
        return [
            'ApartmentId' => $this->apartmentId,
            'BillingPeriod' => $this->billingPeriod,
            'TotalAmount' => $this->totalAmount,
            'DueDate' => $this->dueDate,
            'Status' => $this->status,
            'CreatedByUserId' => $this->createdByUserId,
            'CreatedAt' => now(),
        ];
    }
}
