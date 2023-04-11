## Requirements
-> PHP 8.1.0 or higher
-> symfony 6 or higher

## Setup :-

## create composer file 
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"


## install cli for symfony
curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | sudo -E bash
sudo apt install symfony-cli

## package for send mails
composer require symfony/mailer
we have to generate app key from gmail

## In .env
MAILER_DSN=smtp://yourgmail:appkey@smtp.gmail.com:25


## create project
symfony new --webapp 'project_name'

## create databse :-
php bin/console doctrine:database:create

## migration command :- 
php bin/console make:migration

## migrate command :-
php bin/console doctrine:migrations:migrate

## run symfony application
symfony serve:start

## get fruites console command :- 
symfony console get-fruits

## All Routes:-

## for Fruits list
fruits

## for favourtite Fruits List
favourite

## for filter fruits by name and family
listing

## command for insert data from api to local database
symfony console get-fruits

