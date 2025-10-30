--
-- Database: `gadgethut`
--
CREATE DATABASE IF NOT EXISTS `gadgethut` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `gadgethut`;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image_url`) VALUES
(1, 'Refurbished iPhone 12', 'Excellent condition, 128GB, Unlocked. Comes with a 90-day warranty.', '450.00', 'https://images.prisradar.no/uploads/images/product_image/big/70/Y3oODFQg19hHHz2IH1jjFrx9VKjlsKWtbdl7kP3kyCcSg6Me62YyLBSRY15J3r.jpg?20240811022731'),
(2, 'Refurbished Galaxy S21', 'Good condition, minor scuffs. 256GB, Factory Unlocked. Great performance.', '380.00', 'https://www.corning.com/microsites/csm/gorillaglass/Samsung/CGG_Samsun_galaxys21_phantom.jpg'),
(3, 'Refurbished MacBook Air M1', 'Like new. 8GB RAM, 256GB SSD. Battery health 98%.', '720.00', 'https://placehold.co/600x400/444/FFF?text=MacBook+Air'),
(4, 'Certified Refurbished Dell XPS 13', '11th Gen i7, 16GB RAM, 512GB SSD. Full HD Touchscreen. 1-year warranty.', '650.00', 'https://placehold.co/600x400/666/FFF?text=Dell+XPS+13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
