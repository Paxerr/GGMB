# YÊU CẦU ĐỒNG BỘ DÀNH CHO FRONTEND (CÁC PHÂN HỆ CÒN LẠI)

Tài liệu này tổng hợp danh sách các trường và lưu ý khi kết nối form/modal giữa Giao diện (Blade / JS) với Backend API cho các phân hệ: Biểu phí, Điện nước, Hóa đơn, Yêu cầu hỗ trợ, Bảng tin, Cổng cư dân và Cổng kỹ thuật.

---

## 1. Phân hệ Cấu hình Biểu phí (`fee-rates`)
* **Modal / Form Thêm loại phí (`fee-rates/create.blade.php` / create-modal):**
  * Mã loại phí: `name="Code"` (hoặc `code`) *(Bắt buộc, ví dụ: ELEC, WATER, MGMT)*
  * Tên loại phí: `name="Name"` (hoặc `name`) *(Bắt buộc, ví dụ: Điện năng tiêu thụ)*
  * Mô tả: `name="Description"` (hoặc `description`)
  * Đơn giá khởi tạo: `name="UnitPrice"` (hoặc `price`, `unit_price`)
* **Modal / Form Thêm đơn giá mới (`fee-rates/rates-create.blade.php`):**
  * Gửi `POST` đến `{{ route('fee-rates.rates.store', $feeType->id) }}`
  * Đơn giá: `name="UnitPrice"` (hoặc `price`) *(Bắt buộc)*
  * Ngày áp dụng: `name="EffectiveFrom"` (hoặc `effective_from`) *(Bắt buộc, YYYY-MM-DD)*
  * Ngày kết thúc: `name="EffectiveTo"` (hoặc `effective_to`)

---

## 2. Phân hệ Điện nước & Chỉ số (`utilities`)
* **Modal Đính chính chỉ số (`utilities/partials/correct-modal.blade.php`):**
  * Gửi `POST` đến `{{ route('utilities.correct') }}`
  * ID chỉ số: `name="MeterReadingId"` (hoặc `id`) *(Bắt buộc)*
  * Số cũ: `name="PreviousReading"` (hoặc `old_num`) *(Bắt buộc)*
  * Số mới: `name="CurrentReading"` (hoặc `new_num`) *(Bắt buộc, phải >= số cũ)*
* **Modal Nhập chỉ số ban đầu (`utilities/partials/first-time-modal.blade.php`):**
  * Gửi `POST` đến `{{ route('utilities.first-time') }}`
  * Căn hộ: `name="ApartmentId"` (hoặc `apartment_id`) *(Bắt buộc)*
  * Dịch vụ: `name="FeeTypeId"` (hoặc `fee_type_id`) *(Bắt buộc)*
  * Kỳ ghi: `name="BillingPeriod"` (hoặc `period`) *(Bắt buộc, định dạng MM/YYYY)*
  * Chỉ số cũ: `name="PreviousReading"` (hoặc `old_num`, mặc định 0)
  * Chỉ số mới: `name="CurrentReading"` (hoặc `new_num`) *(Bắt buộc)*

---

## 3. Phân hệ Quản lý Hóa đơn (`invoices`)
* **Modal Lập hóa đơn mới (`invoices/partials/create-modal.blade.php`):**
  * Gửi `POST` đến `{{ route('invoices.store') }}`
  * Căn hộ: `name="ApartmentId"` (hoặc `apartment_id`) *(Bắt buộc)*
  * Kỳ thu: `name="BillingPeriod"` (hoặc `period`) *(Bắt buộc, MM/YYYY)*
  * Hạn nộp: `name="DueDate"` (hoặc `due_date`) *(Bắt buộc, YYYY-MM-DD)*
  * Tổng tiền: `name="total_amount"` (nếu nhập trực tiếp)
  * Danh sách chi tiết (nếu có): `name="items[0][fee_type_id]"`, `name="items[0][quantity]"`, `name="items[0][unit_price]"`...
* **Modal Thu tiền (`invoices/partials/collect-modal.blade.php`):**
  * Gửi `POST` đến `{{ route('invoices.collect', $invoice->id) }}`
  * Phương thức: `name="PaymentType"` (`CASH` / `TRANSFER` hoặc `Tiền mặt` / `Chuyển khoản`)
