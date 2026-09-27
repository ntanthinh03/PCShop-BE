# 🚀 DANH SÁCH TÍNH NĂNG DỰ ÁN (SHOPFLOW ROADMAP)

Tài liệu này quản lý tiến độ phát triển các tính năng của hệ thống backend ShopFlow theo quy trình **[SDLC 6 bước](file:///c:/laragon/www/ShopFlow/.ai/rules/sdlc_lifecycle.md)**.

---

## 💡 1. Ý TƯỞNG (BACKLOG / FUTURE IDEAS)
*Các tính năng được lên kế hoạch phát triển trong tương lai:*


- [ ] **Thanh toán trực tuyến (Payment Gateways Integration):**
  - Tích hợp VNPay / MoMo / ZaloPay.
  - Webhook xử lý trạng thái thanh toán tự động.
- [ ] **Đánh giá & Bình luận (Reviews & Ratings):**
  - Người mua đánh giá sao và để lại nhận xét sản phẩm.
- [ ] **Thông báo tự động (Notification System):**
  - Gửi Email xác nhận đơn hàng, đổi trạng thái qua Queue Worker.
- [ ] **Phân quyền người dùng (RBAC - Role & Permissions):**
  - Phân quyền Admin, Staff, Customer sử dụng Spatie Laravel-Permission.

---

## 🚧 2. ĐANG LÀM (IN PROGRESS)
*Các tính năng đang và sắp chuẩn bị thực hiện theo chu kỳ SDLC mới:*

*(Hiện tại chưa có tính năng mới trong mục Đang làm)*

---

## ✅ 3. ĐÃ HOÀN THÀNH (DONE)
*Các tính năng đã hoàn thiện, có Unit/Feature Test và đã sẵn sàng/merged:*

- [x] **Quản lý Danh mục & Sản phẩm (Category & Product Management API):**
  - [x] Hoàn thiện CRUD Danh mục sản phẩm (Category Controller, Service, Repository & Resource).
  - [x] Quản lý Sản phẩm (CRUD, Slug, SKU, Tồn kho, Giá, Phân trang & Search/Filter).
  - [x] Tải lên nhiều hình ảnh sản phẩm (Media/Image Upload support).
  - [x] 100% Feature Test E2E bao phủ đầy đủ luồng CRUD Danh mục & Sản phẩm (`CategoryTest`, `ProductTest`).
- [x] **Giỏ hàng & Đơn hàng (Cart & Order Management):**
  - [x] Xử lý Đơn hàng với ACID Transaction (`DB::transaction()`), Kiểm tra số lượng tồn kho & Pessimistic Locking (`lockForUpdate()`).
  - [x] API Checkout (`POST /api/v1/orders/checkout`).
  - [x] Lịch sử đơn hàng (`GET /api/v1/orders/history`), Chi tiết đơn hàng (`GET /api/v1/orders/{code}`) và Cập nhật trạng thái (`PATCH /api/v1/orders/{id}/status`).
  - [x] 100% Feature Test E2E bao phủ các luồng Đơn hàng (`OrderTest`).
- [x] **Tích hợp & Triển khai tự động (CI/CD Pipeline & Dockerization):**
  - [x] Cấu hình GitHub Actions chạy Test tự động và Lint code (Pint).
  - [x] Cấu hình Dockerfile & Docker Compose cho môi trường UAT/Production.
  - [x] Hoàn thiện kiểm thử tự động toàn bộ luồng Auth trên CI server.
- [x] **Thiết lập Bộ quy tắc AI Agent & SDLC Lifecycle (`.ai/rules` & `project/`):**
  - [x] Hợp đồng khóa chặt hành vi AI (`.ai/rules/ai_contract.md`).
  - [x] Quy trình 6 bước phát triển tự động (`.ai/rules/sdlc_lifecycle.md`).
- [x] **Hệ thống Xác thực Người dùng (Authentication API V1):**
  - [x] Đăng ký tài khoản (`POST /api/v1/auth/register`) với mã hóa mật khẩu Hash.
  - [x] Đăng nhập (`POST /api/v1/auth/login`) cấp Sanctum Personal Access Token.
  - [x] Đăng xuất (`POST /api/v1/auth/logout`) thu hồi Token hiện tại.
  - [x] Quên mật khẩu & Đặt lại mật khẩu qua Email OTP (`POST /api/v1/auth/forgot-password`, `POST /api/v1/auth/reset-password`).
  - [x] Repository-Service Pattern cho Auth Module.
  - [x] 100% Feature Test bao phủ các luồng Auth (`tests/Feature/AuthTest.php`).
- [x] **Quản lý Danh mục Cơ bản (Category Baseline):**
  - [x] Migration & Model `Category`.
