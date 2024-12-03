-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 02, 2024 at 07:20 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fashion`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `COMMENT_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `ORDER_ID` int(11) DEFAULT NULL,
  `COMMENTS` text NOT NULL,
  `SENDER_TYPE` enum('ADMIN','CUSTOMER','STAFF') NOT NULL,
  `READ1` enum('SEND','ACCEPTED','REJECTED') NOT NULL DEFAULT 'SEND',
  `CREATED_AT` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'sul', 'sul@gmail.com', 'color chnge', 'i wanted my dress to be orange and green but, i got it in yellow and blue', '2024-09-19 23:21:49'),
(3, 'Ann', 'ann@gmail.com', 'color chnge', 'i got the color different from what i ordered', '2024-10-13 02:15:25'),
(4, 'as', 'as@gmail.com', 'fabric change', 'i got the wrong fabric', '2024-10-13 02:45:07'),
(5, 'su', 'sddddddddddddddddddd@gmail.com', 'length', 'i asked for mini dress..i got a tea-length dress', '2024-10-13 02:49:19'),
(6, 'asdfs', 'asdb@gmail.com', 'sleeve length', 'i got sleeveless ..i asked for full length', '2024-10-13 02:54:56'),
(9, 'sulfath', 'sulfath245@gmail.com', 'sleeve length', 'i got 3/4 ..i asked for full length', '2024-10-13 02:57:27'),
(10, 'sulfath', 'sulfath245@gmail.com', 'dress length', 'i got min ..i asked for full length', '2024-10-13 03:33:52'),
(11, 'sulfath', 'sulfath245@gmail.com', 'color ', 'i got the wrong color.but,i still liked it..thank you for your hardwork', '2024-10-13 03:35:22');

-- --------------------------------------------------------

--
-- Table structure for table `customizations`
--

