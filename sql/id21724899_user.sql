-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 17, 2024 at 08:52 AM
-- Server version: 10.5.20-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id21724899_user`
--

-- --------------------------------------------------------

--
-- Table structure for table `Account`
--

CREATE TABLE `Account` (
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(200) NOT NULL,
  `name` varchar(30) NOT NULL,
  `Time_Of_Account_Creation` timestamp NOT NULL DEFAULT current_timestamp()
) ;

--
-- Dumping data for table `Account`
--

INSERT INTO `Account` (`username`, `password`, `email`, `phone`, `address`, `name`, `Time_Of_Account_Creation`) VALUES
('Aayush_Patil', '$2y$10$fOwzRseJzyjHRCS.SW5hnOtm.xo3.2UsW8DglqfPMZkGzGx77pRum', 'aayushpatil418@gmail.com', '1234567890', 'seakjhfkuhiou kufhuoy f uh sdfukhuki kf dhsf', 'AAYUSH PATIL', '2024-04-03 10:36:03'),
('Aman', '$2y$10$IiobdJlMx9ZR6FL8QIwibOEUd3JPEsVmXSnQFygfJqHnsmOnjFBKq', 'as1364467@gmail.com', '1234567890', 'Mumbai Maharashtra ', 'AMANSK ', '2024-03-31 20:58:03'),
('Demo_Acc', '$2y$10$hliYX9la3Are6sC.9o59T.KVuIk/kUahmwPoH5hn3vi5/lA8zazSa', 'asmientp24@gmail.com', '1234567890', 'xfgcvnbm,.bbbdfgbnhm,', 'QERTYZXCVBNM', '2024-03-30 14:19:49'),
('Hacker', '$2y$10$BRF65Z/3GQstQdipQsR/hukNZT9fetxhDbmPQ3SKHqCDdlFHAorAy', 'safiqkhan3u2u171@gmail.com', '9870654321', '407,4th floor,bldg 1 A ,pmgp colony ,Sion west', 'KABIR KHAN', '2024-04-06 13:09:18'),
('Jinay', '$2y$10$tAF/v4LFulINVG4fC9hdku/X848Nh0aqu42a92OaXS5HWmbI1J0h.', 'svayam17@gmail.com', '7045808696', 'Hdbdbdgdhrbdbsnfbrbs', 'JINAY MODI', '2024-03-30 15:20:58'),
('Salman56', '$2y$10$HS4FfE3wcNlm7kGYSIKxKe.mQ47WIacwtSc/wIR240ratAKtIrxpO', 'ss0331429@gmail.com', '9876543120', 'Qraidndnkskaoaosskdndnndnn', 'DEMO BHAI', '2024-04-04 19:47:21');

-- --------------------------------------------------------

--
-- Table structure for table `Cart`
--

CREATE TABLE `Cart` (
  `username` varchar(30) NOT NULL,
  `total_price` int(11) NOT NULL,
  `Time_of_adding` timestamp NOT NULL DEFAULT current_timestamp(),
  `item_no` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_price` int(11) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `item_quantity` int(11) NOT NULL DEFAULT 1,
  `image` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `Cart`
--

INSERT INTO `Cart` (`username`, `total_price`, `Time_of_adding`, `item_no`, `item_name`, `item_price`, `description`, `item_quantity`, `image`) VALUES
('Aayush_Patil', 44639, '2024-04-03 10:41:25', 30, 'Gaming Tower PC', 44639, 'AMD Radeon Graphics AMD Ryzen 5 5600G/ 16GB 8x2  Ram 1TB HDD/ 256GB NVME SSD', 1, 'prebuild.png');

