
drop table if exists finan_pessoal.share_checking_account;

drop table if exists finan_pessoal.checking_account;

drop table if exists finan_pessoal."user";

create table finan_pessoal."user"
(
    id serial
        constraint user_pkey
            primary key,
    name varchar(25) not null,
    login varchar(25) not null,
    password varchar(20) not null,
    fixed_salary double precision,
    login_share varchar(25)
);

create table finan_pessoal.checking_account
(
    id serial
        constraint checking_account_pkey
            primary key,
    description varchar(25) not null,
    value double precision not null,
    "date" date not null,
    type integer not null,
    id_user integer default 0 not null
        constraint checking_account_id_Auser_fkey
            references finan_pessoal."user",
    id_user_share integer default null
        constraint checking_account_id_Auser_share_fkey
            references finan_pessoal."user"
);

create table finan_pessoal.share_checking_account
(
    id serial
        constraint share_transaction_pkey
            primary key,
    date date,
    id_user integer default 0 not null
        constraint share_transaction_id_user_fkey
            references finan_pessoal."user",
    id_checking_account integer default 0 not null
        constraint checking_account_fk_key
            references finan_pessoal."checking_account",
    date_update date,
    accepted bool default null
);


