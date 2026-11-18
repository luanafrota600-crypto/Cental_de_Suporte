CREATE DATABASE IF NOT EXISTS suporte CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE suporte;
CREATE TABLE IF NOT EXISTS chamados (
    id INT NOT NULL AUTO_INCREMENT,
    titulo VARCHAR(150) NOT NULL,
    solicitante VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    prioridade VARCHAR(10) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'Aberto',
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
