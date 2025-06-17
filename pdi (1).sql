-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17/06/2025 às 17:30
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `pdi`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `administrador`
--

CREATE TABLE `administrador` (
  `codigo_administrador` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `administrador`
--

INSERT INTO `administrador` (`codigo_administrador`, `nome`, `email`, `senha`) VALUES
(1, 'Gustavo', 'piercodedev@gmail.com', '$2y$10$k5D1IOuz39GcEcR.N7x7meRZxS0QvR9iR2qFgXdlHMYJ8qHdpGViu');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cartao`
--

CREATE TABLE `cartao` (
  `codigo_cartao` int(11) NOT NULL,
  `codigo_cliente` int(11) NOT NULL,
  `tipo` enum('Crédito','Débito') NOT NULL,
  `apelido` varchar(255) NOT NULL,
  `nome_titular` varchar(255) NOT NULL,
  `bandeira` enum('VISA','Mastercard') NOT NULL,
  `numero` int(11) NOT NULL,
  `data_validade` date NOT NULL,
  `cvv` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoria_produto`
--

CREATE TABLE `categoria_produto` (
  `codigo_categoria` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `imagem` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

CREATE TABLE `cliente` (
  `codigo_cliente` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `telefone` varchar(12) DEFAULT NULL,
  `cpf` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cliente`
--

INSERT INTO `cliente` (`codigo_cliente`, `nome`, `email`, `senha`, `telefone`, `cpf`) VALUES
(1, 'Gustavo Padilla', 'piercodedev@gmail.com', '$2y$10$k5D1IOuz39GcEcR.N7x7meRZxS0QvR9iR2qFgXdlHMYJ8qHdpGViu', NULL, '455.206.978-09');

-- --------------------------------------------------------

--
-- Estrutura para tabela `endereco`
--

CREATE TABLE `endereco` (
  `codigo_endereco` int(11) NOT NULL,
  `codigo_cliente` int(11) NOT NULL,
  `tipo` enum('Comercial','Residencial') NOT NULL,
  `logradouro` varchar(255) NOT NULL,
  `numero` int(11) NOT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  `pais` varchar(255) NOT NULL,
  `cep` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_pedido`
--

CREATE TABLE `itens_pedido` (
  `codigo_item_pedido` int(11) NOT NULL,
  `codigo_produto` int(11) NOT NULL,
  `codigo_pedido` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `subtotal` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_sacola`
--

CREATE TABLE `itens_sacola` (
  `codigo_item_sacola` int(11) NOT NULL,
  `codigo_produto` int(11) NOT NULL,
  `codigo_sacola` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `subtotal` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `metodo_pagamento`
--

CREATE TABLE `metodo_pagamento` (
  `codigo_metodo_pagamento` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedido`
--

CREATE TABLE `pedido` (
  `codigo_pedido` int(11) NOT NULL,
  `codigo_cliente` int(11) NOT NULL,
  `codigo_endereco` int(11) NOT NULL,
  `codigo_metodo_pagamento` int(11) NOT NULL,
  `codigo_cartao` int(11) NOT NULL,
  `preco_total` decimal(5,2) NOT NULL,
  `troco` decimal(5,2) DEFAULT NULL,
  `status` enum('Aguardando confirmação da loja','Em preparo','A caminho','Entregue','Finalizado','Cancelado') NOT NULL DEFAULT 'Aguardando confirmação da loja',
  `data_pedido` datetime NOT NULL,
  `data_entrega` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `codigo_produto` int(11) NOT NULL,
  `codigo_categoria` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `preco` decimal(5,2) NOT NULL,
  `estoque` int(11) NOT NULL,
  `unidade_venda` enum('un','kg','g','L','ml') NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `sacola`
--

CREATE TABLE `sacola` (
  `codigo_sacola` int(11) NOT NULL,
  `codigo_cliente` int(11) NOT NULL,
  `status` enum('Aguardando Confirmação','Em andamento','Pagamento confirmado','Preparando pedido','Pedido finalizado','Saiu para entrega','Chegou ao destino final') NOT NULL DEFAULT 'Aguardando Confirmação'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`codigo_administrador`);

--
-- Índices de tabela `cartao`
--
ALTER TABLE `cartao`
  ADD PRIMARY KEY (`codigo_cartao`),
  ADD KEY `codigo_cliente` (`codigo_cliente`);

--
-- Índices de tabela `categoria_produto`
--
ALTER TABLE `categoria_produto`
  ADD PRIMARY KEY (`codigo_categoria`);

--
-- Índices de tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`codigo_cliente`);

--
-- Índices de tabela `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`codigo_endereco`),
  ADD KEY `codigo_cliente` (`codigo_cliente`);

--
-- Índices de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD PRIMARY KEY (`codigo_item_pedido`),
  ADD KEY `codigo_produto` (`codigo_produto`),
  ADD KEY `codigo_pedido` (`codigo_pedido`);

--
-- Índices de tabela `itens_sacola`
--
ALTER TABLE `itens_sacola`
  ADD PRIMARY KEY (`codigo_item_sacola`),
  ADD KEY `codigo_produto` (`codigo_produto`),
  ADD KEY `codigo_sacola` (`codigo_sacola`);

--
-- Índices de tabela `metodo_pagamento`
--
ALTER TABLE `metodo_pagamento`
  ADD PRIMARY KEY (`codigo_metodo_pagamento`);

--
-- Índices de tabela `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`codigo_pedido`),
  ADD KEY `codigo_cliente` (`codigo_cliente`),
  ADD KEY `codigo_endereco` (`codigo_endereco`),
  ADD KEY `codigo_metodo_pagamento` (`codigo_metodo_pagamento`),
  ADD KEY `codigo_cartao` (`codigo_cartao`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`codigo_produto`),
  ADD KEY `codigo_categoria` (`codigo_categoria`);

--
-- Índices de tabela `sacola`
--
ALTER TABLE `sacola`
  ADD PRIMARY KEY (`codigo_sacola`),
  ADD KEY `codigo_cliente` (`codigo_cliente`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `administrador`
--
ALTER TABLE `administrador`
  MODIFY `codigo_administrador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `cartao`
--
ALTER TABLE `cartao`
  MODIFY `codigo_cartao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `categoria_produto`
--
ALTER TABLE `categoria_produto`
  MODIFY `codigo_categoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `codigo_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `endereco`
--
ALTER TABLE `endereco`
  MODIFY `codigo_endereco` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  MODIFY `codigo_item_pedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `itens_sacola`
--
ALTER TABLE `itens_sacola`
  MODIFY `codigo_item_sacola` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `metodo_pagamento`
--
ALTER TABLE `metodo_pagamento`
  MODIFY `codigo_metodo_pagamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pedido`
--
ALTER TABLE `pedido`
  MODIFY `codigo_pedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `codigo_produto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `sacola`
--
ALTER TABLE `sacola`
  MODIFY `codigo_sacola` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `cartao`
--
ALTER TABLE `cartao`
  ADD CONSTRAINT `cartao_ibfk_1` FOREIGN KEY (`codigo_cliente`) REFERENCES `cliente` (`codigo_cliente`) ON DELETE CASCADE;

--
-- Restrições para tabelas `endereco`
--
ALTER TABLE `endereco`
  ADD CONSTRAINT `endereco_ibfk_1` FOREIGN KEY (`codigo_cliente`) REFERENCES `cliente` (`codigo_cliente`) ON DELETE CASCADE;

--
-- Restrições para tabelas `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD CONSTRAINT `itens_pedido_ibfk_1` FOREIGN KEY (`codigo_produto`) REFERENCES `produto` (`codigo_produto`) ON DELETE CASCADE,
  ADD CONSTRAINT `itens_pedido_ibfk_2` FOREIGN KEY (`codigo_pedido`) REFERENCES `pedido` (`codigo_pedido`) ON DELETE CASCADE;

--
-- Restrições para tabelas `itens_sacola`
--
ALTER TABLE `itens_sacola`
  ADD CONSTRAINT `itens_sacola_ibfk_1` FOREIGN KEY (`codigo_produto`) REFERENCES `produto` (`codigo_produto`) ON DELETE CASCADE,
  ADD CONSTRAINT `itens_sacola_ibfk_2` FOREIGN KEY (`codigo_sacola`) REFERENCES `sacola` (`codigo_sacola`) ON DELETE CASCADE;

--
-- Restrições para tabelas `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`codigo_cliente`) REFERENCES `cliente` (`codigo_cliente`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`codigo_endereco`) REFERENCES `endereco` (`codigo_endereco`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedido_ibfk_3` FOREIGN KEY (`codigo_metodo_pagamento`) REFERENCES `metodo_pagamento` (`codigo_metodo_pagamento`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedido_ibfk_4` FOREIGN KEY (`codigo_cartao`) REFERENCES `cartao` (`codigo_cartao`) ON DELETE CASCADE;

--
-- Restrições para tabelas `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`codigo_categoria`) REFERENCES `categoria_produto` (`codigo_categoria`) ON DELETE CASCADE;

--
-- Restrições para tabelas `sacola`
--
ALTER TABLE `sacola`
  ADD CONSTRAINT `sacola_ibfk_1` FOREIGN KEY (`codigo_cliente`) REFERENCES `cliente` (`codigo_cliente`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
