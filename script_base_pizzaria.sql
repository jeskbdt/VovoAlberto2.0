CREATE DATABASE IF NOT EXISTS pizzaria;
USE pizzaria;

CREATE TABLE atendente (
    id INT AUTO_INCREMENT NOT NULL,
    nome VARCHAR(50) NOT NULL,
    endereco VARCHAR(100) NOT NULL,
    telefone VARCHAR(50) NOT NULL,
    salarioBase DECIMAL(10,2) NOT NULL,
    comissao DECIMAL(10,2) DEFAULT 0,
    CONSTRAINT pk_atendente PRIMARY KEY (id)
);

CREATE TABLE entregador (
    id INT AUTO_INCREMENT NOT NULL,
    nome VARCHAR(50) NOT NULL,
    endereco VARCHAR(100) NOT NULL,
    telefone VARCHAR(50) NOT NULL,
    salarioBase DECIMAL(10,2) NOT NULL,
    comissao DECIMAL(10,2) DEFAULT 0,
    placaMoto VARCHAR(7) NOT NULL,
    modeloMoto VARCHAR(30) NOT NULL,
    CONSTRAINT pk_entregador PRIMARY KEY (id)
);

CREATE TABLE sabores (
    id INT AUTO_INCREMENT NOT NULL,
    nome VARCHAR(70) NOT NULL,
    CONSTRAINT pk_sabores PRIMARY KEY (id),
    CONSTRAINT uk_sabor_nome UNIQUE (nome)
);

CREATE TABLE pedidos (
    id INT AUTO_INCREMENT NOT NULL,
    tamanho ENUM('M', 'G', 'F', 'X') NOT NULL,
    endereco VARCHAR(100) NOT NULL,
    telefoneCliente VARCHAR(50) NOT NULL,
    metodoPagamento ENUM('D', 'C', 'M') NOT NULL,
    id_atendente INT NOT NULL,
    id_entregador INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_pedidos PRIMARY KEY (id),
    CONSTRAINT fk_atendente FOREIGN KEY (id_atendente) REFERENCES atendente (id),
    CONSTRAINT fk_entregador FOREIGN KEY (id_entregador) REFERENCES entregador (id)
);

CREATE TABLE pedido_sabores (
    id_pedido INT NOT NULL,
    id_sabor INT NOT NULL,
    CONSTRAINT fk_pedido FOREIGN KEY (id_pedido) REFERENCES pedidos (id),
    CONSTRAINT fk_sabor FOREIGN KEY (id_sabor) REFERENCES sabores (id),
    CONSTRAINT pk_pedido_sabores PRIMARY KEY (id_pedido, id_sabor)
);

INSERT INTO atendente (nome, endereco, telefone, salarioBase, comissao)
VALUES
    ('Japa dzz7 100% focado', 'Correndo no gramadão', '(45) 99109-6457', 1518.00, 0),
    ('Gustavo Vieira Goularte', 'Condominio Três lagoas', '(45) 91176-7904', 1518.00, 0),
    ('Gabriel Soldado Guilhen', 'Favela da batalha', '(45) 98500-9488', 1518.00, 0);

INSERT INTO entregador (nome, endereco, telefone, salarioBase, comissao, placaMoto, modeloMoto)
VALUES
    ('Enzo Michel Barbosa Suco', 'Rua Franca 670', '(45) 99976-3457', 1518.00, 0, 'BRA0S17', 'Honda cg 125 fan'),
    ('Dj Kauã', 'Fazendo tatuagem', '(45) 99967-2452', 1518.00, 0, 'GQK4D47', 'Fazer 250'),
    ('Senhor Paulo Emanoel Toblerone Feijão', 'Retifoz', '(45) 93846-9068', 1518.00, 0, 'JWK5R09', 'Yamaha Mt-09');

INSERT INTO sabores (nome)
VALUES
    ('Manga'),
    ('Frango com catupiry'),
    ('Bacon com milho'),
    ('Mostarda'),
    ('Calabresa com cebola'),
    ('4 queijos'),
    ('Morango do amor'),
    ('Chocolate'),
    ('Chocolate Branco');

    ALTER TABLE pedidos MODIFY metodoPagamento ENUM('D', 'C', 'M', 'P') NOT NULL;