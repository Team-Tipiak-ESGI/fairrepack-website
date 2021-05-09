create table fairrepack.address
(
    id_address      int             not null
        primary key,
    country         enum ('France') null,
    owner_name      varchar(256)    null,
    address_line1   varchar(256)    null,
    address_line2   varchar(256)    null,
    city            varchar(256)    null,
    state           varchar(256)    null,
    postal_code     varchar(10)     null,
    phone_number    varchar(256)    null,
    additional_info text            null
)
    comment 'Address used for warehouses and user addresses';

create table fairrepack.category
(
    id_category int auto_increment
        primary key,
    name        varchar(128) not null,
    constraint name_UNIQUE
        unique (name)
)
    comment 'Product category';

create table fairrepack.history_ip
(
    id_history_ip int auto_increment
        primary key,
    ip            varchar(45) not null,
    constraint ip_UNIQUE
        unique (ip)
)
    comment 'User login history (remote addresses)' collate = latin1_general_cs;

create table fairrepack.history_useragent
(
    id_history_useragent int auto_increment
        primary key,
    useragent            varchar(1024) collate latin1_general_cs not null,
    constraint useragent_UNIQUE
        unique (useragent)
)
    comment 'User login history (useragents)';

create table fairrepack.type
(
    id_type  int auto_increment
        primary key,
    name     varchar(128) not null,
    category int          null,
    constraint name_UNIQUE
        unique (name),
    constraint id_category
        foreign key (category) references fairrepack.category (id_category)
            on update cascade
)
    comment 'Product type';

create table fairrepack.reference
(
    id_reference   int auto_increment,
    uuid_reference char(36)     not null,
    brand          varchar(128) not null,
    name           varchar(128) not null,
    value          float(6, 2)  not null,
    type           int          not null,
    primary key (id_reference, uuid_reference),
    constraint brand_UNIQUE
        unique (brand),
    constraint name_UNIQUE
        unique (name),
    constraint type
        foreign key (type) references fairrepack.type (id_type)
)
    comment 'Product reference';

create index type_idx
    on fairrepack.reference (type);

create table fairrepack.specification
(
    id_specification int auto_increment
        primary key,
    name             varchar(128) not null,
    value            varchar(45)  not null,
    type             int          not null,
    constraint type_specification
        foreign key (type) references fairrepack.type (id_type)
)
    comment 'Product reference''s specification value';

create index type_idx
    on fairrepack.specification (type);

create index id_category_idx
    on fairrepack.type (category);

create table fairrepack.user
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
    primary key (id_user, uuid_user),
    constraint email_UNIQUE
        unique (email),
    constraint id_address
        foreign key (address) references fairrepack.address (id_address)
            on update cascade on delete set null
);

create table fairrepack.history_login
(
    id_history_login int auto_increment
        primary key,
    user             int                                  not null,
    date             datetime default current_timestamp() not null,
    useragent        int                                  null,
    ip               int                                  null,
    constraint history_ip
        foreign key (ip) references fairrepack.history_ip (id_history_ip)
            on update cascade on delete cascade,
    constraint history_user
        foreign key (user) references fairrepack.user (id_user)
            on update cascade on delete cascade,
    constraint history_useragent
        foreign key (useragent) references fairrepack.history_useragent (id_history_useragent)
            on update cascade on delete cascade
)
    comment 'User login history';

create index id_address_idx
    on fairrepack.user (address);

create table fairrepack.warehouse
(
    id_warehouse int auto_increment
        primary key,
    name         varchar(45) not null,
    address      int         null,
    constraint address
        foreign key (address) references fairrepack.address (id_address)
            on update cascade on delete set null
);

create table fairrepack.product
(
    id_product   int auto_increment,
    uuid_product char(36)                                                                                    not null,
    user         int                                                                                         not null,
    state        enum ('registered', 'in_stock', 'sold', 'rejected', 'accepted') default 'registered'        not null,
    quality      enum ('new', 'high', 'medium', 'low', 'broken')                                             null,
    description  text                                                                                        null,
    reference    int                                                                                         not null,
    warehouse    int                                                                                         null,
    created      datetime                                                        default current_timestamp() not null,
    primary key (id_product, uuid_product),
    constraint reference
        foreign key (reference) references fairrepack.reference (id_reference)
            on update cascade,
    constraint user_product
        foreign key (user) references fairrepack.user (id_user)
            on update cascade,
    constraint warehouse
        foreign key (warehouse) references fairrepack.warehouse (id_warehouse)
            on update cascade
);

create table fairrepack.image
(
    id_image int auto_increment
        primary key,
    product  int         not null,
    image    longblob    not null,
    mime     varchar(64) not null,
    constraint product_image
        foreign key (product) references fairrepack.product (id_product)
            on update cascade on delete cascade
)
    comment 'Product image sent by user';

create index product_idx
    on fairrepack.image (product);

create table fairrepack.offer
(
    id_offer int auto_increment
        primary key,
    user     int                                  not null,
    product  int                                  not null,
    price    float(6, 2)                          null,
    note     text                                 null,
    created  datetime default current_timestamp() not null,
    constraint product_offer
        foreign key (product) references fairrepack.product (id_product)
            on update cascade on delete cascade,
    constraint user_offer
        foreign key (user) references fairrepack.user (id_user)
            on update cascade
);

create index reference_idx
    on fairrepack.product (reference);

create index user_product_idx
    on fairrepack.product (user);

create index warehouse_idx
    on fairrepack.product (warehouse);

create table fairrepack.review
(
    user    int                                  not null,
    product int                                  not null,
    date    datetime default current_timestamp() not null,
    content text                                 null,
    note    int                                  null,
    primary key (user, product),
    constraint product_review
        foreign key (product) references fairrepack.product (id_product)
            on update cascade on delete cascade,
    constraint user_review
        foreign key (user) references fairrepack.user (id_user)
            on update cascade
);

create index product_idx
    on fairrepack.review (product);

create index address_idx
    on fairrepack.warehouse (address);

