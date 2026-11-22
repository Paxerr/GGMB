# YÊU CẦU ĐỒNG BỘ DÀNH CHO FRONTEND (NHÓM 1: QUẢN TRỊ CƠ BẢN)

Tài liệu này tổng hợp các điểm cần hoàn thiện và đồng bộ từ phía giao diện (Blade Views / JavaScript) để kết nối hoàn chỉnh với Backend API / Controller vừa được xây dựng.

---

## 1. Vấn đề chung cần xử lý trên các Form / Modal

1. **Gỡ bỏ `event.preventDefault()` trong form:**
   * Hiện tại một số form / modal đang chặn sự kiện submit mặc định:
     ```html
     <!-- Hiện tại -->
     <form onsubmit="event.preventDefault(); closeCreateAccountModal(); if(window.showToast) window.showToast(...)">
     ```
   * **Cần sửa:** 
     * *Cách 1 (Form submit truyền thống):* Bỏ `event.preventDefault()`, để form gửi trực tiếp POST/PUT đến `action="{{ route(...) }}"`.
     * *Cách 2 (AJAX Fetch/Axios):* Nếu muốn giữ hiệu ứng Modal không reload trang, hãy dùng `fetch(form.action, { method: form.method, body: new FormData(form), headers: { 'Accept': 'application/json' } })`, sau khi thành công thì reload hoặc cập nhật DOM.

2. **Bổ sung thuộc tính `name="..."` cho các thẻ `<input>`, `<select>`, `<textarea>`:**
   * Nhiều modal hiện chỉ có class và placeholder, chưa có thuộc tính `name` nên trình duyệt không thể đóng gói dữ liệu gửi lên server.

3. **Bảo mật CSRF và HTTP Method:**
   * Tất cả các form POST phải có `@csrf`.
   * Các form cập nhật phải có `@csrf` và `@method('PUT')` hoặc `@method('PATCH')`.

---

## 2. Chi tiết các trường cần gắn `name` theo từng chức năng

### 2.1. Quản trị tài khoản (`accounts`)
* **Modal Thêm tài khoản (`resources/views/accounts/partials/create-modal.blade.php`):**
  * Tên đăng nhập: `name="UserName"` (hoặc `user_name`) *(Bắt buộc, duy nhất, không dấu)*
  * Họ và tên: `name="FullName"` (hoặc `full_name`) *(Bắt buộc)*
  * Mật khẩu: `name="Password"` (hoặc `password`) *(Bắt buộc, tối thiểu 6 ký tự)*
  * Số điện thoại: `name="Phone"` (hoặc `phone`)
  * Email: `name="Email"` (hoặc `email`)
  * Số CCCD: `name="CitizenId"` (hoặc `citizen_id`)
  * Vai trò: `name="Role"` (hoặc `role`) *(Bắt buộc, chọn một trong: Quản lý / Hỗ trợ / Kỹ thuật / Bảo vệ)*
  * Bộ phận: `name="Department"` (hoặc `department`)
* **Trang/Modal Chỉnh sửa tài khoản (`resources/views/accounts/edit.blade.php`):**
  * `FullName`, `Phone`, `Email`, `CitizenId`, `Role`, `Department`, `Password` (nếu muốn đổi mật khẩu mới).

### 2.2. Quản lý Căn hộ (`apartments`)
* **Modal / Trang Thêm căn hộ (`resources/views/apartments/partials/create-modal.blade.php` / `create.blade.php`):**
  * Tầng: `name="FloorId"` *(Bắt buộc, ID tầng)*
  * Số căn hộ: `name="ApartmentNumber"` *(Bắt buộc, ví dụ: 0101, 0202)*
  * Trạng thái: `name="Status"` *(Bắt buộc: `AVAILABLE`, `VACANT`, `OCCUPIED`, `SUSPENDED`, `INACTIVE`)*
  * Mô tả: `name="Description"`
* **Modal Đổi trạng thái căn hộ (`resources/views/apartments/partials/status-modal.blade.php`):**
  * Route: `PATCH /apartments/{apartment}/status`
  * Trạng thái: `name="Status"`

### 2.3. Danh bạ Cư dân (`residents`)
* **Modal / Trang Tiếp nhận cư dân (`resources/views/residents/partials/create-modal.blade.php` / `create.blade.php`):**
  * Họ và tên: `name="FullName"` (hoặc `full_name`) *(Bắt buộc)*
  * Số CCCD: `name="CitizenId"` (hoặc `citizen_id`)
  * Số điện thoại: `name="Phone"` (hoặc `phone`)
  * Email: `name="Email"` (hoặc `email`)
  * Căn hộ: `name="ApartmentId"` (hoặc `apartment_id`)
  * Ngày bắt đầu: `name="StartDate"` (hoặc `start_date`) *(Định dạng YYYY-MM-DD)*
  * Ngày kết thúc: `name="EndDate"` (hoặc `end_date`)
  * Tên đăng nhập cấp cho cư dân: `name="UserName"` (tùy chọn, hệ thống tự sinh nếu để trống)
  * Mật khẩu ban đầu: `name="Password"` (tùy chọn, mặc định: `password123`)

### 2.4. Quản lý Phương tiện & Thẻ xe (`vehicles`)
* **Modal Đăng ký phương tiện (`resources/views/vehicles/partials/create-modal.blade.php`):**
  * Căn hộ: `name="ApartmentId"` (hoặc `apartment_id`) *(Bắt buộc)*
  * Biển số xe: `name="LicensePlate"` (hoặc `license_plate`) *(Bắt buộc, ví dụ: 29A-12345)*
  * Loại xe: `name="VehicleType"` (hoặc `vehicle_type`) *(Bắt buộc: `MOTORBIKE`, `CAR`, `ELECTRIC_BIKE`, `BICYCLE` hoặc tiếng Việt: `Xe máy`, `Xe ô tô`, `Xe máy điện`, `Xe đạp`)*
* **Form Hủy đăng ký xe (`resources/views/vehicles/cancel.blade.php` / `cancel-modal.blade.php`):**
  * Gửi `POST` đến `{{ route('vehicles.confirm-cancel', $vehicle->id) }}` kèm `@csrf`.

### 2.5. Tòa nhà & Tầng (`buildings`)
* **Form Thêm / Sửa tòa nhà:**
  * Tên tòa nhà: `name="BuildingName"` *(Bắt buộc, tối đa 100 ký tự)*
