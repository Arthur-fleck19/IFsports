
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
