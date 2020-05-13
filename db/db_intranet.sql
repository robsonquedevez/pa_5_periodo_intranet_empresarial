-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13-Maio-2020 às 02:21
-- Versão do servidor: 10.4.8-MariaDB
-- versão do PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
-- Estrutura da tabela `tb_departamento`
--

CREATE TABLE `tb_departamento` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `gestor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
-- Estrutura da tabela `tb_noticias`
--

CREATE TABLE `tb_noticias` (
  `id` int(11) NOT NULL,
  `titulo` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `fonte` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `conteudo` varchar(1000) COLLATE utf8_bin DEFAULT NULL,
  `imagem` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) COLLATE utf8_bin NOT NULL,
  `usuario` varchar(45) COLLATE utf8_bin NOT NULL,
  `senha` varchar(200) COLLATE utf8_bin NOT NULL,
  `departamento` int(11) DEFAULT NULL,
  `gestor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Índices para tabelas despejadas
--

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
-- Índices para tabela `tb_noticias`
--
ALTER TABLE `tb_noticias`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departamento` (`departamento`),
  ADD KEY `gestor` (`gestor`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_departamento`
--
ALTER TABLE `tb_departamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_documentos`
--
ALTER TABLE `tb_documentos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_noticias`
--
ALTER TABLE `tb_noticias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `tb_departamento`
--
ALTER TABLE `tb_departamento`
  ADD CONSTRAINT `tb_departamento_ibfk_1` FOREIGN KEY (`gestor`) REFERENCES `tb_usuario` (`id`);

--
-- Limitadores para a tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD CONSTRAINT `tb_usuario_ibfk_1` FOREIGN KEY (`departamento`) REFERENCES `tb_departamento` (`id`),
  ADD CONSTRAINT `tb_usuario_ibfk_2` FOREIGN KEY (`gestor`) REFERENCES `tb_usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
