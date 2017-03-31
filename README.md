# _Stylist Workshop_

#### _Listings of Clients, 3/30/17_

#### By _**Eliot Carlsen**_

## Description

_SPECS:_
_Program can add stylists to a MySQL database_
_Program can add clients to a MySQL database_
_Program will assign certain clients to stylists based on their instantiation_
_Program can delete all clients from the MySQL database_
_Program can delete all stylists from the MySQL database_
_Program can display all stylists in MySQL database on page_
_Program can display all clients in MySQL database on page_
_Program can find a specific client for owner_
_Program can find a specific stylist for owner_
_Program can update a specific client for owner_
_Program can update a specific stylist for owner_
_Program can delete a specific client for owner_
_Program can delete a specific stylist for owner_

_MySQL Commands:_
_CREATE DATABASE hair_salon_
_USE hair_salon_
_CREATE TABLE stylists (name VARCHAR (255), id serial PRIMARY KEY)_
_CREATE TABLE clients (name VARCHAR (255), stylist_id INT, id serial PRIMARY KEY)_


## Setup/Installation Requirements

* _Must be run on a server with database (MySQL)_
* _Database is named hair_salon_
* _Database has two tables 1.stylists 2.clients_
* _Composer.json dependencies include: phpunit, silex and twig_

## Known Bugs

_None_

## Support and contact details

_For questions email eliot.carlsen@gmail.com_

## Technologies Used

_PHP_
_MySQL_
_Twig_
_Silex_
_Bootstrap_
_CSS_
_HTML_

### License

Copyright (c) 2016 **_Eliot Carlsen_**
