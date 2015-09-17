## Requirements

 - PHP 5.6 with Symfony2 requirements

## Installation

Install all vendors via composer
`composer install`

Install assets
`php app/console assets:install --symlink`

## Usage
Run build-in web server:
`php app/console server:start`

Go to http://127.0.0.1:8000/ 

## Running tests
To run all tests:
`phpunit -c app/phpunit.xml.dist`

To run only unit tests:
`phpunit -c app/phpunit.xml.dist --group=unit`

To run only integration & performance tests:
`phpunit -c app/phpunit.xml.dist --group=integration`

To run only functional tests for controllers:
`phpunit -c app/phpunit.xml.dist --group=functional`
