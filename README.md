# Backend Service

This is the backend service for the project, built with Laravel. The application is containerized using Docker and can be run using docker-compose.

## Prerequisites

- Docker installed on your system

## Setup

### 1. Clone the Repository

git clone <your-repo-url>  
cd backend

### 2. Create an .env File

Copy the example environment file and update it as needed:

cp .env.example .env

Add the following environment variables with your API keys:

```
NYTIMES_API_KEY=
THE_GUARDIAN_API_KEY=
NEWSAPI_ORG_API_KEY=
```

Modify the following environment variables if necessary:

```
APP_PORT=8000  # Change as needed  
FRONTEND_URL=http://localhost:3000  # Change if frontend URL is different  
SANCTUM_STATEFUL_DOMAINS=localhost  # Change if frontend URL is different
```

### 3. Generate Application Key

Run the following command to generate an application key:

`
php artisan key:generate
`

### 4. Build and Run the Application

`docker-compose up -d`

The API should now be running on http://localhost:8000.

### 5. Run Migrations

Run the following command to migrate the database:

`docker compose exec -it laravel.test php artisan migrate`
