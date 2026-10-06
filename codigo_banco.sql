
CREATE DATABASE IFsports;
USE IFsports;


CREATE TABLE Produtos(
    id_produtos INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nome VARCHAR(150) NOT NULL,
    descricao VARCHAR(500) NOT NULL,
    imagem VARCHAR(1000) NOT NULL,
    estoque INT NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    tipo VARCHAR(15) NOT NULL
);


CREATE TABLE Usuarios(
    id_usuarios INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    email VARCHAR(320) NOT NULL,
    nome VARCHAR(75) NOT NULL,
    tipo VARCHAR(6) NOT NULL,
    senha VARCHAR(300) NOT NULL
);


CREATE TABLE Pedidos(
    id_pedidos INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_usuarios INT NOT NULL,
    statusPed VARCHAR(10) NOT NULL,
    valor DECIMAL(10, 2) NOT NULL,
    data_pedido DATE NOT NULL,
    FOREIGN KEY (id_usuarios) REFERENCES Usuarios(id_usuarios)
);


CREATE TABLE Item_pedidos(
    id_item_pedidos INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_produtos INT NOT NULL,
    id_pedidos INT NOT NULL,
    quantidade INT NOT NULL,
    subtotal DECIMAL(30, 2) NOT NULL,
    preco_unitario DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_produtos) REFERENCES Produtos(id_produtos),
    FOREIGN KEY (id_pedidos) REFERENCES Pedidos(id_pedidos)
);


CREATE TABLE Carrinho(
    id_carrinho INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_usuarios INT NOT NULL,
    data_criacao DATE NOT NULL,
    FOREIGN KEY(id_usuarios) REFERENCES Usuarios(id_usuarios)
);


CREATE TABLE item_carrinho(
    id_item_carrinho INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_carrinho INT NOT NULL,
    id_produtos INT NOT NULL,
    quantidade INT NOT NULL,
    FOREIGN KEY(id_carrinho) REFERENCES Carrinho(id_carrinho),
    FOREIGN KEY(id_produtos) REFERENCES Produtos(id_produtos)
);

INSERT INTO Usuarios (email, nome, tipo, senha) VALUES
('admin@ifsports.com',  'admin', 'admin', '$2y$10$IP2az.9evcpM3vBTs2KBjuEthL5jVot0/xCceQuqOHWH5QYk0VsKK'),
('maria@ifsports.com',  'Maria Silva',   'comum',  '$2y$10$wDRAmVbWoOd1E5icNbS8XO6TA7ZUemGuE4KC7X7VkHxecoypACJn2'),
('joao@ifsports.com',   'João Santos',   'comum',  '$2y$10$FFkrOcPrT4kv3kBqmWfRtuWEcGa3e7ddF7kTTAL4nqrl/6hc1a3jO'),
('ana@ifsports.com',    'Ana Oliveira',  'comum',  '$2y$10$vYBCW8OTgdKLPF71fkDuH.T1a1D9qng3TvJ1YuzBVGkIItqSAKV6G'),
('carlos@ifsports.com', 'Carlos Souza',  'comum',  '$2y$10$G2xdx6vglZ94jy5iFjq.tOIaSV3fPNkkQciYN0qr7Z250ykHqgYba');