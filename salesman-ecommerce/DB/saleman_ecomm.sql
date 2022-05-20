-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 08, 2022 lúc 04:47 AM
-- Phiên bản máy phục vụ: 10.4.20-MariaDB
-- Phiên bản PHP: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `saleman_ecomm`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `area_active`
--

CREATE TABLE `area_active` (
  `id` int(11) NOT NULL,
  `area_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `area_active`
--

INSERT INTO `area_active` (`id`, `area_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'HC001', 'Hải Châu', NULL, NULL),
(2, 'CL001', 'Cẩm Lệ', NULL, NULL),
(3, 'NHS001', 'Ngũ Hành Sơn', NULL, NULL),
(4, 'ST001', 'Sơn Trà', NULL, NULL),
(5, 'HQ001', 'Hòa Quý', NULL, NULL),
(6, 'HH001', 'Hòa Hải', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `category_id`, `name`, `image`, `created_at`, `updated_at`) VALUES
(1, 'CATE001', 'Women\'s fashion', '1', NULL, '2022-01-07 06:43:55'),
(2, 'CATE002', 'Men\' fashion', '1', NULL, '2022-01-07 20:47:20'),
(3, 'CATE003', 'Laptop', '1', '2022-01-07 06:34:30', '2022-01-07 06:34:30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `checkin_address`
--

CREATE TABLE `checkin_address` (
  `id` int(11) NOT NULL,
  `checkin_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salesman_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` double NOT NULL,
  `long` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `customer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` double NOT NULL,
  `long` double NOT NULL,
  `area_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `images` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `customer`
--

INSERT INTO `customer` (`id`, `customer_id`, `name`, `owner`, `phone`, `address`, `lat`, `long`, `area_id`, `images`) VALUES
(1, 'CUS0001', 'Thai Long Mart', 'Mr. Long', '0345252761', '32 Phan Chau Trinh', 16.067859, 108.220026, 'HC001', 'null'),
(2, 'CUS0002', 'BB Mini Mart', 'Ms Hồng', '+84905183173', '53 Trần Kế Xương, Hải Châu 2, Hải Châu, Đà Nẵng 550000, Việt Nam', 16.066793, 108.216483, 'HC001', 'null'),
(7, 'CUS0003', 'TOPS MARKET', 'Ms CLo', '+84905183173', '257 Hùng Vương, Vĩnh Trung, Thanh Khê, Đà Nẵng 550000, Việt Nam', 16.066659, 108.214144, 'HC001', 'null'),
(9, 'CUS0004', 'Tạp Hóa Trúc Mai', 'Ms Mai', '+84905770960', '28 Phạm Phú Thứ, Hải Châu 1, Hải Châu, Đà Nẵng 550000, Việt Nam', 16.067372, 108.224162, 'HC001', 'null'),
(10, 'CUS0005', 'Full - Market 24/7', 'Ms Nam', '+84905183173', '20 Phạm Văn Đồng, An Hải Bắc, Sơn Trà, Đà Nẵng 550000, Việt Nam', 16.071457, 108.235153, 'ST001', 'null'),
(11, 'CUS0006', 'Tạp hóa Bin Hoàng', 'Ms Hoàng', '+84905183173', '8 An Nhơn 4, An Hải Bắc, Sơn Trà, Đà Nẵng 550000, Việt Nam', 16.069218, 108.234446, 'ST001', 'null'),
(12, 'CUS0007', 'Vương Quốc Trái Cây', 'Ms Hoa', '+84905183173', '36CQ+QXH, An Hải, Sơn Trà, Đà Nẵng 550000, Việt Nam', 16.071923, 108.239934, 'ST001', 'null'),
(13, 'CUS0008', 'Minimart Thủy Tiên', 'Ms Tiên', '+84905183173', '18 Hoàng Bích Sơn, Phước Mỹ, Sơn Trà, Đà Nẵng 550000, Việt Nam', 16.076381, 108.24092, 'ST001', 'null'),
(14, 'CUS0009', 'Huy Huệ', 'Huy Huệ', '+84905183173', '110 Đ. Nguyễn Đình Chiểu, Khuê Mỹ, Ngũ Hành Sơn, Đà Nẵng, Việt Nam', 16.025222, 108.244884, 'NHS001', 'null'),
(15, 'CUS0010', 'Tạp Hóa Quang Thủy', 'Ms Thủy', '+84905183173', '09 Đ. Mai Đăng Chơn, Hoà Hải, Ngũ Hành Sơn, Đà Nẵng 550000, Việt Nam', 15.995236, 108.256427, 'HQ001', 'null'),
(16, 'CUS0011', 'Tạp Hóa Sơn Dung', 'Ms Dung', '+84933474759', '153 Lộc Ninh, Hoà Hải, Ngũ Hành Sơn, Đà Nẵng 550000, Việt Nam', 16.066659, 108.214144, 'HH001', 'null');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `kpi`
--

CREATE TABLE `kpi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kpi_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salesman_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `test_2` int(11) NOT NULL,
  `checkin` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `kpi`
--

INSERT INTO `kpi` (`id`, `kpi_id`, `salesman_id`, `order_amount`, `checkin`, `created_at`, `updated_at`) VALUES
(1, 'KPI_0000001', 'USER00000002', 10, 10, '2022-01-07 14:20:34', '2022-01-07 14:20:44');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2020_12_04_054003_create_status_table', 1),
(3, '2020_12_04_054332_create_customer_table', 1),
(4, '2021_11_26_035752_create_type_table', 1),
(5, '2021_11_26_091341_create_categories_table', 1),
(6, '2021_11_26_095315_create_area_active_table', 1),
(7, '2021_11_27_000000_create_users_table', 1),
(8, '2021_11_27_000001_create_products_table', 1),
(9, '2021_11_27_031115_create_orders_table', 1),
(10, '2021_11_27_044509_create_order_detail_table', 1),
(11, '2021_11_27_091438_create_checkin_address_table', 1),
(12, '2021_12_11_025806_create_kpi_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salesman_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `salesman_id`, `customer_id`, `status`, `enabled`, `created_at`, `updated_at`) VALUES
(2, 'ORDER0000001', 'USER00000002', 'CUS0001', 'STT2', 1, '2022-01-07 15:40:17', '2022-01-07 15:40:17');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_detail_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` double(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `created_at`, `updated_at`) VALUES
(5, 'dtthuy.17it1@sict.udn.vn', 'cvip1sB4swizn1NbJyQzf5xivtHEQVfYF2QDRQwQL0bX34LsGrrfJfJEgZSY', '2022-01-07 04:15:28', '2022-01-07 04:15:28'),
(6, 'dtthuy.17it1@sict.udn.vn', 'WwxA91bsI3of5T7BLWhpRQ2bvaJetwJlyDIAOzNrGvhM2Op6BXVqfPPu2Obh', '2022-01-07 04:20:36', '2022-01-07 04:20:36');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `product_id`, `title`, `owner_id`, `category`, `size`, `price`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'ITEM000000001', 'Croptop', 'USER00000003', 'CATE001', 'L', 52.30, 'sdfakjdfhajsdfhshfj', '2', '2022-01-04 02:21:31', '2022-01-04 20:03:23'),
(4, 'ITEM000000002', 'Croptop', 'USER00000003', 'CATE001', 'M', 52.30, 'sdfakjdfhajsdfhshfj', '1', '2022-01-04 20:02:44', '2022-01-04 20:02:44');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `status_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `status`
--

INSERT INTO `status` (`id`, `status_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'STT1', 'Cart', NULL, NULL),
(2, 'STT2', 'Ordered', NULL, NULL),
(3, 'STT3', 'Canceled', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `type`
--

CREATE TABLE `type` (
  `id` int(11) NOT NULL,
  `type_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `type`
--

INSERT INTO `type` (`id`, `type_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'ADM', 'Admin', NULL, NULL),
(2, 'SM', 'Salesman', NULL, NULL),
(3, 'SHOP', 'Shop', '2022-01-08 15:40:17', '2022-01-08 03:36:52');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `sex` tinyint(4) DEFAULT NULL,
  `admin` tinyint(4) NOT NULL DEFAULT 0,
  `enabled` tinyint(4) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courses_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `user_id`, `name`, `email`, `password`, `tel`, `address`, `avatar`, `birthday`, `sex`, `admin`, `enabled`, `remember_token`, `created_at`, `updated_at`, `type_id`, `courses_id`) VALUES
(1, 'USER00000001', 'Admin', 'admin@gmail.com', '$2y$10$FWVFZgZQOqk5PZ3E42Xw2.gy0PYqDpypltMJQyt9XOhEKNCXNVPCW', '0352689471', 'DN', NULL, '1999-12-30', 1, 1, 1, NULL, '2021-12-25 22:55:12', '2021-12-26 00:15:48', 'ADM', NULL),
(3, 'USER00000002', 'Salesman', 'salesman@gmail.com', '$2y$10$cBslopczjKyVYjaxVgKjQOmwmaVBJMNXHVY/DN6zio5vVfu4OsNwO', '0272658491', 'DN', NULL, NULL, NULL, 0, 1, NULL, '2021-12-25 23:15:22', '2021-12-25 23:15:22', 'SM', NULL),
(4, 'USER00000003', 'Admin1', 'dtthuy.17it1@sict.udn.vn', '$2y$10$jGPUV4bOUrtGCANzbAJj.eZ9Gv6rKFDh98TUA0wMiWVNHwZCATWYi', '0352689471', 'DN', '1', '1999-12-30', 1, 0, 1, NULL, '2021-12-25 23:54:09', '2022-01-06 21:34:29', 'ADM', NULL),
(5, 'USER00000004', 'Salesman 2', 'dangthanhthuytg99@gmail.com', '$2y$10$wDvlALHlj2fyC2AR/X3RbOy244PPLSmXs71ZOg4ACmAmLy1DzfzFW', '0256981475', 'DN', NULL, NULL, 0, 0, 1, NULL, '2021-12-26 00:05:15', '2022-01-06 20:39:29', 'SM', NULL),
(6, 'USER00000005', 'Salesman3', 'salesman3@gmail.com', '$2y$10$yJ2F4rgErfI/M1/8WBAQBuZ8w4fyb6b9Rbu1r.UPYe4U8/IzGz4nu', '0326584651', 'DN', '1', NULL, NULL, 0, 0, NULL, '2022-01-04 20:02:10', '2022-01-04 20:02:10', 'SM', NULL),
(7, 'USER00000006', 'Admin2', 'admin2@gmail.com', '$2y$10$zEulFzrI3qVzJSEF5i9SJuiVnHOdYu.056/LOpH8Hz6f3CAYzGd4y', '0125425212', 'DN', NULL, NULL, 0, 0, 1, NULL, '2022-01-05 19:45:13', '2022-01-05 19:45:13', 'ADM', NULL),
(8, 'USER00000007', 'Nguyễn Văn Nhớ', 'nvnho.17it1@vku.udn.vn', '$2y$10$BYKNeqC9Q5ZjLyyXNhZTqOqA7RE6qliX71NEEoSGBpt5HWOfVFL5q', '0125421521', 'DN', NULL, '2021-12-28', 0, 0, 0, NULL, '2022-01-06 23:37:49', '2022-01-06 23:37:49', 'ADM', NULL),
(9, 'USER00000008', 'Thanh Thuý', 'thanhthuy@gmail.com', '$2y$10$V7.iXI5ZHuLEPDU5Jz42POS9/TVDINUKOTYMaqSTPD97kfygDMtSW', '0101010101', 'DN', NULL, '2021-12-28', 1, 0, 0, NULL, '2022-01-06 23:53:19', '2022-01-06 23:53:19', 'ADM', NULL),
(11, 'USER00000009', 'Quang', 'lnquang.17it1@vku.udn.vn', '$2y$10$BAlFJ78rMswVu.2q4zoYxeQI1wYKEy.EmBjMn5nFg0yrfaHnDXpD2', '0120120120', 'DN', '1', '2021-12-28', 0, 0, 1, NULL, '2022-01-07 00:17:20', '2022-01-07 00:17:20', 'SHOP', NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `area_active`
--
ALTER TABLE `area_active`
  ADD PRIMARY KEY (`id`),

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_category_id_unique` (`category_id`);

--
-- Chỉ mục cho bảng `checkin_address`
--
ALTER TABLE `checkin_address`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `checkin_address_checkin_id_unique` (`checkin_id`),
  ADD KEY `checkin_address_salesman_id_foreign` (`salesman_id`);

--
-- Chỉ mục cho bảng `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_customer_id_unique` (`customer_id`);

--
-- Chỉ mục cho bảng `kpi`
--
ALTER TABLE `kpi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kpi_kpi_id_unique` (`kpi_id`),
  ADD KEY `kpi_salesman_id_foreign` (`salesman_id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_id_unique` (`order_id`),
  ADD KEY `orders_salesman_id_foreign` (`salesman_id`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`),
  ADD KEY `orders_status_foreign` (`status`);

--
-- Chỉ mục cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_detail_order_detail_id_unique` (`order_detail_id`),
  ADD KEY `order_detail_product_id_foreign` (`product_id`),
  ADD KEY `order_detail_order_id_foreign` (`order_id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_product_id_unique` (`product_id`),
  ADD KEY `products_owner_id_foreign` (`owner_id`),
  ADD KEY `products_category_foreign` (`category`);

--
-- Chỉ mục cho bảng `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `status_status_id_unique` (`status_id`);

--
-- Chỉ mục cho bảng `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_type_id_unique` (`type_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_user_id_unique` (`user_id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_type_id_foreign` (`type_id`),

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `area_active`
--
ALTER TABLE `area_active`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `checkin_address`
--
ALTER TABLE `checkin_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `kpi`
--
ALTER TABLE `kpi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `type`
--
ALTER TABLE `type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `checkin_address`
--
ALTER TABLE `checkin_address`
  ADD CONSTRAINT `checkin_address_salesman_id_foreign` FOREIGN KEY (`salesman_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `kpi`
--
ALTER TABLE `kpi`
  ADD CONSTRAINT `kpi_salesman_id_foreign` FOREIGN KEY (`salesman_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_salesman_id_foreign` FOREIGN KEY (`salesman_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_status_foreign` FOREIGN KEY (`status`) REFERENCES `status` (`status_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_detail_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_foreign` FOREIGN KEY (`category`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `type` (`type_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
