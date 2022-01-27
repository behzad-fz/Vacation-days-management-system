# Ottonova

- [Services](#services) What Dev offers
- [Extra Apps](#extra-apps) What will be shipped with this image
- [PHP Modules](#php-modules) What PHP modules get installed
- [Privileges](#privileges) What privileges you have in the containers
- [Requirements](#requirements) What are the requirements to use this dockerized playground
- [Installation](#installation) How to create and start
- [Shell Access](#shell-access) How to access inside containers
- [Usage](#usage) instructions to use application
- [Run Tests](#run-tests) How to run tests (PHPUnit)
- [Assumptions](#Assumptions) Assumptions
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

### Installation
```
make build
```

### Shell Access
To access the php container as a root user:
```
make shell
```
### Usage
You get vacation days report following command:
Notice : Commands should be executed inside php container
```
make shell
php index.php 2xxx (get report on terminal)
    Ex : php index.php 2020
php index.php 2xxx --format-json=path/to/file.json (get report in json file)
    Ex : php index.php 2020 --format-json=reports/vacations.json
php index.php 2xxx --format-json=txt/to/file.txt (get report in text file)
    Ex : php index.php 2020 --format-txt=reports/vacations.txt
```

### Run Tests
You can run tests by entering the following command:
Notice : Commands should be executed inside php container
```
make shell
make test (./vendor/bin/phpunit also works)
```


### Assumptions
These are the things it wasn't clear, so I had to assume
```
1 - The requirements states the command only gets the year as input and knowing the months are crucial to be able to calculate, 
    so in every calculation i assume you mean by the end of that year.
    Ex: input year = 2020
        How many vacation days employee has untill 2020.12.31
        How many years is employee working by 2020.12.31
        Is employee going to be >= 30 years old by 2020
        ... 
 
2 - I didn't round down vacation days float number becasue in my current company we have such thing and they convert the floating
    point to hours of vacation.
    Ex: vacation days = 20,33
        means employee has 20 days and 3 hours or something


3- I assume by 5 years you mean 5 full years so i won't take the year to calculation in the employment 
    years even if it is just one day short!
    Ex: if an employee is working for 1 year and 3 month, the years of employment will be 1

4 -  i assume if the employee is borned in 31.12.2020 s/he is not considered 1 year old in 31.12.2021.
    I consider them 1 year old in 01.01.2022

5 - About the data validation, there are a lot of thing i could have done for validation but i keep it simple
    due to lack of time.

6 - The document required to avoid using a database and i used json file as data source. But I also added 
    sqlite to show it's easily expandable. ps, the functionality in sqlite class is missing a lot of options
    like query, delete, update , etc. I just avoided them due to lack of time
 
7 - in Consloe i don't generate the table columns dynamically because i didn't want to spend much time 
    in arranging the appearance on console rather than spending the time on application logic and arcitecture
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





