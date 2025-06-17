-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28/05/2025 às 17:31
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
-- Banco de dados: `pdi1`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `administradores`
--

CREATE TABLE `administradores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `administradores`
--

INSERT INTO `administradores` (`id`, `nome`, `email`, `senha`, `created_at`, `updated_at`) VALUES
(1, 'Gustavo Padilla', 'gustavo@gmail.com', '$2y$12$SY6MP5LEzdjGSscw/NszUeV/SLN5oQrlm9aoO4PBhNkbo6/6i0Uqa', '2025-05-28 00:05:36', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cartoes`
--

CREATE TABLE `cartoes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cliente_id` bigint(20) UNSIGNED NOT NULL,
  `tipo` enum('Crédito','Débito') NOT NULL,
  `apelido` varchar(255) NOT NULL,
  `nome_titular` varchar(255) NOT NULL,
  `bandeira` enum('VISA','Mastercard') NOT NULL,
  `numero` varchar(16) NOT NULL,
  `data_validade` date NOT NULL,
  `cvv` varchar(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `cartoes`
--

INSERT INTO `cartoes` (`id`, `cliente_id`, `tipo`, `apelido`, `nome_titular`, `bandeira`, `numero`, `data_validade`, `cvv`, `created_at`, `updated_at`) VALUES
(1, 2, 'Crédito', 'Cartão Principal', 'Gustavo Padilla', 'VISA', '5579823720833115', '2026-08-31', '549', '2025-05-27 18:56:10', '2025-05-27 23:17:50'),
(3, 2, 'Crédito', 'Cartão Secundário', 'Gustavo Padilla', 'Mastercard', '5635647634245234', '2027-07-31', '223', '2025-05-27 23:31:56', '2025-05-27 23:32:11');

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias_produto`
--

CREATE TABLE `categorias_produto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `categorias_produto`
--

INSERT INTO `categorias_produto` (`id`, `nome`, `descricao`, `imagem`, `created_at`, `updated_at`) VALUES
(1, 'DOCE', 'DOCE', 'doce.png', '2025-05-27 16:38:15', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `cpf` varchar(14) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `email`, `senha`, `telefone`, `cpf`, `created_at`, `updated_at`) VALUES
(1, 'Gustavo Padilla', 'piercodedev@gmail.com', '$2y$12$QoUllI8rPifDv3Q3qAOeAODvyq0WUpBjF2jLX6RjoN5Qhk7Eyrfj.', '(14) 98101-5280', '455.206.978-09', '2025-05-26 07:35:20', '2025-05-26 07:35:20'),
(2, 'teste', 'teste@teste.com', '$2y$12$SY6MP5LEzdjGSscw/NszUeV/SLN5oQrlm9aoO4PBhNkbo6/6i0Uqa', '(14) 99770-6029', '163.140.448-20', '2025-05-26 07:56:30', '2025-05-26 07:56:30');

-- --------------------------------------------------------

--
-- Estrutura para tabela `enderecos`
--

CREATE TABLE `enderecos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cliente_id` bigint(20) UNSIGNED NOT NULL,
  `tipo` enum('Comercial','Residencial') NOT NULL,
  `logradouro` varchar(255) NOT NULL,
  `numero` varchar(255) NOT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  `pais` varchar(255) DEFAULT NULL,
  `cep` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `enderecos`
--

INSERT INTO `enderecos` (`id`, `cliente_id`, `tipo`, `logradouro`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `pais`, `cep`, `created_at`, `updated_at`) VALUES
(1, 2, 'Comercial', 'Rua Mirante', '800', NULL, 'Jardim Americano', 'Lins', 'SP', 'Brasil', '16400670', '2025-05-27 18:55:32', NULL),
(2, 2, 'Comercial', 'Avenida Fuad Lutfalla', '977', 'Prédio Comercial', 'Piqueri', 'São Paulo', 'SP', NULL, '00000-011', '2025-05-27 23:01:52', '2025-05-27 23:01:52');

-- --------------------------------------------------------

--
-- Estrutura para tabela `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_pedido`
--

CREATE TABLE `itens_pedido` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `produto_id` bigint(20) UNSIGNED NOT NULL,
  `pedido_id` bigint(20) UNSIGNED NOT NULL,
  `quantidade` int(11) NOT NULL,
  `subtotal` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `itens_pedido`
--

INSERT INTO `itens_pedido` (`id`, `produto_id`, `pedido_id`, `quantidade`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 5, 25.00, '2025-05-27 21:59:54', '2025-05-27 21:59:54'),
(2, 1, 3, 3, 15.00, '2025-05-27 22:17:55', '2025-05-27 22:17:55'),
(3, 1, 4, 4, 20.00, '2025-05-27 22:21:35', '2025-05-27 22:21:35'),
(4, 1, 5, 7, 35.00, '2025-05-27 22:21:47', '2025-05-27 22:21:47'),
(5, 1, 6, 3, 15.00, '2025-05-28 02:42:44', '2025-05-28 02:42:44');

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_sacola`
--

CREATE TABLE `itens_sacola` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `produto_id` bigint(20) UNSIGNED NOT NULL,
  `sacola_id` bigint(20) UNSIGNED NOT NULL,
  `quantidade` int(11) NOT NULL,
  `subtotal` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `metodos_pagamento`
--

CREATE TABLE `metodos_pagamento` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `metodos_pagamento`
--

INSERT INTO `metodos_pagamento` (`id`, `nome`, `descricao`, `created_at`, `updated_at`) VALUES
(1, 'Cartão', 'Cartão de Crédito Ou Débito', '2025-05-27 18:57:37', NULL),
(2, 'Dinheiro', 'Dinheiro', '2025-05-27 18:58:24', NULL),
(3, 'PIX', 'PIX', '2025-05-27 18:58:36', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_05_25_230001_create_administradors_table', 1),
(5, '2025_05_25_230002_create_clientes_table', 1),
(6, '2025_05_25_230003_create_categoria_produtos_table', 1),
(7, '2025_05_25_230004_create_produtos_table', 1),
(8, '2025_05_25_230005_create_metodo_pagamentos_table', 1),
(9, '2025_05_25_230006_create_enderecos_table', 1),
(10, '2025_05_25_230007_create_cartaos_table', 1),
(11, '2025_05_25_230008_create_sacola_table', 1),
(12, '2025_05_25_230009_create_itens_sacola_table', 1),
(13, '2025_05_25_230010_create_pedidos_table', 1),
(14, '2025_05_25_230011_create_itens_pedidos_table', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cliente_id` bigint(20) UNSIGNED NOT NULL,
  `endereco_id` bigint(20) UNSIGNED NOT NULL,
  `metodo_pagamento_id` bigint(20) UNSIGNED NOT NULL,
  `cartao_id` bigint(20) UNSIGNED DEFAULT NULL,
  `preco_total` decimal(8,2) NOT NULL,
  `troco` decimal(8,2) DEFAULT NULL,
  `status` enum('Aguardando confirmação da loja','Em preparo','A caminho','Entregue','Finalizado','Cancelado') NOT NULL DEFAULT 'Aguardando confirmação da loja',
  `data_pedido` datetime NOT NULL,
  `data_entrega` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `cliente_id`, `endereco_id`, `metodo_pagamento_id`, `cartao_id`, `preco_total`, `troco`, `status`, `data_pedido`, `data_entrega`, `created_at`, `updated_at`) VALUES
