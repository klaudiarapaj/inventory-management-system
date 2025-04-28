CREATE DATABASE IF NOT EXISTS `grocery_db`;
USE `grocery_db`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


-- Database: `grocery_db`


-- --------------------------------------------------------
-- Table: admin
-- --------------------------------------------------------

CREATE TABLE `users` (
  `userid` INT(3) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(30) NOT NULL,
  `mobile` VARCHAR(15) NOT NULL,
  `email` VARCHAR(30) NOT NULL,
  `password` VARCHAR(50) NOT NULL,
  `role` ENUM('admin', 'employee') NOT NULL DEFAULT 'employee',
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users` (`userid`, `name`, `mobile`, `email`, `password`, `role`) VALUES
(1, 'Klaudia', '7756908815', 'klaudia@unyt.edu.al', MD5('12345678'), 'admin'),
(2, 'Gerta', '7756908815', 'gerta@unyt.edu.al', MD5('12345678'), 'employee'),
(3, 'Hatixhe', '774286946', 'hatixhe@unyt.edu.al', MD5('12345678'), 'employee');

-- --------------------------------------------------------
-- Table: categories
-- --------------------------------------------------------

CREATE TABLE `categories` (
  `categoryid` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`categoryid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `categories` (`categoryid`, `name`) VALUES
(1, 'Fruit & Vegetables');

-- --------------------------------------------------------
-- Table: items (products)
-- --------------------------------------------------------

CREATE TABLE `items` (
  `itemid` INT(9) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NOT NULL,
  `category_id` INT,
  `item_rating` INT(3) NOT NULL,
  `image` VARCHAR(90) NOT NULL,
  `description` VARCHAR(800) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`itemid`),
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`categoryid`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `items` (`itemid`, `title`, `category_id`, `item_rating`, `image`, `description`, `price`) VALUES
(1, 'Green Peas', 1, 5, '10000283_11-fresho-green-peas.jpg', '70.00 ALL - 1 kg', 70.00),  -- Assuming 100 in stock
(2, 'Banana', 1, 3, '10000025_24-fresho-banana-robusta.jpg', '200 ALL - 1 kg', 200.00),  -- Assuming 150 in stock
(3, 'Okra', 1, 2, '10000142_16-fresho-ladies-finger.jpg', '100 ALL - 1 kg', 100.00),  -- Assuming 200 in stock
(4, 'Tomato', 1, 5, '10000200_17-fresho-tomato-hybrid.jpg', '100 ALL - 1 kg', 100.00),  -- Assuming 120 in stock
(5, 'Pomegranate', 1, 5, '20000708_14-fresho-pomegranate.jpg', '150 ALL - 1 kg', 150.00);  -- Assuming 80 in stock

-- --------------------------------------------------------
-- Table: inventory
-- --------------------------------------------------------

CREATE TABLE `inventory` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `item_id` INT NOT NULL,
  `quantity` INT NOT NULL DEFAULT 0,
  `last_updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`item_id`) REFERENCES `items`(`itemid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `inventory` (`id`, `item_id`, `quantity`) VALUES
(1, 1, 50),
(2, 2, 40),
(3, 3, 30),
(4, 4, 60),
(5, 5, 20);

-- --------------------------------------------------------
-- Table: transactions
-- --------------------------------------------------------
CREATE TABLE `transactions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `transaction_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `remarks` VARCHAR(255),
  `total` DECIMAL(10,2) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `transaction_lines` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `transaction_id` INT NOT NULL,
  `item_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  `price_each` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`transaction_id`) REFERENCES `transactions`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`item_id`) REFERENCES `items`(`itemid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

COMMIT;

