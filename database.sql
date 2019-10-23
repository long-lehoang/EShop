CREATE TABLE IF NOT EXISTS USER(
    id int AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(11) NOT NULL,
    fullname VARCHAR(255) NOT NULL,
    birthday VARCHAR(10) NOT NULL,
    sex VARCHAR(3) NOT NULL,
    address VARCHAR(255) NOT NULL,
    isadmin BOOLEAN DEFAULT 0
)    ENGINE = MyISAM;

CREATE TABLE IF NOT EXISTS PRODUCT (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(15,2) NOT NULL,
    quantity DECIMAL(15,2) DEFAULT 0,
    sold DECIMAL(15,2) DEFAULT 0,
    productor_id int NOT NULL,
    category_id int NOT NULL,
    user_id int NOT NULL,
    info text NOT NULL
    
)   ENGINE = MyISAM;

CREATE TABLE IF NOT EXISTS CATEGORY(
    id int AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL
)   ENGINE = MyISAM;

CREATE TABLE IF NOT EXISTS PRODUCTOR(
    id int AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    info VARCHAR(255) NOT NULL
)   ENGINE = MyISAM;

CREATE TABLE IF NOT EXISTS PAYMENT (
    id int AUTO_INCREMENT PRIMARY KEY,
    cart_id int NOT NULL,
    user_id int ,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(11) NOT NULL,
    address VARCHAR(255) NOT NULL,
    voucher_id int,
    time datetime DEFAULT CURRENT_TIMESTAMP,
    status boolean DEFAULT 0,
)   ENGINE = MyISAM;

CREATE TABLE IF NOT EXISTS CART(
    id int AUTO_INCREMENT PRIMARY KEY,
    user_id int,
    price DECIMAL(15,2) NOT NULL
)   ENGINE = MyISAM;

CREATE TABLE IF NOT EXISTS VOUCHER(
    id int PRIMARY KEY,
    discount DECIMAL(15,2),
    expire datetime NOT NULL
)   ENGINE = MyISAM;

CREATE TABLE IF NOT EXISTS CART_PRODUCT(
    cart_id int,
    product_id int,
    quantity DECIMAL(15,2),
    CHECK (quantity>0),
    CONSTRAINT PK_CART_PRODUCT PRIMARY KEY(cart_id,product_id)
)   ENGINE = MyISAM;

CREATE TABLE IF NOT EXISTS IMAGE_PRODUCT(
    id int NOT NULL,
    image VARCHAR(255),
    CONSTRAINT PK_IMAGE_PRODUCT PRIMARY KEY (id,image)

)   ENGINE = MyISAM;

CREATE TABLE IF NOT EXISTS COMMENT(
    id int AUTO_INCREMENT PRIMARY KEY,
    parent int DEFAULT 0,
    product_id int NOT NULL,
    time datetime DEFAULT now(),
    comment text,
    star int,
    name varchar(255)
)   ENGINE = MyISAM;

ALTER TABLE COMMENT
ADD FOREIGN KEY (parent) REFERENCES COMMENT(id) ON DELETE CASCADE;
ALTER TABLE COMMENT
ADD FOREIGN KEY (product_id) REFERENCES PRODUCT(id) ON DELETE CASCADE;
ALTER TABLE COMMENT
ADD FOREIGN KEY (name) REFERENCES USER(name) ON DELETE CASCADE;
-- foreign key --
ALTER TABLE PRODUCT
ADD FOREIGN KEY (productor_id) REFERENCES PRODUCTOR(id) ON DELETE SET NULL;
ALTER TABLE PRODUCT
ADD FOREIGN KEY (category_id) REFERENCES CATEGORY(id) ON DELETE SET NULL;
ALTER TABLE PRODUCT
ADD FOREIGN KEY (user_id) REFERENCES USER(id);

ALTER TABLE PAYMENT     
ADD FOREIGN KEY (cart_id) REFERENCES CART(id);
ALTER TABLE PAYMENT
ADD FOREIGN KEY (user_id) REFERENCES USER(id);
ALTER TABLE PAYMENT
ADD FOREIGN KEY (voucher_id) REFERENCES VOUCHER(id);

ALTER TABLE CART
ADD FOREIGN KEY (user_id) REFERENCES USER(id) ON DELETE SET NULL;

ALTER TABLE CART_PRODUCT
ADD FOREIGN KEY (cart_id) REFERENCES CART(id) ON DELETE CASCADE;
ALTER TABLE CART_PRODUCT
ADD FOREIGN KEY (product_id) REFERENCES PRODUCT(id) ON DELETE CASCADE;

ALTER TABLE IMAGE_PRODUCT
ADD FOREIGN KEY (id) REFERENCES PRODUCT(id) ON DELETE CASCADE;

-- view list product --
CREATE VIEW VIEW_PRODUCT
    AS
    SELECT PRODUCT.id as id,PRODUCT.name as name,PRODUCT.quantity as quantity,PRODUCT.price as price,PRODUCT.info as info,CATEGORY.name as category,PRODUCTOR.name as productor,PRODUCT.sold as sold
    FROM PRODUCT,CATEGORY,PRODUCTOR WHERE PRODUCT.category_id = CATEGORY.id AND PRODUCT.productor_id = PRODUCTOR.id
    ORDER BY id ASC

