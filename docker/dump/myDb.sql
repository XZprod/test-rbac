SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE users
(
  id int PRIMARY KEY AUTO_INCREMENT,
  fullname varchar(100) NOT NULL,
  phone varchar(30),
  time1 timestamp DEFAULT current_timestamp,
  time2 timestamp DEFAULT current_timestamp
);

ALTER TABLE users ADD pass VARCHAR(50) NULL;
ALTER TABLE users ADD `key` VARCHAR(50) NULL;

CREATE TABLE auth_items
(
  id int PRIMARY KEY AUTO_INCREMENT,
  title varchar(50) NOT NULL
);
alter TABLE  auth_items add name VARCHAR(50) NULL;
CREATE TABLE groups
(
  id int PRIMARY KEY AUTO_INCREMENT,
  title varchar(50) NOT NULL
);

CREATE TABLE items_groups
(
  item_id int NOT NULL references auth_items,
  group_id int NOT NULL references groups,
  FOREIGN KEY (item_id) REFERENCES auth_items(id),
  FOREIGN KEY (group_id) REFERENCES groups(id),
  PRIMARY KEY (item_id, group_id)
);

CREATE TABLE users_groups
(
  user_id int NOT NULL references users,
  group_id int NOT NULL references groups,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (group_id) REFERENCES groups(id),

  PRIMARY KEY (user_id, group_id)
);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