--
-- Triggers `Cart`
--
DELIMITER $$
CREATE TRIGGER `update_total_price` BEFORE UPDATE ON `Cart` FOR EACH ROW BEGIN
    IF NEW.item_quantity <> OLD.item_quantity OR NEW.item_price <> OLD.item_price THEN
        SET NEW.total_price = NEW.item_quantity * NEW.item_price;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Orders`
--

CREATE TABLE `Orders` (
  `order_id` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `item_image` varchar(255) NOT NULL,
  `total_amount` int(30) NOT NULL DEFAULT 0,
  `delivery_address` varchar(200) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `Orders`
--

INSERT INTO `Orders` (`order_id`, `username`, `payment_method`, `item_name`, `item_quantity`, `total_price`, `status`, `item_image`, `total_amount`, `delivery_address`, `order_date`) VALUES
('6610fc52c63a25.19807082', 'Hacker', 'Cash on Delivery', 'HP Laptop 15s', 2, 74960.00, 'Delivered', 'images/hplaptop15s.png', 74960, '407,4th floor,bldg 1 A ,pmgp colony ,Sion west', '2024-04-06 13:10:02'),
('661f89b2beef62.09105905', 'Salman56 ', 'Cash on Delivery', 'HP Laptop 15s', 1, 37480.00, 'Pending', 'images/hplaptop15s.png', 62412, 'Qraidndnkskaoaosskdndnndnn', '2024-04-17 14:04:58'),
('661f89b2beef62.09105905', 'Salman56 ', 'Cash on Delivery', 'SINLOE Full Combo Set', 2, 24932.00, 'Pending', 'sinloe_cctv.png', 62412, 'Qraidndnkskaoaosskdndnndnn', '2024-04-17 14:04:58');

-- --------------------------------------------------------

--
-- Table structure for table `Product`
--

CREATE TABLE `Product` (
  `product_name` varchar(50) NOT NULL,
  `product_price` int(11) NOT NULL,
  `category` varchar(30) NOT NULL,
  `product_image` varchar(30) NOT NULL,
  `product_discount` int(11) NOT NULL,
  `product_description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `Product`
--

