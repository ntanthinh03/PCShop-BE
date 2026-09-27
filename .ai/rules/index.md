# AI Agent Strict Rules & Behavior Contract

## 📜 HỢP ĐỒNG KHÓA CHẶT HÀNH VI AI AGENT & VÒNG ĐỜI PHÁT TRIỂN (SDLC)

Dự án này tuân thủ nghiêm ngặt 2 tài liệu quy chuẩn bắt buộc cho AI Agent:
1. 📖 **[Hợp đồng khóa chặt hành vi AI (ai_contract.md)](file:///c:/laragon/www/ShopFlow/.ai/rules/ai_contract.md)**
2. 🔄 **[Vòng đời phát triển tự động 6 bước (sdlc_lifecycle.md)](file:///c:/laragon/www/ShopFlow/.ai/rules/sdlc_lifecycle.md)**

---

### 🛑 1. Tóm tắt Hợp đồng khóa chặt hành vi AI (ai_contract.md)
- **Schema & API:** Đúng contract RESTful/GraphQL, cấm đổi Tech Stack (PHP 8.3, Laravel, PostgreSQL, Docker,...).
- **Cấm Mock Data:** Không dùng data giả trong production code.
- **Giới hạn 300 dòng/file:** Phải tách nhỏ Service/Repository khi file tiệm cận 300 dòng.
- **CommitPolicy:** Commit thường xuyên (Atomic Commits), format code bằng Pint trước khi push.
- **Scope Lock:** Không sửa code/module ngoài phạm vi task được giao; không tự ý rewrite logic hiện có.
- **Dọn dẹp rác:** Không để lại file test tạm, comment rác, `dd()`, `var_dump()`.
- **Nghiêm cấm gian lận Test:** Không được sửa lại assertion/test data để vượt qua test khi code bị lỗi logic.

---

### 🔄 2. Quy trình 6 bước Vòng đời phát triển tự động (sdlc_lifecycle.md)
1. **Lập kế hoạch:** Thu thập pain point thật -> Viết **Proto-Spec**.
2. **Thiết kế:** Gộp Yêu cầu + UI/UX + Schema API trong **1 phiên**, tổ chức theo Skills.
3. **Xây dựng:** Chạy Plan Mode -> Kỹ sư duyệt Plan -> Code dưới các rào chắn (Hooks & Rules).
4. **Kiểm thử:** Viết E2E/Feature test mô phỏng thực tế -> Agent tự tìm root cause & sửa lỗi nghiệp vụ chuẩn xác. **CẤM GIAN LẬN TEST:** Không sửa câu lệnh test (assertions) và không viết code logic giả/bypass để ép pass test.
5. **Triển khai:** Review nhiều lớp (Lint, Scope, CI) -> Kỹ sư duyệt code quan trọng -> Deploy.
6. **Vận hành:** Giám sát, thu thập phản hồi -> **Lặp lại quay về Bước 1**.