CREATE TABLE `customizations` (
  `OPTION_ID` int(11) NOT NULL,
  `DRESS_ID` int(11) DEFAULT NULL,
  `FABRIC_ID` int(11) DEFAULT NULL,
  `MEASUREMENT_ID` int(11) DEFAULT NULL,
  `COLOR` char(7) DEFAULT NULL,
  `EMBELLISHMENTS` enum('EMBROIDERY','APPLIQUÉ','SEQUIN','BEADS','LACE','FRINGE','PEARL','PIPING','RHINESTONE','none') DEFAULT 'none',
  `DRESS_LENGTH` enum('MINI','KNEE-LENGTH','TEA-LENGTH','MIDI','MAXI','FULL-LENGTH') DEFAULT NULL,
  `SLEEVE_LENGTH` enum('SLEEVELESS','SHORT','ELBOW','3/4','FULL') DEFAULT NULL,
  `ADDITIONAL_NOTES` varchar(200) DEFAULT NULL,
  `REFERRAL_IMG` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customizations`
--

INSERT INTO `customizations` (`OPTION_ID`, `DRESS_ID`, `FABRIC_ID`, `MEASUREMENT_ID`, `COLOR`, `EMBELLISHMENTS`, `DRESS_LENGTH`, `SLEEVE_LENGTH`, `ADDITIONAL_NOTES`, `REFERRAL_IMG`) VALUES
(70, 4, NULL, 139, 'default', 'none', 'MINI', 'SLEEVELESS', '', NULL),
(71, 8, 4, 140, '#00FFFF', 'none', 'MINI', 'SLEEVELESS', '', NULL),
(72, 2, 3, 141, '#C0C0C0', 'none', 'MINI', 'SLEEVELESS', NULL, NULL),
(73, 9, 8, 142, '#FFFF00', 'none', 'MINI', 'SLEEVELESS', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dress`
--

CREATE TABLE `dress` (
  `DRESS_ID` int(11) NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `DESCRIPTION` text DEFAULT NULL,
  `FABRIC` varchar(50) NOT NULL,
  `COLOR` varchar(100) NOT NULL,
  `SIZES` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `BASE_PRICE` decimal(10,2) NOT NULL,
  `IMAGE_URL` varchar(255) DEFAULT NULL,
  `CREATED_AT` datetime NOT NULL DEFAULT current_timestamp(),
  `visibility` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dress`
--

INSERT INTO `dress` (`DRESS_ID`, `NAME`, `DESCRIPTION`, `FABRIC`, `COLOR`, `SIZES`, `BASE_PRICE`, `IMAGE_URL`, `CREATED_AT`, `visibility`) VALUES
(1, 'Elegant Evening Dress', 'This strapless champagne satin ball gown \r\nsophisticated look perfect for formal occasions.', 'Satin', 'Champagne', 'XS,S,M,L,XL,XXL', 2500.00, '../dress/elegnt evening dress.jpg', '2024-09-15 08:50:00', 1),
(2, 'casual summer dress', ' Geometric Printed Maxi Dress', 'Chiffon', 'Maroon,White', 'XS,S,M,L,XL,XXL', 1500.00, '..\\dress\\casual summer dress.jpg', '2024-09-15 09:29:26', 1),
(3, 'Bridesmaid Dress', 'Make your bridal party stand out with these stunning bridesmaid dresses.', 'Tulle', 'Blush Pink ', 'XS,S,M,L,XL,XXL', 1200.00, '../dress/bridesmade dress.jpg', '2024-09-15 11:20:34', 1),
(4, 'Cocktail Dress', 'Great option for weddings, cocktail parties, or any occasion requiring a polished, sophisticated look.', 'Combination of tulle and satin', 'Soft lavender or lilac', 'XS,S,M,L,XL,XXL', 2500.00, '..\\dress\\cocktail dress.jpg', '2024-09-15 11:20:34', 1),
(5, 'Bohemian Maxi Dress', 'Perfect outfit for a summer event, beach vacation, or any occasion where a relaxed, stylish look is desired.', 'Chiffon', 'Green , Teal', 'XS,S,M,L,XL,XXL', 1400.00, '..\\dress\\bohemian maxi dress.jpg', '2024-09-15 11:26:11', 1),
(6, 'Saree', 'Ideal for festive events, traditional gatherings, or any occasion where a bright, standout ensemble is desired.', 'Georgette ', 'Mustard yellow', 'XS,S,M,L,XL,XXL', 2100.00, '..\\dress\\saree1.jpg', '2024-09-15 11:26:11', 1),
(7, 'Vintage Lace Dress', 'Ensemble exudes timeless charm and grace, perfect for formal or semi-formal events.', ' floral lace overlay on satin', 'wine-red', 'XS,S,M,L,XL,XXL', 2199.00, '..\\dress\\vintage lace dress.jpg', '2024-09-15 11:36:00', 1),
(8, 'salwar suit', 'Exudes a graceful and traditional appeal, perfect for casual gatherings or festive occasions.', 'Cotton', 'pastel green ', 'XS,S,M,L,XL,XXL', 900.00, '..\\dress\\salwar suit1.jpg', '2024-09-15 11:36:00', 1),
(9, 'Modern A-Line Dress', 'Exudes a breezy yet chic vibe, perfect for outdoor events, summer parties, or even a casual evening outing.', 'Satin', 'sage green', 'XS,S,M,L,XL,XXL', 1400.00, '..\\dress\\modern a line dress.jpg', '2024-09-15 11:41:54', 1),
(10, 'Qipao', 'Perfect for formal occasions, especially events that celebrate Chinese heritage, such as weddings, cultural ceremonies, or elegant dinners.', 'Silk', 'light beige', 'XS,S,M,L,XL,XXL', 2299.00, '..\\dress\\qipao1.png', '2024-09-15 11:41:54', 1),
(11, 'Embroidered Midi Dress', 'Exude elegance in this beautifully crafted navy blue midi dress, featuring intricate floral embroidery across the bodice.', 'Georgette ', 'Navy Blue ', 'XS,S,M,L,XL,XXL', 2100.00, '..\\dress\\Embroidered-Midi-Dress1.jpg', '2024-09-15 11:43:50', 1),
(12, 'Pleated Skater Dress', 'perfect for semi-formal to formal events.', 'Crepe', 'deep emerald green', 'XS,S,M,L,XL,XXL', 1200.00, '..\\dress\\pleated skater dress.jpg', '2024-09-15 11:43:50', 1),
(16, 'Kurti', 'Perfect for everyday wear', 'Cotton', 'Ash', 'XS,S,M,L,XL,XXL', 600.00, '../dress/kurti.jpg', '2024-09-25 06:39:36', 0),
(22, 'Churidar', 'ideal for festive occasions and celebrations', 'Brocade and Silk', 'coral pink and yellow', 'XS,S,M,L,XL,XXL', 800.00, '../dress/churidar.jpg', '2024-09-25 07:25:36', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fabrics`
--

CREATE TABLE `fabrics` (
  `FABRIC_ID` int(11) NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `IMAGE_URL` varchar(255) DEFAULT NULL,
  `DESCRIPTION` text DEFAULT NULL,
  `PRICE_PER_UNIT` decimal(10,2) NOT NULL,
  `AVAILABLE_QUANTITY` decimal(10,2) NOT NULL,
  `CREATED_AT` datetime NOT NULL DEFAULT current_timestamp(),
  `visibility` tinyint(1) DEFAULT 1,
  `STOCK_STATUS` varchar(20) NOT NULL DEFAULT 'In Stock'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fabrics`
--

INSERT INTO `fabrics` (`FABRIC_ID`, `NAME`, `IMAGE_URL`, `DESCRIPTION`, `PRICE_PER_UNIT`, `AVAILABLE_QUANTITY`, `CREATED_AT`, `visibility`, `STOCK_STATUS`) VALUES
(1, 'Lace', '../fabric/lace.jpeg', 'Delicate and romantic, perfect for bridal and special occasions.', 500.00, 21797.00, '2024-09-18 15:24:26', 1, 'Out of Stock'),
(2, 'Silk', '..\\fabric\\silk.jpg', 'Luxurious and elegant, perfect for evening wear.', 700.00, 0.00, '2024-09-19 07:49:27', 1, 'Low Stock'),
(3, 'Cotton', '..\\fabric\\cotton1.jpg', 'Comfortable and breathable, ideal for casual dresses.', 300.00, 18.00, '2024-09-19 07:51:47', 1, 'In Stock'),
(4, 'Modal Silk', '..\\fabric\\modal silk.jpg', 'Exceptionally soft and durable, ideal for casual dresses.', 900.00, 20.00, '2024-09-19 07:51:47', 1, 'Low Stock'),
(5, 'Chiffon', '..\\fabric\\chiffon1.jpg', 'Lightweight and sheer, perfect for airy and flowy dresses.', 350.00, 0.00, '2024-09-19 07:54:32', 1, 'Low Stock'),
(6, 'Tweed', '..\\fabric\\tweed.webp', 'Warm and textured, perfect for stylish and cozy outfits.', 1200.00, 0.00, '2024-09-19 07:54:32', 1, 'Out of Stock'),
(7, 'Velvet', '..\\fabric\\velvet1.jpg', 'Soft and plush, ideal for luxurious evening gowns.', 500.00, 12.00, '2024-09-19 07:57:41', 1, 'Low Stock'),
(8, 'Denim', '..\\fabric\\denim1.jpg', 'Durable and stylish, ideal for casual and trendy outfits.', 500.00, 1.00, '2024-09-19 07:57:41', 1, 'Low Stock'),
(9, 'Satin', '..\\fabric\\satin2.jpg', 'Smooth and glossy, ideal for elegant evening dresses.', 800.00, 11.00, '2024-09-19 07:59:54', 1, 'Low Stock'),
(10, 'Linen', '..\\fabric\\linen2.webp', 'Breathable and lightweight, perfect for summer dresses.', 600.00, 10.00, '2024-09-19 07:59:54', 1, 'Low Stock'),
(11, 'Tulle', '..\\fabric\\tulle.webp', 'Delicate and airy, perfect for adding volume to dresses.', 660.00, 11.00, '2024-09-19 08:02:13', 1, 'Low Stock'),
(12, 'Crepe', '..\\fabric\\crepe.jpg', 'Elegant and textured, ideal for sophisticated dresses.', 400.00, 17.00, '2024-09-19 08:02:13', 1, 'Low Stock'),
(15, 'Georgette', '../fabrics/georgette.jpg', ' lightweight, sheer fabric  and it works well for both casual and formal styles.\r\n\r\n\r\n\r\n\r\n\r\n\r\n', 700.00, 30.00, '2024-10-10 21:06:52', 1, 'In Stock');

-- --------------------------------------------------------

--
-- Table structure for table `fabric_purchase`
--

CREATE TABLE `fabric_purchase` (
  `PURCHASE_ID` int(11) NOT NULL,
  `USER_ID` int(11) DEFAULT NULL,
  `FABRIC_ID` int(11) DEFAULT NULL,
  `QUANTITY` decimal(10,2) NOT NULL,
  `TOTAL_PRICE` decimal(10,2) NOT NULL,
  `ESTIMATED_DELIVERY_DATE` date DEFAULT NULL,
  `ACTUAL_DELIVERY_DATE` date DEFAULT NULL,
  `CREATED_AT` datetime NOT NULL,
  `STATUSES` enum('PENDING','IN-PROGRESS','COMPLETED','SHIPPED','DELIVERED','CANCELLED','CART') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `measurements`
--

CREATE TABLE `measurements` (
  `MEASUREMENT_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `DRESS_ID` int(11) DEFAULT NULL,
  `FABRIC_ID` int(11) DEFAULT NULL,
  `SHOULDER` decimal(10,2) DEFAULT NULL,
  `BUST` decimal(10,2) DEFAULT NULL,
  `WAIST` decimal(10,2) DEFAULT NULL,
  `HIP` decimal(10,2) DEFAULT NULL,
  `CREATED_AT` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `measurements`
--

INSERT INTO `measurements` (`MEASUREMENT_ID`, `USER_ID`, `DRESS_ID`, `FABRIC_ID`, `SHOULDER`, `BUST`, `WAIST`, `HIP`, `CREATED_AT`) VALUES
(139, 2, 4, NULL, 22.00, 22.00, 22.00, 22.00, '2024-12-02 21:32:32'),
(140, 2, 8, 4, 33.00, 33.00, 33.00, 33.00, '2024-12-02 21:33:16'),
(141, 45, 2, 3, 55.00, 55.00, 55.00, 55.00, '2024-12-02 22:22:18'),
(142, 44, 9, 8, 22.00, 22.00, 22.00, 22.00, '2024-12-02 22:53:20');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `ORDER_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `DRESS_ID` int(11) DEFAULT NULL,
  `FABRIC_ID` int(11) DEFAULT NULL,
  `OPTION_ID` int(11) DEFAULT NULL,
  `STATUSES` enum('PENDING','IN-PROGRESS','COMPLETED','SHIPPED','DELIVERED','CANCELLED','CART') NOT NULL,
  `SSIZE` varchar(100) DEFAULT NULL,
  `QUANTITY` int(2) NOT NULL DEFAULT 1,
  `TOTAL_PRICE` decimal(10,2) NOT NULL,
  `CATEGORY` enum('FABRIC_PURCHASE','DRESS_PURCHASE','DRESS_CUSTOMIZATION','FULLY_CUSTOMIZATION','OFFLINE_PURCHASE') NOT NULL,
  `ESTIMATED_DELIVERY_DATE` date DEFAULT NULL,
  `ACTUAL_DELIVERY_DATE` date DEFAULT NULL,
  `CREATED_AT` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ORDER_ID`, `USER_ID`, `DRESS_ID`, `FABRIC_ID`, `OPTION_ID`, `STATUSES`, `SSIZE`, `QUANTITY`, `TOTAL_PRICE`, `CATEGORY`, `ESTIMATED_DELIVERY_DATE`, `ACTUAL_DELIVERY_DATE`, `CREATED_AT`) VALUES
(113, 2, 1, NULL, NULL, 'PENDING', 'xs', 1, 2500.00, 'DRESS_PURCHASE', '2024-12-11', '2024-12-16', '2024-12-02 21:31:46'),
(114, 2, NULL, 1, NULL, 'SHIPPED', NULL, 3, 1500.00, 'FABRIC_PURCHASE', '2024-12-05', '2024-12-07', '2024-12-02 21:32:01'),
(115, 2, 4, NULL, 70, 'IN-PROGRESS', 'm', 1, 2500.00, 'DRESS_CUSTOMIZATION', '2024-12-11', '2024-12-16', '2024-12-02 21:32:32'),
(116, 2, 8, 4, 71, 'IN-PROGRESS', 's', 1, 1800.00, 'FULLY_CUSTOMIZATION', '2024-12-11', '2024-12-16', '2024-12-02 21:33:16'),
(117, 45, 2, 3, 72, 'PENDING', 'xs', 1, 1800.00, 'OFFLINE_PURCHASE', '2024-12-11', '2024-12-16', '2024-12-02 22:22:18'),
(118, 44, 9, 8, 73, 'PENDING', 'xs', 3, 1900.00, 'OFFLINE_PURCHASE', '2024-12-11', '2024-12-16', '2024-12-02 22:53:20');

-- --------------------------------------------------------

--
-- Table structure for table `order_assignments`
--

CREATE TABLE `order_assignments` (
  `ASSIGNMENT_ID` int(11) NOT NULL,
  `ORDER_ID` int(11) NOT NULL,
  `STAFF_ID` int(11) NOT NULL,
  `ASSIGNED_AT` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_assignments`
--

INSERT INTO `order_assignments` (`ASSIGNMENT_ID`, `ORDER_ID`, `STAFF_ID`, `ASSIGNED_AT`) VALUES
(12, 115, 43, '2024-12-02 21:40:36'),
(13, 114, 43, '2024-12-02 21:40:43'),
(14, 113, 6, '2024-12-02 21:40:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `USER_ID` int(11) NOT NULL,
  `USERNAME` varchar(50) NOT NULL,
  `PASSWORDD` varchar(255) NOT NULL,
  `EMAIL` varchar(100) DEFAULT NULL,
  `PHONE` varchar(15) NOT NULL,
  `USER_TYPE` enum('ADMIN','CUSTOMER','STAFF','OFF_CUSTOMER') NOT NULL,
  `ADDRESSS` text DEFAULT NULL,
  `CREATED_AT` datetime NOT NULL DEFAULT current_timestamp(),
  `PROFILE_PICTURE` varchar(255) DEFAULT NULL,
  `blocked` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`USER_ID`, `USERNAME`, `PASSWORDD`, `EMAIL`, `PHONE`, `USER_TYPE`, `ADDRESSS`, `CREATED_AT`, `PROFILE_PICTURE`, `blocked`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', '', 'ADMIN', NULL, '2024-09-12 19:44:26', NULL, 0),
(2, 'sul', 'sul', 'sul@gmail.com', '76543232', 'CUSTOMER', '', '2024-09-14 11:33:00', 'uploads/profile_674df79e02c743.73848852.jpg', 0),
(3, 'suluu', 'sulu', 'sulfath@gmail.com', '9876543', 'CUSTOMER', '', '2024-09-14 11:35:19', NULL, 0),
(4, 'ann', 'aa', 'ann@gmail.com', '763453256', 'CUSTOMER', '', '2024-09-14 11:58:57', NULL, 0),
(6, 'maya', 'maya@gmail.com', 'maya@gmail.com', '9856584587', 'STAFF', NULL, '2024-10-24 00:20:35', NULL, 0),
(42, 'raashi', 'suluraashi', 'raashisulu@gmail.com', '7591931355', 'CUSTOMER', 'kunjveettil', '2024-12-02 21:25:24', NULL, 0),
(43, 'raashid', 'raashi@gmail.com', 'raashi@gmail.com', '7591931355', 'STAFF', NULL, '2024-12-02 21:27:05', NULL, 0),
(44, 'zohan', '78379833', NULL, '78379833', 'OFF_CUSTOMER', 'ndbdhbchcb', '2024-12-02 22:07:01', NULL, 0),
(45, 'kb', '345678', NULL, '345678', 'OFF_CUSTOMER', 'sdfghjnmk', '2024-12-02 22:22:18', NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`COMMENT_ID`),
  ADD KEY `USER_ID` (`USER_ID`),
  ADD KEY `ORDER_ID` (`ORDER_ID`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customizations`
--
ALTER TABLE `customizations`
  ADD PRIMARY KEY (`OPTION_ID`),
  ADD KEY `DRESS_ID` (`DRESS_ID`),
  ADD KEY `MEASUREMENT_ID` (`MEASUREMENT_ID`),
  ADD KEY `FABRIC_ID` (`FABRIC_ID`);

--
-- Indexes for table `dress`
--
ALTER TABLE `dress`
  ADD PRIMARY KEY (`DRESS_ID`);

--
-- Indexes for table `fabrics`
--
ALTER TABLE `fabrics`
  ADD PRIMARY KEY (`FABRIC_ID`);

--
-- Indexes for table `fabric_purchase`
--
ALTER TABLE `fabric_purchase`
  ADD PRIMARY KEY (`PURCHASE_ID`),
  ADD KEY `USER_ID` (`USER_ID`),
  ADD KEY `FABRIC_ID` (`FABRIC_ID`);

--
-- Indexes for table `measurements`
--
ALTER TABLE `measurements`
  ADD PRIMARY KEY (`MEASUREMENT_ID`),
  ADD KEY `USER_ID` (`USER_ID`),
  ADD KEY `DRESS_ID` (`DRESS_ID`),
  ADD KEY `FABRIC_ID` (`FABRIC_ID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ORDER_ID`),
  ADD KEY `USER_ID` (`USER_ID`),
  ADD KEY `FABRIC_ID` (`FABRIC_ID`),
  ADD KEY `DRESS_ID` (`DRESS_ID`),
  ADD KEY `OPTION_ID` (`OPTION_ID`);

--
-- Indexes for table `order_assignments`
--
ALTER TABLE `order_assignments`
  ADD PRIMARY KEY (`ASSIGNMENT_ID`),
  ADD UNIQUE KEY `ORDER_ID_2` (`ORDER_ID`),
  ADD KEY `ORDER_ID` (`ORDER_ID`),
  ADD KEY `STAFF_ID` (`STAFF_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`USER_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `COMMENT_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customizations`
--
ALTER TABLE `customizations`
  MODIFY `OPTION_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `dress`
--
ALTER TABLE `dress`
  MODIFY `DRESS_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `fabrics`
--
ALTER TABLE `fabrics`
  MODIFY `FABRIC_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `fabric_purchase`
--
ALTER TABLE `fabric_purchase`
  MODIFY `PURCHASE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `measurements`
--
ALTER TABLE `measurements`
  MODIFY `MEASUREMENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ORDER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `order_assignments`
--
ALTER TABLE `order_assignments`
  MODIFY `ASSIGNMENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `USER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `users` (`USER_ID`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`ORDER_ID`) REFERENCES `orders` (`ORDER_ID`);

--
-- Constraints for table `customizations`
--
ALTER TABLE `customizations`
  ADD CONSTRAINT `customizations_ibfk_1` FOREIGN KEY (`DRESS_ID`) REFERENCES `dress` (`DRESS_ID`),
  ADD CONSTRAINT `customizations_ibfk_2` FOREIGN KEY (`MEASUREMENT_ID`) REFERENCES `measurements` (`MEASUREMENT_ID`),
  ADD CONSTRAINT `customizations_ibfk_3` FOREIGN KEY (`FABRIC_ID`) REFERENCES `fabrics` (`FABRIC_ID`);

--
-- Constraints for table `fabric_purchase`
--
ALTER TABLE `fabric_purchase`
  ADD CONSTRAINT `fabric_purchase_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `users` (`USER_ID`),
  ADD CONSTRAINT `fabric_purchase_ibfk_2` FOREIGN KEY (`FABRIC_ID`) REFERENCES `fabrics` (`FABRIC_ID`);

--
-- Constraints for table `measurements`
--
ALTER TABLE `measurements`
  ADD CONSTRAINT `measurements_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `users` (`USER_ID`),
  ADD CONSTRAINT `measurements_ibfk_2` FOREIGN KEY (`DRESS_ID`) REFERENCES `dress` (`DRESS_ID`),
  ADD CONSTRAINT `measurements_ibfk_4` FOREIGN KEY (`FABRIC_ID`) REFERENCES `fabrics` (`FABRIC_ID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `users` (`USER_ID`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`FABRIC_ID`) REFERENCES `fabrics` (`FABRIC_ID`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`DRESS_ID`) REFERENCES `dress` (`DRESS_ID`),
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`OPTION_ID`) REFERENCES `customizations` (`OPTION_ID`);

--
-- Constraints for table `order_assignments`
--
ALTER TABLE `order_assignments`
  ADD CONSTRAINT `order_assignments_ibfk_1` FOREIGN KEY (`ORDER_ID`) REFERENCES `orders` (`ORDER_ID`),
  ADD CONSTRAINT `order_assignments_ibfk_2` FOREIGN KEY (`STAFF_ID`) REFERENCES `users` (`USER_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
