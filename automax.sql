create database AutoMax;
use AutoMax;

create table carros (
	id_carro int not null primary key auto_increment,
    marca varchar(100) not null,
    modelo varchar(100) not null,
    anoFabricacao int,
    preco float not null
);