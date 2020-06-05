-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29-Maio-2020 às 02:35
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_intranet`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_anexo`
--

CREATE TABLE `tb_anexo` (
  `id` int(11) NOT NULL,
  `id_documento` int(11) NOT NULL,
  `caminho` varchar(256) COLLATE utf8_bin NOT NULL,
  `data` datetime NOT NULL,
  `nome` varchar(256) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_categorias`
--

CREATE TABLE `tb_categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(256) COLLATE utf8_bin NOT NULL,
  `departamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_departamento`
--

CREATE TABLE `tb_departamento` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `gestor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `tb_departamento`
--

INSERT INTO `tb_departamento` (`id`, `nome`, `gestor`) VALUES
(7, 'Faturamento', NULL),
(16, 'Contas a Pagar', 14),
(19, 'Marketing', 15),
(20, 'Contabilidade', 8);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_documentos`
--

CREATE TABLE `tb_documentos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(150) COLLATE utf8_bin NOT NULL,
  `arquivo` longblob NOT NULL,
  `tipo` varchar(15) COLLATE utf8_bin NOT NULL,
  `tamanho` int(11) NOT NULL,
  `dtHrEnvio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_log_documento`
--

CREATE TABLE `tb_log_documento` (
  `id` int(11) NOT NULL,
  `id_documento` int(11) NOT NULL,
  `descricao` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `departamento` int(11) NOT NULL,
  `ip` varchar(30) COLLATE utf8_bin NOT NULL,
  `host` varchar(30) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_permissao`
--

CREATE TABLE `tb_permissao` (
  `id` int(11) NOT NULL,
  `cad_usu_insert` tinyint(1) NOT NULL DEFAULT 0,
  `cad_usu_update` tinyint(1) DEFAULT 0,
  `cad_usu_delete` tinyint(1) NOT NULL DEFAULT 0,
  `cad_dep_insert` tinyint(1) NOT NULL DEFAULT 0,
  `cad_dep_update` tinyint(1) NOT NULL DEFAULT 0,
  `cad_dep_delete` tinyint(1) NOT NULL DEFAULT 0,
  `cad_cat_insert` tinyint(1) NOT NULL DEFAULT 0,
  `cad_cat_update` tinyint(1) NOT NULL DEFAULT 0,
  `cad_cat_delete` tinyint(1) NOT NULL DEFAULT 0,
  `cad_doc_insert` tinyint(1) NOT NULL DEFAULT 0,
  `cad_doc_update` tinyint(1) NOT NULL DEFAULT 0,
  `cad_doc_delete` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuarios`
--

CREATE TABLE `tb_usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) COLLATE utf8_bin NOT NULL,
  `usuario` varchar(45) COLLATE utf8_bin NOT NULL,
  `senha` varchar(200) COLLATE utf8_bin NOT NULL,
  `departamento` int(11) DEFAULT NULL,
  `gestor` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `tb_usuarios`
--

INSERT INTO `tb_usuarios` (`id`, `nome`, `usuario`, `senha`, `departamento`, `gestor`) VALUES
(8, 'Diego', 'diego', '$2y$10$HIe92bOlO.sHkCpAioiy0.bFOX.Uwi4sGL8cTg/vlssoHjpt47TiK', 2, 1),
(15, 'Robson Quedevez', 'robson', '$2y$10$3Q6ZzbQO4BvpOY9TB4oWoe1lkm3alMc6i7CipmccMo7c7i1huVV8W', 7, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tb_anexo`
--
ALTER TABLE `tb_anexo`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_categorias`
--
ALTER TABLE `tb_categorias`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_departamento`
--
ALTER TABLE `tb_departamento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gestor` (`gestor`);

--
-- Índices para tabela `tb_documentos`
--
ALTER TABLE `tb_documentos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_usuarios`
--
ALTER TABLE `tb_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_anexo`
--
ALTER TABLE `tb_anexo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_categorias`
--
ALTER TABLE `tb_categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_departamento`
--
ALTER TABLE `tb_departamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `tb_documentos`
--
ALTER TABLE `tb_documentos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_usuarios`
--
ALTER TABLE `tb_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
