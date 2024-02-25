# Stock Management System

This is a simple stock management system built with the Laravel. It allows you to manage products and lot wise stock.

It also contains notifications for low stock and expiry of products.

## Demo

The project is hosted on personal hosting and can be accessed at the following URL:

https://laravel-practical.smtbos.com

## Prerequisites

-   PHP 8.0 or higher
-   Composer
-   MySQL/PostgreSQL database

## Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/smtbos/laravel-practical.git
    ```

2. Navigate to the project directory:

    ```bash
    cd laravel-practical
    ```

3. Install the dependencies:

    ```bash
    composer install
    ```

4. Copy the `.env.example` file to `.env`:

    ```bash
    cp .env.example .env
    ```

    Make sure to update the values in the `.env` file with your own values.

    Most importantly

    ```bash
    PRODUCT_NOTIFICATON_EXPIRY=true
    PRODUCT_NOTIFICATON_EXPIRY_DAYS=10
    PRODUCT_NOTIFICATON_LESS_STOCK=true
    PRODUCT_NOTIFICATON_LESS_STOCK_QUANTITY=20

    # Eg. true - In each mail it contains products that are going to expire in next 10 days
    # Eg. false - In each mail it contains products that are going to expire after 10 days
    PRODUCT_NOTIFICATON_SEND_EXPIRY_FOR_NOTIFIED_LOTS=true
    ```

5. Generate the application key:

    ```bash
    php artisan key:generate
    ```

6. Migrate the database:

    ```bash
    php artisan migrate
    ```

7. Seed the database(optional)

    ```bash
    php artisan db:seed
    ```

## Starting the server

To start the server, run the following command:

```bash
php artisan serve
```

## Starting the sheduler

To start the scheduler, run the following command:

```bash
php artisan schedule:work
```

## Starting the queue worker

To start the queue worker, run the following command:

```bash
php artisan queue:work
```

## To execute sheduler check(if you want to run the scheduler manually)

Open following URL in browser

http://localhost:8000/schedule-check
