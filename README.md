# Car Management System

This project is a simple car management system built with Vue.js and Laravel. It allows users to create, edit, delete, and categorize cars.

## Installation

### Prerequisites

- PHP (>=7.4)
- Composer
- Node.js (>=14)
- npm or yarn
- MySQL or any other database of your choice

### Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/your-username/car-management-system.git


2. **Navigate to project folder**

   ```bash
   cd car-purchase-app

3. **Install laravel dependencies**

   ```bash
   composer install

4. **Create a copy of the .env.example file and rename it to .env:**

   ```bash
   cp .env.example .env

   
5. **Generate application key**

   ```bash
   php artisan key:generate


6. **Configure your database in the .env file:**

    DB_CONNECTION=mysql
    DB_HOST=your-database-host
    DB_PORT=your-database-port
    DB_DATABASE=your-database-name
    DB_USERNAME=your-database-username
    DB_PASSWORD=your-database-password


6. **Generate application key**

   php artisan migrate --seed

   php artisan db:seed --class=CarTableSeeder

   
7. **Install Node.js dependecies**

   npm install


8. **Build vue js assets**

   npm run dev

      
10. **Run laravel**

   php artisan serve

# Usage

## Open your browser and go to http://localhost:8000 to access the Laravel application.

### Register or log in to start managing cars. 
     Admin credentials: username: admin email: admin@example.com password: password.



   
     
