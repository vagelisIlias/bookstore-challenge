# Bookstore API

A simple REST API for managing a bookstore — authors, books, and loans.

## Setup

### Requirements

- Docker and Docker Compose

### Getting Started

1. Clone the repository
2. Copy the environment file: `cp .env.example .env`
3. Start the containers: `docker-compose up -d --build` or `docker compose up -d --build`
4. Install dependencies: `docker exec -it bookstore_api composer install`
5. Generate app key: `docker exec -it bookstore_api php artisan key:generate`
6. Run migrations: `docker exec -it bookstore_api php artisan migrate`
7. Seed the database: `docker exec -it bookstore_api php artisan db:seed`
8. The API is available at `http://localhost:8080`

For any errors make sure the port is ```3306``` or ```3307```

### Running Tests

```bash
docker exec -it bookstore_api ./vendor/bin/phpunit
```

---

## API Documentation

### Authors

#### Create Author

```
POST /api/authors
```

Request body:

```json
{
    "name": "Stephen King"
}
```

Response `201 Created`:

```json
{
    "name": "Stephen King",
    "uuid": "019d0c97-928b-718f-bebb-5b92013990c1"
}
```

#### List Authors

```
GET /api/authors
```

Response `200 OK`:

```json
{
    "current_page": 1,
    "data": [
        {
            "uuid": "a948c7e3-7377-4f25-a02d-02c966bcce49",
            "name": "George Orwell"
        },
        {
            "uuid": "ecce0c70-b729-4c6f-8efd-5d059a3741dd",
            "name": "J.R.R. Tolkien"
        },
        {
            "uuid": "e4095384-37a1-436d-80f3-aee4fa622815",
            "name": "Isaac Asimov"
        },
        {
            "uuid": "019d0c97-928b-718f-bebb-5b92013990c1",
            "name": "Stephen King"
        }
    ],
    "first_page_url": "http://127.0.0.1:8080/api/authors?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://127.0.0.1:8080/api/authors?page=1",
    "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "page": null,
            "active": false
        },
        {
            "url": "http://127.0.0.1:8080/api/authors?page=1",
            "label": "1",
            "page": 1,
            "active": true
        },
        {
            "url": null,
            "label": "Next &raquo;",
            "page": null,
            "active": false
        }
    ],
    "next_page_url": null,
    "path": "http://127.0.0.1:8080/api/authors",
    "per_page": 15,
    "prev_page_url": null,
    "to": 4,
    "total": 4
}
```

---

### Books

#### Create Book

```
POST /api/books
```

Request body:

```json
{
    "title": "New Book Coming Home",
    "isbn": "978-0451524534",
    "author_uuid": "019d0c97-928b-718f-bebb-5b92013990c1"
}
```

Response `201 Created`:

```json
{
    "title": "New Book Coming Home",
    "isbn": "978-0451524534",
    "uuid": "019d0c98-d1fb-7399-8263-131dd89c5b31"
}
```

#### List Books

```
GET /api/books
```

Query parameters:

| Parameter | Type   | Description                      |
|-----------|--------|----------------------------------|
| `search`  | string | Filter by title (partial match)  |
| `author`  | string | Filter by author UUID            |

Response `200 OK`:

