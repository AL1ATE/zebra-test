# API Запросы через Postman

Ниже описание, как тестировать API с помощью Postman или любого другого REST клиента.

## Заполнение бд

**Чтобы заполнить БД необходимо поместить файл test_task_data.csv в директорию:**
**storage/app/**

**После чего выполнить консольную команду кнутри контейнера:**

```
 docker-compose exec app php artisan import:tenders storage/app/test_task_data.csv
```


## Регистрация пользователя

**Запрос**

- **Method:** POST
- **URL:** `http://localhost:8000/api/auth/register`
- **Headers:** `Content-Type: application/json`
- **Body (raw JSON):**

```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password"
}
```

## Авторизация пользователя (получение токена)

**Запрос**

- **Method:** POST
- **URL:** `http://localhost:8000/api/auth/login`
- **Headers:** `Content-Type: application/json`
- **Body (raw JSON):**

```json
{
    "email": "john@example.com",
    "password": "password"
}
```
**Ответ**
```
{
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6..."
}
```

## Получение списка тендеров

**Запрос**

- **Method:** GET
- **URL:** `http://localhost:8000/api/tenders`
- **Headers:** `Authorization: Bearer <ТОКЕН>`

**Query-параметры (опционально):**

- **name:** `фильтр по названию`
- **date:** `фильтр по дате (формат YYYY-MM-DD)`

**Ответ**
```json
[
    {
        "id": 1,
        "external_code": 152467180,
        "number": "17660-2",
        "status": "Закрыто",
        "name": "Лабораторная посуда",
        "updated_at_original": "2022-08-14T19:25:14.000000Z",
        "created_at": "2025-07-01T12:00:00.000000Z",
        "updated_at": "2025-07-01T12:00:00.000000Z"
    }
]
```

##  Получение информации о тендере по ID

- **Method:** GET
- **URL:** `http://localhost:8000/api/tenders/{id}`
- **Headers:** `Authorization: Bearer <ТОКЕН>`

**Ответ**
```json
[
    {
        "id": 1,
        "external_code": 152467180,
        "number": "17660-2",
        "status": "Закрыто",
        "name": "Лабораторная посуда",
        "updated_at_original": "2022-08-14T19:25:14.000000Z",
        "created_at": "2025-07-01T12:00:00.000000Z",
        "updated_at": "2025-07-01T12:00:00.000000Z"
    }
]
```

##  Создание нового тендера

- **Method:** POST
- **URL:** `http://localhost:8000/api/tenders`
- **Headers:** `Authorization: Bearer <ТОКЕН>`
- **Headers:** `Content-Type: application/json`
- **Body (raw JSON):** 

```json
{
  "external_code": 999999999,
  "number": "12345-6",
  "status": "Открыто",
  "name": "Новый тестовый тендер",
  "updated_at_original": "2024-07-01 12:00:00"
}
```
