<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p> <p align="center"> <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a> </p>
About Laravel
Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

Simple, fast routing engine.
Powerful dependency injection container.
Multiple back-ends for session and cache storage.
Expressive, intuitive database ORM.
Database agnostic schema migrations.
Robust background job processing.
Real-time event broadcasting.
Laravel is accessible, powerful, and provides tools required for large, robust applications.

Booking & Provider Search API
This project extends Laravel to provide an API for managing bookings and searching for providers based on location.

Key Features
Implementing user registration, login, and password recovery using Laravel's built-in authentication features.
Bookings Management: Users can create, update, delete, and view bookings.
Service Management: Users can create and list services available for booking.
Provider Search: Search for service providers within a specified range (25 km) using geographical data (latitude/longitude).
Table of Contents
Installation
API Endpoints
Bookings
Services
Providers
Usage
Create a Booking
Search for Providers
Validation
PhpUnit Test
Postman Requests
Installation
To set up the Booking & Provider Search API:

Clone the repository:

bash
Copy code
git clone https://github.com/mubeen54/booking_system.git
Install dependencies:

composer install
Configure your .env file:

bash
Copy code
cp .env.example .env
Update your database configuration in the .env file:

bash
Copy code
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
Run migrations:

bash
Copy code
php artisan migrate
Start the server:

bash
Copy code
php artisan serve
API Endpoints
Bookings Endpoints
Method Endpoint Description Parameters
GET /api/bookings Get all bookings -
POST /api/bookings Create a new booking service_id, booking_date, title
GET /api/bookings/{id} Get a booking by ID -
PUT /api/bookings/{id} Update a booking service_id, booking_date, title, status
DELETE /api/bookings/{id} Delete a booking -
Services Endpoints
Method Endpoint Description Parameters
GET /api/services Get all services -
POST /api/services Create a new service name, description, price
Providers Endpoints
Method Endpoint Description Parameters
GET /api/providers Get all providers -
POST /api/providers Create a new provider name, latitude, longitude
POST /api/providers/search Search for providers within range latitude, longitude
Usage
Create Booking
To create a new booking:

Endpoint: POST /api/bookings

Request Body:

json
Copy code
{
"service_id": 1,
"booking_date": "2024-09-01",
"title": "Booking for Service A"
}
Response:

json
Copy code
{
"id": 1,
"user_id": 1,
"service_id": 1,
"booking_date": "2024-09-01",
"title": "Booking for Service A",
"status": "pending",
"created_at": "2024-09-01T12:34:56.000000Z",
"updated_at": "2024-09-01T12:34:56.000000Z"
}
Search for Providers
To search for providers within a 25 km range:

Endpoint: POST /api/providers/search

Request Body:

json
Copy code
{
"latitude": 34.0522,
"longitude": -118.2437
}
Response (if providers found):

json
Copy code
[
{
"id": 1,
"name": "Provider A",
"latitude": "34.0522",
"longitude": "-118.2437",
"distance": 10.5
},
{
"id": 2,
"name": "Provider B",
"latitude": "34.1403",
"longitude": "-118.3949",
"distance": 22.1
}
]
Response (if no providers found):

json
Copy code
{
"message": "No providers found within 25 km."
}
Validation
The API includes robust validation for user inputs. Here are some key validation rules:

Provider Search
latitude: Required, must be a valid float.
longitude: Required, must be a valid float.
Create Booking
service_id: Required, must exist in the services table.
booking_date: Required, must be a valid date.
title: Required, must be a string (max length 255 characters).
Postman Example Requests
Create a Provider
Endpoint: POST /api/providers
Request Body:
json
Copy code
{
"name": "Provider A",
"latitude": 34.0522,
"longitude": -118.2437
}
Response:
json
Copy code
{
"id": 1,
"name": "Provider A",
"latitude": "34.0522000",
"longitude": "-118.2437000",
"created_at": "2024-09-01T12:34:56.000000Z",
"updated_at": "2024-09-01T12:34:56.000000Z"
}
Contributing
Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the Laravel documentation.

License
The Laravel framework and this project are open-sourced software licensed under the MIT license.

This README now includes Laravel framework details along with the custom API documentation for your booking and provider search system.
