-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th6 02, 2026 lúc 11:02 AM
-- Phiên bản máy phục vụ: 10.11.14-MariaDB-cll-lve
-- Phiên bản PHP: 8.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `ywvpewmp_tinhoc`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `answers_mcq`
--

CREATE TABLE `answers_mcq` (
  `question_id` int(11) NOT NULL,
  `opt_a` mediumtext DEFAULT NULL,
  `opt_b` mediumtext DEFAULT NULL,
  `opt_c` mediumtext DEFAULT NULL,
  `opt_d` mediumtext DEFAULT NULL,
  `correct_opt` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `answers_mcq`
--

INSERT INTO `answers_mcq` (`question_id`, `opt_a`, `opt_b`, `opt_c`, `opt_d`, `correct_opt`) VALUES
(197, 'Xe tự hành sử dụng hệ thống cảm biến và phân tích dữ liệu.', 'Đèn giao thông điều chỉnh theo giờ cố định.', 'Máy hút bụi hoạt động bằng tay.', 'Đồng hồ báo thức chỉ kêu vào giờ được cài đặt sẵn.', 'A'),
(198, 'Y tế, giáo dục, giao thông.', 'Thủ công mỹ nghệ, nông nghiệp truyền thống.', 'Khai thác khoáng sản bằng tay.', 'Thể thao không sử dụng công nghệ.', 'A'),
(199, 'Vì AI có khả năng học hỏi từ dữ liệu, suy luận và đưa ra quyết định giống con người.', 'Vì AI được lập trình để hoạt động nhanh hơn bất kỳ cỗ máy nào khác.', 'Vì AI có thể làm việc mà không cần bất kỳ sự hướng dẫn nào từ con người.', 'Vì AI có trí thông minh cao hơn con người trong mọi lĩnh vực.', 'A'),
(200, 'AI hỗ trợ giải quyết các công việc phức tạp nhanh hơn, nhưng cũng đặt ra lo ngại về quyền riêng tư và mất việc làm.', 'AI chỉ mang lại lợi ích tích cực, không có bất kỳ tác động tiêu cực nào.', 'AI giúp giảm chi phí lao động nhưng không ảnh hưởng đến bất kỳ ai trong xã hội.', 'AI làm cho con người phụ thuộc hoàn toàn và không còn khả năng suy nghĩ độc lập.', 'A'),
(201, 'Một loại mạng không dây', 'Một loại mạng có dây', 'Một loại mạng LAN', 'Một loại mạng WAN', 'A'),
(202, 'Kết nối toàn cầu', 'Chia sẻ tài nguyên', 'Chia sẻ dữ liệu', 'Chia sẻ kết nối Internet', 'A'),
(203, 'Mạng WAN', 'Mạng LAN', 'Mạng MAN', 'Mạng PAN', 'A'),
(204, 'Read.', 'Không cần cài đặt chế độ.', 'Change.', 'Full Control.', 'A'),
(205, '<html>', '<body>', '<head>', '<header>', 'A'),
(206, '<link> URL </link>', '<a href=\"URL\"> văn bản </a>', '<hyperlink> URL </hyperlink>', '<url href=\"văn bản\"> </url>', 'B'),
(207, 'link.', 'title.', 'src.', 'alt.', 'D'),
(208, '<link rel=“stylesheet” src=“styles.css”>.', '<link rel=“stylesheet” link=“styles.css”>.', '<link rel=“stylesheet” href=“styles.css”>.', '<link rel=“stylesheet” url=“styles.css”>.', 'C'),
(209, 'h1 {color: red;}', 'p {text-indent: 15px; color: blue;}', 'div {background: yellow;}', 'a {font-size: 14px;}', 'B'),
(210, '<input type=“text” name=“txt”>.', '<textfield name=“txt”>.', '<textinput name=“txt”>.', '<input type=“txtfield” name=“txt”>.', 'A'),
(211, '<a href=\"folder/page.html\">Trang mới</a>', '<a href=\"folder://page.html\">Trang mới</a>', '<a src=\"folder/page.html\">Trang mới</a>', '<a link=\"folder/page.html\">Trang mới</a>', 'A'),
(212, 'type=\"date\"', 'type=\"datetime-local\"', 'type=\"text\"', 'type=\"number\"', 'A'),
(213, 'Việc sử dụng công nghệ để lợi dụng người khác.', 'Tôn trọng quyền riêng tư và sự công bằng giữa mọi người.', 'Việc phát tán thông tin sai lệch để thu hút sự chú ý.', 'Sử dụng các công cụ mạng để phá hoại.', 'B'),
(214, 'Vì nó giúp giảm thiểu các mối đe dọa từ công nghệ.', 'Vì nó bảo vệ quyền lợi của mọi người và tạo môi trường mạng an toàn.', 'Vì nó có thể tạo ra lợi ích về kinh tế cho cá nhân.', 'Vì nó không ảnh hưởng đến quyền tự do của người sử dụng mạng.', 'B'),
(215, 'Lập tức chia sẻ lại thông tin để mọi người cùng biết và giúp đỡ bạn.', 'Nhắn tin riêng khuyên bạn tự đăng hoàn cảnh của mình để nhận hỗ trợ.', 'Liên hệ tác giả chủ bài viết để gỡ bài viết, đồng thời liên hệ động viên bạn mình.', 'Bình luận phản đối việc tiết lộ thông tin cá nhân mà không được sự đồng ý.', 'C'),
(216, 'Thiết kế đồ họa', 'Quản lý và duy trì hệ thống mạng', 'Lập trình phần mềm ứng dụng', 'Kiểm thử phần mềm', 'B'),
(217, 'Phát triển web', 'Tối ưu hóa công cụ tìm kiếm (SEO)', 'Phương thức tấn công mạng như DoS', 'Thiết kế giao diện người dùng', 'C'),
(218, 'Phát triển phần mềm mới', 'Quản lý hệ điều hành và xử lý sự cố hệ thống', 'Thiết kế ứng dụng di động', 'Tiếp thị kỹ thuật số', 'B'),
(219, '<table class=\"w-full border-collapse border border-slate-300 mt-2 mb-2\">\r\n  <tbody>\r\n    <tr>\r\n      <td class=\"border border-slate-300 px-4 py-3 align-top\">&lt;table&gt;<br>  &lt;tr&gt;&lt;td&gt;Cell 1&lt;/td&gt;&lt;td&gt;Cell 2&lt;/td&gt;&lt;/tr&gt;<br>  &lt;tr&gt;&lt;td&gt;Cell 3&lt;/td&gt;&lt;td&gt;Cell 4&lt;/td&gt;&lt;/tr&gt;<br>  &lt;tr&gt;&lt;td&gt;Cell 5&lt;/td&gt;&lt;td&gt;Cell 6&lt;/td&gt;&lt;/tr&gt;<br>&lt;/table&gt;</td>\r\n    </tr>\r\n  </tbody>\r\n</table>\r\n', '<table class=\"w-full border-collapse border border-slate-300 mt-2 mb-2\">\r\n  <tbody>\r\n    <tr>\r\n      <td class=\"border border-slate-300 px-4 py-3 align-top\">&lt;table&gt;<br>  &lt;thead&gt;&lt;tr&gt;&lt;th&gt;Header 1&lt;/th&gt;&lt;th&gt;Header 2&lt;/th&gt;&lt;/tr&gt;&lt;/thead&gt;<br>  &lt;tbody&gt;&lt;tr&gt;&lt;td&gt;Cell 1&lt;/td&gt;&lt;td&gt;Cell 2&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;<br>&lt;/table&gt;</td>\r\n    </tr>\r\n  </tbody>\r\n</table>\r\n', '<table class=\"w-full border-collapse border border-slate-300 mt-2 mb-2\">\r\n  <tbody>\r\n    <tr>\r\n      <td class=\"border border-slate-300 px-4 py-3 align-top\">&lt;table&gt;<br>  &lt;tr&gt;&lt;td&gt;Row 1&lt;/td&gt;&lt;/tr&gt;<br>  &lt;tr&gt;&lt;td&gt;Row 2&lt;/td&gt;&lt;/tr&gt;<br>&lt;/table&gt;</td>\r\n    </tr>\r\n  </tbody>\r\n</table>\r\n', '<table class=\"w-full border-collapse border border-slate-300 mt-2 mb-2\">\r\n  <tbody>\r\n    <tr>\r\n      <td class=\"border border-slate-300 px-4 py-3 align-top\">&lt;table&gt;<br>  &lt;tr&gt;&lt;td&gt;Row 1&lt;/td&gt;&lt;td&gt;Row 2&lt;/td&gt;&lt;td&gt;Row 3&lt;/td&gt;&lt;/tr&gt;<br>&lt;/table&gt;</td>\r\n    </tr>\r\n  </tbody>\r\n</table>\r\n', 'A'),
(220, '<table class=\"w-full border-collapse border border-slate-300 mt-2 mb-2\">\r\n  <thead>\r\n    <tr class=\"bg-slate-100\">\r\n      <th class=\"border border-slate-300 px-3 py-2 w-1/3\">Cột 1</th>\r\n      <th class=\"border border-slate-300 px-3 py-2\">Cột 2</th>\r\n    </tr>\r\n  </thead>\r\n  <tbody>\r\n    <tr>\r\n      <td class=\"border border-slate-300 px-3 py-2 font-semibold\">PYTHON</td>\r\n      <td class=\"border border-slate-300 px-3 py-2\">sum=0<br>t=45<br>while t&lt;100:<br>  sum=sum+t<br>  t=t+2<br>print(\'Tong =\',sum)</td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\"border border-slate-300 px-3 py-2 font-semibold\">C++</td>\r\n      <td class=\"border border-slate-300 px-3 py-2\">int main() {<br>    int sum = 0;<br>    int t = 45;<br>    while (t &lt; 100) {<br>        sum += t;<br>        t += 2;<br>    }<br>    cout &lt;&lt; \"Tong = \" &lt;&lt; sum &lt;&lt; endl;<br>    return 0;<br>}</td>\r\n    </tr>\r\n  </tbody>\r\n</table>\r\n', '<table class=\"w-full border-collapse border border-slate-300 mt-2 mb-2\">\r\n  <thead>\r\n    <tr class=\"bg-slate-100\">\r\n      <th class=\"border border-slate-300 px-3 py-2 w-1/3\">Cột 1</th>\r\n      <th class=\"border border-slate-300 px-3 py-2\">Cột 2</th>\r\n    </tr>\r\n  </thead>\r\n  <tbody>\r\n    <tr>\r\n      <td class=\"border border-slate-300 px-3 py-2 font-semibold\">PYTHON</td>\r\n      <td class=\"border border-slate-300 px-3 py-2\">sum=0<br>t=45<br>while t&lt;100:<br>  t=t+2<br>  sum=sum+t<br>print(\'Tong =\',sum)</td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\"border border-slate-300 px-3 py-2 font-semibold\">C++</td>\r\n      <td class=\"border border-slate-300 px-3 py-2\">int main() {<br>    int sum = 0;<br>    int t = 45;<br>    while (t &lt; 100) {<br>        t += 2;<br>        sum += t;<br>    }<br>    cout &lt;&lt; \"Tong = \" &lt;&lt; sum &lt;&lt; endl;<br>    return 0;<br>}</td>\r\n    </tr>\r\n  </tbody>\r\n</table>\r\n', '<table class=\"w-full border-collapse border border-slate-300 mt-2 mb-2\">\r\n  <thead>\r\n    <tr class=\"bg-slate-100\">\r\n      <th class=\"border border-slate-300 px-3 py-2 w-1/3\">Cột 1</th>\r\n      <th class=\"border border-slate-300 px-3 py-2\">Cột 2</th>\r\n    </tr>\r\n  </thead>\r\n  <tbody>\r\n    <tr>\r\n      <td class=\"border border-slate-300 px-3 py-2 font-semibold\">PYTHON</td>\r\n      <td class=\"border border-slate-300 px-3 py-2\">sum=0<br>t=45<br>while t&lt;100:<br>  t=t+1<br>  sum=sum+t<br>print(\'Tong =\',sum)</td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\"border border-slate-300 px-3 py-2 font-semibold\">C++</td>\r\n      <td class=\"border border-slate-300 px-3 py-2\">int main() {<br>    int sum = 0;<br>    int t = 45;<br>    while (t &lt; 100) {<br>        t += 1;<br>        sum += t;<br>    }<br>    cout &lt;&lt; \"Tong = \" &lt;&lt; sum &lt;&lt; endl;<br>    return 0;<br>}</td>\r\n    </tr>\r\n  </tbody>\r\n</table>\r\n', '<table class=\"w-full border-collapse border border-slate-300 mt-2 mb-2\">\r\n  <thead>\r\n    <tr class=\"bg-slate-100\">\r\n      <th class=\"border border-slate-300 px-3 py-2 w-1/3\">Cột 1</th>\r\n      <th class=\"border border-slate-300 px-3 py-2\">Cột 2</th>\r\n    </tr>\r\n  </thead>\r\n  <tbody>\r\n    <tr>\r\n      <td class=\"border border-slate-300 px-3 py-2 font-semibold\">PYTHON</td>\r\n      <td class=\"border border-slate-300 px-3 py-2\">sum=0<br>t=45<br>while t&lt;100:<br>  sum=sum+t<br>  t=t+1<br>print(\'Tong =\',sum)</td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\"border border-slate-300 px-3 py-2 font-semibold\">C++</td>\r\n      <td class=\"border border-slate-300 px-3 py-2\">int main() {<br>    int sum = 0;<br>    int t = 45;<br>    while (t &lt; 100) {<br>        sum += t;<br>        t += 1;<br>    }<br>    cout &lt;&lt; \"Tong = \" &lt;&lt; sum &lt;&lt; endl;<br>    return 0;<br>}</td>\r\n    </tr>\r\n  </tbody>\r\n</table>\r\n', 'A'),
(225, 'Mở khóa điện thoại thông minh.', 'Kiểm soát ra vào tòa nhà.', 'Đóng mở cửa ra vào các nhà hàng, siêu thị hay phòng chờ ở nhà ga, bến tàu…', 'Xác minh danh tính tại sân bay.', 'C'),
(226, 'Thúc đẩy sự cạnh tranh lành mạnh giữa các công ty công nghệ.', 'Không gây ra vấn đề gì nếu được kiểm soát bởi chính phủ.', 'Tạo ra lo ngại về an ninh do thiếu minh bạch.', 'Thúc đẩy sự tiến bộ công nghệ một cách nhanh chóng.', 'C'),
(227, 'AI Hẹp (ANI) và AI Siêu Thông Minh (ASI).', 'AI Hẹp (ANI) và AI Tổng quát (AGI).', 'AI Tổng quát (AGI) và AI tự học (ALI).', 'AI Tổng quát (AGI) và AI Siêu Thông Minh (ASI).', 'B'),
(228, 'Xử lí hoá đơn trong giao dịch thương mại điện tử.', 'Dự đoán thời tiết.', 'Xác minh chữ kí trong các giao dịch điện tử.', 'Nhập dữ liệu tự động.', 'B'),
(229, 'Cáp mạng.', 'Access Point.', 'Router.', 'Switch.', 'B'),
(230, 'Modem.', 'Switch.', 'Access Point.', 'Router.', 'D'),
(231, 'Kết nối các thiết bị với nhau theo mô mạng hình sao.', 'Cho phép kết nối nhiều thiết bị vào mạng.', 'Kết nối các thiết bị không dây vào mạng.', 'Kết nối các máy tính trong cùng mạng LAN.', 'C'),
(232, 'Modem.', 'Switch.', 'Router', 'Access point.', 'A'),
(233, '<div>', '<span>', '<p>', '<section>', 'C'),
(234, 'type', 'list-style-type', 'start', 'bullet-type', 'B'),
(235, 'colspan và rowspan', 'mergecell', 'span', 'cellmerge', 'A'),
(236, 'nutlenh {color: blue; background-color: grey;}', '*nutlenh {color: blue; background-color: grey;}', '#nutlenh {color: blue; background-color: grey;}', '^nutlenh {color: blue; background-color: grey;}', 'C'),
(237, 'h3 {font-size: 20px; color: grey', 'p. h4 font-size: 20px; color: red;}', 'a {color: red;})', '#dautrang background-color: yellow; font-family: \"Arial\")', 'D'),
(238, 'tieude {font-size: 20px; font-family: \"Arial\";}', '!tieude {font-size: 20px; font-family: \"Arial\";}', '*tieude {font-size: 20px; font-family: \"Arial\";}', '^tieude {font-size: 20px; font-family: \"Arial\";}', 'A'),
(239, 'h1, h2 h3 {color: red;}', 'h1, h2, h3 {color: red;}', 'h1 h2, h3 {color: red;}', 'h1 h2 h3 {color: red;}', 'B'),
(240, '<style> p {color: green;} </style>', '<link rel=\"stylesheet\" href=\"styles.css\">', '<p style=\"color: green;\">Text</p>', 'h1 {color: green;}', 'C'),
(241, 'h1 {color: red;}', 'p {text-indent: 15px; color: blue;}', 'div {background: yellow;}', 'a {font-size: 14px;}', 'B'),
(242, 'Mạng xã hội.', 'Diễn đàn trực tuyến.', 'Thư giấy.', 'FaceTime.', 'C'),
(243, 'Tăng sự gần gũi và tương tác', 'Gây xa cách và độc lập', 'Không ảnh hưởng đến mối quan hệ', 'Tùy thuộc vào hoàn cảnh cụ thể', 'A'),
(244, 'Giấu', 'Bảo vệ', 'Chia sẻ', 'Giữ bí mật', 'C'),
(245, 'Lên kế hoạch cho việc nâng cấp và bảo trì thiết bị', 'Sửa chữa lỗ hổng an toàn thông tin', 'Lập và triển khai thực hiện kế hoạch xử lí sự cố an toàn thông tin', 'Thiết lập và hướng dẫn các quy định an toàn thông tin cho người dùng.', 'A'),
(246, 'An toàn thông tin', 'Quản trị mạng', 'Quản trị vào bảo trì hệ thống', 'Kĩ thuật viên an toàn thông tin', 'A'),
(247, 'hệ điều hành; hệ thống mạng và một số giao thức mạng; cơ sở dữ liệu và các nền tảng ứng dụng; bảo mật, mã hoá, tường lửa, các công cụ phát hiện xâm nhập,...', 'Phần cứng máy tính; các loại thiết bị mạng; hệ thống mạng; một số giao thức mạng và các dịch vụ mạng phổ biến; an toàn an ninh mạng', 'Phần cứng máy tính và thiết bị số; phần mềm hệ thống (hệ điều hành và các phần mềm tiện ích liên quan); mạng máy tính và Internet', 'Hệ thống thông tin; các nền tảng ứng dụng; hệ thống mạng và an toàn thông tin.', 'A'),
(248, '0', '1', '4', '5', 'D'),
(253, 'Khả năng hiểu ngôn ngữ.', 'Khả năng suy luận.', 'Khả năng học.', 'Khả năng xử lý tình huống.', 'D'),
(254, 'Là một hệ thống AI tạo sinh.', 'Có thể tạo ra văn bản hoặc âm thanh.', 'ChatGPT là ví dụ về AI mạnh.', 'Có thể giải các bài toán phức tạp.', 'C'),
(255, 'Giúp chẩn đoán bệnh.', 'Giúp lập phác đồ điều trị.', 'Dự đoán được sự tiến triển của bệnh.', 'Tạo ra thuốc chữa bệnh theo yêu cầu.', 'D'),
(256, 'Mạng diện rộng.', 'Mạng cục bộ.', 'Mạng cục bộ không dây.', 'Mạng LAN.', 'C'),
(257, 'Một phần mềm.', 'Một giao thức.', 'Một loại cáp.', 'Một mạng Internet.', 'B'),
(258, 'LAN là loại mạng kết nối các thiết bị khác nhau có phạm vi địa lý rộng lớn, như một thành phố, một quốc gia.', 'WLAN là mạng cục bộ sử dụng công nghệ không dây, cho phép kết nối các thiết bị mà không cần sử dụng dây cáp.', 'WAN là mạng kết nối những máy tính và các thiết bị số trong một phạm vi nhỏ như phòng thực hành.', 'Internet là mạng máy tính chỉ cho phép các máy tính và thiết bị khác kết nối trong phạm vi một quốc gia.', 'B'),
(259, 'Địa chỉ IP cho biết loại máy tính kết nối vào mạng.', 'Mỗi máy tính tham gia vào mạng Internet phải có một địa chỉ duy nhất.', 'IPv4 và IPv8 là hai phiên bản địa chỉ IP phổ biến hiện nay.', 'Các máy tính tham gia vào mạng Internet không cần địa chỉ IP.', 'B'),
(260, '13 dây cáp quang.', 'Một Modem mạng.', '13 dây cáp xoắn đôi có 2 đầu RJ45.', 'Một Switch 16 cổng kết nối.', 'A'),
(261, 'Tiết kiệm thời gian và chi phí.', 'Mở rộng kết nối xã hội.', 'Khó xảy ra hiểu lầm.', 'Công cụ giao tiếp đa dạng.', 'C'),
(262, 'Lắng nghe và tôn trọng ý kiến của người khác.', 'Cẩn trọng với ngôn từ và cách viết.', 'Tự kiểm tra, cải thiện hành vi trực tiếp của mình.', 'Đặt mình vào vị trí của người khác.', 'C'),
(263, 'Lập tức chia sẻ lại thông tin để mọi người cùng biết và giúp đỡ bạn B.', 'Nhắn tin riêng khuyên bạn B tự đăng hoàn cảnh của mình để nhận hỗ trợ.', 'Báo cáo với quản trị viên để ẩn bài viết, đồng thời liên hệ động viên bạn B.', 'Bình luận phản đối việc tiết lộ thông tin cá nhân mà không được sự đồng ý.', 'C'),
(264, 'src.', 'href.', 'link.', 'url.', 'A'),
(265, 'h1 { color: red; }.', 'h1 { background: red; }.', 'h1 { font-color: red; }.', 'h1 { text-color: red; }.', 'A'),
(266, '<ul>.', '<ol>.', '<li>.', '<dl>.', 'A'),
(267, '<video src=\"youtube.com/abc\"></video>.', '<iframe src=\"youtube.com/embed/abc\"></iframe>.', '<embed url=\"youtube.com/abc\"></embed>.', '<link href=\"youtube.com/abc\"></link>.', 'A'),
(268, 'Khi muốn nhóm các nội dung không liên quan lại với nhau.', 'Khi muốn tạo một phần nội dung độc lập và có ý nghĩa riêng biệt.', 'Khi muốn chèn một đoạn văn bản.', 'Khi muốn tạo một liên kết đến trang khác.', 'C'),
(269, 'color', 'background-color', 'border-color', 'font-color', 'B'),
(270, 'Sửa chữa ổ cứng.', 'Lập trình ứng dụng di động.', 'Lắp đặt mạng LAN.', 'Bảo trì máy in.', 'B'),
(271, 'Nhu cầu xử lý dữ liệu lớn.', 'Máy tính cá nhân giảm giá.', 'Phần mềm miễn phí tăng.', 'Mạng xã hội phổ biến.', 'A'),
(272, 'Các công ty muốn giảm chi phí đào tạo nhân viên.', 'Sự bùng nổ của dữ liệu lớn (Big Data) và nhu cầu phân tích dữ liệu để đưa ra quyết định kinh doanh.', 'Sự phổ biến của các thiết bị điện tử cá nhân như điện thoại thông minh.', 'Các trường học yêu cầu học sinh học lập trình từ sớm.', 'B'),
(273, 'Dòng 5', 'Dòng 6', 'Dòng 7', 'Dòng 8', 'B'),
(274, '```html\r\n<ul>\r\n  <li>Mục 1</li>\r\n  <li>Mục 2</li>\r\n  <li>Mục 3</li>\r\n</ul>\r\n```\r\n', '```html\r\n<ol>\r\n  <li>Mục 1</li>\r\n  <li>Mục 2</li>\r\n  <li>Mục 3</li>\r\n</ol>\r\n\r\n\r\n```\r\n', '```html\r\n<list>\r\n  <li>Mục 1</li>\r\n  <li>Mục 2</li>\r\n  <li>Mục 3</li>\r\n</list>\r\n\r\n\r\n```\r\n', '```html\r\n<ordered>\r\n  <li>Mục 1</li>\r\n  <li>Mục 2</li>\r\n  <li>Mục 3</li>\r\n</ordered>\r\n\r\n\r\n```\r\n', 'B'),
(275, '200px', '240px', '260px', '300px', 'C'),
(276, '10', '6', '15', '0', 'A'),
(309, '1 → 2 → 3\r\n', '1 → 3 → 2\r\n', '2 → 3 → 1\r\n', ' 3 → 1 → 2\r\n', 'D'),
(310, 'Chữ màu đỏ, kích thước 16px.', 'Chữ màu đỏ, kích thước 18px.\r\n', 'Chữ màu xanh dương, kích thước 16px.\r\n', 'Chữ màu xanh dương, kích thước 18px.\r\n', 'D'),
(311, '5', '56', '55', '54', 'C'),
(312, 'Chỉ giúp định dạng nội dung văn bản.', 'Không ảnh hưởng đến cấu trúc của trang web.', 'Giúp trang web trở nên đẹp mắt hơn.', 'Cho phép tách biệt nội dung khỏi cách trình bày.', 'D'),
(313, '<img src=\"icon.png\" alt=\"Biểu tượng\" width=\"20\" height=\"20\">', '<icon src=\"icon.png\" alt=\"Biểu tượng\" width=\"20\" height=\"20\"></icon>', '<img href=\"icon.png\" alt=\"Biểu tượng\" size=\"20\">', '<image src=\"icon.png\" alt=\"Biểu tượng\" width=\"20\" height=\"20\"></image>', 'A'),
(314, '<ol type=\"A\" start=\"3\"><li>Nội dung</li></ol>', '<ol type=\"A\" start=\"C\"><li>Nội dung</li></ol>', '<ol type=\"C\"><li>Nội dung</li></ol>', '<ul type=\"A\" start=\"C\"><li>Nội dung</li></ul>', 'A'),
(315, '<link rel=\"stylesheet\" href=\"tên_tệp.css\">', '<style src=\"tên_tệp.css\"></style>', '<script src=\"tên_tệp.css\"></script>', '<stylesheet href=\"tên_tệp.css\"></stylesheet>', 'A'),
(316, '<table><td><tr>Dòng 1</tr><tr>Dòng 2</tr></td></table>', '<table><tr><td>Dòng 1</td><td>Dòng 2</td></tr></table>', '<table><td>Dòng 1</td><td>Dòng 2</td></table>', '<table><tr><td>Dòng 1</td></tr><tr><td>Dòng 2</td></tr></table>', 'D'),
(317, 'Phản đối hành vi tiêu cực trực tuyến.', 'Sử dụng deepfake để cảnh báo về lừa đảo.', 'Mạo danh người khác chiếm đoạt tài khoản để lừa đảo.', 'Bày tỏ sự đồng cảm với những người gặp khó khăn.', 'C'),
(318, 'Tham gia một lớp học ngoại ngữ trực tuyến qua mạng.', 'Làm lây lan virus qua mạng.', 'Chia sẻ phần mềm nguồn mở cho bạn bè học tập.', 'Gửi email cho bạn bè trong lớp mà thiếu tiêu đề.', 'B'),
(319, 'Bảo vệ trẻ em trên môi trường mạng.', 'Quảng cáo sản phẩm game sai sự thật.', 'Bản quyền phần mềm thiết kế game.', 'Quản lý nội dung của trò chơi trực tuyến.', 'A'),
(320, 'Kỹ thuật viên công nghệ thông tin', 'Kỹ sư an toàn thông tin', 'Kỹ sư phần mềm', 'Kỹ sư quản trị mạng', 'C'),
(321, 'Mạng máy tính và truyền thông dữ liệu', 'Công nghiệp phần mềm', 'Quản trị cơ sở dữ liệu', 'Trí tuệ nhân tạo', 'D'),
(322, 'Nhà phân tích dữ liệu', 'Kĩ sư điện toán đám mây', 'Kiểm thử viên', 'Người quản lí kiểm thử', 'D'),
(323, 'AI có khả năng tạo ra nội dung từ dữ liệu đã có.', 'AI có khả năng tự học hỏi mà không cần sự can thiệp của con người.', 'AI có khả năng giao tiếp với con người bằng ngôn ngữ tự nhiên.', 'AI có khả năng nhận thức môi trường xung quanh.', 'A'),
(324, 'Lĩnh vực nghiên cứu các mô hình ngôn ngữ.', 'Lĩnh vực nghiên cứu xử lý hình ảnh kỹ thuật số.', 'Lĩnh vực nghiên cứu học máy.', 'Lĩnh vực nghiên cứu tạo nội dung văn bản.', 'B'),
(325, 'Giao tiếp với người dùng bằng văn bản hoặc tiếng nói.', 'Thay thế hoàn toàn các nhân viên chăm sóc khách hàng.', 'Tạo ra nội dung văn bản mới.', 'Điều khiển các thiết bị gia dụng thông minh.', 'A'),
(326, 'Chẩn đoán bệnh và lập phác đồ điều trị.', 'Thực hiện các phẫu thuật phức tạp.', 'Cung cấp thuốc điều trị.', 'Thay thế hoàn toàn các bác sĩ.', 'A'),
(327, 'Một hệ thống các thiết bị số được kết nối với nhau để truyền dữ liệu và trao đổi thông tin.', 'Một hệ thống các máy tính không thể kết nối với nhau.', 'Một thiết bị mạng có chức năng duy nhất là phát sóng Wi-Fi.', 'Một hệ thống chỉ sử dụng để kết nối điện thoại.', 'A'),
(328, 'Switch', 'Router', 'Modem', 'Access Point', 'C'),
(329, 'Chuyển dữ liệu giữa các mạng WAN và LAN.', 'Khuếch đại tín hiệu Wi-Fi và chuyển tiếp dữ liệu cho các thiết bị không dây trong mạng LAN.', 'Giám sát và ghi lại toàn bộ hoạt động truy cập Internet của người dùng.', 'Cấp địa chỉ IP tĩnh cho toàn bộ thiết bị trong mạng.', 'B'),
(330, '<body>', '<footer>', '<head>', '<header>', 'C'),
(331, '<title>', '<header>', '<footer>', '<meta>', 'A'),
(332, 'Tạo các đoạn văn bản', 'Tạo các tiêu đề', 'Tạo các siêu liên kết', 'Tạo các bảng', 'C'),
(337, 'Tăng cường bảo mật thông tin.', 'Giảm sự phụ thuộc vào dữ liệu.', 'Gây ra các vấn đề đạo đức do thiên vị trong dữ liệu.', 'Cải thiện sự minh bạch trong quản lý thông tin.', 'C'),
(338, 'Làm  mọi công việc như con người', 'Thực hiện một nhiệm vụ cụ thể', 'Giải quyết mọi vấn đề trong cuộc', 'Tự học hỏi và tự cải thiện', 'B'),
(339, 'Khả năng học.', 'Khả năng giải quyết vấn đề.', 'Khả năng hiểu ngôn ngữ.', 'Khả năng nhận thức.', 'A'),
(340, 'Sử dụng AI để tự động hóa quy trình kiểm tra chất lượng sản phẩm', 'Sử dụng AI để viết hướng dẫn cho công nhân', 'Đào tạo công nhân vận hành máy móc bằng cách đọc tài liệu AI tạo ra', 'Sử dụng AI để tổ chức vào các buổi họp cho công nhân trong nhà máy', 'A'),
(341, 'Một hệ thống truyền thông không dây.', 'Môi trường được tạo ra nhờ sự kết nối của các mạng máy tính.', 'Nơi chỉ dùng để gọi điện và nhắn tin qua điện thoại.', 'Không gian dành riêng cho việc chơi game.', 'B'),
(342, 'Chỉ trích, công kích cá nhân để giành phần thắng.', 'Phớt lờ và tránh giải quyết vấn đề.', 'Bình tĩnh, lắng nghe và đối thoại một cách tôn trọng.', 'Tạo nhiều tài khoản để gây rối và quấy rối người khác.', 'C'),
(343, 'Mã hóa dữ liệu để đảm bảo an toàn.', 'Định tuyến dữ liệu giữa các thiết bị trong mạng.', 'Chia nhỏ dữ liệu thành các gói để truyền tải.', 'Kiểm tra và phát hiện lỗi trong quá trình truyền dữ liệu.', 'A'),
(344, 'Giúp kiểm soát và ngăn chặn các kết nối không an toàn.', 'Tăng tốc độ truyền dữ liệu trong mạng.', 'Loại bỏ hoàn toàn nguy cơ bị tấn công mạng.', 'Cho phép tất cả các kết nối từ Internet vào mạng nội bộ.', 'A'),
(345, '<list>', '<ul>', '<li>', '<dl>', 'C'),
(346, '<! DOCTYPE html>', '<head>', '<body>', '<p>', 'B'),
(347, '<input type=\"textfield\">\r\n', '<textinput type=\"text\">\r\n', '<input type=\"text\">\r\n', '<textfield>\r\n', 'C'),
(348, 'border-style', 'border', 'border-width', 'border-color', 'D'),
(349, 'background-color = #000000;', 'background-color: #000000;', 'background: color (#000000);', 'color: background (#000000);', 'B'),
(350, 'font: size(16px);', '16px: font-size;', 'font-size: 16px;', 'size: font (16px);', 'C'),
(351, 'border: color (#000000);', '#000000; border-color;', 'border-color: #000000;', 'color: border (#000000);', 'C'),
(352, 'size: 100px 100px;', 'width= 100px; height = 100px;', 'width 100px; height = 100px;', '100px: width; 100px: height;', 'B'),
(353, '<video src=\"caphe.mp4\" width=\"640px\" height=\"380px\" controls>', '<video source=\"caphe.mp4\" width=\"640px\" height=\"380px\" controls>', '<video link=\"caphe.mp4\" width=\"640px\" height=\"380px\" controls>', '<video url=\"caphe.mp4\" width=\"640px\" height=\"380px\" controls>', 'A'),
(354, 'Quyết định số 874-QĐ-BTTTT ngày 17/6/2021.', 'Quyết định số 874-QĐ-BTTTT ngày 17/6/2019.', 'Quyết định số 847-QĐ-BTTTT ngày 17/6/2021.', 'Quyết định số 784-QĐ-BTTTT ngày 17/6/2020.', 'A'),
(355, 'Công kích cá nhân để giành phần thắng.', 'Tránh giải quyết, bỏ qua vấn đề.', 'Tìm cách đối thoại một cách ôn hòa và tôn trọng.', 'Tạo nhiều tài khoản để gây rối và làm phiền người khác.', 'C'),
(356, 'Gửi biểu tượng thể hiện sự không đồng tình.', 'Hỏi Tuấn về quan điểm của anh ấy.', 'Bỏ qua bình luận của Tuấn.', 'Khóa bình luận của Tuấn.', 'B'),
(357, 'Xác định và khắc phục lỗi phần cứng làm cho máy tính của khách hàng ngừng hoạt động.', 'Khắc phục những lỗ hổng về an toàn thông tin.', 'Quản lí, vận hành các thiết bị mạng.', 'Phân tích và xác định nhu cầu của hệ thống thông tin, từ đó thiết lập chính sách và quy trình với người dùng trong hệ thống.', 'A'),
(358, 'Theo dõi, điều chỉnh các thông số cấu hình để mạng đạt được hiệu năng cao nhất.', 'Cài đặt hệ điều hành và các phần mềm tiện ích mạng trên máy chủ và các máy trạm.', 'Cài đặt, vận hành và giám sát các thiết bị mạng.', 'Sửa chữa các thiết bị số bị hỏng hóc về phần cứng chẳng hạn như màn hình, máy in.', 'C'),
(359, 'Công cuộc chuyển đổi số đang làm gia tăng nhanh chóng khối lượng và giá trị của dữ liệu người dùng, nhưng cũng kéo theo sự gia tăng nguy cơ về an ninh mạng.', 'Các phương thức, thủ đoạn tấn công của tin tặc ngày càng tinh vi, phức tạp.', 'Theo thống kê tại Việt Nam cũng như trên toàn thế giới, vụ tấn công mạng vào các cơ quan tổ chức không ngừng gia tăng, năm sau cao hơn năm trước. Những hậu quả, thiệt hại mà chúng gây ra cũng tăng lên nhanh chóng.', 'Nhiều ngành học ở Việt Nam đang đào tạo nhân lực cho nghề Bảo mật hệ thống thông tin như: An ninh mạng, An toàn thông tin, Quản trị và bảo trì hệ thống, Bảo mật hệ thống thông tin.', 'A'),
(360, 'Tìm phần tử có giá trị nhỏ nhất trong mảng. \r\n', 'Tìm phần tử có giá trị lớn nhất trong mảng.\r\n', 'Tìm chỉ số của phần tử có giá trị lớn nhất trong mảng. ', 'Tìm chỉ số của phần tử có giá trị nhỏ nhất trong mảng.\r\n', 'C'),
(365, 'Đèn điều khiển giao thông tự động đổi màu tại ngã tư', 'Máy giặt theo chương trình định trước', 'Thiết bị bay không người lái UAV', 'Máy chụp X-quang trong bệnh viện', 'C'),
(366, 'Tự động hóa quy trình.', 'Nhận diện giọng nói.', 'Tạo năng lượng sinh học.', 'Phân tích dữ liệu lớn.', 'C'),
(367, 'Lưu trữ hồ sơ bệnh án điện tử.', 'Dự đoán nguy cơ mắc bệnh dựa trên dữ liệu gen.', 'Gửi thông báo lịch khám qua SMS.', 'Quản lý danh sách bác sĩ theo chuyên khoa.', 'B'),
(368, 'Tự động hóa dẫn đến thất nghiệp hàng loạt.', 'Sự cạn kiệt tài nguyên thiên nhiên.', 'Lạm dụng dữ liệu cá nhân để thao túng hành vi.', 'Phát tán thông tin giả mạo qua deepfake.', 'B'),
(369, 'Switch.', 'Router.', 'Hub.', 'Access Point.', 'B'),
(370, 'Cáp Ethernet.', 'Switch.', 'Modem.', 'Card mạng.', 'C'),
(371, 'Khuếch đại tín hiệu Wi-Fi và chuyển tiếp dữ liệu cho các thiết bị không dây trong mạng LAN.', 'Chuyển dữ liệu giữa các mạng WAN và LAN.', 'Giám sát và ghi lại toàn bộ hoạt động truy cập Internet của người dùng.', 'Cấp địa chỉ IP tĩnh cho toàn bộ thiết bị trong mạng.', 'A'),
(372, 'head', 'body', 'html', 'meta', 'A'),
(373, '<table class=\"w-full border-collapse border border-slate-300 mt-2 mb-2\">\r\n  <tbody>\r\n    <tr>\r\n      <td class=\"border border-slate-300 px-4 py-3 align-top\">&lt;strong&gt;Nội dung&lt;/strong&gt;</td>\r\n    </tr>\r\n  </tbody>\r\n</table>\r\n', '<table class=\"w-full border-collapse border border-slate-300 mt-2 mb-2\">\r\n  <tbody>\r\n    <tr>\r\n      <td class=\"border border-slate-300 px-4 py-3 align-top\">&lt;em&gt;Nội dung&lt;/em&gt;</td>\r\n    </tr>\r\n  </tbody>\r\n</table>\r\n', '<table class=\"w-full border-collapse border border-slate-300 mt-2 mb-2\">\r\n  <tbody>\r\n    <tr>\r\n      <td class=\"border border-slate-300 px-4 py-3 align-top\">&lt;mark&gt;Nội dung&lt;/mark&gt;</td>\r\n    </tr>\r\n  </tbody>\r\n</table>\r\n', '<table class=\"w-full border-collapse border border-slate-300 mt-2 mb-2\">\r\n  <tbody>\r\n    <tr>\r\n      <td class=\"border border-slate-300 px-4 py-3 align-top\">&lt;title&gt;Nội dung&lt;/title&gt;</td>\r\n    </tr>\r\n  </tbody>\r\n</table>\r\n', 'A'),
(374, '<table class=\"w-full border-collapse border border-slate-300 mt-2 mb-2\">\r\n  <tbody>\r\n    <tr>\r\n      <td class=\"border border-slate-300 px-4 py-3 align-top\">&lt;strong&gt;Nội dung&lt;/strong&gt;</td>\r\n    </tr>\r\n  </tbody>\r\n</table>\r\n', '<table class=\"w-full border-collapse border border-slate-300 mt-2 mb-2\">\r\n  <tbody>\r\n    <tr>\r\n      <td class=\"border border-slate-300 px-4 py-3 align-top\">&lt;em&gt;Nội dung&lt;/em&gt;</td>\r\n    </tr>\r\n  </tbody>\r\n</table>\r\n', '<table class=\"w-full border-collapse border border-slate-300 mt-2 mb-2\">\r\n  <tbody>\r\n    <tr>\r\n      <td class=\"border border-slate-300 px-4 py-3 align-top\">&lt;mark&gt;Nội dung&lt;/mark&gt;</td>\r\n    </tr>\r\n  </tbody>\r\n</table>\r\n', '<table class=\"w-full border-collapse border border-slate-300 mt-2 mb-2\">\r\n  <tbody>\r\n    <tr>\r\n      <td class=\"border border-slate-300 px-4 py-3 align-top\">&lt;title&gt;Nội dung&lt;/title&gt;</td>\r\n    </tr>\r\n  </tbody>\r\n</table>\r\n', 'C'),
(375, '<audio src=\"baihat.mp3\" controls></audio>', '<a href=\"https://c3easup.daklak.edu.vn/\">Trường THPT Ea Súp</a>.', '<p style=\"color=red\">Text</p>.', '<h1 id=\"header\">Title</h1>.', 'C'),
(376, 'type=\"a\" dùng chữ cái hoa (A, B, C...), còn type=\"i\" dùng chữ cái thường (a, b, c...).', 'type=\"a\" dùng chữ cái thường (a, b, c...), còn type=\"i\" dùng chữ số La Mã thường (i, ii, iii...).', 'type=\"a\" dùng chữ số (1, 2, 3...), còn type=\"i\" dùng chữ số La Mã hoa (I, II, III...).', 'type=\"a\" dùng chữ cái thường (a, b, c...), còn type=\"i\" dùng chữ cái thường (i, j, k...).', 'B'),
(377, '<img src=\"icon.png\" alt=\"Biểu tượng\" width=\"20\" height=\"20\">', '<icon src=\"icon.png\" alt=\"Biểu tượng\" width=\"20\" height=\"20\"></icon>', '<img href=\"icon.png\" alt=\"Biểu tượng\" size=\"20\">', '<image src=\"icon.png\" alt=\"Biểu tượng\" width=\"20\" height=\"20\"></image>', 'A'),
(378, '.warning { color: red; }.', '#warning { color: red; }.', 'warning { color: red; }.', 'class.warning { color: red; }.', 'A'),
(379, 'Tất cả các phần tử có id (định danh) là highlight.', 'Tất cả các phần tử có class là highlight.', 'Tất cả các thẻ <h1> trong trang.', 'Tất cả các thẻ <highlight> trong trang.', 'B'),
(380, 'Phản đối việc bắt nạt, quấy rối người khác.', 'Sử dụng deepfake để cảnh báo về lừa đảo.', 'Đăng tin giả mạo để thu hút lượt xem.', 'Ca ngợi những việc làm tốt trong cộng đồng.', 'C'),
(381, 'Sao chép mã nguồn mở và ghi rõ tác giả.', 'Phân phối phần mềm crack không bản quyền.', 'Sử dụng hình ảnh có giấy phép.', 'Trích dẫn nguồn khi đăng bài nghiên cứu.', 'B'),
(382, 'Quyền bảo vệ danh tính và quyền riêng tư.', 'Quyền sở hữu trí tuệ.', 'Quyền tự do ngôn luận.', 'Quyền tự do báo chí.', 'A'),
(383, 'Tìm kiếm và vá lỗ hổng bảo mật.', 'Lắp đặt máy tính mới.', 'Sửa chữa bàn phím và chuột máy tính.', 'Phát triển trò chơi di động.', 'A'),
(384, 'Chỉnh sửa hình ảnh và video.', 'Quản lý hệ thống máy chủ mạng.', 'Lập trình hệ thống nhúng.', 'Lắp đặt và sửa chữa linh kiện phần cứng.', 'A'),
(385, 'Internet và hệ thống mạng trở thành nền tảng quan trọng trong doanh nghiệp.', 'Nhiều người sử dụng máy tính cá nhân hơn trước.', 'Các hãng sản xuất phần cứng liên tục ra mắt sản phẩm mới.', 'Nhu cầu giải trí trực tuyến đang tăng cao.', 'A'),
(386, '20', '25', '30', '35', 'B'),
(387, 'Màu đen, kích thước 24px\r\n', 'Màu tím, kích thước 20px\r\n', 'Màu đen, kích thước 20px\r\n', 'Màu tím, kích thước 24px\r\n', 'B'),
(388, '1 → 2 → 3\r\n', ' 1 → 3 → 2\r\n', '2 → 3 → 1\r\n', '3 → 1 → 2\r\n', 'D'),
(393, '3', '5', '7', '9', 'B'),
(394, 'Điện thoại thông minh', 'Máy tính để bàn', 'Máy quét vân tay', 'Tivi thông minh', 'A'),
(395, 'Giao thông, giáo dục, tài chính', 'Chỉ trong lĩnh vực sản xuất', 'Chỉ trong trò chơi điện tử', 'Không có ứng dụng thực tế', 'A'),
(396, 'Máy quét mã vạch', 'Máy tính bỏ túi', 'Camera an ninh thông minh', 'Máy fax', 'C'),
(397, 'Quản lý lượng dữ liệu khổng lồ', 'Tăng tốc độ xử lý', 'Giảm chi phí sản xuất', 'Tạo ra trí tuệ tương tự con người', 'A'),
(398, 'Router', 'Máy in', 'Webcam', 'Điện thoại bàn', 'A'),
(399, 'HTTP', 'HTTPS', 'FTP', 'IMAP', 'B'),
(400, 'Tăng tốc độ tải dữ liệu', 'Giúp ẩn danh khi duyệt web', 'Lọc quảng cáo khi duyệt web', 'Cải thiện độ phân giải hình ảnh', 'B'),
(401, 'Dropbox', 'USB', 'Ổ cứng di động', 'Email', 'A'),
(402, 'href', 'src', 'alt', 'style', 'B'),
(403, 'p { font-size: 18px; }', 'p { color: red; }', 'p { text-align: center; }', 'p { background-color: blue; }', 'A'),
(404, '<ul>', '<ol>', '<li>', '<dl>', 'B'),
(405, '<audio>', '<video>', '<iframe>', '<img>', 'B'),
(406, '<input>', '<form>', '<table>', '<div>', 'A'),
(407, 'Chia sẻ mật khẩu với bạn bè', 'Sử dụng mật khẩu mạnh và không chia sẻ', 'Đăng nhập trên máy công cộng', 'Để máy tính không có mật khẩu', 'B'),
(408, 'Mua sắm trực tuyến', 'Đăng tải thông tin giả mạo', 'Tham gia diễn đàn công nghệ', 'Đọc tin tức chính thống', 'B'),
(409, 'Kỹ sư an ninh mạng', 'Thợ sửa chữa', 'Nhà báo', 'Kỹ sư cơ khí', 'A'),
(410, 'Phân tích và dự đoán hành vi khách hàng', 'Giảm chi phí sản xuất', 'Tăng trưởng tốc độ mạng', 'Giúp giao tiếp nhanh hơn', 'A'),
(411, 'Hỗ trợ phát triển phần mềm và ứng dụng', 'Chỉ cần thiết cho lập trình viên chuyên nghiệp', 'Giúp cải thiện công việc thủ công', 'Không có tác dụng thực tế', 'A'),
(412, 'Chia sẻ lại để cảnh báo mọi người', 'Báo cáo cho nền tảng mạng xã hội', 'Bình luận công khai', 'Bỏ qua, không quan tâm', 'B'),
(413, 'Sử dụng mật khẩu mạnh và không chia sẻ', 'Đăng nhập vào các trang web lạ để kiểm tra', 'Chia sẻ công khai số điện thoại và địa chỉ', 'Sử dụng mật khẩu dễ đoán để dễ nhớ', 'A'),
(414, 'Nhà khoa học dữ liệu', 'Kỹ sư xây dựng', 'Thợ sửa chữa', 'Giáo viên thể dục', 'A'),
(415, 'Machine Learning', 'Blockchain', 'Internet of Things', 'Hệ điều hành Windows', 'A'),
(416, 'Giúp lưu trữ và truy cập dữ liệu mọi lúc mọi nơi', 'Làm cho máy tính chạy chậm', 'Chỉ dùng để chơi game online', 'Không có lợi ích thực tế', 'A');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `answers_tf`
--

CREATE TABLE `answers_tf` (
  `question_id` int(11) NOT NULL,
  `part_a` mediumtext DEFAULT NULL,
  `is_a_true` tinyint(1) DEFAULT NULL,
  `part_b` mediumtext DEFAULT NULL,
  `is_b_true` tinyint(1) DEFAULT NULL,
  `part_c` mediumtext DEFAULT NULL,
  `is_c_true` tinyint(1) DEFAULT NULL,
  `part_d` mediumtext DEFAULT NULL,
  `is_d_true` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `answers_tf`
--

INSERT INTO `answers_tf` (`question_id`, `part_a`, `is_a_true`, `part_b`, `is_b_true`, `part_c`, `is_c_true`, `part_d`, `is_d_true`) VALUES
(221, 'Cần có Router định tuyến giữa các mạng LAN.', 1, 'Giáo viên có thể xóa tệp trong thư mục “BAITAP”.', 1, 'Mọi máy tính đều có thể truy cập và sửa xóa tệp trong thư mục “BAITAP”.', 0, 'Các máy tính cần nằm trong một mạng LAN.', 1),
(222, 'Trường Ma_hoc_sinh là khóa chính của bảng HOC_SINH; Trường Ma_mon_hoc là khóa chính của bảng MON_HOC.', 1, 'Bảng BANG_DIEM dùng để liên kết bảng HOC_SINH và bảng MON_HOC.', 1, 'Câu lệnh SELECT * FROM BANG_DIEM WHERE Diemtin = \"10\" liệt kê học sinh có điểm môn Tin học nhỏ hơn 10.', 0, 'Hệ CSDL tập trung cần thiết nếu dữ liệu lưu trên một máy chủ.', 1),
(223, 'Có thể dùng các mẫu có sẵn của các phần mềm tạo web (Mobirise, Dreamwearver…) hoặc các mã nguồn mở như WordPress để tạo trang web.', 1, 'Để truy cập website online cần upload lên hosting.', 1, 'Xây dựng Plugin tạo hiệu ứng chuyển động cho \"Góc ảnh\".', 1, 'Chèn Video vào trang web bằng chức năng Thêm hình ảnh/Video của phần mềm tạo web sẽ tiết kiệm dung lượng hơn việc nhúng video trực tiếp từ các nguồn khác như YouTube…', 0),
(224, 'Excel vẽ biểu đồ từng mặt hàng đã bán, tồn kho dưới dạng biểu đồ một cách thuận lợi.', 1, 'Hàm VLOOKUP dùng để liên kết các bảng.', 0, 'SQL tính tổng doanh thu theo tháng.', 1, 'Truy vấn JOIN cần thiết để xuất báo cáo chi tiết.', 1),
(249, 'Cấu trúc của văn bản HTML gồm hai phần: phần đầu (head) và phần thân (body)', 1, 'Dòng đầu tiên của văn bản HTML cung cấp thông tin của phiên bản HTML được sử dụng.', 1, 'Nội dung của phần tử head sẽ hiển thị trên màn hình trình duyệt web.', 0, 'Nội dung của phần tử title sẽ hiển thị trên tiêu đề của sửa sổ trình duyệt web.', 1),
(250, 'Bảng NGUOIMUON có một cột Masothe làm khóa chính.', 1, 'Một cuốn sách có thể xuất hiện nhiều lần trong bảng MUONTRA vì một cuốn sách có thể được mượn nhiều lần.', 1, 'Để xác định tổng số tiền của tất cả các cuốn sách đã được mượn, ta chỉ cần tính tổng Giatien trong bảng SACH.', 0, 'Để tìm danh sách các học sinh chưa từng mượn sách, ta có thể sử dụng câu truy vấn kết hợp bảng NGUOIMUON và MUONTRA, sau đó tìm những học sinh không có trong bảng MUONTRA.', 1),
(251, 'Tạo các trang con của trang chủ và đặt tên cho trang con Lịch sử nhà trường, Thành tích nhà trường, Cơ cấu tổ chức.', 1, 'Tạo nội dung cho các trang con của trang chủ và đặt tên cho trang con Lịch sử nhà trường, Thành tích nhà trường, Cơ cấu tổ chức.', 1, 'Phải thiết lập để mỗi trang bài viết chi tiết của website đều phải được hiển thị trên cùng một mục nào đó trên thanh điều hướng.', 0, 'Tạo các bài viết tóm tắt trên trang chủ và thêm các liên kết đến các trang chi tiết tương ứng.', 1),
(252, 'Khoá chính của bảng MonHoc là MaMH.', 1, 'Trong bảng MonHoc, thuộc tính Tên môn học có các giá trị là số nguyên.', 0, 'Liên kết HocSinh – KetQuaThi qua khoá ngoài SBD, bảng HocSinh là bảng tham chiếu, bảng KetQuaThi là bảng được tham chiếu.', 0, 'Câu lệnh SQL để lấy bảng điểm của học sinh có SBD bằng 45004301 là: \r\nSELECT * FROM HocSinh, KetQuaThi \r\nWHERE HocSinh.SBD = KetQuaThi.SBD and ketQuaThi.SBD = 45004301', 1),
(277, 'Switch là thiết bị cần thiết để mở rộng LAN.', 1, 'Router định tuyến giữa các mạng con.', 1, 'Chia sẻ file cần cấp quyền \"read/write\".', 1, 'Thứ tự kết nối: Modem → Router → Switch → Máy tính.', 0),
(278, 'Trường MaSach là khóa chính của bảng SACH.', 1, 'Bảng MUONSACH dùng để liên kết SACH và DOCGIA.', 0, 'Câu lệnh SELECT * FROM DOCGIA WHERE GioiTinh = \"Nam\" liệt kê độc giả nam.', 1, 'Hệ CSDL phân tán cần thiết nếu dữ liệu lưu trên một máy chủ.', 0),
(279, 'Có thể dùng WordPress để tạo trang web.', 1, 'Chia sẻ website bằng cách upload lên hosting.', 1, 'Xây dựng Plugin \"Giỏ hàng\" hỗ trợ thanh toán trực tuyến.', 1, 'Nên nhúng video trực tiếp từ YouTube để tiết kiệm dung lượng.', 1),
(280, 'Excel vẽ biểu đồ thống kê tồn kho.', 1, 'Hàm VLOOKUP dùng để liên kết các bảng.', 0, 'SQL tính tổng doanh thu theo tháng.', 1, 'Truy vấn JOIN cần thiết để xuất báo cáo chi tiết.', 1),
(333, 'Router có khả năng kết nối và chuyển tiếp dữ liệu giữa các mạng LAN khác nhau.', 1, 'Router và Switch đều có chức năng xác định đường đi cho gói tin trong mạng.', 0, 'Trong mạng LAN, các gói tin được chuyển tiếp giữa các thiết bị thông qua địa chỉ MAC.', 1, 'Switch không thể hoạt động nếu không có Router.', 0),
(334, 'Trường MaSach là khóa chính của bảng SACH.', 1, 'Bảng SACH và bảng DOCGIA được liên kết thông qua bảng MUONSACH.', 1, 'Câu lệnh SELECT * FROM DOCGIA WHERE GioiTinh = \"Nam\" liệt kê tất cả Tên độc giả có giới tính “Nam”.', 0, 'Thư viện chọn một máy chủ để lưu cơ sở dữ liệu nói trên, do vậy phải chọn hệ Cơ sở dữ liệu phân tán.', 0),
(335, 'Có thể xuất dữ liệu từ CTHD sang phần mềm bảng tính Excel. Sau đó sử dụng phần mềm bảng tính Excel để tính tổng doanh thu theo từng sản phẩm và vẽ biểu đồ cột.', 1, 'Để biết tên sản phẩm và loại sản phẩm trong từng hoá đơn, chỉ cần xem bảng CTHD.', 0, 'Trong phần mềm quản trị CSDL, nếu muốn biết doanh thu theo ngày, ta cần lấy thông tin NgayLap từ HOADON, sau đó kết nối với CTHD qua MaHD.', 1, 'Khi cập nhật giá bán của một sản phẩm trong bảng SANPHAM, phần mềm sẽ tự động cập nhật giá bán của tất cả hoá đơn đã lập trước đó.', 0),
(336, 'Thẻ <a> được sử dụng để tạo một danh sách. \r\n', 0, ' Tiêu đề của trang web là \"Bài tập HTML\". \r\n', 1, 'Chương trình trên sẽ hiển thị một hình ảnh có tên \"anh.jpg\". \r\n', 1, 'Chương trình trên sẽ tạo một đoạn văn có màu đỏ. \r\n', 0),
(361, 'MAN là loại mạng có số lượng máy trạm nhỏ hơn so với mạng LAN.', 0, 'Mạng LAN còn được gọi là Mạng cục bộ hay Mạng nội bộ.', 1, 'Mạng Wi-Fi ra đời sau, khi chưa có Wi-Fi các máy trạm phải dùng dây cáp mạng để kết nối với nhau.', 1, 'Một trường THPT có khoảng 50 máy PC kết nối mạng với nhau để học sinh thực hành và giáo viên truy cập Internet. Mạng nội bộ của trường đó thuộc loại mạng MAN', 0),
(362, 'Các liên kết được hiển thị trong một danh sách không có thứ tự.\r\n', 1, 'Các liên kết được hiển thị theo hàng ngang.\r\n', 1, 'Các liên kết không được hiển thị trên trình duyệt web vì được đặt trong khu vực header.\r\n', 0, ' Khi người dùng rễ chuột lên liên kết Trang chủ, nội dung văn bản được chuyển sang màu xanh lá cây.\r\n', 0),
(363, 'Có thể tự thiết kế phần đầu trang hoặc sử dụng các theme (mẫu) có sẵn. \r\n', 1, 'Tất cả các trang web trong một website thường có thanh điều hướng giống nhau.\r\n', 1, 'Logo hoặc biểu ngữ của trang web được thêm vào bằng cách chèn thêm hình\r\nảnh (Image) từ máy tính hoặc từ Internet thông qua URL.\r\n', 1, 'Không thể tạo các mục con (submenu) trong các mục (nội dung) của thanh điều hướng.', 0),
(364, 'Trong bảng nhanvien, cột idNhanvien lưu trữ tên của nhân viên', 0, 'Bảng nhanvien lưu thông tin về nhân viên, bao gồm họ tên, ngày sinh, địa chỉ, số điện thoại và mã phòng làm việc.', 1, 'Khi xoá một nhân viên trong bảng nhanvien thì cần xoá phòng tương ứng của nhân viện đó trong bảng phong.', 0, 'Nếu cho phép một nhân viên có thể thuộc nhiều hơn một phòng thì cơ sở dữ liệu với 2 bảng trên không đáp ứng được.', 1),
(389, 'Router là thiết bị duy nhất cần thiết để xây dựng WAN.', 0, 'WAN yêu cầu sử dụng cáp quang để kết nối giữa các chi nhánh.', 0, 'VPN (Mạng riêng ảo) có thể được dùng để bảo mật kết nối WAN.', 1, 'Trong mạng WAN, có thể sử dụng địa chỉ MAC để định tuyến dữ liệu giữa các chi nhánh.', 0),
(390, 'Lọc ra tên của những khách hàng có giao dịch trong ngày 20/10/2024 cần sử dụng bảng KHACHANG và bảng GIAODICH', 1, 'Nếu ngân hàng muốn mở rộng hệ thống để phục vụ nhiều chi nhánh trên cả nước, nên sử dụng cơ sở dữ liệu quan hệ vì đảm bảo tính toàn vẹn dữ liệu.', 1, 'Trong bảng GIAODICH, kết hợp hai thuộc tính SoTK và MaKH có thể tạo thành một khóa chính.', 0, 'Câu lệnh SQL sau tính tổng số tiền giao dịch của khách hàng có SoTK = \'8840595191\' trong năm 2024:\r\nSELECT SUM(GIAODICH.SoTien) AS TongTienGD  \r\nFROM GIAODICH  \r\nWHERE GIAODICH.SoTK = \'8840595191\'  OR YEAR(GIAODICH.NgayGD) = 2024;', 0),
(391, 'Có thể dùng nền tảng tạo website CMS (Content Management System) – Hệ thống quản lý nội dung như WordPress để thiết kế trang mà không cần lập trình.', 1, 'Nếu khách hàng muốn mua sách, họ phải đến trực tiếp cửa hàng vì website không hỗ trợ đặt hàng online.', 0, 'Việc cập nhật danh sách sách mới bắt buộc phải chỉnh sửa trực tiếp trong mã nguồn HTML của website.', 0, 'Khi muốn nhúng video giới thiệu sách từ YouTube vào website, chỉ cần sao chép URL trên thanh địa chỉ trình duyệt từ YouTube mà không cần tải video về máy.', 0),
(392, 'Để biết tên sản phẩm và loại sản phẩm trong từng hoá đơn, chỉ cần xem bảng CTHD.', 0, 'Có thể xuất dữ liệu từ CTHD sang phần mềm bảng tính Excel. Sau đó sử dụng phần mềm bảng tính Excel để tính tổng doanh thu theo từng sản phẩm và vẽ biểu đồ cột.', 1, 'Khi cập nhật giá bán của một sản phẩm trong bảng SANPHAM, phần mềm sẽ tự động cập nhật giá bán của tất cả hoá đơn đã lập trước đó.', 0, 'Trong phần mềm quản trị CSDL, nếu muốn biết doanh thu theo ngày, ta cần lấy thông tin NgayLap từ HOADON, sau đó kết nối với CTHD qua MaHD.', 1),
(417, 'Mật khẩu mạnh nên có cả chữ hoa, chữ thường, số và ký tự đặc biệt.', 1, 'Firewall giúp ngăn chặn truy cập trái phép từ bên ngoài vào hệ thống mạng.', 1, 'Mã hóa dữ liệu giúp bảo vệ thông tin ngay cả khi bị đánh cắp.', 1, 'Chia sẻ mật khẩu với đồng nghiệp giúp tăng cường bảo mật.', 0),
(418, 'SQL là ngôn ngữ dùng để thao tác và truy vấn dữ liệu trong CSDL quan hệ.', 1, 'Index trong CSDL giúp tăng tốc độ tìm kiếm dữ liệu.', 1, 'DELETE và TRUNCATE đều có thể xóa dữ liệu nhưng TRUNCATE không thể khôi phục.', 1, 'Hệ quản trị CSDL NoSQL phù hợp nhất để lưu trữ dữ liệu có cấu trúc chặt chẽ.', 0),
(419, 'HTML được dùng để tạo nội dung trang web.', 1, 'CSS giúp tạo hiệu ứng động trên trang web.', 0, 'JavaScript có thể xử lý các sự kiện như nhấn nút hoặc nhập liệu.', 1, 'Hệ thống quản lý nội dung (CMS) giúp quản lý nội dung web mà không cần lập trình.', 1),
(420, 'Dữ liệu lớn thường có đặc điểm: khối lượng lớn, tốc độ cao, đa dạng nguồn dữ liệu.', 1, 'Hadoop là một công nghệ phổ biến để xử lý dữ liệu lớn.', 1, 'Mọi dữ liệu trong hệ thống Big Data đều được lưu trữ trên một máy chủ duy nhất.', 0, 'Phân tích dữ liệu giúp doanh nghiệp hiểu rõ hơn về hành vi khách hàng.', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exams`
--

CREATE TABLE `exams` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `code` varchar(50) NOT NULL,
  `duration` int(11) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `exams`
--

INSERT INTO `exams` (`id`, `title`, `code`, `duration`, `description`, `status`, `created_at`) VALUES
(8, 'SỞ GD - ĐT ĐẮK LẮK TRƯỜNG THPT BUÔN HỒ', 'KỲ THI TỐT NGHIỆP THPT TỪ NĂM 2025', 50, 'ĐỀ THAM KHẢO', 'active', '2026-04-19 10:09:37'),
(9, 'SỞ GD - ĐT ĐẮK LẮK TRƯỜNG THPT TRẦN QUỐC TOẢN', 'KỲ THI TỐT NGHIỆP THPT TỪ NĂM 2025', 50, 'ĐỀ THAM KHẢO', 'active', '2026-04-19 10:25:17'),
(10, 'SỞ GD VÀ ĐT ĐẮK LẮK TRƯỜNG THPT Y JÚT', 'KỲ THI TỐT NGHIỆP THPT TỪ NĂM 2025', 50, 'ĐỀ THAM KHẢO', 'active', '2026-04-19 10:34:20'),
(12, 'SỞ GD - ĐT ĐẮK LẮK TRƯỜNG THPT LÊ HỒNG PHONG', ' KỲ THI TỐT NGHIỆP THPT TỪ NĂM 2025', 50, 'ĐỀ THAM KHẢO', 'active', '2026-04-19 10:49:28'),
(13, 'SỞ GD - ĐT ĐẮK LẮK TRƯỜNG THPT CƯMGAR', 'KỲ THI TỐT NGHIỆP THPT TỪ NĂM 2025', 50, 'ĐỀ THAM KHẢO', 'active', '2026-04-19 10:57:03'),
(14, 'SỞ GD - ĐT ĐẮK LẮK TRƯỜNG THPT THPT EA SÚP', 'KỲ THI TỐT NGHIỆP THPT TỪ NĂM 2025', 50, 'ĐỀ THAM KHẢO', 'active', '2026-04-19 11:06:42'),
(15, 'SỞ GD - ĐT ĐẮK LẮK TRƯỜNG THPT HUỲNH THÚC KHÁNG', 'KỲ THI TỐT NGHIỆP THPT TỪ NĂM 2025', 50, 'ĐỀ THAM KHẢO', 'active', '2026-04-19 11:14:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `q_type` enum('mcq','tf') NOT NULL,
  `q_index` int(11) DEFAULT NULL,
  `content` mediumtext DEFAULT NULL,
  `layout` varchar(50) DEFAULT 'normal',
  `left_content` mediumtext DEFAULT NULL,
  `right_content` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `questions`
--

INSERT INTO `questions` (`id`, `exam_id`, `q_type`, `q_index`, `content`, `layout`, `left_content`, `right_content`) VALUES
(197, 8, 'mcq', 1, 'Trong các ví dụ sau, đâu là ứng dụng của Trí tuệ nhân tạo (AI)?', 'normal', '', ''),
(198, 8, 'mcq', 2, 'Trí tuệ nhân tạo (AI) hiện nay được ứng dụng trong lĩnh vực nào sau đây?', 'normal', '', ''),
(199, 8, 'mcq', 3, 'Vì sao Trí tuệ nhân tạo (AI) được coi là mô phỏng trí thông minh của con người?', 'normal', '', ''),
(200, 8, 'mcq', 4, 'Hãy chọn nhận định đúng về tác động tích cực và tiêu cực của Trí tuệ nhân tạo (AI):', 'normal', '', ''),
(201, 8, 'mcq', 5, 'Mạng Wi-Fi là gì?', 'normal', '', ''),
(202, 8, 'mcq', 6, 'Tính năng nào dưới đây không phải của mạng LAN?', 'normal', '', ''),
(203, 8, 'mcq', 7, 'Hãy chỉ ra loại mạng nào phù hợp cho kết nối giữa các chi nhánh của một công ty trong một quốc gia.', 'normal', '', ''),
(204, 8, 'mcq', 8, 'Trong một phòng máy ở một công ty, người quản lí muốn chia sẻ một thư mục trong đó chứa các thông báo và quyết định để nhân viên có thể xem được. Chế độ phân quyền nào sau đây là phù hợp nhất khi chia sẻ thư mục trong tình huống trên?', 'normal', '', ''),
(205, 8, 'mcq', 9, 'Thẻ HTML nào dùng để bắt đầu một trang web?', 'normal', '', ''),
(206, 8, 'mcq', 10, 'Cách tạo một siêu liên kết trong HTML là gì?', 'normal', '', ''),
(207, 8, 'mcq', 11, 'Thuộc tính nào của phần tử img được dùng để  hiển thị thông báo khi hình ảnh chèn vào trang web gặp lỗi trong quá trình hiển thị trên màn hình trình duyệt web?', 'normal', '', ''),
(208, 8, 'mcq', 12, 'Khai báo áp dụng external CSS nào sau đây đúng cú pháp?', 'normal', '', ''),
(209, 8, 'mcq', 13, 'Đoạn mã nào sau đây là ví dụ về CSS với nhiều quy định trong vùng mô tả?', 'normal', '', ''),
(210, 8, 'mcq', 14, 'Khai báo nào được dùng để tạo điều khiển nhập dữ liệu ô text trong biểu mẫu?', 'normal', '', ''),
(211, 8, 'mcq', 15, 'Trong HTML, bạn cần tạo một liên kết đến một trang khác trong cùng một thư mục. Bạn sẽ sử dụng cú pháp nào sau đây?', 'normal', '', ''),
(212, 8, 'mcq', 16, 'Trong biểu mẫu HTML, để người dùng có thể nhập ngày sinh theo định dạng ngày/tháng/năm, bạn nên sử dụng thuộc tính nào cho thẻ <input>?', 'normal', '', ''),
(213, 8, 'mcq', 17, 'Tính nhân văn trong thế giới ảo đề cập đến:', 'normal', '', ''),
(214, 8, 'mcq', 18, 'Tại sao việc gìn giữ tính nhân văn trong thế giới ảo lại quan trọng?', 'normal', '', ''),
(215, 8, 'mcq', 19, 'Em vô tình phát hiện một bài viết tiết lộ hoàn cảnh gia đình khó khăn của một bạn trong lớp trên mạng xã hội (mà bạn không muốn công khai). Em nên làm gì để vừa thể hiện tính nhân văn, vừa tôn trọng quy tắc giao tiếp trên môi trường số?', 'normal', '', ''),
(216, 8, 'mcq', 20, 'Chuyên gia quản trị mạng có nhiệm vụ chính nào sau đây?', 'normal', '', ''),
(217, 8, 'mcq', 21, 'Trong bảo mật hệ thống thông tin, chuyên gia cần hiểu biết về gì?', 'normal', '', ''),
(218, 8, 'mcq', 22, 'Điều nào sau đây là một phần của công việc quản trị và bảo trì hệ thống?', 'normal', '', ''),
(219, 8, 'mcq', 23, 'Để tạo một bảng có hai cột và ba hàng trong HTML, bạn cần sử dụng các thẻ nào?', 'normal', '', ''),
(220, 8, 'mcq', 24, 'Tính tổng các số lẻ từ 45 đến 100. ', 'normal', '', ''),
(221, 8, 'tf', 25, 'Trường học có 1 phòng Tin học. Một bạn học sinh thực hiện chia sẻ một thư mục có tên “BAITAP” bằng chức năng “Chia sẻ thư mục” của hệ điều hành Windows cho máy tính của Giáo viên và các bạn khác trong phòng thực hành. Học sinh đó thiết lập như sau: “Quyền “Read/Write” đối với người truy cập là giáo viên, Quyền “Read” đối với các bạn học sinh”. Cho biết tính Đúng/Sai của các ý kiến:', 'normal', '', ''),
(222, 8, 'tf', 26, 'CSDL quản lý học tập (CSDL_QLHT) gồm 3 bảng: HOC_SINH, BANG_DIEM, MON_HOC. Cho biết tính Đúng/Sai của các nhận xét:', 'normal', '', ''),
(223, 8, 'tf', 27, 'Một nhóm học sinh tạo website báo tường online cho lớp gồm các trang Giới thiệu; Bài viết; Góc ảnh; Góc âm nhạc, video:', 'normal', '', ''),
(224, 8, 'tf', 28, 'CSDL quản lý KINH DOANH gồm 3 bảng có cấu trúc như sau:\r\n+ KHACH_HANG (Ma_khach_hang, Ho_ten, Dia_chi): Lưu thông tin mã khách hàng, họ tên khách hàng, địa chỉ của khách hàng.\r\n+ MAT_HANG (Ma_mat_hang, Ten_mat_hang, Don_gia): Lưu thông tin mã mặt hàng, tên mặt hàng, đơn giá.\r\n+ HOA_DON (So_don, So_luong, Ngay_giao, Đon_gia, Thanh_tien): Lưu thông tin mã hóa đơn, số lượng, ngày giao hàng, đơn giá, thành tiền.\r\nMột số học sinh có ý kiến sau về việc sử dụng các phần mềm khai thác CSDL như sau:', 'normal', '', ''),
(225, 9, 'mcq', 1, 'Ứng dụng nào sau đây không sử dụng công nghệ nhận dạng khuôn mặt?', 'normal', '', ''),
(226, 9, 'mcq', 2, 'Các hệ thống AI không công khai, được phát triển bởi tổ chức tư nhân có thể tạo ra nguy cơ gì?', 'normal', '', ''),
(227, 9, 'mcq', 3, 'AI được chia thành hai loại chính nào?', 'normal', '', ''),
(228, 9, 'mcq', 4, 'Nhận dạng chữ viết tay bằng AI không được sử dụng trong hoạt động nào sau đây?', 'normal', '', ''),
(229, 9, 'mcq', 5, 'Phương án nào sau đây là một thành phần của mạng WLAN?', 'normal', '', ''),
(230, 9, 'mcq', 6, 'Thiết bị mạng nào sau đây có khả năng tìm đường đi tối ưu cho gói tin trong mạng WAN?', 'normal', '', ''),
(231, 9, 'mcq', 7, 'Thiết bị Switch không có khả năng nào sau đây?', 'normal', '', ''),
(232, 9, 'mcq', 8, 'Trong phòng thực hành có nhiều máy tính để bàn, ngoài ra có thể dùng cả thiết bị di động. Giáo viên muốn kết nối chúng thành một mạng cục bộ. Có thể không dùng một thiết bị nào sau đây?', 'normal', '', ''),
(233, 9, 'mcq', 9, 'Thẻ HTML nào thường được sử dụng để tạo đoạn văn bản?', 'normal', '', ''),
(234, 9, 'mcq', 10, 'Để thay đổi kí tự đầu dòng trong danh sách không có thứ tự, chúng ta sử dụng thuộc tính nào?', 'normal', '', ''),
(235, 9, 'mcq', 11, 'Để gộp ô trong một bảng của trang web, chúng ta sử dụng thuộc tính nào?', 'normal', '', ''),
(236, 9, 'mcq', 12, 'Khai báo CSS nào sau đây đúng cú pháp?', 'normal', '', ''),
(237, 9, 'mcq', 13, 'Khai báo CSS nào sau đây sử dụng bộ chọn định danh', 'normal', '', ''),
(238, 9, 'mcq', 14, 'Khai báo CSS nào sau đây đúng cú pháp?', 'normal', '', ''),
(239, 9, 'mcq', 15, 'Nếu bạn muốn định dạng tất cả các thẻ <h1>, <h2>, <h3> cùng một lúc, bạn nên viết CSS như thế nào?', 'normal', '', ''),
(240, 9, 'mcq', 16, 'Mẫu định dạng nào dưới đây là CSS nội tuyến?', 'normal', '', ''),
(241, 9, 'mcq', 17, 'Đoạn mã nào sau đây biểu diễn đúng về CSS với nhiều quy định trong vùng mô tả?', 'normal', '', ''),
(242, 9, 'mcq', 18, 'Phương án nào sau đây không phải là một phương thức giao tiếp qua không gian mạng?', 'normal', '', ''),
(243, 9, 'mcq', 19, 'Ứng xử nhân văn trong không gian mạng có tác động như thế nào đến mối quan hệ xã hội?', 'normal', '', ''),
(244, 9, 'mcq', 20, 'Hãy chọn nội dung thích hợp dưới đây để điền vào chỗ trống: “ Việc…..” thông tin cá nhân của người khác mà không có sự đồng ý của họ là vi phạm quyền riêng tư và không phản ánh tính nhân văn.”', 'normal', '', ''),
(245, 9, 'mcq', 21, 'Đâu là công việc của kĩ thuật viên công nghệ thông tin?', 'normal', '', ''),
(246, 9, 'mcq', 22, 'Hành động ngăn cản, phòng ngừa sự sử dụng, truy cập, tiết lộ, chia sẻ, phát tán, ghi lại hoặc phá hủy thông tin chưa có sự cho phép thuộc lĩnh vực nào?', 'normal', '', ''),
(247, 9, 'mcq', 23, 'Để trở thành Nhà quản trị và bảo trì hệ thống cần có kiến thức, kĩ năng về:', 'normal', '', ''),
(248, 9, 'mcq', 24, 'Đoạn chương trình sau cho kết quả là bao nhiêu?\r\n', 'python,cpp', 'A = [2, 4, 3, 1, 5]\r\ndem = 0\r\n\r\nwhile dem < len(A):\r\n    dem = dem + 1\r\n\r\nprint(dem)\r\n', 'int main()\r\n{\r\n    int A[] = {2, 4, 3, 1, 5};\r\n    int dem = 0;\r\n    int length = sizeof(A) / sizeof(A[0]);\r\n    while (dem < length) {\r\n        dem = dem + 1;\r\n    }\r\n    cout << dem << endl;\r\n    return 0;\r\n}\r\n'),
(249, 9, 'tf', 25, 'Mỗi phát biểu sau đây về cấu trúc và nội dung văn bản HTML là đúng hay sai?', 'normal', '', ''),
(250, 9, 'tf', 26, 'Cho một cơ sở dữ liệu quản lí thư viện trong trường THPT, có các bảng sau: bảng NGUOIMUON có các cột Masothe (khóa chính) Hoten, Ngaysinh, Giotinh, Lop, Ngaycapthe; bảng  SACH  có các cột Masach (khóa chính), Tacgia, Tensach, Loai, NXB, NamXB, Giatien và bảng MUONTRA có các cột Mamuon (khóa chính),Masach, Ngaymuon, Ngaytra, Ghichu. \r\nMột số bạn học sinh nêu ý kiến về cơ sở dữ liệu trên như sau:', 'normal', '', ''),
(251, 9, 'tf', 27, 'Trong dự án thiết kế trang web giới thiệu về trường THPT A, cần thiết kế thanh điều hướng gồm các mục Giới thiệu, Tin tức-Sự kiện, Hoạt động đoàn thể, lịch công tác. Trong mục Giới thiệu có các trang con Lịch sử nhà trường, Thành tích nhà trường, Cơ cấu tổ chức. Trang web cũng có các bài viết chi tiết cho các nội dung tương ứng. Xem xét các công việc mà người thiết kế phải thực hiện.', 'normal', '', ''),
(252, 9, 'tf', 28, 'Trong kì thi tốt nghiệp THPT, học sinh được đánh số báo danh (SBD), có thể thi một số môn, được chia vào các phòng thi được đánh số, sau khi chấm sẽ có điểm thi với các môn đăng kí dự thi. Dựa trên yêu cầu của bài toán, một bạn học sinh đề CSDL có các bảng dữ liệu (các trường làm khóa chính được gạch chân) như sau:\r\n- Bảng HocSinh (SBD, HoTen, NgaySinh, Truong) lưu thông tin số báo danh, họ tên, ngày sinh, trường.\r\n- Bảng MonHoc (MaMH, TenMonHoc) có mã môn học, tên môn học.\r\n- Bảng PhongThi (MaPhongThi, TenPhongThi) có mã phòng thi, tên phòng thi.\r\n- Bảng KetQuaThi (SBD, MaMH, MaPhongThi, DiemThi) lưu thông tin số báo danh, mã môn học, mã phòng thi, điểm thi.\r\nSau khi tìm hiểu dữ liệu của phần mềm, một số bạn học sinh có các ý kiến như sau:', 'normal', '', ''),
(253, 10, 'mcq', 1, 'Phương án nào sau đây KHÔNG phải là đặc trưng cơ bản của Trí tuệ nhân tạo (AI)?', 'normal', '', ''),
(254, 10, 'mcq', 2, 'Phương án nào sau đây là sai khi nói về ChatGPT', 'normal', '', ''),
(255, 10, 'mcq', 3, 'Phát biểu nào là KHÔNG đúng khi nói về ứng dụng của AI trong y tế, chăm sóc sức khoẻ?', 'normal', '', ''),
(256, 10, 'mcq', 4, 'Phát biểu nào sau đây là đúng khi nói về mạng Wi-Fi?', 'normal', '', ''),
(257, 10, 'mcq', 5, 'Điều kiện để các máy tính trong mạng giao tiếp được với nhau khi chúng được dùng chung?', 'normal', '', ''),
(258, 10, 'mcq', 6, 'Phát biểu nào sau đây, giải thích đúng về các loại mạng máy tính?', 'normal', '', ''),
(259, 10, 'mcq', 7, 'Trong các phát biểu về địa chỉ IP sau, phát biểu nào đúng?', 'normal', '', ''),
(260, 10, 'mcq', 8, 'Một phòng làm việc có 10 chiếc máy tính để bàn hỗ trợ cổng kết nối có dây. Với mục đích cả văn phòng dùng chung 2 máy in và 1 máy photocopy. Theo em loại thiết bị và số lượng cần thiết để kết nối mạng dành cho tất cả các máy tính và thiết bị trong văn phòng này là? Em hãy chọn phương án sai trong các phương án dưới đây?', 'normal', '', ''),
(261, 10, 'mcq', 9, 'Giao tiếp trong không gian mạng KHÔNG có ưu điểm nào sau đây?', 'normal', '', ''),
(262, 10, 'mcq', 10, 'Phương án nào sau đây KHÔNG đúng khi đề cập đến các cách hình thành thói quen ứng xử nhân văn trong không gian mạng?', 'normal', '', ''),
(263, 10, 'mcq', 11, 'Trên một diễn đàn học tập, bạn A vô tình phát hiện một thành viên chia sẻ bài viết tiết lộ điểm thi và hoàn cảnh gia đình khó khăn của bạn B (mà B không muốn công khai). Nếu là A, bạn nên làm gì để vừa thể hiện tính nhân văn, vừa tôn trọng quy tắc giao tiếp trên mạng?', 'normal', '', ''),
(264, 10, 'mcq', 12, 'Thuộc tính HTML nào xác định đường dẫn hình ảnh?', 'normal', '', ''),
(265, 10, 'mcq', 13, 'Đoạn CSS nào đặt màu chữ cho phần tử <h1>?', 'normal', '', ''),
(266, 10, 'mcq', 14, 'Thẻ HTML nào tạo danh sách không đánh số?', 'normal', '', ''),
(267, 10, 'mcq', 15, 'Đoạn mã HTML nào chèn video từ YouTube?', 'normal', '', ''),
(268, 10, 'mcq', 16, 'Khi nào nên sử dụng thẻ <p> trong HTML?', 'normal', '', ''),
(269, 10, 'mcq', 17, 'Thuộc tính CSS nào sau đây được sử dụng để thay đổi màu nền của một phần tử?', 'normal', '', ''),
(270, 10, 'mcq', 18, 'Công việc nào thuộc nghề phát triển phần mềm?', 'normal', '', ''),
(271, 10, 'mcq', 19, 'Lý do chính khiến nghề phân tích dữ liệu phát triển?', 'normal', '', ''),
(272, 10, 'mcq', 20, 'Trong bối cảnh cách mạng công nghiệp 4.0, tin học đóng vai trò quan trọng trong việc định hướng nghề nghiệp. Hãy chọn phương án đúng nhất để giải thích tại sao kỹ năng lập trình và phân tích dữ liệu lại trở thành yêu cầu thiết yếu trong nhiều ngành nghề hiện nay.', 'normal', '', ''),
(273, 10, 'mcq', 21, 'Một công ty muốn tạo một trang web với nhiều liên kết đến các trang khác nhau để cung cấp thông tin cho khách hàng. Hãy xem đoạn mã HTML sau và cho biết dòng nào chứa siêu liên kết đến trang \"Liên hệ\":\r\n\r\n```html\r\n\r\n<html>\r\n<body>\r\n<ul>\r\n  <li><a href=\"index.html\">Trang chủ</a></li>\r\n  <li><a href=\"about.html\">Giới thiệu</a></li>\r\n  <li><a href=\"contact.html\">Liên hệ</a></li>\r\n</ul>\r\n</body>\r\n</html>\r\n\r\n```\r\n', 'normal', '', ''),
(274, 10, 'mcq', 22, 'Đoạn mã HTML nào dùng để tạo một danh sách có thứ tự với 3 mục?\r\n', 'normal', '', ''),
(275, 10, 'mcq', 23, 'Cho đoạn mã CSS sau:\r\n\r\n```html\r\n.box {\r\n  width: 200px;\r\n  height: 200px;\r\n  padding: 20px;\r\n  border: 10px solid black;\r\n  margin: 30px;\r\n}\r\n```\r\nKích thước tổng chiều rộng (total width) của phần tử .box là bao nhiêu?', 'normal', '', ''),
(276, 10, 'mcq', 24, 'Chọn một trong hai ngôn ngữ Python hoặc C++ để xem xét đoạn chương trình sau:\r\n', 'python,cpp', 's = 0  \r\nfor i in range(1, 5):  \r\n    s += i  \r\nprint(s)  \r\n\r\nKết quả của đoạn chương trình là?\r\n\r\n', '#include <iostream>\r\nint main() {\r\n    int s = 0;\r\n    for (int i = 1; i < 5; ++i) {\r\n        s += i;\r\n    }\r\n    std::cout << s << std::endl;\r\n    return 0;\r\n}\r\n\r\nKết quả của đoạn chương trình là?\r\n'),
(277, 10, 'tf', 25, 'Một công ty có 3 phòng ban cần kết nối mạng LAN. ISP cung cấp modem tích hợp router và access point. Các ý kiến:', 'normal', '', ''),
(278, 10, 'tf', 26, 'CSDL quản lý thư viện gồm 3 bảng: SACH, DOCGIA, MUONSACH. Nhận xét:', 'normal', '', ''),
(279, 10, 'tf', 27, 'Thiết kế website bán hàng:', 'normal', '', ''),
(280, 10, 'tf', 28, 'CSDL quản lý kho hàng:', 'normal', '', ''),
(309, 12, 'mcq', 1, 'Một phòng máy tính được trang bị 1 máy chủ (server) và nhiều máy trạm (client). Giáo viên muốn chia sẻ một thư mục tài liệu trên máy chủ để tất cả máy trạm đều có thể truy cập. Dưới đây là các bước cần thực hiện:\r\n1. Chia sẻ thư mục tài liệu (thông qua tính năng chia sẻ trong hệ điều hành).\r\n2. Phân quyền (read/write) cho các tài khoản tương ứng.\r\n3. Tạo tài khoản (username, password) cho từng máy trạm trên máy chủ.\r\nHãy chọn thứ tự đúng để thiết lập chia sẻ thành công:\r\n', 'normal', '', ''),
(310, 12, 'mcq', 2, 'Phương án nào cho bên dưới mô tả đúng định dạng của văn bản được hiển thị khi thực thi đoạn mã HTML dưới đây?\r\n\r\n```html\r\n<head>\r\n	<style>\r\n    	p { color: red; font-size: 16px; }\r\n    	p { color: blue; font-size: 18px; }\r\n	</style>\r\n</head>\r\n<body>\r\n	<p>Chào mừng bạn đến với trang web!</p>\r\n</body>\r\n\r\n```\r\n', 'normal', '', ''),
(311, 12, 'mcq', 3, 'Chọn một trong hai ngôn ngữ Python hoặc C++ để xem xét đoạn chương trình như sau: \r\nSau khi thực hiện đoạn chương trình trên, giá trị của s in ra màn hình là?', 'python,cpp', 's=0\r\ni=1\r\nwhile i <= 10:\r\n    s=s+i\r\n    i=i+1\r\nprint(s)', 'int s = 0, i = 1;\r\nwhile (i <= 10)\r\n{\r\n    s = s + i;\r\n    i = i +1;\r\n}\r\ncout << s;'),
(312, 12, 'mcq', 4, 'Câu nào sau đây mô tả đúng chức năng của Cascading Style Sheets (CSS)?', 'normal', '', ''),
(313, 12, 'mcq', 5, 'Cú pháp để chèn biểu tượng (icon) từ một tệp hình ảnh là?', 'normal', '', ''),
(314, 12, 'mcq', 6, 'Muốn định dạng phần văn bản “Nội dung” của danh sách có thứ tự bắt đầu bằng kí tự “C” ta sử dụng câu lệnh nào trong các câu lệnh sau đây là đúng?', 'normal', '', ''),
(315, 12, 'mcq', 7, 'Làm thế nào để liên kết một tệp CSS ngoại vào tệp HTML?', 'normal', '', ''),
(316, 12, 'mcq', 8, 'Khai báo nào sau đây sẽ tạo ra một bảng gồm hai dòng, mỗi dòng một ô dữ liệu?', 'normal', '', ''),
(317, 12, 'mcq', 9, 'Hành vi nào sau đây KHÔNG được coi là ứng xử nhân văn trên không gian mạng?', 'normal', '', ''),
(318, 12, 'mcq', 10, 'Hành vi nào sau đây bị xem là vi phạm pháp luật trên không gian mạng?', 'normal', '', ''),
(319, 12, 'mcq', 11, 'Một doanh nghiệp cung cấp dịch vụ trò chơi trực tuyến nhưng không có cơ chế xác minh độ tuổi, dẫn đến việc trẻ em dưới 18 tuổi có thể truy cập và chơi game có nội dung không phù hợp… Theo Nghị định 72/2013/NĐ-CP về quản lý, cung cấp và sử dụng dịch vụ Internet và thông tin trên mạng, doanh nghiệp này có thể vi phạm quy định về điều nào trong điều dưới đây?', 'normal', '', ''),
(320, 12, 'mcq', 12, 'Nhóm nghề nào dưới đây không thuộc nhóm nghề dịch vụ trong ngành công nghệ thông tin?', 'normal', '', ''),
(321, 12, 'mcq', 13, 'Nhóm nghề Thiết kế và Lập trình thuộc ngành nào?', 'normal', '', ''),
(322, 12, 'mcq', 14, 'Nghề đòi hỏi kiến thức chuyên sâu về kĩ thuật phần mềm, có kinh nghiệm về kiểm thử phần mềm là?', 'normal', '', ''),
(323, 12, 'mcq', 15, 'AI tạo sinh là gì?', 'normal', '', ''),
(324, 12, 'mcq', 16, 'Thị giác máy tính là gì?', 'normal', '', ''),
(325, 12, 'mcq', 17, 'Các trợ lý ảo như Google Assistant, Siri có thể làm gì?', 'normal', '', ''),
(326, 12, 'mcq', 18, 'DeepMind của Google trong y tế và chăm sóc sức khỏe có thể làm gì?', 'normal', '', ''),
(327, 12, 'mcq', 19, 'Mạng máy tính là gì?', 'normal', '', ''),
(328, 12, 'mcq', 20, 'Thiết bị nào dưới đây dùng để kết nối các thiết bị sử dụng Internet tới nhà cung cấp dịch vụ Internet?', 'normal', '', ''),
(329, 12, 'mcq', 21, 'Phương án nào sau đây nêu đúng chức năng chính của Access Point (AP)?', 'normal', '', ''),
(330, 12, 'mcq', 22, 'Phần tử nào được sử dụng để xác định phần đầu của một tài liệu HTML?', 'normal', '', ''),
(331, 12, 'mcq', 23, 'Thẻ nào trong phần đầu của tài liệu HTML dùng để khai báo tiêu đề của trang web?', 'normal', '', ''),
(332, 12, 'mcq', 24, 'Phần tử <a> trong HTML được sử dụng để làm gì?', 'normal', '', ''),
(333, 12, 'tf', 25, 'Những nhận định dưới đây là Đúng hay Sai?', 'normal', '', ''),
(334, 12, 'tf', 26, 'Cơ sở dữ liệu quản lý thư viện tại một trường THPT gồm 3 bảng:\r\nSACH (MaSach, TenSach, TenTacgia, NhaXuatban) lưu thông tin: mã sách, tên sách, tên tác giả, nhà xuất bản.\r\nDOCGIA (MaDocgia, TenDocgia, GioiTinh, NgaySinh) lưu thông tin: mã đọc giả, tên đọc giả, giới tính, ngày sinh.\r\nMUONSACH (MaPhieu, MaDocgia, MaSach, NgayMuon, NgayTra) lưu thông tin: mã số phiếu, mã đọc giả, mã sách, ngày mượn, ngày trả.\r\nHọc sinh đưa ra các nhận định như sau:', 'normal', '', ''),
(335, 12, 'tf', 27, 'Quản lý cửa hàng bán sản phẩm Cơ sở dữ liệu của một cửa hàng gồm 3 bảng: \r\n- SANPHAM(MaSP, TenSP, GiaBan, LoaiSP) Lưu mã sản phẩm, tên sản phẩm, giá bán, loại sản phẩm. \r\n- HOADON(MaHD, NgayLap, TongTien) Lưu mã hoá đơn, ngày lập hoá đơn, tổng tiền hoá đơn. \r\n- CTHD(MaHD, MaSP, SoLuong, ThanhTien) Lưu chi tiết hoá đơn: mã hoá đơn, mã sản phẩm, số lượng bán, thành tiền (SoLuong * GiaBan). \r\nCó một ý kiến nhận xét như sau:', 'normal', '', ''),
(336, 12, 'tf', 28, 'Cho chương trình HTML sau:\r\n\r\n```html\r\n<!DOCTYPE html>\r\n<html>\r\n<head>\r\n    <title>Bài tập HTML</title>\r\n</head>\r\n<body>\r\n    <h1>Đây là một tiêu đề</h1>\r\n    <p>Đây là một đoạn văn.</p>\r\n    <img src=\"anh.jpg\" alt=\"Một bức ảnh\">\r\n    <a href=\"https://example.com\">Truy cập website</a>\r\n</body>\r\n</html>\r\n\r\n```\r\nMột số bạn đưa ra ý kiến như sau:\r\n', 'normal', '', ''),
(337, 13, 'mcq', 1, 'Một trong những cảnh báo về AI trong tương lai là gì?', 'normal', '', ''),
(338, 13, 'mcq', 2, 'Trí tuệ nhân tạo hẹp (AI yếu) được thiết kế để làm gì?', 'normal', '', ''),
(339, 13, 'mcq', 3, 'Khả năng nào của AI cho phép máy tính điều chỉnh hành vi dựa trên dữ liệu mới?', 'normal', '', ''),
(340, 13, 'mcq', 4, 'Một nhà máy sản xuất ô tô muốn ứng dụng AI để cải thiện quy trình sản xuất. Theo bạn, giải pháp nào sau đây sử dụng AI một cách hiệu quả nhất?', 'normal', '', ''),
(341, 13, 'mcq', 5, 'Không gian mạng là gì?', 'normal', '', ''),
(342, 13, 'mcq', 6, 'Khi xảy ra tranh luận hoặc mâu thuẫn trên mạng, bạn nên xử lý như thế nào?', 'normal', '', ''),
(343, 13, 'mcq', 7, 'Giao thức TCP/IP có nhiều tính năng quan trọng. Tuy nhiên, tính năng nào sau đây KHÔNG thuộc về TCP/IP?', 'normal', '', ''),
(344, 13, 'mcq', 8, 'Tường lửa có vai trò gì trong việc bảo vệ mạng?', 'normal', '', ''),
(345, 13, 'mcq', 9, 'Thẻ nào dưới đây được dùng để tạo danh sách trong HTML:', 'normal', '', ''),
(346, 13, 'mcq', 10, 'Phần tử <title> nằm trong phần tử nào sau đây?', 'normal', '', ''),
(347, 13, 'mcq', 11, 'Thẻ HTML nào sau đây tạo ra một ô nhập dữ liệu văn bản (ô text)?', 'normal', '', ''),
(348, 13, 'mcq', 12, 'Thuộc tính nào dưới đây dùng để thay đổi màu đường viền của một phần', 'normal', '', ''),
(349, 13, 'mcq', 13, 'Để đặt màu nền đen (#000000) cho một phần tử, cách khai báo nào sau chính xác?', 'normal', '', ''),
(350, 13, 'mcq', 14, 'Để đặt kích thước phông chữ là 16px cho một phần tử, cách khai bộ thị phần tử sau đây là chính xác?', 'normal', '', ''),
(351, 13, 'mcq', 15, 'Để đặt màu đen cho đường viền của một phần tử, cách khai báo nào sau đây là chính xác?', 'normal', '', ''),
(352, 13, 'mcq', 16, 'Để đặt kích thước dài 100px, rộng 100px cho một phần tử, cách khai báo nào sau đây là chính xác?', 'normal', '', ''),
(353, 13, 'mcq', 17, 'Cần chèn một video có tên là caphe.mp4 trên một trang web. Khung hình của video có độ rộng 640px và độ cao 380px. Phương án nào sau đây phù hợp để thực hiện nhiệm vụ này?', 'normal', '', ''),
(354, 13, 'mcq', 18, 'Các quy tắc ứng xử trên mạng xã hội phù hợp với quy định của pháp luật được nêu trong văn bản nào?', 'normal', '', ''),
(355, 13, 'mcq', 19, 'Trong trường hợp có xung đột hoặc tranh luận trên mạng, cách giải quyết phù hợp nhất là gì?', 'normal', '', ''),
(356, 13, 'mcq', 20, 'Hà tham gia một diễn đàn trực tuyến về sách. Cô chia sẻ ý kiến về cuốn sách mới ra mắt trên MXH facebook và nhận được nhiều phản hồi từ các thành viên khác. Trong số đó, có một bạn tên Tuấn đã bình luận cho rằng ý kiến của Hà không có cơ sở, căn cứ. Theo em, Hà nên xử lí tình huống trên thế nào?', 'normal', '', ''),
(357, 13, 'mcq', 21, 'Công việc nào sau đây là của người làm nghề Sửa chữa và bảo trì máy tính?', 'normal', '', ''),
(358, 13, 'mcq', 22, 'Công việc nào sau đây là của người Quản trị mạng?', 'normal', '', ''),
(359, 13, 'mcq', 23, 'Phát biểu nào sau đây nêu đúng nguyên nhân dẫn tới sự gia tăng nhu cầu nhân lực Bảo mật hệ thống thông tin?', 'normal', '', ''),
(360, 13, 'mcq', 24, ' Cho khai báo mảng và đoạn chương trình như sau:\r\nĐoạn chương trình trên thực hiện công việc gì sau đây? \r\n', 'python,cpp', 'k = 0\r\nfor i in range (1, len (A))\r\n            if A[i]> A[k]\r\n                          k = i\r\n\r\n', 'int k = 0; \r\n    for (int i = 1; i < A.size(); i++) {\r\n             if (A[i] > A[k]) {\r\n                        k = i;\r\n        }\r\n    }\r\n'),
(361, 13, 'tf', 25, 'Thông thường mạng có vài chục hoặc vài trăm máy trạm, hoạt động trong phạm vi một toà nhà, một gia đình hay cơ quan cỡ nhỏ thì được gọi là mạng LAN, còn gọi là Mạng cục bộ hay Mạng nội bộ. MAN là loại mạng có số lượng máy trạm và phạm vi hoạt động lớn hơn so với LAN. Ở thời kì đầu mạng LAN chỉ sử dụng cáp mạng, hiện nay công nghệ truyền không dây của mạng Wi-Fi giúp các máy trạm trao đổi dữ liệu thuận tiện và dễ dàng hơn.\r\nSau khi đọc nhận xét trên, một số bạn đưa ra ý kiến như sau:', 'normal', '', ''),
(362, 13, 'tf', 26, 'Bạn A muốn tạo liên kết tới các trang con trong trang web của mình và thêm các hiệu ứng làm nổi bật các liên kết đó. Bạn đã viết code HTML với khai báo CSS tương ứng như sau:\r\n\r\n```html\r\nCode HTML\r\n <header>\r\n<nav>\r\n<ul>\r\n|<li><a href=\"#\">Nông sản Tây Nguyên</a></li> \r\n<li><a href=\"#\">Cà phê</a></li>\r\n<li><a href=\"#\">Tiêu</a></li>\r\n<li><a href=\"#\">Hạt điều</a></li>\r\n</ul>\r\n</nav>\r\n</header>\r\n\r\n\r\n```\r\n\r\n```html\r\nKhai báo CSS\r\nnav ul {\r\n            list-style: none;\r\n}\r\nnav ul li {\r\n                display: inline; \r\n                margin-right: 20px;\r\n}\r\nnav ul li:hover { \r\n                 color: green;\r\n}\r\n\r\n\r\n```\r\n', 'normal', '', ''),
(363, 13, 'tf', 27, 'Một bạn sử dụng phần mềm tạo trang web để tạo website giới thiệu về nông sản Đăk Lăk gồm: Trang chủ, Sản phẩm nông sản Đăk Lăk và Liên hệ. Bạn muốn tạo phần đầu trang có biểu ngữ, logo và thanh điều hướng để liên kết các trang web trong website với nhau. Bạn có một vài nhận xét như sau:\r\n', 'normal', '', ''),
(364, 13, 'tf', 28, 'Một cơ sở dữ liệu quản lí nhân sự của một công ty gồm các bảng có cấutrúc như sau:\r\nBảng nhanvien (idNhanvien, hoten, ngaysinh, diachi, soDT, idPhong) lưu id nhân viên, họ tên, ngày sinh, địa chỉ liên hệ, số điện thoại, id phòng quản lí nhân viên đó.\r\nBảng phong (idPhong, tenphong, diachiPhong) lưu id phòng, tên phòng, địa chỉ làm việc của phòng.\r\nTrong đó, idNhanvien, idPhong đều là kiểu số nguyên (int), nhận giá trị ban đầu là 0 và tự động tăng lên 1 mỗi khi một bản ghi mới được thêm vào bảng. Một số bạn học sinh đưa ra các ý kiến về việc khai thác cơ sở dữ liệu trên như sau:', 'normal', '', ''),
(365, 14, 'mcq', 1, 'AI được ứng dụng vào thiết bị nào dưới đây', 'normal', '', ''),
(366, 14, 'mcq', 2, 'Khả năng nào sau đây không phải là đặc trưng của trí tuệ nhân tạo (AI)?', 'normal', '', ''),
(367, 14, 'mcq', 3, 'Ứng dụng nào sau đây thể hiện rõ học máy (machine learning) trong y tế?', 'normal', '', ''),
(368, 14, 'mcq', 4, 'Nguy cơ nào sau đây không liên quan đến sự phát triển của AI?', 'normal', '', ''),
(369, 14, 'mcq', 5, 'Thiết bị nào sau đây có chức năng chính là định tuyến trong mạng?', 'normal', '', ''),
(370, 14, 'mcq', 6, 'Thiết bị nào không cần thiết để xây dựng mạng LAN?', 'normal', '', ''),
(371, 14, 'mcq', 7, 'Phương án nào sau đây nêu đúng chức năng chính của Access Point (AP)?', 'normal', '', ''),
(372, 14, 'mcq', 8, 'Phần đầu của văn bản HTML được xác định thông qua phần tử', 'normal', '', ''),
(373, 14, 'mcq', 9, 'Cú pháp nào sau đây dùng để làm in đậm từ “Nội dung”', 'normal', '', ''),
(374, 14, 'mcq', 10, 'Cú pháp nào sau đây dùng để đánh dấu từ “Nội dung”', 'normal', '', ''),
(375, 14, 'mcq', 11, 'Đoạn mã HTML nào sau đây không hợp lệ?', 'normal', '', ''),
(376, 14, 'mcq', 12, 'So sánh sự khác nhau giữa thuộc tính type=\"a\" và type=\"i\" của thẻ <ol> trong HTML. Hãy chọn phương án đúng', 'normal', '', ''),
(377, 14, 'mcq', 13, 'Đâu là cú pháp đúng để chèn biểu tượng (icon) từ một tệp hình ảnh?', 'normal', '', ''),
(378, 14, 'mcq', 14, 'Đoạn mã CSS nào sau đây thiết lập màu chữ đỏ cho tất cả các phần tử lớp warning?', 'normal', '', ''),
(379, 14, 'mcq', 15, 'Cho bộ chọn sau được khai báo trong phần <style>:\r\n.highlight {color: orange; font-weight: bold; font-size: 14px;}\r\nPhương án nào sau đây nêu đúng phạm vi áp dụng của bộ chọn .highlight  đối với các phần tử trong trang web?', 'normal', '', ''),
(380, 14, 'mcq', 16, 'Hành vi nào sau đây KHÔNG được coi là ứng xử nhân văn trên không gian mạng?', 'normal', '', ''),
(381, 14, 'mcq', 17, 'Hành vi nào sau đây vi phạm quyền sở hữu trí tuệ?', 'normal', '', ''),
(382, 14, 'mcq', 18, 'Hành vi mạo danh tài khoản của người khác trên mạng xã hội để lợi dụng hoặc lừa đảo người dùng khác là vi phạm điều nào?', 'normal', '', ''),
(383, 14, 'mcq', 19, 'Công việc nào dưới đây thuộc nhóm nghề an toàn thông tin?', 'normal', '', ''),
(384, 14, 'mcq', 20, 'Công việc nào dưới đây thuộc nhóm nghề thiết kế đồ họa?', 'normal', '', ''),
(385, 14, 'mcq', 21, 'Lý do nào sau đây là lý do chính khiến nhu cầu tuyển dụng kỹ sư mạng gia tăng?', 'normal', '', ''),
(386, 14, 'mcq', 22, 'Chọn một trong hai ngôn ngữ Python hoặc C++ để xem xét đoạn chương trình sau:\r\nPhương án nào dưới đây nêu đúng giá trị của S sau khi thực hiện đoạn chương trình trên?\r\n', 'python,cpp', 'S = 0\r\ni = 1\r\nwhile i < 10:\r\n    S += i\r\n    i += 2\r\nprint(S)\r\n', 'int S = 0;\r\nint i = 1;\r\nwhile (i < 10) {\r\n    S += i;\r\n    i += 2;\r\n}\r\ncout << S;\r\n'),
(387, 14, 'mcq', 23, 'Cho đoạn mã HTML và CSS như sau: \r\n\r\nDòng chữ “Tin mới nhất” sẽ hiển thị như thế nào?\r\n\r\n<table class=\"w-full border-collapse border border-slate-300 mt-2 mb-2\">\r\n  <tbody>\r\n    <tr>\r\n      <td class=\"border border-slate-300 px-4 py-3 align-top\">&lt;head&gt; &lt;style&gt;<br>    #new {color: purple;  font-size: 20px;}<br>    h1 {color: black;   font-size: 24px;}<br>&lt;/style&gt; &lt;/head&gt;<br>&lt;body&gt; &lt;h1 id=\"new\"&gt;Tin mới nhất&lt;/h1&gt; &lt;/body&gt;</td>\r\n    </tr>\r\n  </tbody>\r\n</table>\r\n', 'normal', '', ''),
(388, 14, 'mcq', 24, 'Một phòng máy tính được trang bị 1 máy chủ (server) và nhiều máy trạm (client). Giáo viên muốn chia sẻ một thư mục tài liệu trên máy chủ để tất cả máy trạm đều có thể truy cập. Dưới đây là các bước cần thực hiện:\r\n1. Chia sẻ thư mục tài liệu (thông qua tính năng chia sẻ trong HĐH).\r\n2. Phân quyền (read/write) cho các tài khoản tương ứng.\r\n3. Tạo tài khoản (username, password) cho từng máy trạm trên máy chủ.\r\nHãy chọn thứ tự đúng để thiết lập chia sẻ thành công:\r\n', 'normal', '', ''),
(389, 14, 'tf', 25, 'Một công ty muốn triển khai hệ thống mạng WAN kết nối các chi nhánh. Các ý kiến sau được đưa ra:', 'normal', '', ''),
(390, 14, 'tf', 26, 'Quản lý thông tin khách hàng tại một ngân hàng\r\nMột ngân hàng quản lý thông tin khách hàng và tài khoản với cơ sở dữ liệu quan hệ gồm 3 bảng:\r\nKHACHHANG (MaKH, HoTen, GioiTinh, NgaySinh) lưu thông tin mã khách hàng, họ tên, giới tính và ngày sinh.\r\nTAIKHOAN (SoTK, LoaiTK, SoDu) lưu thông tin số tài khoản, loại tài khoản và số dư hiện tại.\r\nGIAODICH (SoTK, MaKH, SoTien, NgayGD) lưu thông tin số tài khoản, mã khách hàng thực hiện giao dịch, số tiền và ngày giao dịch.\r\nMột khách hàng có thể có nhiều tài khoản, và một tài khoản có thể có nhiều giao dịch.\r\nNhững nhận xét sau đây là đúng hay sai?', 'normal', '', ''),
(391, 14, 'tf', 27, 'Xây dựng website cửa hàng trực tuyến\r\nMột cửa hàng sách online muốn xây dựng một website để giới thiệu và bán sách. Website sẽ có các trang: Trang chủ, Danh mục sách, Giỏ hàng, Liên hệ. Khi tìm hiểu về hệ thống này một bạn học sinh có nhận xét như sau:', 'normal', '', ''),
(392, 14, 'tf', 28, 'Quản lý cửa hàng bán sản phẩm\r\nCơ sở dữ liệu của một cửa hàng gồm 3 bảng:\r\nSANPHAM(MaSP, TenSP, GiaBan, LoaiSP) Lưu mã sản phẩm, tên sản phẩm, giá bán, loại sản phẩm.\r\nHOADON(MaHD, NgayLap, TongTien) Lưu mã hoá đơn, ngày lập hoá đơn, tổng tiền hoá đơn.\r\nCTHD(MaHD, MaSP, SoLuong, ThanhTien) Lưu chi tiết hoá đơn: mã hoá đơn, mã sản phẩm, số lượng bán, thành tiền (SoLuong * GiaBan).\r\nCó một ý kiến nhận xét như sau:', 'normal', '', ''),
(393, 15, 'mcq', 1, 'Kết quả của đoạn mã Python sau là gì?\r\n', 'python', 'x = 2\r\nfor i in range(3):\r\n    x += i\r\nprint(x)\r\n', ''),
(394, 15, 'mcq', 2, 'Thiết bị nào có thể sử dụng nhận diện khuôn mặt để mở khóa?', 'normal', '', ''),
(395, 15, 'mcq', 3, 'Trí tuệ nhân tạo có thể ứng dụng vào lĩnh vực nào dưới đây?', 'normal', '', ''),
(396, 15, 'mcq', 4, 'Hệ thống nào sử dụng AI trong việc nhận diện hình ảnh?', 'normal', '', ''),
(397, 15, 'mcq', 5, 'Một trong những thách thức lớn của AI là gì?', 'normal', '', ''),
(398, 15, 'mcq', 6, 'Thiết bị nào sau đây giúp kết nối với mạng Wi-Fi?', 'normal', '', ''),
(399, 15, 'mcq', 7, 'Giao thức nào giúp bảo mật trong việc truyền tải dữ liệu trực tuyến?', 'normal', '', ''),
(400, 15, 'mcq', 8, 'Lợi ích chính của VPN là gì?', 'normal', '', ''),
(401, 15, 'mcq', 9, 'Khi cần chia sẻ file lớn qua Internet, bạn nên sử dụng dịch vụ nào?', 'normal', '', ''),
(402, 15, 'mcq', 10, 'Thuộc tính nào trong HTML dùng để chỉ định đường dẫn đến ảnh?', 'normal', '', ''),
(403, 15, 'mcq', 11, 'Đoạn CSS nào dùng để thay đổi kích thước chữ?', 'normal', '', ''),
(404, 15, 'mcq', 12, 'Để tạo danh sách có thứ tự trong HTML, ta dùng thẻ nào?', 'normal', '', ''),
(405, 15, 'mcq', 13, 'Thẻ HTML nào dùng để nhúng video?', 'normal', '', ''),
(406, 15, 'mcq', 14, 'Thẻ HTML nào dùng để tạo input text?', 'normal', '', ''),
(407, 15, 'mcq', 15, 'Hành vi nào là bảo mật tốt khi sử dụng mạng?', 'normal', '', ''),
(408, 15, 'mcq', 16, 'Hành vi nào có thể vi phạm Luật An ninh mạng?', 'normal', '', ''),
(409, 15, 'mcq', 17, 'Nghề nào liên quan đến việc xây dựng hệ thống bảo mật mạng?', 'normal', '', ''),
(410, 15, 'mcq', 18, 'Dữ liệu lớn (Big Data) có thể giúp doanh nghiệp trong việc gì?', 'normal', '', ''),
(411, 15, 'mcq', 19, 'Vì sao kỹ năng lập trình quan trọng trong thời đại công nghệ số?', 'normal', '', ''),
(412, 15, 'mcq', 20, 'Khi gặp thông tin sai lệch trên Internet, bạn nên làm gì?', 'normal', '', ''),
(413, 15, 'mcq', 21, 'Cách tốt nhất để bảo vệ thông tin cá nhân trên mạng là gì?', 'normal', '', ''),
(414, 15, 'mcq', 22, 'Nghề nào phù hợp với người yêu thích làm việc với dữ liệu?', 'normal', '', ''),
(415, 15, 'mcq', 23, 'Công nghệ nào giúp máy tính học từ dữ liệu mà không cần lập trình trực tiếp?', 'normal', '', ''),
(416, 15, 'mcq', 24, 'Vì sao điện toán đám mây (Cloud Computing) quan trọng?', 'normal', '', ''),
(417, 15, 'tf', 25, 'Một công ty triển khai các biện pháp bảo mật để bảo vệ hệ thống thông tin. Các nhận định:', 'normal', '', ''),
(418, 15, 'tf', 26, 'Một doanh nghiệp sử dụng hệ thống cơ sở dữ liệu để quản lý khách hàng. Nhận định:', 'normal', '', ''),
(419, 15, 'tf', 27, 'Một doanh nghiệp muốn xây dựng trang web bán hàng trực tuyến. Nhận định:', 'normal', '', ''),
(420, 15, 'tf', 28, 'Một công ty sử dụng dữ liệu lớn (Big Data) để cải thiện dịch vụ khách hàng. Nhận định:', 'normal', '', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `score` decimal(4,2) DEFAULT NULL,
  `mcq_score` decimal(4,2) DEFAULT NULL,
  `tf_score` decimal(4,2) DEFAULT NULL,
  `time_taken` int(11) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `device` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


--
-- Cấu trúc bảng cho bảng `result_details`
--

CREATE TABLE `result_details` (
  `id` int(11) NOT NULL,
  `result_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `user_answer` mediumtext DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT NULL,
  `points` decimal(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



--
-- Cấu trúc bảng cho bảng `settings`
--

CREATE TABLE `settings` (
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `settings`
--

INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES
('favicon', 'uploads/img_69e41dd0200d1_1776557520.png'),
('logo_icon', 'fa-solid fa-laptop-code'),
('logo_image', ''),
('logo_type', 'icon');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `answers_mcq`
--
ALTER TABLE `answers_mcq`
  ADD PRIMARY KEY (`question_id`);

--
-- Chỉ mục cho bảng `answers_tf`
--
ALTER TABLE `answers_tf`
  ADD PRIMARY KEY (`question_id`);

--
-- Chỉ mục cho bảng `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Chỉ mục cho bảng `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Chỉ mục cho bảng `result_details`
--
ALTER TABLE `result_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `result_id` (`result_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Chỉ mục cho bảng `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_key`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=421;

--
-- AUTO_INCREMENT cho bảng `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT cho bảng `result_details`
--
ALTER TABLE `result_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1485;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ràng buộc đối với các bảng kết xuất
--

--
-- Ràng buộc cho bảng `answers_mcq`
--
ALTER TABLE `answers_mcq`
  ADD CONSTRAINT `answers_mcq_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `answers_tf`
--
ALTER TABLE `answers_tf`
  ADD CONSTRAINT `answers_tf_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `results_ibfk_2` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `result_details`
--
ALTER TABLE `result_details`
  ADD CONSTRAINT `result_details_ibfk_1` FOREIGN KEY (`result_id`) REFERENCES `results` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `result_details_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
