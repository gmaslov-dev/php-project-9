### Hexlet tests and linter status:
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=gmaslov-dev_php-project-9&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=gmaslov-dev_php-project-9)
[![Actions Status](https://github.com/gmaslov-dev/php-project-9/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/gmaslov-dev/php-project-9/actions)
[![project-check](https://github.com/StandAlone404/php-project-48/actions/workflows/project-check.yml/badge.svg)](https://github.com/gmaslov-dev/php-project-9/actions/workflows/project-check.yml)
---
# [Анализатор страниц](https://php-project-9-9cq6.onrender.com/)

**Анализатор страниц** — веб-приложение для анализа SEO-пригодности страниц по аналогии с [PageSpeed Insights](https://pagespeed.web.dev/).

Проект разработан в рамках обучения на платформе [Hexlet](https://hexlet.io) и демонстрирует практическое применение современных подходов веб-разработки на PHP.

## 🎯 Возможности

- Проверка доступности сайтов
- Анализ основных SEO-параметров (title, h1, description)
- История проверок для каждого добавленного URL
- Валидация введённых адресов
- Responsive дизайн на Bootstrap 5

## 🛠 Технологический стек

**Backend:**
- PHP 8.x
- [Slim Framework 4](https://www.slimframework.com/) — микрофреймворк для роутинга и обработки запросов
- [Twig](https://twig.symfony.com/) — шаблонизатор для рендеринга страниц
- PDO — работа с базой данных PostgreSQL
- [Guzzle](https://docs.guzzlephp.org/) — HTTP-клиент для запросов к анализируемым сайтам
- [DiDOM](https://github.com/Imangazaliev/DiDOM) — парсинг HTML-контента

**Frontend:**
- Bootstrap 5

**Инфраструктура:**
- PostgreSQL — хранение данных
- [Render.com](https://render.com) — хостинг (PaaS)

**Dev Tools:**
- PHP_CodeSniffer — проверка стандартов кодирования
- PHPStan — статический анализ кода
- Composer — управление зависимостями

## 📋 Требования

- PHP >= 8.1
- Composer
- PostgreSQL >= 13
- Расширения PHP: pdo, pdo_pgsql, dom

## 🚀 Установка

### Клонирование репозитория

```bash
git clone https://github.com/gmaslov-dev/php-project-9.git
cd php-project-9
```

### Установка зависимостей

```bash
composer install
```

### Настройка окружения

Создайте файл `.env` в корне проекта:

```env
DATABASE_URL=postgresql://username:password@localhost:5432/page_analyzer
```

### Инициализация базы данных

```bash
composer db:init
```

Или напрямую:

```bash
php bin/init_db.php
```

Это создаст необходимые таблицы в базе данных.

### Локальный запуск

```bash
php -S localhost:8000 -t public
```

Приложение будет доступно по адресу: `http://localhost:8000`

## 📊 Структура базы данных

**Таблица `urls`:**
- `id` — уникальный идентификатор
- `name` — URL сайта
- `created_at` — дата добавления

**Таблица `url_checks`:**
- `id` — уникальный идентификатор проверки
- `url_id` — связь с таблицей urls
- `status_code` — HTTP статус-код
- `h1` — содержимое тега h1
- `title` — содержимое тега title
- `description` — содержимое meta description
- `created_at` — дата проверки

## 🎮 Использование

1. Откройте главную страницу приложения
2. Введите URL сайта, который хотите проанализировать
3. Нажмите кнопку "Проверить"
4. Просмотрите результаты анализа
5. При необходимости запустите повторную проверку

## 🧪 Проверка кода

### Линтинг

```bash
composer lint
```

### Статический анализ

```bash
composer analyse
```

## 🏗 Архитектура

Проект построен на принципах чистой архитектуры с разделением ответственности:
```bash
./src
├── Controller/              # Контроллеры для обработки HTTP-запросов
│   ├── CheckController.php
│   ├── PageController.php
│   └── UrlController.php
├── Database/                # Подключение к базе данных
│   └── Connection.php
├── Entity/                  # Модели данных (Data Objects)
│   ├── Check.php
│   ├── Url.php
│   └── UrlWithLastCheck.php
├── Handler/                 # Обработчики исключений и ошибок
│   └── ErrorHandler.php
├── Initializer/             # Инициализация компонентов приложения
│   ├── ContainerInitializer.php
│   ├── MiddlewareInitializer.php
│   └── RouteInitializer.php
├── Repository/              # Слой доступа к данным (Data Access Layer)
│   ├── CheckRepository.php
│   └── UrlRepository.php
├── Service/                 # Бизнес-логика приложения
│   ├── CheckService.php
│   ├── UrlCheckerService.php
│   └── UrlCheckService.php
└── Validator/               # Валидация данных
└── UrlValidator.php
```
## 📚 Что отрабатывается в проекте

- ✅ Клиент-серверная архитектура и HTTP-протокол
- ✅ Роутинг и обработка HTTP-методов (GET, POST)
- ✅ Работа с шаблонизатором Twig
- ✅ Проектирование базы данных (нормальные формы, связи)
- ✅ SQL-запросы через PDO
- ✅ Валидация пользовательских данных
- ✅ Работа с внешними API (HTTP-запросы)
- ✅ Парсинг HTML-контента
- ✅ Flash-сообщения для UX
- ✅ Bootstrap для frontend
- ✅ Деплой на PaaS-платформу

## 👤 Автор

**Gennady Maslov**
- Email: gennadiy.dev@yandex.ru
- GitHub: [@gmaslov-dev](https://github.com/gmaslov-dev)

## 📄 Лицензия

Этот проект создан в образовательных целях в рамках обучения на платформе Hexlet.

---

⭐️ Если проект был полезен, поставьте звезду на GitHub!