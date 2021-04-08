create table if not exists address
(
    id_address         int             not null
        primary key,
    country            enum ('France') null,
    owner_name         varchar(256)    null,
    address_line1      varchar(256)    null,
    address_line2      varchar(256)    null,
    city               varchar(256)    null,
    state              varchar(256)    null,
    postal_code        varchar(10)     null,
    phone_number       varchar(256)    null,
    additional_info text            null
);

create table if not exists category
(
    id_category int auto_increment
        primary key,
    name        varchar(128) null
);

create table if not exists reference
(
    id_reference int auto_increment
        primary key,
    brand        varchar(128)  not null,
    name         varchar(128)  not null,
    value        decimal(6, 2) not null,
    type         int           not null,
    constraint brand_UNIQUE
        unique (brand),
    constraint name_UNIQUE
        unique (name),
    constraint type
        foreign key (type) references type (id_type)
)
    comment 'Product reference';

create table if not exists type
(
    id_type  int auto_increment
        primary key,
    name     varchar(128) not null,
    category int          null,
    constraint id_category
        foreign key (category) references category (id_category)
)
    comment 'Product type';

create table if not exists specification
(
    id_specification int auto_increment
        primary key,
    name             varchar(128) not null,
    value            varchar(45)  not null,
    type             int          not null,
    constraint type_specification
        foreign key (type) references type (id_type)
);

create table if not exists user
(
    id_user   int auto_increment,
    uuid_user char(36)                                                       not null,
    username  varchar(128)                                                   null,
    password  char(64)                                                       not null,
    email     varchar(256)                                                   not null,
    avatar    blob                                                           null,
    language  enum ('fr', 'en')                  default 'fr'                not null,
    address   int                                                            null,
    user_type enum ('normal', 'seller', 'admin') default 'normal'            not null,
    created   datetime                           default current_timestamp() not null,
    constraint email_UNIQUE
        unique (email),
    primary key (id_user, uuid_user),
    constraint id_address
        foreign key (address) references address (id_address)
);

create table if not exists warehouse
(
    id_warehouse int auto_increment
        primary key,
    name         varchar(45) null,
    address      int         null,
    constraint address
        foreign key (address) references address (id_address)
);

create table if not exists product
(
    id_product   int auto_increment,
    uuid_product char(36)                                                                         not null,
    state        enum ('registered', 'sent', 'in_stock', 'sold', 'rejected') default 'registered' not null,
    quality      enum ('new', 'high', 'medium', 'low', 'broken')                                  null,
    description  text                                                                             null,
    reference    int                                                                              not null,
    warehouse    int                                                                              null,
    primary key (id_product, uuid_product),
    constraint reference
        foreign key (reference) references reference (id_reference),
    constraint warehouse
        foreign key (warehouse) references warehouse (id_warehouse)
);

create table if not exists image
(
    id_image int auto_increment
        primary key,
    product  int  null,
    image    blob null,
    constraint product_image
        foreign key (product) references product (id_product)
);

create table if not exists offer
(
    id_offer int auto_increment
        primary key,
    user     int           not null,
    product  int           not null,
    price    decimal(6, 2) null,
    note     text          null,
    constraint product
        foreign key (product) references product (id_product),
    constraint user
        foreign key (user) references user (id_user)
);

create table if not exists review
(
    user    int                                  not null,
    product int                                  not null,
    date    datetime default current_timestamp() not null,
    content text                                 null,
    note    int                                  null,
    primary key (user, product),
    constraint product_review
        foreign key (product) references product (id_product),
    constraint user_review
        foreign key (user) references user (id_user)
);