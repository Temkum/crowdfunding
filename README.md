# Crowdfunding Application

This project is a Crowdfunding Platform built using Laravel with Sanctum for authentication, Tailwind CSS for styling frontend components. The application allows users to create donation requests and contribute to existing donations.

## Features

- User Authentication: Users can register, log in, and manage their profiles.
- Donation Requests: Users can create donation requests specifying target amounts.
- Donations: Users can contribute to active donation requests.
- CRUD Operations: Users can view, edit, and delete donation requests.
- API Endpoints: The application provides a RESTful API for managing donations and contributions.
- Docker Integration: The app is containerized using Docker, making deployment and environment setup easier.

### Installation

1. Clone the repository

```bash
git clone https://github.com/your-username/crowdfunding.git
cd crowdfunding
```

2. Set Up Environment Variables
Copy the .env.example file to .env and configure the necessary environment variables (e.g., database connection, Sanctum configuration).

```bash
cp .env.example .env
```

Set up your database information in the .env file:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=crowdfunding
DB_USERNAME=yourusername
DB_PASSWORD=yourpassword
```

3. Install Dependencies
Install the PHP and JavaScript dependencies using Composer and npm.

```bash
composer install
npm install
```

4. Run Migrations

Run the migrations to set up your database tables:

```bash
php artisan migrate
```

5. Documentation

Read api documentation

6. Compile Frontend Assets
To build the components and Tailwind CSS, run:

```bash
npm run dev
```

For production, you can use:

```bash
npm run build
```

7. Start Docker
Ensure that Docker and Docker Compose are installed on your machine.

```bash
docker-compose up -d
```

This will run your application in a containerized environment.

8. Serve the Application
You can now serve the application using:

```bash
php artisan serve
```

By default, this will run the application on `http://localhost:8000`.

### API Endpoints

Here are some of the core API routes:

Authentication

- Login: `POST /login`

Register: `POST /register`

Donation Requests

- Create a Donation Request: `POST /donations`

- View All Donations: `GET /donations`

- View a Single Donation Request: `GET /donations/{id}`

- Update a Donation Request: `PATCH /donations/{id}`

- Delete a Donation Request: `DELETE /donations/{id}`

Contributions

- Contribute to a Donation: `POST /donations/{id}/contribute`

For detailed API documentation, check the api-doc.md file in the project.

> Testing API with Postman
You can use Postman to test your API:

Set the Authorization type to Bearer Token in the Authorization tab.
Use the endpoints provided above to interact with the API.

Don’t forget to include necessary data in the Body section when making POST requests.
Deployment

This project is Dockerized, making it easy to deploy on any cloud provider that supports Docker.

Build the Docker image:

```bash
docker-compose build
```

Push the Docker image to a container registry or deploy using your cloud provider’s Docker service.