# Example project with Laravel 5.4 - PHP 7 and MySql

This project is a web project that uses Laravel 5.4 as a web framework. Its contains a example how to upload a Json File and process this file into Mysql Database and export the data to Excel table. 

This web project has 4 pages:
- Home Page: brief introduction about the project and explanation about the project structure
- Upload Files - Form page that allows to upload files to the server
- Process Files - Page with list table of uploaded files and with an option to select which file will process
- Processing File - Page with a list of files that are processing
- Processed Files - Page with a list of processed file with an option to export the data as Excel / PDF table.

## Requirements

Here the requirements to start the project

- Docker Compose - Docker version 18.06.0-ce, build 0ffa825

## How to start

- git clone the project 
- Edit the file docker-compose.yml inside the docker folder
 -- Configure the Volume: 
 --- inside the web container edit the <project-folder> with the current project example: /local/opt/project/widgtes
 --- inside the db container edit the <mysql-folder> with the path to a folder to save the mysql data files: /local/opt/project/mysql

## Run the project

First start the containers - enter the docker folder and type: docker-compose up

## Configure the Laravel project

Into the widget folder type: 
- docker exec -it web_php_widgets php artisan migrate (To create the tables)
- docker exec -it web_php_widgets sh -c "printf \"upload_max_filesize=100M\npost_max_size = 100M\" > /usr/local/etc/php/php.ini"
(now it needs to stop the cotainer and start again to read the new php configuration - docker-compose stop then docker-compose up )
- docker exec -it web_php_widgets php artisan queue:work --daemon (to start the queue service to process the files)

## Steps inside the project
- Acess the http://localhost:8081
- Link to the Upload Form: <a href="http://localhost:8081/upload"> click here</a>
- Link to list of uploaded Files: <a href="http://localhost:8081/json"> click here</a>
- Link to list of processing Files table: <a href="http://localhost:8081/json/processing"> click here
- Link to list of processed Files table: <a href="http://localhost:8081/json/processed"> click here</a>
