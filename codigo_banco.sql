CREATE DATABASE IFsports;
USE IFsports;

CREATE TABLE Produtos(
	id_produtos INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nome VARCHAR(150) NOT NULL, 
    descricao VARCHAR(500) NOT NULL,
    imagem VARCHAR(1000) NOT NULL, -- Mudar tamanho
    estoque INT NOT NULL, -- Perguntar se necessário
    preco DECIMAL(10, 2) -- Discutir ainda limite
);

CREATE TABLE item_pedidos(
	id_item_pedidos INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    quantidade INT NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL, -- Ver limite e se esta correto
    preco_unitario DECIMAL(10, 2) NOT NULL,
    id_produtos INT NOT NULL,
    id_pedidos INT NOT NULL,
    FOREIGN KEY (id_produtos) REFERENCES Produtos(id_produtos),
    FOREIGN KEY (id_pedidos) REFERENCES Pedidos(id_pedidos)
);

CREATE TABLE Pedidos(
	id_pedidos INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    statusPedido VARCHAR(10) NOT NULL, -- Discutir tamanho
    valor DECIMAL(10, 2) NOT NULL, -- Discutir Tamanho
    data_pedido DATE NOT NULL, -- Ver sobre padrão brasileiro
    id_usuarios INT NOT NULL,
    FOREIGN KEY (id_usuarios) REFERENCES Usuarios(id_usuarios)
);

CREATE TABLE Usuarios(
	id_usuarios INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    email VARCHAR(254) NOT NULL,
    nome VARCHAR(75) NOT NULL,
    tipo VARCHAR (5) NOT NULL,
    senha VARCHAR(300) NOT NULL
);

CREATE TABLE Carrinho(
	id_carrinho INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    data_criacao DATE NOT NULL, -- Ver sobre padrão brasileiro
    id_usuarios INT NOT NULL,
    FOREIGN KEY(id_usuarios) REFERENCES Usuarios(id_usuarios)
);

CREATE TABLE item_carrinho(
	id_item_carrinho INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    quantidade INT NOT NULL,
    id_carrinho INT NOT NULL,
    id_produto INT NOT NULL,
    FOREIGN KEY(id_carrinho) REFERENCES Carrinho(id_carrinho),
    FOREIGN KEY(id_produtos) REFERENCES Produtos(id_produtos)
);