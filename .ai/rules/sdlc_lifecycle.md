# 🔄 QUY TRÌNH VÒNG ĐỜI PHÁT TRIỂN TỰ ĐỘNG (AUTOMATED SDLC LIFECYCLE)

> **CĂN CỨ:** Quy trình này được tích hợp hoàn toàn với Hợp đồng hành vi AI Agent tại [ai_contract.md](file:///c:/laragon/www/ShopFlow/.ai/rules/ai_contract.md) và áp dụng cho tất cả các tính năng trong tương lai.

---

## 🔁 6 BƯỚC TRONG VÒNG ĐỜI PHÁT TRIỂN TỰ ĐỘNG

### 🎯 Bước 1: Lập kế hoạch (Planning & Requirements)
- **Nguồn dữ liệu:** AI chủ động thu thập và tổng hợp Pain Points, User Stories từ thực tế (Log lỗi, phản hồi người dùng, hoặc file yêu cầu dự án).
- **Sản phẩm đầu ra:** Viết bản **Proto-Spec** (Specification sơ bộ) mô tả chi tiết:
  - Vấn đề cần giải quyết.
  - Mục tiêu tính năng.
  - Phân tích rủi ro & ràng buộc hệ thống.

### 🎨 Bước 2: Thiết kế (Single-Session Design & Architecture)
- **Hợp nhất phiên:** Gộp toàn bộ Yêu cầu + Thiết kế giao diện + Cấu trúc dữ liệu vào **1 phiên làm việc duy nhất**.
- **Tổ chức theo Skills:** Áp dụng chặt chẽ các skill của hệ thống (như `laravel-best-practices`, `tailwindcss-development`,...):
  - Thiết kế Schema Database (Migrations, Models).
  - Định nghĩa chuẩn RESTful/GraphQL API endpoints.
  - Thiết kế luồng dữ liệu & UI/UX (Clean Architecture).

### 🛠️ Bước 3: Xây dựng & Lập trình (Plan Mode & Controlled Execution)
- **Kế hoạch trước khi gõ code:** AI chuyển sang **Plan Mode** để lập Implementation Plan chi tiết từng bước.
- **Kỹ sư phê duyệt (Human-in-the-loop):** Kỹ sư/User duyệt bản Plan trước khi AI bắt đầu ghi mã nguồn.
- **Chốt chặn Hooks & Rules:** Quá trình viết code bị rào chặt bởi 4 quy tắc khóa tại `ai_contract.md`:
  - 🛑 *Cấm đổi Tech Stack, Cấm Mock Data.*
  - 📏 *Mỗi file tối đa 300 dòng code.*
  - 🔒 *Scope Lock: Không đụng vào code/module không liên quan.*
  - 💾 *Atomic Commits: Commit liên tục theo từng step.*

### 🧪 Bước 4: Kiểm thử tự động & Tự sửa lỗi (Self-Healing Testing Gate)
- **Viết Test E2E / Feature Test:** Tạo các kịch bản test mô phỏng thực tế tương tác người dùng (nhập liệu, gửi request, click chuột).
- **Cơ chế Tự sửa lỗi chuẩn xác (Self-Healing):**
  - Khi Test FAILED, AI tự đọc Traceback log để tìm đúng **nguyên nhân gốc rễ (Root Cause)** và khắc phục lỗi thực sự trong hệ thống.
- **🛑 KHÓA CHẶT QUY TẮC NGHƯƠNG CẤM GIAN LẬN TEST (STRICT NO TEST FRAUD):**
  - **Cấm sửa lại câu lệnh Test (Assertions/Test Cases):** Không được sửa đổi kỳ vọng (expectations/assertions), hạ thấp tiêu chuẩn test hoặc đổi mock data chỉ để test báo XANH (PASSED).
  - **Cấm sửa bậy Code Logic:** Không được viết code logic giả, bypass câu lệnh `if/else`, swallow exception, hay bypass nghiệp vụ để ép test chạy qua. Code logic ứng dụng phải được giải quyết đúng yêu cầu thực tế của sản phẩm.

### 🚀 Bước 5: Triển khai & Review nhiều lớp (Multi-Layer Code Review & Deployment)
- **Review nhiều lớp (Multi-Layer Review):**
  - *Lớp 1 (Syntax & Style):* Tự động format chuẩn bằng `vendor/bin/pint --dirty --format agent`.
  - *Lớp 2 (Quality & Safety):* Kiểm tra lại phạm vi thay đổi (Scope Check) và kiểm thử CI/CD.
- **Phê duyệt mã nguồn:** Kỹ sư/User chỉ cần duyệt phần code logic quan trọng (Core Business Logic) trước khi Merge/Deploy.

### 📡 Bước 6: Vận hành & Giám sát (Operations & Continuous Loop)
- Giám sát ứng dụng sau khi triển khai, thu thập log/metric phản hồi.
- 🔁 **LẶP LẠI VÒNG ĐỜI:** Khi có tính năng mới hoặc yêu cầu cải tiến, quay trở lại **Bước 1**.

---

> **QUY ĐỊNH THI HÀNH:** Mọi task phát triển tính năng mới từ thời điểm này sẽ tự động tuân thủ 100% theo 6 bước Lifecycle nêu trên.
