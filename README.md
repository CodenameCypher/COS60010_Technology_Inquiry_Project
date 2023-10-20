# Bright Boost - Online Learning Platform
## COS60010 - Technology Inquiry Problem

Bright Boost is a web-based platform designed to facilitate seamless communication and collaboration between teachers and students. This README provides an overview of the project, its features, and how to set it up.

## Table of Contents

- [Features](#features)
- [Technologies Used](#technologies-used)
- [Getting Started](#getting-started)
- [Project Structure](#project-structure)
- [Usage](#usage)
- [Contributing](#contributing)

## Features

Bright Boost offers several features to cater to different types of users:

### Admin

- Log in securely as an admin.
- Create, edit, update, or delete sessions and users.
- View statistics per session, including two pie graphs for student attendance and questions asked and answered.

### Teachers

- Log in or register for an account.
- Enroll or unenroll from sessions.
- Join sessions during their scheduled period.
- View and answer questions asked by students in the session.

### Students

- Log in or register for an account.
- Enroll in sessions.
- Join sessions during their scheduled period.
- View questions asked by other students and post new questions in the session.

## Technologies Used

- Backend Framework: Laravel (PHP)
- Frontend: HTML, CSS, Bootstrap
- Database: MySQL

## Getting Started

To get started with Bright Boost on your local machine, follow these steps:

1. **Clone the Repository**:
   ```bash
    git clone https://github.com/your-username/bright-boost.git
    ```
    
2. **Setup Environment Variables**:
   Create a `.env` file by copying the `.env.example` file. Update the database configuration and any other environment variables as needed.
   ```bash
   git clone https://github.com/your-username/bright-boost.git
   ```
    
3. **Install Dependencies**:
   Install the project dependencies using Composer (PHP package manager) and NPM (Node Package Manager for frontend assets).
   ```bash
   composer install
   npm install
   ```
   
4. **Generate Application Key**:
   Generate the application key for your Laravel application.
   ```bash
   php artisan key:generate
   ```

5. **Run Database Migrations**:
   Migrate the database structure and seed it with sample data.
   ```bash
   php artisan migrate --seed
   ```

6. **Start the Development Server**:
   Start the Laravel development server.

   ```bash
   php artisan serve
   ```

7. **Access the Application**:

## Project Structure

The project directory structure is organized as follows:

- `app`: Contains the Laravel application code, including controllers, models, and routes.
- `bootstrap`: Bootstrap and initialization files for the application.
- `config`: Configuration files for the application.
- `database`: Database migrations and seeders.
- `public`: Public assets such as CSS, JavaScript, and images.
- `resources`: Views and frontend assets.
- `routes`: Route definitions for the application.
- `storage`: Temporary files, logs, and framework storage.
- `tests`: Test files for the application.
- `vendor`: Composer dependencies.
- `node_modules`: NPM dependencies.
- `.env`: Environment configuration file.

## Usage

To use Bright Boost, follow these steps:

### Admin

- Log in as an admin using the provided credentials.
- Create, view, modify or delete sessions and modify users as needed.
- View session statistics to monitor student attendance and questions.

### Teachers

- Register or log in as a teacher.
- Enroll in sessions.
- Join sessions during their scheduled time.
- Answer questions asked by students.

### Students

- Register or log in as a student.
- Enroll in sessions.
- Join sessions during their scheduled time.
- View questions asked by other students and post new questions.

## Contributors

1. Aditya Roy.
2. Nabeel Ahmed.
3. Fahim Shahrear.


