
drop database if exists kanta;
create database kanta;
use kanta;






CREATE TABLE asiakas (
    asid integer primary key auto_increment, 
    astunnus CHAR(10), 
    asetunimi CHAR(50) NOT NULL, 
    assukunimi CHAR(50) NOT NULL,
    asosoite CHAR(50) NOT NULL,
    postinro CHAR(5), 
    postitmp CHAR(10), 
    puhelin CHAR(10),
    email CHAR(30)
    );



INSERT INTO asiakas VALUES (1, 'peltsi','Pera','Järvinen','Raatteentie 8','88900','Kuhmo',0401230432, 'pera@roudarit.fi') ;
INSERT INTO asiakas VALUES (2, 'mikko','Mikko','Aho','Puistokatu 68','91500','Muhos',0403213321, 'mikko@talkkarit.fi') ;
INSERT INTO asiakas VALUES (3, 'kille','Kimmo','Revontuli','Umpikuja 33','93100','Pudasjärvi',040765657, 'kille@hemmot.fi') ;




create table category (
    id int primary key auto_increment,
    name varchar(100) not null
);
INSERT INTO category(name) value('Tietokirjallisuus');
INSERT INTO category(name) value('Fiktiokirjallisuus');
INSERT INTO category(name) value('Lastenkirjallisuus');




CREATE TABLE kirja (
    kirjaid int primary key auto_increment, 
    kirjanimi CHAR(100) NOT NULL,
    kirjailija CHAR(100) NOT NULL,
    vuosi SMALLINT,kieli CHAR(10) NOT NULL,
    kustantaja CHAR(100) NOT NULL,
    kuvaus CHAR(255) NOT NULL,
    hinta DECIMAL(5,2),saldo SMALLINT,
    kuva CHAR(225),
    CONSTRAINT kirjanimi_un UNIQUE (kirjanimi), 
    category_id int not null,
    index category_id(category_id),
    foreign key (category_id) references category(id) on delete restrict
    );


INSERT INTO kirja VALUES (1,'nimi1','kirjailija1', 2019, 'Suomi','Otava');
INSERT INTO kirja VALUES (2,'nimi2','kirjailija2', 2018, 'Suomi','Gummerus');
INSERT INTO kirja VALUES (3,'nimi3','kirjailija3', 2019, 'Suomi','Otava');
INSERT INTO kirja VALUES (4,'nimi4','kirjailija4', 2019, 'Suomi','Gummerus');
INSERT INTO kirja VALUES (5,'nimi5','kirjailija5', 2020, 'Suomi','Otava');
INSERT INTO kirja VALUES (6,'nimi6','kirjailija6', 2017, 'Suomi','Gummerus');
INSERT INTO kirja VALUES (7,'nimi7','kirjailija7', 2016, 'Suomi','Otava');






CREATE TABLE tilaus (
    tilausnro INTEGER primary key auto_increment NOT NULL,
    asid integer NOT NULL, 
    pvm timestamp default current_timestamp, 
    tila CHAR(1),
    CONSTRAINT tilaus_asiakas_fk FOREIGN KEY (asid) REFERENCES asiakas (asid)
    ); 


INSERT INTO tilaus VALUES (1,1,'2021-11-08 20:17:04','T');
INSERT INTO tilaus VALUES (2,1,'2021-11-08 10:29:01','L');
INSERT INTO tilaus VALUES (3,2,'2021-11-09 08:45:02','M');
INSERT INTO tilaus VALUES (4,3,'2021-11-01 12:51:09','T');



CREATE TABLE tilausrivi (
    tilausnro INTEGER NOT NULL,
    kirjaid INTEGER, 
    kpl INTEGER,
    PRIMARY KEY(tilausnro, kirjaid),
    CONSTRAINT tilausrivi_fk FOREIGN KEY (tilausnro) REFERENCES tilaus(tilausnro), 
    CONSTRAINT tilausrivi_kirja_fk FOREIGN KEY (kirjaid) REFERENCES kirja (kirjaid)
    );


INSERT INTO tilausrivi VALUES (1,1,2); 
INSERT INTO tilausrivi VALUES (2,6,1);
INSERT INTO tilausrivi VALUES (2,11,2);
INSERT INTO tilausrivi VALUES (2,12,1);
INSERT INTO tilausrivi VALUES (3,7,9); 
INSERT INTO tilausrivi VALUES (3,20,1);
INSERT INTO tilausrivi VALUES (3,3,3);
INSERT INTO tilausrivi VALUES (4,2,1); 


CREATE TABLE user (
    userid integer primary key auto_increment,
    firstname VARCHAR(50), 
    lastname VARCHAR(50), 
    username VARCHAR(50),
    password VARCHAR(10)
    );

INSERT INTO user VALUES (1, 'Iso','Pomo','admin','admin'); 