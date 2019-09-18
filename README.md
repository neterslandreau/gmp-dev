# Grow-My-Profits

## [Laravel 6.0 Server Requirements](https://laravel.com/docs/6.0/installation#server-requirements)

##### Important step in processing: `alias phart='php artisan'`

### GMP Installation
1. clone repository and `cd` into the installation directory.
1. ```composer update```
1. ```phart migrate```
1. ```phart db:seed```
(this will add superusers)
1. ( _optional to add fake users._ ) ``` phart db:seed --class=UsersTableSeeder``` 
1. Login as a superuser and assign yourself the stores you wish to access.
1. Process data files to load the database.

### GMP File Processing

All of the file processing commands are ready for crontabs:

`0 3 * * * /usr/bin/php artisan {process:files [date('dmy')]}` 

The above will process the sales and invoices '.K' file at 3am on {dmy}.

To run a daily import of the data:

```phart process:files {date}```

This will download and process all files for the date given. 
Date format is "dmy" (010119).

The ```process:files```  method calls the following commands:

```download:file {file} {type}``` where type can be ```Invoices``` or ```Items```.

```download:file``` the calls the following commands:

 ```import:invoices {file}```

 ```import:items {file}```

The ```import:*```  parse the files and update the tables in the database.

All of the commands can be executed by themselves.
