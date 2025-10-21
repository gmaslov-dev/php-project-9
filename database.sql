CREATE TABLE IF NOT EXISTS urls
(
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL
);

INSERT INTO urls (name, created_at)
VALUES ('https://www.google.com', '2024-01-01 00:00:00'),
    ('https://www.youtube.com', '2024-01-02 00:00:00');
