

# Book Management System API's

## Introduction

The Book Management System is a Laravel-based application designed to manage authors, books, publishers, and users. This system provides functionality to create, read, update, and delete records for each entity, along with user authentication and management features.

## Features

- Manage Authors: Add, view, edit, and delete author information.
- Manage Books: Add, view, edit, and delete book details.
- Manage Publishers: Add, view, edit, and delete publisher data.
- User Management: Register, login, and manage user profiles.
- Data Factories: Generate fake data for testing and development purposes.

## Technologies Used

- Laravel 10
- PHP 8.1
- MySQL
- Composer
- NPM
- Faker Library

## Installation

### Prerequisites

- PHP 8.1 or higher
- Composer
- MySQL
- NPM

### Steps 

#### 1. Clone the repository

```bash
git clone https://github.com/saaifiqbal/book-management-system.git
cd book-management-system
```

#### 2. Install dependencies

```bash
composer install
npm install
npm run dev
```

#### 3. Setup environment variables
Copy the .env.example file to .env and update the necessary configurations (database credentials, etc.).

```bash
cp .env.example .env
```

#### 4. Generate application key
```bash
php artisan key:generate
```

#### 5. Run migrations and seeders
```bash
php artisan migrate --seed
```

#### 6. Run Extra seeders
##### You Can Add Seed More for Author, Books, Publisher

##### Author
```bash
php artisan db:seed --class=AuthorTableSeeder
```
##### Book
```bash
php artisan db:seed --class=BookTableSeeder
```
##### Publisher
```bash
php artisan db:seed --class=PublishersTableSeeder
```

#### 7. Start the development server
```bash
php artisan serve
```
Access the application at http://127.0.0.1:8000/api.

## Usage 

### Authentication
1. Login with an existing user.
2. Use the provided dashboard to manage authors, books, and publishers.
### Managing Authors
1. Navigate to the Authors section from the dashboard.
2. Add, edit, view, or delete authors as needed.

### Managing Books
1. Navigate to the Books section from the dashboard.
2. Add, edit, view, or delete books as needed.
### Managing Publishers
1. Navigate to the Publishers section from the dashboard.
2. Add, edit, view, or delete publishers as needed.

## API Endpoints
### Authentication Routes
- POST /auth/login: Log in a user.
- POST /auth/logout: Log out the current user.
- POST /auth/refresh: Refresh the authentication token.

### Author Routes
- GET /author: List all authors.
- POST /author: Create a new author.
- GET /author/{id}: View a specific author.
- PUT /author/{id}: Update a specific author.
- DELETE /author/{id}: Delete a specific author.

### Book Routes
- GET /book: List all books.
- POST /book: Create a new book.
- GET /book/{id}: View a specific book.
- PUT /book/{id}: Update a specific book.
- DELETE /book/{id}: Delete a specific book.

### Publisher Routes
- GET /publisher: List all publishers.
- POST /publisher: Create a new publisher.
- GET /publisher/{id}: View a specific publisher.
- PUT /publisher/{id}: Update a specific publisher.
- DELETE /publisher/{id}: Delete a specific publisher.

## Testing
Use the following command to run the tests:
    php artisan test
```bash
php artisan test
```

### Directory Structure
- app/Models: Contains the Eloquent models.
- database/factories: Contains the factory classes for generating fake data.
- database/seeders: Contains the seeder classes for populating the database.
- routes: Contains all the route definitions.
- resources/views: Contains the Blade templates for the frontend.

### Factories
The system uses factories to generate fake data for testing and development purposes. Below are the available factories:

- AuthorFactory: Generates fake authors.
- BookFactory: Generates fake books.
- PublisherFactory: Generates fake publishers.
- UserFactory: Generates fake users.

## Contributing
Contributions are welcome! Please fork this repository and submit pull requests. For major changes, please open an issue first to discuss what you would like to change.

## License
This project is open-source and available under the MIT License.

For any questions or issues, please open an issue on GitHub or contact the maintainer at [saaifiqbal@gmail.com].