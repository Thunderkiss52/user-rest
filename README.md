# Symfony REST API

Simple REST API for user management with Symfony.

## Endpoints

- **POST /api/register**: Create a user.
    - Body: `{"email": "user@example.com", "password": "pass"}`
    - Validation: Email must be valid, password must be at least 6 characters.
    - Response: `201 {"message": "User created"}` or `400 {"error": "validation_message"}`
    - Access: Public

- **POST /api/login**: Authenticate user and get JWT token.
    - Body: `{"email": "user@example.com", "password": "pass"}`
    - Response: `200 {"token": "jwt_token_here"}`
    - Access: Public

- **GET /api/users/me**: Get current user info.
    - Headers: `Authorization: Bearer <token>`
    - Response: `200 {"id": 1, "email": "user@example.com"}`
    - Access: Authenticated

- **PUT /api/users/me**: Update user email.
    - Headers: `Authorization: Bearer <token>`
    - Body: `{"email": "new@example.com"}`
    - Validation: Email must be valid.
    - Response: `200 {"message": "User updated"}` or `400 {"error": "validation_message"}`
    - Access: Authenticated

- **DELETE /api/users/me**: Delete current user.
    - Headers: `Authorization: Bearer <token>`
    - Response: `200 {"message": "User deleted"}`
    - Access: Authenticated

## Setup

1. Clone: `git clone https://github.com/your-username/symfony-rest-api.git`
2. Install: `composer install`
3. Migrate DB: `php bin/console doctrine:migrations:migrate`
4. Run: `php bin/console server:start`