(2, 2, 1, 2, 1, 25.00, 50.00, 'Aguardando confirmação da loja', '2025-05-27 18:59:54', '2025-05-27 20:59:54', '2025-05-27 21:59:54', '2025-05-27 21:59:54'),
(3, 2, 1, 2, 1, 15.00, 50.00, 'Aguardando confirmação da loja', '2025-05-27 19:17:55', '2025-05-27 21:17:55', '2025-05-27 22:17:55', '2025-05-27 22:17:55'),
(4, 2, 1, 1, 1, 20.00, NULL, 'Aguardando confirmação da loja', '2025-05-27 19:21:35', '2025-05-27 21:21:35', '2025-05-27 22:21:35', '2025-05-27 22:21:35'),
(5, 2, 1, 3, 1, 35.00, NULL, 'Aguardando confirmação da loja', '2025-05-27 19:21:47', '2025-05-27 21:21:47', '2025-05-27 22:21:47', '2025-05-27 22:21:47'),
(6, 2, 2, 1, 3, 15.00, NULL, 'Aguardando confirmação da loja', '2025-05-27 23:42:44', '2025-05-28 01:42:44', '2025-05-28 02:42:44', '2025-05-28 02:42:44');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `categoria_id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `preco` decimal(8,2) NOT NULL,
  `estoque` int(11) NOT NULL,
  `unidade_venda` enum('un','kg','g','L','ml') NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `categoria_id`, `nome`, `descricao`, `preco`, `estoque`, `unidade_venda`, `imagem`, `ativo`, `created_at`, `updated_at`) VALUES
(1, 1, 'SONHO', 'SABOR CHOCOLATE', 5.00, -2, 'un', 'images/sonho.jpg', 1, '2025-05-27 16:38:44', '2025-05-28 02:42:44');

-- --------------------------------------------------------

--
-- Estrutura para tabela `sacola`
--

CREATE TABLE `sacola` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cliente_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('Aguardando Confirmação','Em andamento','Pagamento confirmado','Preparando pedido','Pedido finalizado','Saiu para entrega','Chegou ao destino final') NOT NULL DEFAULT 'Aguardando Confirmação',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `sacola`
--

INSERT INTO `sacola` (`id`, `cliente_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Pedido finalizado', '2025-05-27 08:26:33', '2025-05-27 21:59:54'),
(2, 2, 'Pedido finalizado', '2025-05-27 22:07:05', '2025-05-27 22:17:55'),
(3, 2, 'Pedido finalizado', '2025-05-27 22:18:09', '2025-05-27 22:21:35'),
(4, 2, 'Pedido finalizado', '2025-05-27 22:21:42', '2025-05-27 22:21:47'),
(5, 2, 'Pedido finalizado', '2025-05-28 02:41:43', '2025-05-28 02:42:44');

