
-- DROP TABLE IF EXISTS checks;
-- DROP TABLE IF EXISTS urls;

CREATE TABLE IF NOT EXISTS urls
(
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL
);

INSERT INTO urls (name, created_at)
VALUES ('https://www.google.com', '2024-01-01 00:00:00'),
    ('https://www.youtube.com', '2024-01-02 00:00:00');

-- TODO добавить таблицу checks
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