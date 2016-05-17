# DbVerge
A Laravel package to show the first or the last row data of DB in command line.  
(This is for Laravel 4.2. [For Laravel 5+](https://github.com/SUKOHI/DbVerge))

# Installation

Execute composer command.

    composer require sukohi/db-verge:1.*

Register the service provider in app.php

    'providers' => [
        ...Others...,  
        'Sukohi\DbVerge\DbVergeServiceProvider',
    ]

Now you are able to execute `php artisan db:verge` command.

# Basic usage

`php artisan db:verge`

# Options

`--orderby`

Order direction. `asc` or `desc`. Default is `desc`.

`--table`

Specific table name that you'd like to show.

`--limit`

Number of records to return. Default is 1.


# License

This package is licensed under the MIT License.

Copyright 2016 Sukohi Kuhoh