-- --------------------------------------------------------

--
-- Estrutura para tabela `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('BQVC776XSgpQBEcrXNMB05wooOi1WqlzoaqslzuI', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibXJJT1lVSVpqOGVreDF5MHhxSjdSaG1HM21ReEFwZEtpRHpMVUYwSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9wZWRpZG9zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MjoibG9naW5fYWRtaW5fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1748397014),
('EkDpTwor4UYTX7UssHyHObvlBkG3z8SUCZqZc3cj', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoidG1GMDNKeFJkV2RjU1V4MmNtVUVRNXN3dkVvSzAyWUZvS0tYcE9mWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC8ud2VsbC1rbm93bi9hcHBzcGVjaWZpYy9jb20uY2hyb21lLmRldnRvb2xzLmpzb24iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjI4OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvc2Fjb2xhIjt9czo1MjoibG9naW5fYWRtaW5fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1748391416);

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `administradores_email_unique` (`email`);

--
-- Índices de tabela `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Índices de tabela `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Índices de tabela `cartoes`
--
ALTER TABLE `cartoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cartoes_cliente_id_foreign` (`cliente_id`);

--
-- Índices de tabela `categorias_produto`
--
ALTER TABLE `categorias_produto`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clientes_email_unique` (`email`),
  ADD UNIQUE KEY `clientes_cpf_unique` (`cpf`);

--
-- Índices de tabela `enderecos`
--
ALTER TABLE `enderecos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enderecos_cliente_id_foreign` (`cliente_id`);

--
-- Índices de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Índices de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `itens_pedido_produto_id_foreign` (`produto_id`),
  ADD KEY `itens_pedido_pedido_id_foreign` (`pedido_id`);

--
-- Índices de tabela `itens_sacola`
--
ALTER TABLE `itens_sacola`
  ADD PRIMARY KEY (`id`),
  ADD KEY `itens_sacola_produto_id_foreign` (`produto_id`),
  ADD KEY `itens_sacola_sacola_id_foreign` (`sacola_id`);

--
-- Índices de tabela `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Índices de tabela `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `metodos_pagamento`
--
ALTER TABLE `metodos_pagamento`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedidos_cliente_id_foreign` (`cliente_id`),
  ADD KEY `pedidos_endereco_id_foreign` (`endereco_id`),
  ADD KEY `pedidos_metodo_pagamento_id_foreign` (`metodo_pagamento_id`),
  ADD KEY `pedidos_cartao_id_foreign` (`cartao_id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produtos_categoria_id_foreign` (`categoria_id`);

--
-- Índices de tabela `sacola`
--
ALTER TABLE `sacola`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sacola_cliente_id_foreign` (`cliente_id`);

--
-- Índices de tabela `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `cartoes`
--
ALTER TABLE `cartoes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `categorias_produto`
--
ALTER TABLE `categorias_produto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `enderecos`
--
ALTER TABLE `enderecos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `itens_sacola`
--
ALTER TABLE `itens_sacola`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `metodos_pagamento`
--
ALTER TABLE `metodos_pagamento`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `sacola`
--
ALTER TABLE `sacola`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `cartoes`
--
ALTER TABLE `cartoes`
  ADD CONSTRAINT `cartoes_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `enderecos`
--
ALTER TABLE `enderecos`
  ADD CONSTRAINT `enderecos_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD CONSTRAINT `itens_pedido_pedido_id_foreign` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `itens_pedido_produto_id_foreign` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `itens_sacola`
--
ALTER TABLE `itens_sacola`
  ADD CONSTRAINT `itens_sacola_produto_id_foreign` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `itens_sacola_sacola_id_foreign` FOREIGN KEY (`sacola_id`) REFERENCES `sacola` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_cartao_id_foreign` FOREIGN KEY (`cartao_id`) REFERENCES `cartoes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedidos_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedidos_endereco_id_foreign` FOREIGN KEY (`endereco_id`) REFERENCES `enderecos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedidos_metodo_pagamento_id_foreign` FOREIGN KEY (`metodo_pagamento_id`) REFERENCES `metodos_pagamento` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias_produto` (`id`);

--
-- Restrições para tabelas `sacola`
--
ALTER TABLE `sacola`
  ADD CONSTRAINT `sacola_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
