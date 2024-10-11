# API Documentation

## Authentication

All endpoints require authentication. Use the `Authorization` header with a Bearer token.

## Dashboard

### GET /dashboard

Returns the dashboard for the authenticated user.

## User Donations

### GET /users/{id}/donations

Returns a list of donations for the specified user.

## Donations

### GET /donations/create

Returns the form for creating a new donation.

### POST /donations

Creates a new donation.

Request Body:

```json
{ "description": "string", "amount": "number" }
```

### GET /donations/{donation}/edit

Returns the form for editing a donation.

### PATCH /donations/{donation}

Updates an existing donation.

Request Body:

```json
    { "description": "string", "amount": "number" }
```

### GET /donations/{donation}/contribute

Returns the form for contributing to a donation.

### POST /donations/{donation}/contribute

Contributes to an existing donation.

Request Body:

```json
    { "amount": "number" }
```
