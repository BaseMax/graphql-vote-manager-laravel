# Secure Online Voting System using GraphQL Laravel

This project is a secure online voting system built using Laravel 10 and PHP 8.2, with the added feature of caching using Redis. The system allows users to create and participate in polls and surveys through a GraphQL API. This README provides an overview of the project, setup instructions, and usage guidelines.

A comprehensive GraphQL-powered voting system developed with Laravel 10 and PHP 8.2. Manage polls, surveys, and user votes securely, utilizing Redis caching for optimized responsiveness.

## Introduction

The Secure Online Voting System is a web application that leverages GraphQL to provide a flexible and efficient API for creating, managing, and participating in polls and surveys. The system is built on top of Laravel 10 and PHP 8.2, ensuring a robust and modern backend architecture.

## Features

- User authentication and authorization
- Create, read, update, and delete polls/surveys
- Vote on poll options
- Real-time updates using GraphQL subscriptions
- Caching with Redis for improved performance
- Comprehensive API documentation

## Prerequisites

Before you begin, ensure you have the following installed on your system:

- PHP 8.2
- Composer
- Laravel 10
- Redis
- Git

## Installation

Clone the repository:

```bash
git clone https://github.com/basemax/graphql-vote-manager-laravel.git
```

Navigate to the project directory:

```bash
cd graphql-vote-manager-laravel
```

Install project dependencies:

```bash
composer install
```

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Generate an application key:

```bash
php artisan key:generate
```

Set up your database configuration in the `.env` file.

Run database migrations:

```bash
php artisan migrate
```

Start the Laravel development server:

```bash
php artisan serve
```

Access the application in your browser at `http://localhost:8000`.

## Configuration

You can configure various settings in the .env file, including database connections, caching, and GraphQL related configurations.

## Usage

Once the application is up and running, you can interact with the GraphQL API using tools like Insomnia or Postman. Refer to the API documentation for details on the available queries, mutations, and subscriptions.

## API Documentation

For detailed information about the available API operations, refer to the API documentation.

## Security

Security is a top priority in this project. User authentication and authorization mechanisms are implemented to ensure that only authorized users can perform certain actions.

## Contributing

Contributions to the project are welcome. If you find any bugs, security vulnerabilities, or have suggestions for improvements, please open an issue or submit a pull request.

## License

This project is open-source and available under the GPL-3.0 License. Feel free to use, modify, and distribute it as per the terms of the license.

Copyright 2023, Max Base
