-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mumfern`
--

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` tinyint(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `order_username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `order_date` datetime NOT NULL,
  `order_status` tinyint(1) NOT NULL DEFAULT '1',
  `total_paid` decimal(10,2) NOT NULL,
  `tracking_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=55 ;

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(4) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `product_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `product_price` decimal(7,2) NOT NULL,
  `product_detail` text COLLATE utf8_unicode_ci NOT NULL,
  `product_type` int(1) NOT NULL,
  `product_quality` int(1) NOT NULL,
  `product_size` int(1) NOT NULL,
  `product_stock` int(1) NOT NULL,
  `product_image` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=44 ;

--
-- dump ตาราง `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_price`, `product_detail`, `product_type`, `product_quality`, `product_size`, `product_stock`, `product_image`) VALUES
(0002, 'Diversifolium', '200.00', 'เป็น P.hilii cv. อีกชนิด ใบ fertile frond แคบเรียว ใบส่วนที่แตกแฉกไม่แผ่กว้าง ส่วนเว้าที่ปลายใบไม่ลึกเหมือนกับอีกชนิดหนึ่ง ใบ shields frond ตั้งขึ้นเป็นมงกุฎ', 1, 1, 4, 1, '20141010_132804~1.jpg'),
(0003, 'ข้าหลวงอินโดนิเซีย', '200.00', 'ความสวยงามของข้าหลวงนี้อยู่ที่ขอบเป็นสัน หยักคลื่นและเป็นระเบียบ เป็นข้าหลวงที่กลายพันธุ์ในอินโดนิเซีย', 1, 2, 4, 1, '20141010_123611.jpg'),
(0004, 'ข้าหลวงด่างญี่ปุ่น', '800.00', '', 1, 2, 4, 1, '20141013_113255.jpg'),
(0005, 'ข้าหลวงลาซานญ่า', '600.00', '', 1, 4, 1, 1, '20141013_113221.jpg'),
(0006, 'หูช้างแอฟริกา', '450.00', 'หรือหูช้าง ลักษIะเด่นของเฟินชนิดนี้ ใบ shields frond สีเขียวสว่าง ในธรรมชาติจะเกิดก่อนฤดูหนาว ใบ fertile frond กว้าง ยาว ยื่นออกมาแล้วห้อยลงมา อับสปอร์เกิดปลายใบ  ลักษณะในทั้งสองแบบเป็นคลื่น มีรอยนูนตามเส้นใบ ทำให้ดูเหมือนใบเป็นร่องลึก เหง้าสีขนสีขาวปกคลุม เฟินชนิดนี้ชอบอากาศร้อน และแสงมาก\r\n\r\nพบตามในบริเวณเส้นศูนย์สูตร ตามแนวชายฝั่งของแอฟาริกากลาง ขึ้นอยู่ตามต้นไม้ใหญ่ ที่ระดับความสูงจากระดับน้ำทะเล 200-1,500 เมตร เช่นประเทศอูกันดา พบในพื้นที่แห้งแล้งกว่า P.stemaria', 1, 1, 4, 1, '20141010_132756.jpg'),
(0007, 'ชองนางคลี่ก้านดำ', '1000.00', 'ช่อนางคลีก้านขาวเส้นใหญ่ๆ สวยๆ', 1, 3, 4, 1, '20141013_113158.jpg'),
(0008, 'เม้าคิชฌกูฏ', '2000.00', 'P.Mt.Kitshakood   เป็นลูกผสมระหว่าง P.coroanrium และ P.redleyi', 1, 1, 4, 1, '20141013_113138.jpg'),
(0009, 'หางปลา', '200.00', 'เฟิน ข้าหลวงที่กลายพันธุ์ไปจากพันธุ์เดิม มีการแตกกอแน่น ใบเล็กแคบ ปลายใบแตกเป็นพูแฉกขนาดใหญ่ดูคล้ายหางปลาที่โบกขึ้นเหนือน้ำ ขอบใบเป็นคลื่นไม่เรียบเหมือนพันธุ์ปกติ เส้นกลางใบสีน้ำตาลอ่อนอมเขียว จำนวนใบต่อกอมากกว่าชนิดปกติ ปลายใบอาจแตกเป็นพูเล็กๆได้อีก', 1, 2, 4, 1, '20141013_113536.jpg'),
(0010, 'ฮิลลิอาย', '80.00', 'ลักษณะเด่นของ P.hillii คือใบ fertile frond กว้าง ตั้งชูขึ้น สีเขียวเข็ม ใบ shields frond ไม่เป็นมงกุฏ หรือกระจาก เหมือนรังนก แต่จะปิดเรียบสม่ำเสมอ\r\n\r\nพบในเขตพื้นที่ต่ำ ชุ่มชื้น ในประเทศออสเตรเลีย และปาปัวนิวกินี', 1, 1, 4, 1, '20141014_113257.jpg'),
(0011, 'แวนเด้ (Platycerium wandae)', '120.00', ' โดยทั่วไปมักเรียกเฟินชนิดนี้ว่า "ชายผ้าวันดี" "ชายผ้าแวนเด้" หรือ "ชายผ้าวานเด" แล้วแต่สำเนีนงของแต่ละคน\r\n\r\n    เฟินชายผ้าสีดาแวนเด้ (Platycerium wandae)  เป็นเฟินอิงอาศัยที่เติบโตเป็นต้นเดี่ยวๆ มีถิ่นกำเนิดในนิวกีนี นับว่าเป็นชายผ้าที่มีขนาดใหญ่ที่สุด อาศัยอยู่ตามคาคบไม้สูง 25 เมตร ในป่าดิบชื้นระดับ 0-1,000 เมตร จากระดับน้ำทะเล หากอยู่ในสภาพแวดล้อมที่เหมาะสม จนได้รับฉายาว่าเป็น "ราชินีชายผ้าสีดา" (Oueen Staghorn)', 1, 1, 4, 1, '20141014_113456.jpg'),
(0012, 'ข้าหลวงโอซากา', '50.01', 'เป็นเฟินข้าหลวงซึ่งกลายพันธุ์ในญี่ปุ่น มีขนาดย่อมกว่าเฟินข้าหลวงปลายใบเรียวแหลม ขอบใบหยักเป็นลอน ใบสีเขียวอ่อน', 1, 2, 4, 1, '20141014_113401.jpg'),
(0013, 'ปาปัวก้านดำ', '150.00', '', 1, 2, 4, 1, '20141014_113409.jpg'),
(0014, 'แกรนเด้', '250.00', 'ชื่อสามัญ Staghorn fern กระโปรงสีดา\r\nมีถิ่นกำเนิดในพิลิปปินส์เท่านั้นและมีแน้วโน้มสูญพันธุ์ไปจากป่าธรรมชาติ \r\n', 1, 1, 4, 1, '20141014114330.jpg'),
(0015, 'หางสิวสร้อย', '250.00', '', 1, 3, 4, 1, '20141014_114118.jpg'),
(0016, 'แหลม', '20.00', 'ขนาด 7" * 10"', 2, 6, 3, 1, '20141013_112643.jpg'),
(0017, 'ก้นตัดตื้น', '20.00', 'ขนาด 8" * 5"', 2, 7, 3, 1, '20141013_112748.jpg'),
(0018, 'แหลมจิ๋ว', '12.00', '5" * 8"', 2, 6, 1, 1, 'JL1.jpg'),
(0019, 'แหลมเล็ก', '14.00', '', 2, 6, 2, 1, 'll1.jpg'),
(0020, 'แหลมใหญ่', '27.00', '8" * 11"', 2, 6, 3, 1, 'Bl1.jpg'),
(0021, 'ตัดตื้นกลาง', '0.00', '8" * 5"', 2, 7, 3, 1, 'ttm.jpg'),
(0022, 'ตัดตื้นเล็ก', '14.00', '7" * 4"', 2, 7, 3, 1, 'tts.jpg'),
(0023, 'บอล', '12.00', '5" *3"', 2, 5, 1, 1, 'bxs.jpg'),
(0024, 'บอลเล็ก', '14.00', '6" * 4"', 2, 5, 1, 1, 'bs.jpg'),
(0025, 'บอลกลาง', '20.00', '7" * 5"', 2, 5, 3, 1, 'bm.jpg'),
(0026, 'บอลใหญ่', '27.00', '8" * 5.5"', 2, 5, 3, 1, 'bxl.jpg'),
(0027, 'ตัดปกติ', '27.00', '8" * 7.5"', 2, 7, 3, 1, 'txl.jpg'),
(0043, 'qweqweพพ', '123.00', '123พพ', 2, 1, 1, 1, 'Hydrangeas.jpg');

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `quality`
--

CREATE TABLE IF NOT EXISTS `quality` (
  `product_quality` int(2) NOT NULL AUTO_INCREMENT,
  `quality_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `quality_type` int(1) NOT NULL,
  PRIMARY KEY (`product_quality`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- dump ตาราง `quality`
--

INSERT INTO `quality` (`product_quality`, `quality_name`, `quality_type`) VALUES
(1, 'ชายผ้าสีดา', 1),
(2, 'ข้าหลวง', 1),
(3, 'เฟิร์นสาย', 1),
(4, 'ไพโรเซีย', 1),
(5, 'แบบกลม', 2),
(6, 'แบบแหลม', 2),
(7, 'แบบตัด', 2);

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `size`
--

CREATE TABLE IF NOT EXISTS `size` (
  `product_size` int(1) NOT NULL,
  `size_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- dump ตาราง `size`
--

INSERT INTO `size` (`product_size`, `size_name`) VALUES
(1, 'เล็ก'),
(2, 'กลาง'),
(3, 'ใหญ่'),
(4, 'ไม่สามารถระบุขนาด');

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `slide`
--

CREATE TABLE IF NOT EXISTS `slide` (
  `slide_id` int(1) NOT NULL AUTO_INCREMENT,
  `product_id` int(4) NOT NULL,
  `slide_detail` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`slide_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- dump ตาราง `slide`
--

INSERT INTO `slide` (`slide_id`, `product_id`, `slide_detail`) VALUES
(1, 43, 'asdasdasdasdasasdasdasdasdasdasdasasdasdasdasdasdasdd<br>asdasdasasdasdasdasdasdasdasdasdasdasdasdas'),
(2, 5, 'wwwwwwwwwwwwwwwwwwwwwwwwwwwwee'),
(3, 10, 'eeeeeeeeeeeeeeeeeeeeeeeeeee'),
(4, 11, 'sssssssssssssssssssssss');

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `type`
--

CREATE TABLE IF NOT EXISTS `type` (
  `product_type` int(1) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`product_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- dump ตาราง `type`
--

INSERT INTO `type` (`product_type`, `type_name`) VALUES
(1, 'เฟิร์น'),
(2, 'กระถาง'),
(7, 'ปุ๋ย'),
(8, 'กล้วยไม้'),
(9, 'ต้นไม้');

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `passwd` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `middlename` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(1) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- dump ตาราง `users`
--

INSERT INTO `users` (`username`, `passwd`, `fullname`, `middlename`, `lastname`, `address`, `image`, `phone`, `email`, `type`) VALUES
('admin', '1234', 'jukkapong', '', 'marsri', '    123456789    ', 'Koala.jpg', '0847524421', 'jigsaw1011@gmail.com', 1),
('lescken', '1234', 'Jukkit', 'tham', 'jinda', '223', 'Jellyfish.jpg', '', '', 3),
('localhost', '1234', 'Veeradae', '', 'Buaphuane', '112/2            ', 'Koala.jpg', '0908932864', 'jigsaw1018@windowslive.com', 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
