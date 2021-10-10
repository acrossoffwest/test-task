# Test Task

## Task description

Create a PHP script that completes the following:

1. Takes input as POST for the following variables:
   sendername, senderemail, eventtime, eventname, eventdescription, guestname, guestemail
2. Holds the AWS endpoint details as variables defined at the top
3. Generates a correctly formatted ICS file (use eg Gmail to test if they display a calendar invitation, or just an attachemnt) to attach to an e-mail with defined eventtime, sendername, senderemail, eventname, eventdescription
4. Sends the ICS as an attachment to an e-mail through AWS SES to guestname/guestemail.

You can use existing repositories, libraries etc, but the script itself should be vanilla PHP.

## Usage
Configure app and nginx

Create `default.conf` for `nginx` in `./docker/nginx.d/` directory

Create `.env` in `root` directory

You'll find .example files for configuration files.


## Run

Install dependencies:

    docker run -v $(pwd):/var/www/html  acrossoffwest/domda-php-fpm:8.0.8.1 composer install

For running application with Docker you could run command below from `root` directory:

    docker run -p 8080:8080 -v $(pwd):/var/www/html -v $(pwd)/docker/nginx.d/default.conf:/etc/nginx/conf.d/default.conf -v $(pwd)/docker/supervisor:/etc/supervisor acrossoffwest/domda-php-fpm:8.0.8.1

## Test

    docker run -v $(pwd):/var/www/html  acrossoffwest/domda-php-fpm:8.0.8.1 ./vendor/bin/phpunit

## Methods

### POST / HTTP/1.0
    
Request headers:
    
    Content-Type: application/json
    
Request body:

    {
        "sendername": "Sender Name",
        "senderemail": "m@aow.space",
        "eventtime": "20211010T012349Z",
        "eventname": "Event from Postman",
        "eventdescription": "Description of event from Postman",
        "guestname": "Guest Name",
        "guestemail": "m@aow.space"
    }
