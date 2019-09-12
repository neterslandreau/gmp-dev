# Grow-My-Profits

##[Laravel 5.8 Server Requirements](https://laravel.com/docs/5.8/installation#server-requirements)

### GMP File Processing

All of the file processing commands are ready for crontabs:

`0 3 * * * /usr/bin/php artisan {process:files 010119}` 

The above will process the sales and invoices '.K' file at 3am daily.

####Important step in processing: `alias phart='php artisan'`

To run a daily import of the data:

```phart process:files {date}```

This will download and process all files for the date given. 
Date format is "mdy" (010119).

The ```process:files```  method calls the following commands:

```download:file {file} {type}``` where type can be ```Invoices``` or ```Items```.

```download:file``` the calls the following commands:

 ```import:invoices {file}```

 ```import:items {file}```

The ```import:*```  parse the files and update the tables tables in the database.

All of the commands can be executed by themselves.
