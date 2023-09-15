-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th9 15, 2023 lúc 04:51 AM
-- Phiên bản máy phục vụ: 10.4.27-MariaDB
-- Phiên bản PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `webclotherphp`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `idproduct` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`id`, `username`, `idproduct`, `quantity`) VALUES
(296, 'phamthinga', 106, 1),
(298, 'hoadoan207', 99, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `trademark` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `datecreated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id`, `name`, `trademark`, `status`, `datecreated`) VALUES
(1, 'Céline', 'Céline', 1, '2023-06-09'),
(43, 'Hermès', 'Hermès', 1, '2023-09-12'),
(44, 'Gucci', 'Gucci', 0, '2023-09-12'),
(45, 'Loewe', 'Loewe', 0, '2023-09-12'),
(46, 'Louis Vuitton', 'Louis Vuitton', 0, '2023-09-12'),
(47, 'Chanel', 'Chanel', 0, '2023-09-12'),
(48, 'Prada', 'Prada', 0, '2023-09-12'),
(49, 'Christian Dior', 'Christian Dior', 0, '2023-09-12'),
(50, 'Versace', 'Versace', 0, '2023-09-12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `info_ship`
--

CREATE TABLE `info_ship` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `phonenumber` varchar(11) NOT NULL,
  `address` varchar(200) NOT NULL,
  `note` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `info_ship`
--

INSERT INTO `info_ship` (`id`, `username`, `fullname`, `phonenumber`, `address`, `note`) VALUES
(51, 'phamthinga', 'phamthinga', '0335630884', '523/25 trưng nữ vương', 1),
(52, 'phamthinga', 'dangquochuy', '0334640332', '523/25 trưng nữ vương', 0),
(53, 'hoadoan207', 'hoadoan', '0387380570', '127 Pham Van Xao', 0),
(54, 'hoadoan207', 'hoadoan', '0355675450', '523/25 trưng nữ vương', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `oder`
--

CREATE TABLE `oder` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_info_ship` int(11) NOT NULL,
  `payment_status` int(11) NOT NULL,
  `admin_status` int(11) NOT NULL DEFAULT 0,
  `order_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `oder`
--

INSERT INTO `oder` (`id`, `username`, `payment_method`, `create_at`, `update_at`, `id_info_ship`, `payment_status`, `admin_status`, `order_status`) VALUES
(146, 'phamthinga', 'Thanh Toán Khi Nhận Hàng', '2023-09-13 00:48:17', '2023-09-13 07:53:13', 51, 1, 1, 1),
(147, 'phamthinga', 'Thanh Toán Khi Nhận Hàng', '2023-09-13 00:52:41', '2023-09-13 07:57:15', 51, 0, 2, 0),
(148, 'phamthinga', 'Thanh Toán Khi Nhận Hàng', '2023-09-13 00:55:45', '2023-09-13 07:57:56', 51, 0, 1, 0),
(149, 'phamthinga', 'PayPal', '2023-09-13 01:09:18', '2023-09-13 08:10:02', 51, 1, 1, 1),
(150, 'phamthinga', 'Thanh Toán Khi Nhận Hàng', '2023-09-13 01:57:16', '2023-09-13 09:12:11', 51, 0, 2, 0),
(151, 'phamthinga', 'Thanh Toán Khi Nhận Hàng', '2023-09-13 02:35:28', '2023-09-14 01:42:05', 51, 0, 2, 0),
(152, 'phamthinga', 'PayPal', '2023-09-13 18:40:52', '2023-09-14 01:40:52', 51, 1, 1, 0),
(153, 'phamthinga', 'Thanh Toán Khi Nhận Hàng', '2023-09-13 18:48:01', '2023-09-14 01:48:01', 51, 0, 0, 0),
(154, 'hoadoan207', 'Thanh Toán Khi Nhận Hàng', '2023-09-14 03:11:59', '2023-09-14 10:11:59', 54, 0, 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `oder_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_detail`
--

INSERT INTO `order_detail` (`id`, `oder_id`, `product_id`, `product_price`, `product_quantity`) VALUES
(90, 146, 103, 121000, 4),
(91, 146, 100, 121000, 5),
(92, 147, 101, 311000, 2),
(93, 148, 101, 311000, 4),
(94, 149, 107, 531000, 6),
(95, 150, 101, 311000, 1),
(96, 150, 105, 324000, 4),
(97, 150, 104, 121000, 6),
(98, 151, 105, 324000, 4),
(99, 152, 104, 121000, 4),
(100, 153, 104, 121000, 4),
(101, 153, 101, 311000, 1),
(102, 154, 101, 311000, 34);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(50) NOT NULL,
  `describe` text NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(255) NOT NULL,
  `color` varchar(50) NOT NULL,
  `datecreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `catalogcode` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `describe`, `quantity`, `image`, `color`, `datecreated`, `update_at`, `catalogcode`, `status`) VALUES
(98, 'Áo Khoác', 134000, 'Thương hiệu Céline nổi tiếng về đồ da và quần áo nổi tiếng, cao cấp. Những mẫu thiết kế của Céline luôn hướng đến phong cách sang trọng, trẻ trung, thời thượng, vừa cổ điển vừa hiện đại, đặc biệt là tính ứng dụng cao trong cuộc sống hàng ngày. ', 56, '65003e38cf0a7_pc-ao-khoac-du-nam-truot-nuoc-mau-xanh-da-quang-large-1669600982-6771.jpg', 'trắng', '2023-09-12 03:13:41', '2023-09-13 01:00:50', 43, 0),
(99, 'Túi xách', 134000, 'Loewe được biết đến là một thương hiệu thời trang nổi tiếng thế giới với các mẫu túi xách, quần áo cao cấp. Những sản phẩm túi xách của Loewe như Puzzle và Gate,.. là những sản phẩm thủ công được làm từ da. Mỗi sản phẩm của Loewe luôn đem sự mới lạ và trẻ trung khi khách hàng diện chúng lên người.', 56, '65026fb39f69d_images (5).jpg', 'trắng', '2023-09-12 03:29:40', '2023-09-13 19:28:03', 45, 0),
(100, 'Áo Da', 121000, 'Louis Vuitton là nhãn hiệu thời trang nổi tiếng và có giá trị cao cấp nhất thế giới hiện nay. Các sản phẩm của thương hiệu này đều có nét đặc trưng là họa tiết chữ LV lồng vào nhau cùng hoa bốn thùy (monogram) quen thuộc trên nền da hoặc vải canvas thượng hạng.', 67, '65006f810807f_cac-thuong-hieu-thoi-trang-noi-tieng.png', 'nâu xám', '2023-09-12 07:02:40', '2023-09-13 19:52:40', 46, 0),
(101, 'Áo Gucci', 311000, 'Gucci có sự phát triển vô cùng mạnh mẽ, trở thành biểu tượng thời trang hàng đầu thế giới với những dòng sản phẩm độc đáo, đẳng cấp và đại diện cho thương hiệu xa xỉ bậc nhất hiện nay.', 34, '65006fde3aa1f_images (3).jpg', 'đỏ', '2023-09-12 07:04:14', '2023-09-13 19:52:45', 44, 0),
(102, 'Áo Bơi', 321112, 'Thương hiệu Céline nổi tiếng về đồ da và quần áo nổi tiếng, cao cấp. Những mẫu thiết kế của Céline luôn hướng đến phong cách sang trọng, trẻ trung, thời thượng, vừa cổ điển vừa hiện đại, đặc biệt là tính ứng dụng cao trong cuộc sống hàng ngày. ', 34, '6500703d13dc8_images (4).jpg', 'xanh', '2023-09-12 07:05:49', '2023-09-13 19:52:53', 1, 0),
(103, 'Giày ', 121000, 'Mỗi sản phẩm của Chanel đều mang phong cách đẳng cấp, luôn đề cao sự sang trọng, xa hoa, quyền quý và sự tinh tế lên đến cực đỉnh từ nước hoa, quần áo, đồng hồ,…', 52, '650276e9cb2c3_images (10).jpg', 'đen', '2023-09-12 07:08:34', '2023-09-13 19:58:49', 47, 0),
(104, 'Áo lót', 121000, 'Ngày nay, áo ba lỗ trắng vẫn thường xuất hiện trên sàn diễn của các hãng thời trang xa xỉ, nhưng ít ai biết rằng áo ba lỗ trắng, hay còn gọi là tank top trắng, đã có một lịch sử thú vị từ vài thế kỷ trước. Ban đầu, chiếc áo chỉ được sử dụng làm đồ lót, đặc biệt được những người dân lao động ưa hay người chơi thể thao ưa chuộng vì tính chất nhẹ nhàng và thoáng khí. ', 52, '65027039816c2_images (8).jpg', 'trắng', '2023-09-13 01:02:29', '2023-09-13 19:30:17', 44, 0),
(105, 'Váy', 324000, 'Đầm maxi đi biển cho người thấp là một trong những từ khóa được các bạn gái tìm kiếm nhiều nhất, đặc biệt là vào mùa hè. Sở hữu đôi chân khiêm tốn ngăn cản bạn trong việc lựa chọn đầm maxi? Hãy cùng FM STYLE điểm qua các mẫu đầm maxi đi biển cho người thấp đẹp sau đây để tự tin diện trong những chuyến vui chơi hoặc du lịch nhé.', 123, '65016ce9c5b2b_tải xuống (2).jpg', 'trắng', '2023-09-13 01:03:53', '2023-09-13 08:03:53', 46, 0),
(106, 'Váy xòe', 231000, 'Đầm maxi đi biển cho người thấp là một trong những từ khóa được các bạn gái tìm kiếm nhiều nhất, đặc biệt là vào mùa hè. Sở hữu đôi chân khiêm tốn ngăn cản bạn trong việc lựa chọn đầm maxi? Hãy cùng FM STYLE điểm qua các mẫu đầm maxi đi biển cho người thấp đẹp sau đây để tự tin diện trong những chuyến vui chơi hoặc du lịch nhé.', 31, '65016d2e82dc0_dam-maxi-di-bien-cho-nguoi-thap-co-yem copy (1).jpg', 'nâu xám', '2023-09-13 01:05:02', '2023-09-13 19:53:00', 45, 0),
(107, 'Đầm', 531000, 'Đầm maxi đi biển cho người thấp là một trong những từ khóa được các bạn gái tìm kiếm nhiều nhất, đặc biệt là vào mùa hè. Sở hữu đôi chân khiêm tốn ngăn cản bạn trong việc lựa chọn đầm maxi? Hãy cùng FM STYLE điểm qua các mẫu đầm maxi đi biển cho người thấp đẹp sau đây để tự tin diện trong những chuyến vui chơi hoặc du lịch nhé.', 50, '65016d7e36724_vay-maxi-di bien-tre-vai.jpg', 'nâu xám', '2023-09-13 01:06:22', '2023-09-13 08:09:18', 47, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `username` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `permission` int(11) NOT NULL DEFAULT 0,
  `verificationcodes` varchar(50) NOT NULL,
  `forgot_code` varchar(100) NOT NULL,
  `datecreated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `vertified` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`username`, `password`, `email`, `name`, `image`, `phone`, `permission`, `verificationcodes`, `forgot_code`, `datecreated`, `vertified`) VALUES
('admin', '$2y$10$4BLjIhcGTIxJMXbyIs24Ce3CMqGzcheYCGI4OLXsGTm6.lUhCLEjy', 'huyhuydai059@gmail.com', '', '', '', 1, '267055', '', '2023-09-12 07:00:13', 1),
('asa', '$2y$10$21Ox4EdRz29tkbe0CnasMOuRprG7zTWthHm2IWr.w/wXtyoWOh3KK', 'ngap2504@gmail.com', '', '', '', 0, '347198', '', '2023-09-14 09:51:41', 1),
('hoadoan202', '$2y$10$JTdSTYOxcU//5EsEwpClwu12eEXC0uUUGWy74kEsnffe9wxkgNul2', 'hoadchoadc2@gmail.com', '', '', '', 0, '187770', '', '2023-09-14 10:00:42', 0),
('hoadoan207', '$2y$10$ydpXBYQ3wxia4/m8wxnTt.MCyWyiFPu4cw0FRlQ/4ScekDT5msa4G', 'hoadchoadc@gmail.com', 'hoa doan', '6502da968a8fe_images (8).jpg', '0123456789', 0, '288092', '', '2023-09-14 10:07:15', 1),
('phamthinga', '$2y$10$NCoG2cBhYctMTvlqkE4WtORt/ZN3EyhOjdeEaMZ4/LHhgoc.KIiUq', 'dqh28092001@gmail.com', 'phạm thị nga', '65013444d7979_khach.jpg', '0334630884', 0, '143553', '2579695047b14cf408c60f37ecb8b3535d0c55af0eb26399864a601f5969888ff48143aea2b6a08851ec99bbe7c288945a97', '2023-09-13 07:09:41', 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_cart_users` (`username`),
  ADD KEY `FK_cart_product` (`idproduct`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `info_ship`
--
ALTER TABLE `info_ship`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_info_ship_user` (`username`);

--
-- Chỉ mục cho bảng `oder`
--
ALTER TABLE `oder`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_info_ship` (`id_info_ship`);

--
-- Chỉ mục cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_oder_detail_oder` (`oder_id`),
  ADD KEY `fk_order_detail_product` (`product_id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Product_categogy` (`catalogcode`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=299;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT cho bảng `info_ship`
--
ALTER TABLE `info_ship`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT cho bảng `oder`
--
ALTER TABLE `oder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `FK_cart_product` FOREIGN KEY (`idproduct`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_cart_users` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Các ràng buộc cho bảng `info_ship`
--
ALTER TABLE `info_ship`
  ADD CONSTRAINT `fk_info_ship_user` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Các ràng buộc cho bảng `oder`
--
ALTER TABLE `oder`
  ADD CONSTRAINT `fk_order_info_ship` FOREIGN KEY (`id_info_ship`) REFERENCES `info_ship` (`id`);

--
-- Các ràng buộc cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `fk_oder_detail_oder` FOREIGN KEY (`oder_id`) REFERENCES `oder` (`id`),
  ADD CONSTRAINT `fk_order_detail_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_Product_categogy` FOREIGN KEY (`catalogcode`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
