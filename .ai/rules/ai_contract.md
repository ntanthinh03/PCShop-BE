# 📜 HỢP ĐỒNG QUY TẮC BẮT BUỘC DÀNH CHO AI AGENT (AI BEHAVIOR CONTRACT)

> **MỤC TIÊU:** Khóa chặt hành vi của AI Agent, đảm bảo chất lượng mã nguồn, tính bảo mật, cấu trúc sạch (Clean Code) và ngăn ngừa tuyệt đối các hành vi tự ý phá vỡ hệ thống hoặc làm giả kết quả test.

---

## 🛑 ĐIỀU 1: CHUẨN HÓA SCHEMA, API & NGUYÊN TẮC CODE CRITICAL
1. **Khung Schema & API Endpoints:**
   - Phải thiết kế và làm việc chính xác theo định dạng API RESTful / GraphQL đã thỏa thuận.
   - Khi chỉnh sửa API, phải cập nhật đúng Request/Response contract (Eloquent Resources, Form Requests).
2. **Cấm đổi Tech Stack:**
   - Giữ nguyên 100% Công nghệ, Framework, Thư viện cốt lõi của dự án (PHP 8.3, Laravel, PostgreSQL, Docker,...). Nghiêm cấm tự ý cài đặt thêm package mới hoặc thay đổi công nghệ khi chưa có sự đồng ý của User.
3. **Cấm Mock Data trong Production Code:**
   - Không được dùng dữ liệu giả (hardcode / mock) trong ứng dụng thực tế. Dữ liệu phải được truy vấn thật từ Database/Service.
4. **Giới hạn độ dài file (File Length Limit):**
   - **Tối đa 300 dòng code** cho mỗi file.
   - Khi file tiệm cận hoặc vượt quá 300 dòng, phải chủ động tách nhỏ theo các Pattern: Service, Repository, Trait, Helper, hoặc Component rời để bảo trì Clean Code.

---

## 🔄 ĐIỀU 2: QUY TRÌNH COMMIT VÀ ĐỒNG BỘ
1. **Commit thường xuyên (Atomic Commits):**
   - Thực hiện commit ngay sau khi hoàn thành xong từng tính năng nhỏ hoặc từng bài test vượt qua.
   - Thông điệp commit phải tuân thủ chuẩn **Conventional Commits**: `feat:`, `fix:`, `test:`, `refactor:`, `style:`.
2. **Đồng bộ với CI/CD:**
   - Trước khi push code, phải đảm bảo chạy linter (`vendor/bin/pint --dirty --format agent`) và test suite local để không bị lặp lại lỗi CI (dấu ❌ 0/2).

---

## 🔒 ĐIỀU 3: KHOÁ PHẠM VI CHỈNH SỬA (SCOPE LOCK)
1. **Cấm chạm vào code không liên quan:**
   - AI chỉ được thao tác trong phạm vi các file/module được yêu cầu trực tiếp.
   - Không được sửa file cấu hình chung, các module đang chạy ổn định của người khác nếu không thuộc task.
2. **Cấm viết lại logic module khác:**
   - Tuyệt đối không được refactor hoặc viết lại (rewrite) logic của các class/function bên ngoài Scope task được giao.
   - Phải tái sử dụng (reuse) Interface, Service, Helper hiện có thay vì tự tạo lại logic trùng lặp.

---

## 🧹 ĐIỀU 4: DỌN DẸP SCRIPT VÀ TÀI NGUYÊN RÁC TỰ ĐỘNG
1. **Không tạo Script rác:**
   - Không tạo các file script tạm, file test chạy thử (`test.php`, `tinker_script.php`, `temp_debug.js`) ở thư mục gốc hoặc trong dự án.
2. **Tự động làm sạch:**
   - Nếu bắt buộc phải tạo tài nguyên tạm trong quá trình debug, phải tạo trong thư mục scratch được chỉ định và xóa bỏ/dọn dẹp ngay sau khi hoàn thành task.
   - Không để lại comment code thừa, `var_dump()`, `dd()`, `console.log()` hoặc các đoạn code thử nghiệm bị disable.

---

## 🧪 ĐIỀU 5: NGUYÊN TẮC KIỂM THỬ (E2E & INTEGRATION TESTING)
1. **Mô phỏng hành vi người dùng thật:**
   - Viết các kịch bản test (Feature Test, E2E Test) mô phỏng chính xác hành vi nhập liệu, click chuột, tương tác HTTP request thực tế từ phía Client/Browser.
2. **Nghiêm cấm "Sửa Test để vượt qua lỗi Code" (No Test Fraud):**
   - **TẠI BẤT KỲ THỜI ĐIỂM NÀO:** Khi Test bị FAILED, AI **KHÔNG ĐƯỢC PHÁP** sửa assertion, hạ thấp tiêu chuẩn test, hoặc đổi mock data để bài test báo XANH (PASSED) giả tạo.
   - Phải truy tìm đến cùng **Logic Bug** trong ứng dụng thực tế và sửa lỗi logic đó cho tới khi bài test vượt qua một cách khách quan và chính xác.

---

> **CAM KẾT:** AI Agent phải đọc và áp dụng nghiêm ngặt tất cả các điều khoản trên trong mọi lượt tương tác và xử lý mã nguồn!
