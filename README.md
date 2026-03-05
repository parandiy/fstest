# Project Description

This project allows users to upload PDF and DOCX files, view them, delete them, and receive deletion notifications via RabbitMQ. Files are automatically deleted after 24 hours.

## Features

File Upload

Supports PDF and DOCX files.

Asynchronous upload via AJAX.

File size limit: 10MB.

File Management (CRUD)

View a list of uploaded files.

Manual deletion of files.

Automatic deletion after 24 hours.

Deletion Notifications

Sends messages to RabbitMQ when files are deleted manually or automatically.

## Technical Details

Laravel 11 + PHP 8

MySQL for storing file metadata

RabbitMQ for sending messages

Bootstrap + jQuery for frontend

## Installation and Setup

Clone the repository:

```
git clone <repository-url>
cd <project-folder>
```

Install dependencies:

```
composer install
```

Create .env and configure database and RabbitMQ:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=files_db
DB_USERNAME=root
DB_PASSWORD=root
```

```
QUEUE_CONNECTION=rabbitmq
RABBITMQ_HOST=127.0.0.1
RABBITMQ_PORT=5672
RABBITMQ_USER=guest
RABBITMQ_PASSWORD=guest
RABBITMQ_QUEUE=file-events
```

Generate application key and run migrations:

```
php artisan key:generate
php artisan migrate
```

Start the Laravel development server:

```
php artisan serve
```

Access the application at http://127.0.0.1:8000.

## Usage

Open the / page.

Upload files via the interface.

View the list of files and delete as needed.

Deletion notifications are sent to RabbitMQ (SMTP not required).

## Project Structure

app/Models/StoredFile.php — File model

app/Http/Controllers/FileController.php — CRUD controller

app/Http/Controllers/FileUploadController.php — Asynchronous upload controller

app/Services/FileDeletionService.php — Service for file deletion

resources/views/files — Blade templates

## Technical Notes

Files are stored in storage/app/files

AJAX upload displays progress and handles server errors

RabbitMQ is used for deletion notifications

Automatic file deletion is implemented via Laravel Scheduler

## Notes

The project can run without Docker.

RabbitMQ must be accessible locally or in the network.

Frontend uses Bootstrap + jQuery for a simple and clear UI.
