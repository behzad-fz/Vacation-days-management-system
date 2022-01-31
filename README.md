# Vacation-days-management-system

- [Services](#services) What Dev offers
- [Extra Apps](#extra-apps) What will be shipped with this image
- [PHP Modules](#php-modules) What PHP modules get installed
- [Privileges](#privileges) What privileges you have in the containers
- [Requirements](#requirements) What are the requirements to use this dockerized playground
- [Installation](#installation) How to create and start
- [Shell Access](#shell-access) How to access inside containers
- [Usage](#usage) instructions to use application
- [Run Tests](#run-tests) How to run tests (PHPUnit)
- [Code Examples](#code-examples) Code examples

### Services
- PHP 8.1

### Extra Apps
- supervisor
-git
- unzip
- pkg-config
- zlib1g-dev
- libzip-dev
- libonig-dev
- libcurl4-openssl-dev
- libssl-dev
- libicu-dev
- g++
- vim
- wget

### PHP Modules
- zip 
- sockets 
- intl 
- bcmath

### Privileges
- root

### Requirements
- Docker
- Docker Compose
- Make

### Help
You can either use provided (make) commands or use original commands.

Run command below to see list of available make commands
```
~$ make

/---Vacation-days-management-system------------------------------/
build		Build the container
up	        Create and start containers
destroy		Stop and remove containers
status 		Shows the status of the containers
shell		Starting a shell in php container
test     	Run all the application tests
/-----------------------------------------------------------------/
```
### Installation
```
~$ make build
 OR
~$ docker-compose up --build -d
```

### Shell Access
To access the php container as a root user:
```
~$ make shell
 OR
~$ docker-compose exec app bash
```
### Usage
You get vacation days report following command:
Notice : Commands should be executed inside php container
```
~$ make shell
~$ php index.php 2xxx (get report on terminal)
    Ex : ~$ php index.php 2020
~$ php index.php 2xxx --format-json=path/to/file.json (get report in json file)
    Ex : ~$ php index.php 2020 --format-json=reports/vacations.json
~$ php index.php 2xxx --format-json=txt/to/file.txt (get report in text file)
    Ex : ~$ php index.php 2020 --format-txt=reports/vacations.txt
```

### Run Tests
You can run tests by entering the following command:
Notice : Commands should be executed inside php container
```
~$ make shell
~$ make test 
 OR
~$ ./vendor/bin/phpunit
```

### Code Examples
Here are some code examples may be useful
```

$sqlite = new \App\DataSources\Sqlite();
$employees = $sqlite->path("database/ottivo.sqlite")->createTable('employees', [
    'name' => 'VARCHAR (255) NOT NULL',
    'date_of_birth' => 'VARCHAR (255) NOT NULL',
    'contract_start_date' => 'VARCHAR (255) NOT NULL',
    'special_contract' => 'VARCHAR (255) NULL',
    'special_contract_vacation_days' => 'INT  NULL',
]);

$sqlite->path("database/ottivo.sqlite")->table('employees')->insert([
    [
        'name' => 'ali',
        'date_of_birth' => '23',
        'contract_start_date' => '55',
        'special_contract' => 'golden',
        'special_contract_vacation_days' => 40,
    ],
]);

$data = $inputSource->path("database/ottivo.sqlite")->table('employees')->fetch();
```