```json
{
    "current_page": 1,
    "data": [
        {
            "uuid": "0330e8b3-7b27-4bed-aad5-cfd5e36a1b66",
            "title": "1984",
            "isbn": "978-0451524935",
            "available": true,
            "borrower_name": null,
            "author": {
                "uuid": "a948c7e3-7377-4f25-a02d-02c966bcce49",
                "name": "George Orwell"
            }
        },
        {
            "uuid": "abc02e1f-0914-4a27-ba51-b2bbbf9edad8",
            "title": "Animal Farm",
            "isbn": "978-0451526342",
            "available": false,
            "borrower_name": "Alice",
            "author": {
                "uuid": "a948c7e3-7377-4f25-a02d-02c966bcce49",
                "name": "George Orwell"
            }
        },
        {
            "uuid": "658a867a-c053-42ba-95f4-c0cad1214375",
            "title": "The Lord of the Rings",
            "isbn": "978-0618640157",
            "available": true,
            "borrower_name": null,
            "author": {
                "uuid": "ecce0c70-b729-4c6f-8efd-5d059a3741dd",
                "name": "J.R.R. Tolkien"
            }
        },
        {
            "uuid": "3306ac42-1fd8-4a62-b9cc-337e67dda658",
            "title": "The Hobbit",
            "isbn": "978-0547928227",
            "available": false,
            "borrower_name": "Bob",
            "author": {
                "uuid": "ecce0c70-b729-4c6f-8efd-5d059a3741dd",
                "name": "J.R.R. Tolkien"
            }
        },
        {
            "uuid": "6b2d603b-b087-4887-b149-9e92b2f337e3",
            "title": "Foundation",
            "isbn": "978-0553293357",
            "available": true,
            "borrower_name": null,
            "author": {
                "uuid": "e4095384-37a1-436d-80f3-aee4fa622815",
                "name": "Isaac Asimov"
            }
        },
        {
            "uuid": "d746442a-3435-4ac1-b679-c4fd12f714c0",
            "title": "I, Robot",
            "isbn": "978-0553294385",
            "available": false,
            "borrower_name": "Charlie",
            "author": {
                "uuid": "e4095384-37a1-436d-80f3-aee4fa622815",
                "name": "Isaac Asimov"
            }
        },
        {
            "uuid": "019d0c98-d1fb-7399-8263-131dd89c5b31",
            "title": "New Book Coming Home",
            "isbn": "978-0451524534",
            "available": true,
            "borrower_name": null,
            "author": {
                "uuid": "019d0c97-928b-718f-bebb-5b92013990c1",
                "name": "Stephen King"
            }
        }
    ],
    "first_page_url": "http://127.0.0.1:8080/api/books?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://127.0.0.1:8080/api/books?page=1",
    "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "page": null,
            "active": false
        },
        {
            "url": "http://127.0.0.1:8080/api/books?page=1",
            "label": "1",
            "page": 1,
            "active": true
        },
        {
            "url": null,
            "label": "Next &raquo;",
            "page": null,
            "active": false
        }
    ],
    "next_page_url": null,
    "path": "http://127.0.0.1:8080/api/books",
    "per_page": 15,
    "prev_page_url": null,
    "to": 7,
    "total": 7
}
```

#### Get Book

```
GET /api/books/{uuid}
```

Response `200 OK`:

```json
{
    "uuid": "0330e8b3-7b27-4bed-aad5-cfd5e36a1b66",
    "title": "1984",
    "isbn": "978-0451524935",
    "available": true,
    "borrower_name": null,
    "author": {
        "uuid": "a948c7e3-7377-4f25-a02d-02c966bcce49",
        "name": "George Orwell"
    }
}
```

---

## Your Task

### 1. Refactor

The current code works but could be better structured. Improve the codebase — reorganize, extract, clean up — whatever you think makes it more maintainable.

The API endpoints should remain the same. We're interested in the choices you make and why.

### 2. Add Feature: Book Loans

Add the ability to borrow and return books:

- `POST /api/books/{uuid}/borrow` — Borrow a book (requires a `borrower` name)
- `POST /api/books/{uuid}/return` — Return a book

Rules:

- A book that is already borrowed cannot be borrowed again
- A book that is not borrowed cannot be returned
- The `GET /api/books/{uuid}` endpoint should show whether a book is available or borrowed, and who has it
- The `GET /api/books` endpoint should support an `available` filter (e.g., `?available=true`)
- Invalid operations should return appropriate HTTP status codes and clear error messages

How you model and structure this is up to you.

### 3. Tests

Write tests you think are meaningful for your changes. There is no minimum number — we want to see what you choose to test.

### Submission

Fork this repository, make your changes, and send us the link.

We care more about clean, thoughtful code than completeness. If you run out of time, a short note explaining what you'd do next is perfectly fine. If you have any questions, feel free to reach out.
