create table products
(
    id          int auto_increment
        primary key,
    name        varchar(512) null,
    description text         null,
    amount      int          null
);

INSERT INTO shopping_list.products (id, name, description, amount) VALUES (1, 'bread', 'white', 1);
INSERT INTO shopping_list.products (id, name, description, amount) VALUES (2, 'milk', '2,5% 1l', 2);
INSERT INTO shopping_list.products (id, name, description, amount) VALUES (11, 'cheese', 'kg', 1);