* **Modal Hủy hóa đơn (`invoices/partials/cancel-modal.blade.php`):**
  * Gửi `POST` đến `{{ route('invoices.cancel', $invoice->id) }}`
  * Lý do hủy: `name="reason"`

---

## 4. Phân hệ Yêu cầu hỗ trợ Kanban (`tickets`)
* **Modal Tạo yêu cầu (`tickets/partials/create-modal.blade.php`):**
  * Gửi `POST` đến `{{ route('tickets.store') }}`
  * Căn hộ: `name="ApartmentId"` (hoặc `apartment_id`)
  * Danh mục: `name="Category"` (hoặc `category`) *(Tài khoản, Xe, Kỹ thuật, Hóa đơn, Phản ánh, Khác)*
  * Tiêu đề: `name="Subject"` (hoặc `title`) *(Bắt buộc)*
  * Nội dung: `name="Description"` (hoặc `description`) *(Bắt buộc)*
* **Modal Phân công (`tickets/partials/assign-modal.blade.php`):**
  * Gửi `POST` đến `{{ route('tickets.assign', $ticket->id) }}`
  * Kỹ thuật viên: `name="AssignedToUserId"` (hoặc `assignee_id`) *(Bắt buộc)*
* **Modal Nghiệm thu / Hoàn thành (`tickets/partials/verify-modal.blade.php`):**
  * Gửi `POST` đến `{{ route('tickets.verify', $ticket->id) }}`
  * Hành động: `name="action"` (`RESOLVE` hoặc `CLOSE`)
  * Ghi chú: `name="notes"`
* **Modal Hủy yêu cầu (`tickets/partials/cancel-modal.blade.php`):**
  * Gửi `POST` đến `{{ route('tickets.cancel', $ticket->id) }}`
  * Lý do hủy: `name="reason"`

---

## 5. Phân hệ Bảng tin & Thông báo (`notifications`)
* **Trang Soạn thông báo (`notifications/create.blade.php`):**
  * Gửi `POST` đến `{{ route('notifications.store') }}`
  * Tiêu đề: `name="Title"` (hoặc `title`) *(Bắt buộc)*
  * Nội dung: `name="Content"` (hoặc `content`) *(Bắt buộc)*
  * Phạm vi: `name="TargetType"` (`ALL`, `BUILDING`, `FLOOR`, `APARTMENT`)
  * Tòa nhà mục tiêu: `name="BuildingId"` (khi phạm vi là Tòa nhà)
  * Tầng mục tiêu: `name="FloorId"` (khi phạm vi là Tầng)
  * Căn hộ mục tiêu: `name="ApartmentId"` hoặc `name="apartment_ids[]"` (khi phạm vi là Căn hộ)

---

## 6. Cổng Cư dân (`portal`)
* **Gửi yêu cầu hỗ trợ (`portal/tickets/create.blade.php`):**
  * Gửi `POST` đến `{{ route('portal.tickets.store') }}`
  * Tiêu đề: `name="Subject"` (hoặc `title`)
  * Chi tiết: `name="Description"` (hoặc `description`)
  * Danh mục: `name="Category"` (hoặc `category`)
* **Phản hồi trao đổi ticket (`portal/tickets/show.blade.php`):**
  * Gửi `POST` đến `{{ route('portal.tickets.reply', $ticket->id) }}`
  * Nội dung: `name="content"`
* **Cập nhật hồ sơ cư dân (`portal/profile/edit.blade.php`):**
  * Gửi `POST` đến `{{ route('portal.profile.update') }}`
  * Điện thoại: `name="Phone"`, Email: `name="Email"`, Mật khẩu mới: `name="Password"`

---

## 7. Cổng Kỹ thuật (`tech`)
* **Xác nhận kết quả xử lý công việc (`tech/tasks/show.blade.php`):**
  * Gửi `POST` đến `{{ route('tech.tasks.complete', $task->id) }}`
  * Kết quả / Ghi chú: `name="content"`
  * Trạng thái: `name="status"` (`RESOLVED`)

