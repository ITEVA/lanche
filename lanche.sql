-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 24-Jan-2017 às 16:20
-- Versão do servidor: 5.7.12
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lanche`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cardapio`
--

CREATE TABLE `cardapio` (
  `id` int(11) NOT NULL,
  `data` date DEFAULT NULL,
  `hora_inicio` time(6) DEFAULT NULL,
  `hora_final` time(6) DEFAULT NULL,
  `id_empregador` int(11) DEFAULT NULL,
  `turno` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cardapio`
--

INSERT INTO `cardapio` (`id`, `data`, `hora_inicio`, `hora_final`, `id_empregador`, `turno`) VALUES
(5, '2017-01-20', '07:30:00.000000', '08:30:00.000000', 1, 1),
(6, '2017-01-20', '12:00:00.000000', '15:00:00.000000', 1, 0),
(7, '2017-01-21', '07:30:00.000000', '08:30:00.000000', 1, 1),
(10, '2017-01-23', '07:00:00.000000', '11:59:00.000000', 1, 1),
(11, '2017-01-23', '13:00:00.000000', '19:30:00.000000', 1, 0),
(12, '2017-01-24', '07:30:00.000000', '09:30:00.000000', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `empregador`
--

CREATE TABLE `empregador` (
  `id` int(11) NOT NULL,
  `cnpj` varchar(45) DEFAULT NULL,
  `razaosocial` varchar(100) DEFAULT NULL,
  `nomefantasia` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `empregador`
--

INSERT INTO `empregador` (`id`, `cnpj`, `razaosocial`, `nomefantasia`) VALUES
(1, '03.502.169/0001-38', 'Iteva', 'Instituto Tecnológico e Vocacional Avançado'),
(2, '00.000.000/0000-00', 'Teste', 'Teste');

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('nicolasmatos0905@gmail.com', '35ee6787683c6ecc19df073f6eb987b2e248eb99a58bac7cf367b50000716687', '2017-01-17 17:58:44');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `data` date DEFAULT NULL,
  `preco` double DEFAULT NULL,
  `observacao` longtext,
  `turno` tinyint(1) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_cardapio` int(11) DEFAULT NULL,
  `id_empregador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `data`, `preco`, `observacao`, `turno`, `id_usuario`, `id_cardapio`, `id_empregador`) VALUES
(6, '2017-01-20', 3.2, '', 1, 1, 5, 1),
(15, '2017-01-20', 1.5, '', 0, 1, 6, 1),
(21, '2017-01-23', 6.2, '', 1, 1, 10, 1),
(22, '2017-01-23', 20.5, '', 0, 1, 11, 1),
(23, '2017-01-23', 4.5, '', 0, 4, 11, 1),
(24, '2017-01-23', 4.5, '', 0, 2, 11, 1),
(25, '2017-01-23', 18, '', 0, 3, 11, 1),
(26, '2017-01-23', 15, '', 0, 5, 11, 1),
(27, '2017-01-24', 7.15, '', 1, 1, 12, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissoes`
--

CREATE TABLE `permissoes` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `descricao` longtext,
  `id_empregador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `permissoes`
--

INSERT INTO `permissoes` (`id`, `nome`, `descricao`, `id_empregador`) VALUES
(2, 'Usuário Comum', 'Acesso limitado a perfil e pedido no sistema', 1),
(3, 'Administrador', 'Acesso total ao sistema', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissoes_classes`
--

CREATE TABLE `permissoes_classes` (
  `id` int(11) NOT NULL,
  `classe` varchar(100) DEFAULT NULL,
  `id_permissao` int(11) DEFAULT NULL,
  `id_empregador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `permissoes_classes`
--

INSERT INTO `permissoes_classes` (`id`, `classe`, `id_permissao`, `id_empregador`) VALUES
(135, 'perfil', 2, 1),
(136, 'pedido', 2, 1),
(137, 'inicio', 3, 1),
(138, 'user', 3, 1),
(139, 'permissao', 3, 1),
(140, 'produto', 3, 1),
(141, 'cardapio', 3, 1),
(142, 'perfil', 3, 1),
(143, 'pedido', 3, 1),
(144, 'relatorio', 3, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `preco` double DEFAULT NULL,
  `especificacao` varchar(255) DEFAULT NULL,
  `id_empregador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `preco`, `especificacao`, `id_empregador`) VALUES
(1, 'Sanduiche misto', 3.2, '', 1),
(2, 'Sanduiche de queijo', 2.25, '', 1),
(3, 'Canja', 2.25, '', 1),
(4, 'Café com leite', 0.75, '', 1),
(5, 'Vitamina de goiaba', 1.5, '', 1),
(6, 'Bananada', 3, '', 1),
(7, 'Vitamina de açai', 5, '', 1),
(8, 'Colher de leite em pó', 1, '', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto_cardapio`
--

CREATE TABLE `produto_cardapio` (
  `id` int(11) NOT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `id_cardapio` int(11) DEFAULT NULL,
  `id_empregador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produto_cardapio`
--

INSERT INTO `produto_cardapio` (`id`, `id_produto`, `id_cardapio`, `id_empregador`) VALUES
(112, 1, 5, 1),
(113, 2, 5, 1),
(114, 3, 5, 1),
(115, 4, 5, 1),
(120, 1, 7, 1),
(121, 2, 7, 1),
(122, 3, 7, 1),
(123, 4, 7, 1),
(127, 5, 6, 1),
(154, 1, 10, 1),
(155, 2, 10, 1),
(156, 4, 10, 1),
(158, 5, 11, 1),
(159, 6, 11, 1),
(160, 7, 11, 1),
(161, 8, 11, 1),
(165, 1, 12, 1),
(166, 2, 12, 1),
(167, 4, 12, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto_pedido`
--

CREATE TABLE `produto_pedido` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `quantidade` double DEFAULT NULL,
  `data` date DEFAULT NULL,
  `turno` tinyint(1) DEFAULT NULL,
  `preco_unitario` double DEFAULT NULL,
  `preco_total` double DEFAULT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `id_empregador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produto_pedido`
--

INSERT INTO `produto_pedido` (`id`, `nome`, `quantidade`, `data`, `turno`, `preco_unitario`, `preco_total`, `id_pedido`, `id_empregador`) VALUES
(58, 'Sanduiche misto', 1, '2017-01-20', 1, 3.2, 3.2, 6, 1),
(68, 'Vitamina de goiaba', 1, '2017-01-20', 0, 1.5, 1.5, 15, 1),
(80, 'Sanduiche misto', 2, '2017-01-23', 1, 3.2, 3.2, 21, 1),
(81, 'Sanduiche de queijo', 1, '2017-01-23', 1, 2.25, 2.25, 21, 1),
(82, 'Café com leite', 1, '2017-01-23', 1, 0.75, 0.75, 21, 1),
(84, 'Vitamina de goiaba', 1, '2017-01-23', 0, 1.5, 1.5, 22, 1),
(85, 'Bananada', 3, '2017-01-23', 0, 3, 9, 22, 1),
(86, 'Vitamina de açai', 1, '2017-01-23', 0, 5, 5, 22, 1),
(87, 'Colher de leite em pó', 5, '2017-01-23', 0, 1, 5, 22, 1),
(88, 'Vitamina de açai', 0.5, '2017-01-23', 0, 5, 2.5, 23, 1),
(89, 'Colher de leite em pó', 2, '2017-01-23', 0, 1, 2, 23, 1),
(90, 'Bananada', 1, '2017-01-23', 0, 3, 3, 24, 1),
(91, 'Vitamina de goiaba', 1, '2017-01-23', 0, 1.5, 1.5, 24, 1),
(92, 'Vitamina de açai', 3, '2017-01-23', 0, 5, 15, 25, 1),
(93, 'Colher de leite em pó', 3, '2017-01-23', 0, 1, 3, 25, 1),
(94, 'Bananada', 5, '2017-01-23', 0, 3, 15, 26, 1),
(95, 'Sanduiche misto', 2, '2017-01-24', 1, 3.2, 6.4, 27, 1),
(96, 'Café com leite', 1, '2017-01-24', 1, 0.75, 0.75, 27, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `apelido` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `foto` varchar(100) DEFAULT 'default.jpg',
  `status` tinyint(1) DEFAULT '1',
  `permissao` varchar(100) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_empregador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `nome`, `apelido`, `email`, `password`, `foto`, `status`, `permissao`, `remember_token`, `created_at`, `updated_at`, `id_empregador`) VALUES
(1, 'Ruan Nícolas da Silva Matos', 'Nícolas Matos', 'nicolasmatos0905@gmail.com', '', 'nicolas_2.jpg', 1, '3', 'DT1snVakbukaD6GV0eWQO354922crvhUKJOVbSAz38HMtwLuc0WuK77h87vC', NULL, '2017-01-24 19:17:48', 1),
(2, 'Maria Giselly Rebouças Azevedo', 'Giselly Rebouças', 'giselly.reboucas@iteva.org.br', '$2y$10$hifyhF4DHWFjHHEylvjqOes860X0F./yAP.WXKTuvyINrko2Iy6fC', 'giselly.jpg', 1, '2', '3eJvc02jnxy0rgIKLAM5vLa2zdee0onczxGkkzWIdQ4afWHMvUdb9VmzzfUC', '2016-12-21 22:36:57', '2017-01-24 16:02:06', 1),
(3, 'Josinaldo da Silva Batista', 'Josinaldo Batista', 'josinaldo.batista@iteva.org.br', '$2y$10$tv0Ar2TVB2HVjt.PolQIXO7wzlLve4OSIBg.HQefmLoKnwPvOUqXW', 'josinaldo_1.jpg', 1, '3', 'v33zQp0Y2YzzUlnfpb0nA54uQFNjnGFRuL9rOQGyN4SvCO3xbkrdNSBy4Hlr', '2016-12-21 22:52:57', '2017-01-24 16:04:09', 1),
(4, 'Reginaldo Maranhão Sousa', 'Reginaldo Maranhão', 'reginaldo.maranhao@iteva.org.br', '$2y$10$TmJrQFwbj8dQrPamdyR32eAb/dczuHGxtepF97EY16yYyWzswQg6i', 'Reginaldo.jpg', 1, '3', 'rwhFz01eH2GGQqPudY2rTOUWcmEf9tw2odhIRIBeB7bVKQ9QkKs9uumEPzGi', '2016-12-22 14:47:54', '2017-01-24 19:05:59', 1),
(5, 'Antônio Miguel de Sousa Lima', 'Miguel Lima', 'miguel.lima@iteva.org.br', '$2y$10$jldOS53/emHSZPpDU69QYeGQHQA14.qE.qpoffzGr4XLdhuR14dMW', 'miguel.jpg', 1, '2', 'HYukXTHXyvnamsnZSiAuAR7mGROg2qYheTLFgxyqipdRS8s7VXFExvMsOoKg', '2017-01-19 20:21:12', '2017-01-24 15:59:48', 1),
(6, 'Isabela Borges Pereira', 'Isabela Borges', 'isabela.borges@iteva.org.br', '$2y$10$0WHi3M27Cey//tcloBg1tOCSkkXb4/zXa.hAMeZr235E1C3TUGo0q', 'isabela_1.jpg', 1, '3', NULL, '2017-01-24 15:48:05', '2017-01-24 16:00:11', 1),
(7, 'Anderson Ribeiro Pires', 'Anderson Pires', 'anderson@iteva.org.br', '$2y$10$0cgniMvOeafNCGhc45ZWme5NFO06y/hkqtSUJI9JTANsT.AUmUvVe', 'anderson_1.jpg', 1, '2', NULL, '2017-01-24 15:48:54', '2017-01-24 15:59:41', 1),
(8, 'Fábio Cezar Aidar Beneduce', 'Fabio Beneduce', 'fabio@iteva.org.br', '$2y$10$iY.Qg6yi46mSn0CFV9cA.eHF9LSlBmKeXrGkgNPG.qqKS.f1H0wHW', 'fabio_1.jpg', 1, '2', NULL, '2017-01-24 15:49:23', '2017-01-24 16:00:04', 1),
(9, 'Israel Araújo de Oliveira', 'Israel de Oliveira', 'israel.araujo@iteva.org.br', '$2y$10$leKumKFev9LScHiLawMuHeWhgsN69pM2n/U6lI9NBvu/mD.6NJBpq', 'israel_1.jpg', 1, '2', NULL, '2017-01-24 15:50:05', '2017-01-24 16:00:17', 1),
(10, 'Jaqueline Thayná José Mendes', 'Jaqueline Thayná', 'jaqueline.thayna@iteva.org.br', '$2y$10$0ShijPHAz.ERjExID1wqvuKPYdAoGBCdmU5Y9m8IUiq/vWSpwm72S', 'jaquet_1.jpg', 1, '2', NULL, '2017-01-24 15:51:57', '2017-01-24 16:00:55', 1),
(11, 'Jaqueline da Silva Ferreira', 'Jaqueline Ferreira', 'jaqueline.ferreira@iteva.org.br', '$2y$10$pWP26.3UHN5qQZkM4Ju6W.XEFMrILMUOZ1/FVsfG4sY/xjbD2aWQG', 'jaquef_1.jpg', 1, '2', NULL, '2017-01-24 15:52:30', '2017-01-24 16:00:45', 1),
(12, 'João Lucas Rodrigues do Nascimento', 'João Lucas', 'joaolucas@iteva.org.br', '$2y$10$sAgvI.yJXefiB/EWWasyze4sSFJJKGEs8/Jt4zDEUc1HqQMtFk1y2', 'joao_1.jpg', 1, '2', NULL, '2017-01-24 15:53:16', '2017-01-24 16:01:30', 1),
(13, 'Kananda Menezes de Freitas', 'Kananda Freitas', 'kananda.freitas@iteva.org.br', '$2y$10$YFhCmgZ8TptVhe2MUYwSx.PP/A8ms4Ta.1IukNRlLcSvuRJsENdp.', 'kananda_1.jpg', 1, '3', NULL, '2017-01-24 15:54:54', '2017-01-24 16:01:39', 1),
(14, 'Vanessa Saraiva Belém', 'Vanessa Belém', 'vanessa@iteva.org.br', '$2y$10$j3lX9VKcbVaK8F1MApO45.F7yGYoFmDZTVabi.aei3OucDgWnjc3.', 'vanessa_1.jpg', 1, '2', NULL, '2017-01-24 15:55:30', '2017-01-24 16:02:43', 1),
(15, 'Francisco Dimas Silva da Rocha', 'Dimas Silva', 'dimas.silva@iteva.org.br', '$2y$10$6eeJguqr1NRpaNyny9xzhuaG7e/n/mXj5hX2nEXZ.fIJEr9i56eFG', 'dimas_1.jpg', 1, '2', NULL, '2017-01-24 15:56:46', '2017-01-24 15:59:58', 1),
(16, 'Pedro Henrique Freitas Vasconselos', 'Pedro Henrique', 'pedro.henrique@iteva.org.br', '$2y$10$nzzbCNhebRI5unXvv9Z9.ODn1ihWzNpsEPwHI7g4AjBPSiWCjqsaC', 'pedro.jpg', 1, '2', NULL, '2017-01-24 15:57:56', '2017-01-24 16:03:44', 1),
(17, 'Sara Belém Beneduce', 'Sara Beneduce', 'sara@iteva.org.br', '$2y$10$hS0ENSYJYV9iEkS/wGMaZ.MT52cmIGjq3jW4r0mokYzAXtzmF5xAO', 'sara_1.jpg', 1, '2', NULL, '2017-01-24 15:58:28', '2017-01-24 16:02:34', 1),
(18, 'Jair da Silva Ferreira', 'Jair Ferreira', 'jair.ferreira@iteva.org.br', '$2y$10$Ye4A9ciIMMiybj3cKPc/t.KqewPElQoLs6PD9Ms2B8hnUUy4PxuYu', 'jair_1.jpg', 1, '2', NULL, '2017-01-24 15:58:55', '2017-01-24 16:00:38', 1),
(19, 'Jefferson Wilker Souza Barreto', 'Jefferson Wilker', 'jefferson.wilker@iteva.org.br', '$2y$10$BwdCNPvma64ZiT9wIFBM1OwyE/QN7JqlXVdmzrvk.dP5qSG5Hb6fa', 'jefferson.jpg', 1, '2', NULL, '2017-01-24 15:59:30', '2017-01-24 16:01:01', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cardapio`
--
ALTER TABLE `cardapio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_empregador_cardapio_idx` (`id_empregador`);

--
-- Indexes for table `empregador`
--
ALTER TABLE `empregador`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario_pedido_idx` (`id_usuario`),
  ADD KEY `fk_empregador_pedido_idx` (`id_empregador`),
  ADD KEY `fk_cardapio_pedido_idx` (`id_cardapio`);

--
-- Indexes for table `permissoes`
--
ALTER TABLE `permissoes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome_UNIQUE` (`nome`),
  ADD KEY `fk_empregador_users_idx` (`id_empregador`);

--
-- Indexes for table `permissoes_classes`
--
ALTER TABLE `permissoes_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_permissao_idx` (`id_permissao`),
  ADD KEY `fk_empregador_permissoes_classe_idx` (`id_empregador`);

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_produto_empregador_idx` (`id_empregador`);

--
-- Indexes for table `produto_cardapio`
--
ALTER TABLE `produto_cardapio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_produto_idx` (`id_produto`),
  ADD KEY `fk_cardapio_idx` (`id_cardapio`),
  ADD KEY `fk_empregador_idx` (`id_empregador`);

--
-- Indexes for table `produto_pedido`
--
ALTER TABLE `produto_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pedido_idx` (`id_pedido`),
  ADD KEY `fk_empregador_p_p_idx` (`id_empregador`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD KEY `fk_empregador_users_idx` (`id_empregador`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cardapio`
--
ALTER TABLE `cardapio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `empregador`
--
ALTER TABLE `empregador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `permissoes`
--
ALTER TABLE `permissoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `permissoes_classes`
--
ALTER TABLE `permissoes_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;
--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `produto_cardapio`
--
ALTER TABLE `produto_cardapio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;
--
-- AUTO_INCREMENT for table `produto_pedido`
--
ALTER TABLE `produto_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `cardapio`
--
ALTER TABLE `cardapio`
  ADD CONSTRAINT `fk_emp_cardapio` FOREIGN KEY (`id_empregador`) REFERENCES `empregador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_cadapio_p` FOREIGN KEY (`id_cardapio`) REFERENCES `cardapio` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_empregador_pedido` FOREIGN KEY (`id_empregador`) REFERENCES `empregador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_pedido` FOREIGN KEY (`id_usuario`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `permissoes`
--
ALTER TABLE `permissoes`
  ADD CONSTRAINT `fk_empregador_permissoes` FOREIGN KEY (`id_empregador`) REFERENCES `empregador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `permissoes_classes`
--
ALTER TABLE `permissoes_classes`
  ADD CONSTRAINT `fk_empregador_permissoes_classe` FOREIGN KEY (`id_empregador`) REFERENCES `empregador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_permissao_classe` FOREIGN KEY (`id_permissao`) REFERENCES `permissoes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_produto_empregador` FOREIGN KEY (`id_empregador`) REFERENCES `empregador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `produto_cardapio`
--
ALTER TABLE `produto_cardapio`
  ADD CONSTRAINT `fk_cardapio` FOREIGN KEY (`id_cardapio`) REFERENCES `cardapio` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_empregador` FOREIGN KEY (`id_empregador`) REFERENCES `empregador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_produto` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `produto_pedido`
--
ALTER TABLE `produto_pedido`
  ADD CONSTRAINT `fk_empregador_p_p` FOREIGN KEY (`id_empregador`) REFERENCES `empregador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_empregador_users` FOREIGN KEY (`id_empregador`) REFERENCES `empregador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
