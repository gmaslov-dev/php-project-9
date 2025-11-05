CREATE TABLE IF NOT EXISTS urls
(
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL
);

CREATE TABLE IF NOT EXISTS checks
(
    id SERIAL PRIMARY KEY,
    url_id INTEGER NOT NULL REFERENCES urls(id),
    status_code INTEGER,
    h1 TEXT,
    title VARCHAR(255),
    description TEXT,
    created_at TIMESTAMP NOT NULL
);