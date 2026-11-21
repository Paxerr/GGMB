<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeeRateController extends Controller
{
    /**
     * Cấu hình biểu phí (Bám sát Ảnh 6).
     */
    public function index(Request $request): View
    {
        $feeRates = collect([
            (object) [
                'id' => 1,
                'rate_id' => 1,
                'unit' => 'kWh',
                'name' => 'Điện',
                'description' => 'Điện năng tiêu thụ',
                'status' => 'ACTIVE',
                'status_label' => 'Áp dụng',
                'price' => 3500,
                'effective_from' => '01/01/2025',
                'effective_to' => null,
            ],
            (object) [
                'id' => 2,
                'rate_id' => 2,
                'unit' => 'm³',
                'name' => 'Nước',
                'description' => 'Nước sinh hoạt',
                'status' => 'ACTIVE',
                'status_label' => 'Áp dụng',
                'price' => 18000,
                'effective_from' => '01/01/2025',
                'effective_to' => null,
            ],
            (object) [
                'id' => 3,
                'rate_id' => 3,
                'unit' => 'm²/tháng',
                'name' => 'Phí quản lý',
                'description' => 'Phí quản lý vận hành chung cư',
                'status' => 'ACTIVE',
                'status_label' => 'Áp dụng',
                'price' => 12000,
                'effective_from' => '01/01/2025',
                'effective_to' => null,
            ],
            (object) [
                'id' => 4,
                'rate_id' => 4,
                'unit' => 'xe/tháng',
                'name' => 'Gửi xe',
                'description' => 'Phí gửi xe phương tiện đăng ký',
                'status' => 'ACTIVE',
                'status_label' => 'Áp dụng',
                'price' => 100000,
                'effective_from' => '01/01/2025',
                'effective_to' => null,
            ],
            (object) [
                'id' => 5,
                'rate_id' => 5,
                'unit' => 'tháng',
                'name' => 'Internet',
                'description' => 'Phí kết nối mạng nội bộ',
                'status' => 'ACTIVE',
                'status_label' => 'Áp dụng',
                'price' => 200000,
                'effective_from' => '01/01/2025',
                'effective_to' => null,
            ],
        ]);

        return view('fee-rates.index', [
            'feeRates' => $feeRates,
        ]);
    }

    /**
     * Chi tiết loại phí và lịch sử đơn giá (Bám sát Ảnh 7).
     */
    public function show(int $id): View
    {
        $feeRate = (object) [
            'id' => $id,
            'name' => 'Điện',
            'code' => (string) $id,
            'description' => 'Điện năng tiêu thụ',
            'status' => 'ACTIVE',
            'status_label' => 'Đang sử dụng',
            'price' => 3500,
            'effective_from' => '01/01/2025',
            'effective_to' => null,
        ];

        return view('fee-rates.show', [
            'feeRate' => $feeRate,
        ]);
    }

    /**
     * Thêm loại phí (Bám sát Ảnh 8).
     */
    public function create(): View
    {
        return view('fee-rates.create');
    }

    /**
     * Lưu loại phí mới.
     */
    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('fee-rates.index')->with('success', 'Thêm loại phí mới thành công.');
    }

    /**
     * Chỉnh sửa loại phí (Bám sát Ảnh 9).
     */
    public function edit(int $id): View
    {
        $feeRate = (object) [
            'id' => $id,
            'name' => 'Điện',
            'code' => (string) $id,
            'description' => 'Điện năng tiêu thụ',
            'status' => 'ACTIVE',
            'status_label' => 'Đang sử dụng',
        ];

        return view('fee-rates.edit', [
            'feeRate' => $feeRate,
        ]);
    }

    /**
     * Cập nhật loại phí.
     */
    public function update(int $id, Request $request): RedirectResponse
    {
        return redirect()->route('fee-rates.show', $id)->with('success', 'Cập nhật thông tin loại phí thành công.');
    }

    /**
     * Ngừng sử dụng loại phí (Bám sát Ảnh 10).
     */
    public function deactivate(int $id): View
    {
        $feeRate = (object) [
            'id' => $id,
            'name' => 'Điện',
            'status' => 'ACTIVE',
            'status_label' => 'Đang sử dụng',
        ];

        return view('fee-rates.deactivate', [
            'feeRate' => $feeRate,
        ]);
    }

    /**
     * Xác nhận ngừng sử dụng.
     */
    public function confirmDeactivate(int $id, Request $request): RedirectResponse
    {
        return redirect()->route('fee-rates.index')->with('success', "Đã ngừng sử dụng loại phí #{$id} thành công.");
    }

    /**
     * Kích hoạt lại loại phí (Bám sát Ảnh Kích hoạt lại loại phí).
     */
    public function activate(int $id): View
    {
        $feeRate = (object) [
            'id' => $id,
            'name' => 'Điện',
            'status' => 'INACTIVE',
            'status_label' => 'Ngừng sử dụng',
        ];

        return view('fee-rates.activate', [
            'feeRate' => $feeRate,
        ]);
    }

    /**
     * Xác nhận kích hoạt lại loại phí.
     */
    public function confirmActivate(int $id, Request $request): RedirectResponse
    {
        return redirect()->route('fee-rates.index')->with('success', "Đã kích hoạt lại loại phí #{$id} thành công.");
    }

    /**
     * Thêm đơn giá mới (Bám sát Ảnh Thêm đơn giá mới).
     */
    public function createRate(int $id): View
    {
        $feeRate = (object) [
            'id' => $id,
            'name' => 'Điện',
        ];

        return view('fee-rates.rates-create', [
            'feeRate' => $feeRate,
        ]);
    }

    /**
     * Lưu đơn giá mới.
     */
    public function storeRate(int $id, Request $request): RedirectResponse
    {
        return redirect()->route('fee-rates.show', $id)->with('success', 'Thêm đơn giá mới thành công.');
    }
}
