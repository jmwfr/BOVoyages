# BOVoyages

## Getting Started

### Prerequisites

This project is based on Symfony and has external dependencies and uses CDNs so you must be connected to internet in order to make it work.

You have to have an installed version of MySQL on your computer too.

### Installing

Once you have cloned the project, go to the root folder and open a terminal, then install Yarn dependencies running:

```
yarn install
```

Then, to install composer modules use the following command:

 ```
 composer install
 ```
 
 ### Database creation
 
 In order to create the database, modify the *.env* file at the root of the project.
 
 Modify the followng line according to your MySQL server parameters :
 
 ```
 DATABASE_URL=mysql://<login>:<password>@127.0.0.1:3306/<database name>
 ```
 
 Once done, create the database using Doctrine, back in the terminal run:
 
 ```
 php bin/console doctrine:database:create
 ```
 
 Then to create database tables:
 
 ```
 php bin/console doctrine:migations:migrate
 ```
 
 ### Database data injection
 
 ***NB:*** *This step is not mandatory, you can create all the data manually using the different menus of the app.*
 
 The project already contains fixtures, created with [hautelook/AliceBundle](https://github.com/hautelook/AliceBundle) fixtures generator, to automatically inject some data in the DB.
 
 In order to inject this data, run the following command:
 
 ```
 php bin/console hautelook:fixtures:load
  ```
 
 This will automatically create 100 travels, 30 customers and 1 user.
 
 User connection credentials are:
 
 * Login: root
 * Password: 123456789
 
## Authors
  
 * [Nirmala](https://github.com/gnimmy28)
 * [Bobo](https://github.com/traorebob)
 * [Jean-Marc](https://github.com/jmwfr)
   
## License

This software is licensed under the MIT license (details [here](LICENSE.md))

## Known issues and todos

* Travels
    * [x] Add image management
    
* Bookings
    * [ ] Fix the automatic selection of the customer when editing

* Customers
    * [ ] Add a customer space page

* All pages
    * [ ] Unformize the page title