# AI Agent Strict Rules & Behavior Contract

## 📜 HỢP ĐỒNG KHÓA CHẶT HÀNH VI AI AGENT (STRICT AGENT RULES)

### 1. Schema, API & Tech Stack Guidelines
- **Khung Schema & API Endpoints:** Phải thiết kế chuẩn xác theo hợp đồng RESTful / GraphQL API (dùng Eloquent Resources, Form Requests).
- **Cấm đổi Tech Stack:** Giữ nguyên 100% công nghệ (PHP 8.3, Laravel, PostgreSQL, Docker,...). Không tự ý cài đặt thêm dependency/package mới nếu không được chỉ định.
- **Cấm Mock Data:** Tuyệt đối không dùng dữ liệu giả trong production code.
- **Giới hạn độ dài file (Sub-300 lines limit):** Mỗi file code không được vượt quá **300 dòng**. Phải tách nhỏ sang Service, Repository, Trait hoặc Helper nếu tiệm cận giới hạn.

### 2. Commit Policy
- **Commit thường xuyên (Atomic Commits):** Thực hiện commit ngay khi hoàn thành từng bước nhỏ hoặc từng test case thành công.
- Tuân thủ định dạng `feat:`, `fix:`, `test:`, `style:`, `refactor:`.

### 3. Scope Lock (Phạm vi thao tác)
- **Cấm chạm vào code không liên quan:** Chỉ thao tác trong phạm vi các file/module được chỉ định.
- **Cấm viết lại (Rewrite) logic module khác:** Phải tái sử dụng (reuse) Interface, Service, Helper hiện có thay vì tự viết lại code trùng lặp.

### 4. Cleanup & Garbage Script Prevention
- **Cấm tạo script rác:** Không tạo file test tạm (`test.php`, `debug.php`,...) ở root hoặc source code.
- **Tự động dọn dẹp:** Dọn dẹp sạch sẽ toàn bộ log tạm, `var_dump()`, `dd()`, `console.log()` trước khi bàn giao.

### 5. E2E & Integrity Testing Rules
- **Mô phỏng người dùng thật:** Viết Feature/E2E test mô phỏng thực tế tương tác request, click chuột, nhập liệu.
- **CẤM GIAN LẬN TEST (No Test Fraud):** Khi bài test thất bại (FAILED), **TUYỆT ĐỐI KHÔNG DƯỢC SỬA LẠI NỘI DUNG TEST/ASSERTION** để ép test trôi qua. Phải tìm đúng lỗi logic trong ứng dụng để sửa.
