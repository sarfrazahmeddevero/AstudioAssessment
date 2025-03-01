Laravel Project
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p> <p align="center"> <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a> </p>
About This Project
This project demonstrates how to build an application in Laravel 11 with advanced features such as API authentication (using Laravel Passport) and dynamic entity-attribute-value (EAV) functionality for projects. It supports RESTful API endpoints, flexible filtering, and CRUD operations.

Features
Authentication using Laravel Passport
Dynamic attribute system using EAV (Entity-Attribute-Value)
Flexible filtering system for Projects based on standard and dynamic attributes
CRUD API Endpoints for managing Projects, Attributes, and their values
Setup Instructions
Follow these steps to set up the project on your local machine.

Step 1: Install Dependencies
Clone the repository and install the required dependencies using Composer.

bash
Copy
git clone https://github.com/your-repository/your-project.git
cd your-project
composer install
Step 2: Set Up Environment Variables
Copy the .env.example file to .env and update the database and other necessary configurations.

bash
Copy
cp .env.example .env
Step 3: Generate Application Key
Run the following command to generate the application key.

bash
Copy
php artisan key:generate
Step 4: Run Migrations
Run the database migrations to create the necessary tables.

bash
Copy
php artisan migrate
Step 5: Install Passport
Since the project uses Laravel Passport for API authentication, you need to install Passport and set it up.

bash
Copy
php artisan passport:install
This command will generate encryption keys for Passport and create necessary tables for OAuth.

Step 6: Seed the Database
You can optionally seed the database with test data using:

bash
Copy
php artisan db:seed
API Endpoints
Part 1: Authentication (Laravel Passport)
POST /api/register: Register a new user.
POST /api/login: Login a user and receive an authentication token.
POST /api/logout: Logout a user (invalidate the token).
Part 2: CRUD Operations for Projects, Attributes, and Attribute Values
1. Projects
GET /api/projects: Fetch all projects (supports filtering).
GET /api/projects/{id}: Fetch a specific project by its ID.
POST /api/projects: Create a new project with dynamic attributes.
PUT /api/projects/{id}: Update an existing project and its dynamic attributes.
DELETE /api/projects/{id}: Delete a project.
2. Attributes
GET /api/attributes: Fetch all available attributes.
GET /api/attributes/{id}: Fetch a specific attribute by its ID.
POST /api/attributes: Create a new attribute.
PUT /api/attributes/{id}: Update an existing attribute.
DELETE /api/attributes/{id}: Delete an attribute.
3. Attribute Values
GET /api/attribute-values: Fetch all attribute values (filtered by project).
GET /api/attribute-values/{id}: Fetch a specific attribute value.
POST /api/attribute-values: Create a new attribute value for a project.
PUT /api/attribute-values/{id}: Update an existing attribute value.
DELETE /api/attribute-values/{id}: Delete an attribute value.
Part 1: Authentication Setup
1. Install Passport
We use Laravel Passport for API authentication. First, ensure you’ve installed Passport and run the necessary commands:

bash
Copy
php artisan passport:install
Then, make sure to add the HasApiTokens trait to your User model to enable API authentication:

php
Copy
use Laravel\Passport\HasApiTokens;
Finally, register the Passport routes in AuthServiceProvider.php:

php
Copy
use Laravel\Passport\Passport;

public function boot()
{
    Passport::routes();
}
2. API Routes Configuration
All the API routes are defined in routes/api.php. Make sure that the following are added:

php
Copy
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Part 2: EAV (Entity-Attribute-Value) Implementation
In this part, we implement a dynamic system where projects can have custom attributes using an EAV model.

1. Create Models
We created three models:

Project (holds basic project details).
Attribute (holds information about available attributes).
AttributeValue (links Project to dynamic attributes).
The AttributeValue model allows projects to have dynamic attributes like department, start_date, end_date, etc.

2. Database Structure
projects: Stores basic project details.
attributes: Stores available attribute names (e.g., department, status).
attribute_values: Links projects to their dynamic attributes and values.
3. ProjectController:
The controller for managing projects also handles the creation and updating of attribute values. Make sure the controller supports both static and dynamic attributes.

Part 3: CRUD API Endpoints
1. Controller Setup
We’ve implemented CRUD operations for projects, attributes, and attribute values. This is managed by the ProjectController and AttributeController.

2. Routes
All routes for handling CRUD operations are set up in the routes/api.php file. Make sure each model has routes for index, show, store, update, and delete.

For example, here is how the ProjectController might look:

php
Copy
Route::middleware('auth:api')->group(function () {
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('attributes', AttributeController::class);
    Route::apiResource('attribute-values', AttributeValueController::class);
});
Part 4: Filtering System
1. Filtering Projects
In the ProjectController, we’ve implemented a flexible filtering system that supports both regular attributes (name, status) and EAV attributes (department, start_date, end_date). The API allows you to filter projects based on these fields and use operators like LIKE, =, >, and <.

2. Example Request for Filtering
You can filter projects using the filters query parameter.

bash
Copy
GET /api/projects?filters[name]=ProjectA&filters[department]=IT&filters_operators[department]=LIKE
This example will filter projects where the name is "ProjectA" and the department contains "IT".

3. Test Credentials
For testing purposes, you can use the following test credentials:

Email: test@example.com
Password: password
Token: (Obtain it via login)
Use this token in the Authorization header for all authenticated API requests.