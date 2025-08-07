# Laravel Multi-Tenant Project

This is a multi-tenant Laravel 12 application built with API endpoints only. It supports managing multiple teams, assigning roles, inviting users, and managing tasks. Docker is used for easy environment setup.

## 🚀 Features

- Multi-tenant architecture (teams)
- User invitation via email (stubbed)
- Modular code structure using `Actions` and `Services`
- Dockerized for consistent local development
- Stripe integration (optional)
- Soft deletes and recovery
- API token authentication

---

## 🛠 Prerequisites

Ensure you have the following installed:

- Docker: https://docs.docker.com/get-docker/
- Docker Compose
- Git

---

## ⚙️ Setting Up the Project

### 1. Clone the Repository

```bash
git clone https://github.com/shahroz-tech/Multi_Tenant_Backend.git
cd your-repo
```

### 2. Copy the Example Environment File

```bash
cp .env.example .env
```

Update any necessary environment variables such as database name, user, password, mail settings, etc.

---

## 🐳 Using Docker

### 1. Build and Start Containers

```bash
docker-compose up -d --build
```

> This will set up the Laravel app, Nginx, PHP, and MySQL containers.

### 2. Install Composer Dependencies

```bash
docker exec -it laravel-app composer install
```

### 3. Generate Application Key

```bash
docker exec -it laravel-app php artisan key:generate
```

### 4. Run Migrations

```bash
docker exec -it laravel-app php artisan migrate
```

### 5. (Optional) Seed the Database

```bash
docker exec -it laravel-app php artisan db:seed
```

---

## 📂 File Structure

```
.
├── app/
├── routes/
│   ├── api.php
├── docker/
│   ├── php.ini
├── Dockerfile
├── docker-compose.yml
├── .env
├── README.md
```

---

## 🔐 Authentication

The API uses token-based authentication via Laravel Sanctum or Passport.

### Example Login Request

```http
POST /api/v1/auth/login

{
  "email": "user@example.com",
  "password": "secret"
}
```

Response:
```json
{
  "message": "Login successful.",
  "user": {
    "deleted_at": null,
    "id": 68,
    "name": "Shahroz",
    "email": "user@example.com",
    "email_verified_at": null,
    "created_at": "2025-08-06T05:45:04.000000Z",
    "updated_at": "2025-08-06T05:45:04.000000Z",
    "stripe_id": null,
    "pm_type": null,
    "pm_last_four": null,
    "trial_ends_at": null
  },
  "token": "9|j7XihUoscBSCzFgeXcONqNxMmCk7a8DW5gJ08J2F95dd4d0a"
}
```

Use this token in the Authorization header for subsequent API requests:

```
Authorization: Bearer YOUR_TOKEN_HERE
```

---

## 📬 Email Invites

Email invites are stubbed. To send actual invites:

- Configure mail credentials in `.env`
- Enable logic in `InviteUserToTeamAction.php`

---

## 🔄 Useful Commands

### Run Tests

```bash
docker exec -it laravel-app php artisan test
```


### Artisan Command

```bash
docker exec -it laravel-app php artisan <command>
```


## ❌ Stopping the Containers

```bash
docker-compose down
```

Add `-v` to remove volumes:

```bash
docker-compose down -v
```

---

## ✅ Tips

- Use `docker-compose logs -f` to monitor logs.
- If you face permission issues, run `sudo chmod -R 777 storage bootstrap/cache`.

---

## 📄 License

This project is licensed under the MIT License.
