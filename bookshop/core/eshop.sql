DROP DATABASE IF EXISTS eshop;
CREATE DATABASE eshop CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE eshop;

CREATE TABLE catalog (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    pubyear INT NOT NULL
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id VARCHAR(50) NOT NULL UNIQUE,
    customer VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    address VARCHAR(255) NOT NULL,
    created DATETIME NOT NULL
);

CREATE TABLE ordered_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id VARCHAR(50) NOT NULL,
    item_id INT NOT NULL,
    quantity INT NOT NULL
);

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    created DATETIME NOT NULL
);

DELIMITER $$

CREATE PROCEDURE spAddItemToCatalog(IN p_title VARCHAR(255), IN p_author VARCHAR(255), IN p_price DECIMAL(10,2), IN p_pubyear INT)
BEGIN
    INSERT INTO catalog (title, author, price, pubyear) VALUES (p_title, p_author, p_price, p_pubyear);
END$$

CREATE PROCEDURE spGetCatalog()
BEGIN
    SELECT id, title, author, price, pubyear FROM catalog ORDER BY id;
END$$

CREATE PROCEDURE spGetItemsForBasket(IN p_ids VARCHAR(255))
BEGIN
    SELECT id, title, author, price, pubyear FROM catalog WHERE FIND_IN_SET(id, p_ids) > 0 ORDER BY id;
END$$

CREATE PROCEDURE spSaveOrder(IN p_order_id VARCHAR(50), IN p_customer VARCHAR(255), IN p_email VARCHAR(255), IN p_phone VARCHAR(50), IN p_address VARCHAR(255))
BEGIN
    INSERT INTO orders (order_id, customer, email, phone, address, created) VALUES (p_order_id, p_customer, p_email, p_phone, p_address, NOW());
END$$

CREATE PROCEDURE spSaveOrderedItems(IN p_order_id VARCHAR(50), IN p_items VARCHAR(255), IN p_counts VARCHAR(255))
BEGIN
    DECLARE p_id INT;
    DECLARE p_count INT;
    WHILE CHAR_LENGTH(p_items) > 0 DO
        SET p_id = CAST(SUBSTRING_INDEX(p_items, ',', 1) AS UNSIGNED);
        SET p_count = CAST(SUBSTRING_INDEX(p_counts, ',', 1) AS UNSIGNED);
        INSERT INTO ordered_items (order_id, item_id, quantity) VALUES (p_order_id, p_id, p_count);
        IF LOCATE(',', p_items) > 0 THEN
            SET p_items = SUBSTRING(p_items, LOCATE(',', p_items) + 1);
            SET p_counts = SUBSTRING(p_counts, LOCATE(',', p_counts) + 1);
        ELSE
            SET p_items = '';
            SET p_counts = '';
        END IF;
    END WHILE;
END$$

CREATE PROCEDURE spGetOrders()
BEGIN
    SELECT id, order_id, customer, email, phone, address, created FROM orders ORDER BY id DESC;
END$$

CREATE PROCEDURE spGetOrderedItems(IN p_order_id VARCHAR(50))
BEGIN
    SELECT c.id, c.title, c.author, c.pubyear, c.price, oi.quantity
    FROM ordered_items oi
    JOIN catalog c ON c.id = oi.item_id
    WHERE oi.order_id = p_order_id
    ORDER BY c.id;
END$$

CREATE PROCEDURE spSaveAdmin(IN p_login VARCHAR(100), IN p_password VARCHAR(255), IN p_email VARCHAR(255))
BEGIN
    INSERT INTO admins (login, password, email, created) VALUES (p_login, p_password, p_email, NOW());
END$$

CREATE PROCEDURE spGetAdmin(IN p_login VARCHAR(100))
BEGIN
    SELECT id, login, password, email, created FROM admins WHERE login = p_login LIMIT 1;
END$$

DELIMITER ;

INSERT INTO catalog (title, author, price, pubyear) VALUES
('Мастер и Маргарита', 'Михаил Булгаков', 590, 1967),
('Война и мир', 'Лев Толстой', 890, 1869),
('Преступление и наказание', 'Фёдор Достоевский', 480, 1866),
('Евгений Онегин', 'Александр Пушкин', 350, 1833),
('Тихий Дон', 'Михаил Шолохов', 720, 1940);

CALL spSaveAdmin('admin', '$2y$10$KXEM53X.QXv4CL26ep7CV.EaSoyBy6qziL5kzwf2qcmYBjPRor1De', 'admin@eshop.ru');