INSERT INTO `Product` (`product_name`, `product_price`, `category`, `product_image`, `product_discount`, `product_description`) VALUES
('Apple MacBook Air', 74990, 'Laptop & Desktop', 'images/applemacbookair.png', 19, 'M1 chip, 13.3-inch/33.74 cm Retina Display, 8GB RAM, 256GB SSD Storage, Backlit Keyboard'),
('Canon PIXMA E477', 5599, 'Printers,Routers & Switches', 'canon_printer.png', 12, 'All in One (Print, Scan, Copy)  WiFi Ink Efficient  Colour Printer for Home/Student'),
('CP PLUS Security Cam', 6030, 'CCTV Services', 'cp_plus_cctv.png', 55, 'Cp plus 4 Channel HD DVR 1080p 1Pcs,Outdoor Camera 2.4 MP 2Pcs,500 GB Hard Disk'),
('D3D Home Security System', 7036, 'Home and Office Automation', 'd3d_system.png', 56, 'Motion Detection Sensor | Door Security Sensor | WiFi and GSM Dual Protection Alarm System'),
('Gaming Tower PC', 44639, 'Laptop & Desktop', 'prebuild.png', 38, 'AMD Radeon Graphics AMD Ryzen 5 5600G/ 16GB 8x2  Ram 1TB HDD/ 256GB NVME SSD'),
('GuardianAntivirus', 310, 'Anti Virus', 'AntivirusGuardian.png', 69, 'Total Security With Anti-Ransomware- 1Pc/1Year (Email Delivery In 2 Hours- No Cd)'),
('HIKVISION 5 MP CCTV', 1666, 'CCTV Services', 'hikvision_cctv.png', 51, 'Outdoor Bullet CCTV Ethernet Camera with inbuilt Audio Mic IP67 DS-2CE16H0T-ITPFS'),
('HP Laptop 15s', 37480, 'Laptop & Desktop', 'images/hplaptop15s.png', 27, '12th Gen Intel Core i3, 15.6-inch (39.6 cm), 8GB DDR4, 512GB SSD, Thin & Light'),
('HP Laser Printer', 12999, 'Printers,Routers & Switches', 'hp_printer.png', 18, 'Wireless, Single Function, Print, Hi-Speed USB 2.0, Up to 21 ppm, 150-sheet Input Tray'),
('IOTICS Smart Wifi Board', 7463, 'Home and Office Automation', 'iotics_smart_board.png', 25, '6 Light & 2 Fan Switches. Finger Touch, Remote, App Control. Voice via Google Home/Alexa'),
('Keyboard & mouse', 1199, 'Computer Accessories', 'zebronics_keyboard.png', 56, '2.4GHz Wireless Keyboard and Mouse Set, USB Nano Receiver, Chiclet Keys, Power On/Off Switch'),
('Lenovo Silent Mouse', 1499, 'Computer Accessories', 'lenovomouse.png', 48, 'Compact, Portable, Dongle-Free Multi-Device connectivity with Microsoft Swift Pair | Adjustable'),
('Logitech Desk Mat', 2310, 'Computer Accessories', 'logitech_mat.png', 23, 'Studio Series, Multifunctional Large Desk Pad, Extended Mouse Mat, Office Desk Protector'),
('McAfee Antivirus', 700, 'Anti Virus', 'mcafee_antivirus.png', 22, 'McAfee Antivirus 2024 | 1 Device, 3 Year | Antivirus Internet Security Software| Email Delivery'),
('McAfee Total Protection', 1488, 'Anti Virus', 'mcafee_antivirus2.png', 38, 'Antivirus Internet Security Software | Password Manager & Dark Web Monitoring Included '),
('Net Protector Antivirus', 1000, 'Anti Virus', 'netprotector_antivirus.png', 50, 'Antivirus for PC | Total Security 2024 | 1 PC | 3 Years | Email Delivery in less than 2 hours|'),
('QUBO Smart Door Lock', 20099, 'Home and Office Automation', 'qubo_doorlock.png', 33, '5-Way Unlocking | Fingerprint | Pincode| RFID Access Card | Bluetooth Mobile App | OTP Access'),
('Redragon K617 Fizz', 2799, 'Computer Accessories', 'Redragon_keyboard.png', 20, '60% Wired RGB Gaming Keyboard, 61 Keys Compact Mechanical Keyboard w/White and Grey Color Keycaps'),
('SINLOE Full Combo Set', 12466, 'CCTV Services', 'sinloe_cctv.png', 57, '8 Channel 1080P Full HD DVR 2MP, 4 Dome + 4 Bullet, 1TB Hard Disk Full Combo Set\r\n'),
('SONOFF NSPanel', 9483, 'Home and Office Automation', 'sonoff_smart_panel.png', 27, 'Smart Scene Wall Switch Intelligent Color LCD Touch Smart Work with Alexa, Google Home'),
('TP-Link Camera System', 10000, 'CCTV Services', 'tplink_cctv.png', 41, '4Mp Outdoor Smart Wire-Free Security Battery Camera System, Water & Dust Proof'),
('TP-Link Deco Router', 10050, 'Printers,Routers & Switches', 'tplink_router.png', 33, 'Home Mesh WiFi 6 System with PoE Router | Seamless AI | HomeShield | 3000 Mbps Wireless'),
('TP-Link LS105G', 1175, 'Printers,Routers & Switches', 'tplink_switch.png', 44, '5-Port Desktop/ Wall-mount Gigabit Ethernet Switch, Ethernet Splitter, Plug & Play');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Account`
--
ALTER TABLE `Account`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `Cart`
--
ALTER TABLE `Cart`
  ADD PRIMARY KEY (`item_no`),
  ADD KEY `fk_product_name` (`item_name`),
  ADD KEY `fk_username` (`username`);

--
-- Indexes for table `Orders`
--
ALTER TABLE `Orders`
  ADD KEY `fk_item_name` (`item_name`),
  ADD KEY `Orders_ibfk_1` (`username`);

--
-- Indexes for table `Product`
--
ALTER TABLE `Product`
  ADD PRIMARY KEY (`product_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Cart`
--
ALTER TABLE `Cart`
  MODIFY `item_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Cart`
--
ALTER TABLE `Cart`
  ADD CONSTRAINT `fk_product_name` FOREIGN KEY (`item_name`) REFERENCES `Product` (`product_name`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_username` FOREIGN KEY (`username`) REFERENCES `Account` (`username`);

--
-- Constraints for table `Orders`
--
ALTER TABLE `Orders`
  ADD CONSTRAINT `Orders_ibfk_1` FOREIGN KEY (`username`) REFERENCES `Account` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
