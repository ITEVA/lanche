-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 06-Fev-2017 às 19:25
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
  `descricao` varchar(255) DEFAULT NULL,
  `hora_inicio` time(6) DEFAULT NULL,
  `hora_final` time(6) DEFAULT NULL,
  `id_empregador` int(11) DEFAULT NULL,
  `turno` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cardapio`
--

INSERT INTO `cardapio` (`id`, `data`, `descricao`, `hora_inicio`, `hora_final`, `id_empregador`, `turno`) VALUES
(2, '2017-01-25', NULL, '13:00:00.000000', '15:00:00.000000', 1, 0),
(4, '2017-01-26', 'Sanduíche e bolo fofo Sanduíche e bolo fofo Sanduíche e bolo fofo Sanduíche e bolo fofo', '07:45:00.000000', '11:45:00.000000', 1, 1),
(5, '2017-01-27', 'Sanduiche natural', '07:30:00.000000', '08:30:00.000000', 1, 1),
(6, '2017-01-26', 'Vitaminas', '13:00:00.000000', '17:00:00.000000', 1, 0),
(7, '2017-02-01', 'dasfdasfas', '12:00:00.000000', '17:00:00.000000', 1, 0),
(8, '2017-02-02', 'sadf', '06:00:00.000000', '08:00:00.000000', 1, 1);

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
('nicolasmatos0905@gmail.com', '35ee6787683c6ecc19df073f6eb987b2e248eb99a58bac7cf367b50000716687', '2017-01-17 17:58:44'),
('pedro.henrique@iteva.org.br', 'a07d2ddce3a20602def3bb2b8674443ea890373802a96ec674811c487f8e0ae7', '2017-01-26 13:55:49');

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
  `corrigido` tinyint(1) DEFAULT NULL,
  `motivo_correcao` longtext,
  `data_correcao` datetime DEFAULT NULL,
  `responsavel_correcao` varchar(255) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_cardapio` int(11) DEFAULT NULL,
  `id_empregador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `data`, `preco`, `observacao`, `turno`, `corrigido`, `motivo_correcao`, `data_correcao`, `responsavel_correcao`, `id_usuario`, `id_cardapio`, `id_empregador`) VALUES
(10, '2017-01-25', 0.6799999999999999, '', 0, 0, NULL, NULL, NULL, 10, 2, 1),
(12, '2017-01-25', 0.93, '', 0, NULL, NULL, NULL, NULL, 5, 2, 1),
(13, '2017-01-25', 6.29, '', 0, NULL, NULL, NULL, NULL, 17, 2, 1),
(14, '2017-01-25', 1.86, '', 0, NULL, NULL, NULL, NULL, 15, 2, 1),
(15, '2017-01-25', 5.85, '', 0, NULL, NULL, NULL, NULL, 8, 2, 1),
(16, '2017-01-25', 6.32, '', 0, NULL, NULL, NULL, NULL, 26, 2, 1),
(17, '2017-01-26', 0.99, '', 1, NULL, NULL, NULL, NULL, 17, 4, 1),
(18, '2017-01-26', 2.33, '', 1, NULL, NULL, NULL, NULL, 18, 4, 1),
(19, '2017-01-26', 4.09, '', 1, NULL, NULL, NULL, NULL, 19, 4, 1),
(20, '2017-01-26', 0.695, '', 1, 1, '', '2017-01-26 16:17:00', 'Nícolas Matos', 10, 4, 1),
(21, '2017-01-26', 0.99, '', 1, NULL, NULL, NULL, NULL, 2, 4, 1),
(22, '2017-01-26', 4.4399999999999995, 'No lugar do pão de forma colocar pão carioquinha', 1, NULL, NULL, NULL, NULL, 16, 4, 1),
(23, '2017-01-26', 1.98, '', 1, NULL, NULL, NULL, NULL, 9, 4, 1),
(24, '2017-01-26', 0.99, '', 1, NULL, NULL, NULL, NULL, 24, 4, 1),
(25, '2017-01-26', 2.33, '', 1, NULL, NULL, NULL, NULL, 5, 4, 1),
(26, '2017-01-26', 3.37, '', 1, NULL, NULL, NULL, NULL, 22, 4, 1),
(27, '2017-01-26', 1.3399999999999999, '', 1, NULL, NULL, NULL, NULL, 11, 4, 1),
(28, '2017-01-26', 1.23, '', 1, NULL, NULL, NULL, NULL, 25, 4, 1),
(29, '2017-01-26', 0.88, '', 1, NULL, NULL, NULL, NULL, 6, 4, 1),
(31, '2017-01-26', 0.99, '', 1, NULL, NULL, NULL, NULL, 3, 4, 1),
(32, '2017-01-26', 1.49, '', 1, NULL, NULL, NULL, NULL, 8, 4, 1),
(33, '2017-01-26', 0.745, '', 1, 0, NULL, NULL, NULL, 7, 4, 1),
(34, '2017-01-26', 2.09, '', 1, NULL, NULL, NULL, NULL, 1, 4, 1),
(41, '2017-01-26', 1.65, '1', 0, 1, '1', '2017-01-26 15:58:00', 'Nícolas Matos', 20, 6, 1),
(42, '2017-01-26', 1.65, '', 0, 1, '', '2017-01-26 16:17:00', 'Nícolas Matos', 1, 6, 1),
(43, '2017-01-26', 0.48, '', 0, 1, '', '2017-01-26 16:49:00', 'Nícolas Matos', 7, 2, 1),
(44, '2017-01-27', 1.39, '', 1, 1, '1', '2017-01-26 16:55:00', 'Nícolas Matos', 20, 5, 1),
(45, '2017-01-27', 6.890000000000001, '', 1, NULL, NULL, NULL, NULL, 1, 5, 1),
(46, '2017-02-01', 2.15, 'hehe', 0, 1, '69', '2017-02-01 15:20:00', 'Nícolas Matos', 1, 7, 1),
(47, '2017-02-02', 1.075, '', 1, NULL, NULL, NULL, NULL, 1, 8, 1);

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
(173, 'inicio', 3, 1),
(174, 'user', 3, 1),
(175, 'permissao', 3, 1),
(176, 'produto', 3, 1),
(177, 'cardapio', 3, 1),
(178, 'perfil', 3, 1),
(179, 'pedido', 3, 1),
(180, 'corrigirPedido', 3, 1),
(181, 'relatorio', 3, 1);

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
(1, 'Vitamina de goiaba', 1.65, '', 1),
(2, 'Vitamina de maracujá', 2.15, '', 1),
(4, 'Vitamina de açaí', 3.35, '', 1),
(5, 'Vitamina de banana', 1.86, '', 1),
(6, 'Vitamina de açaí c/ banana', 3.83, '', 1),
(7, 'Leite com nescau', 1.39, '', 1),
(8, 'Copo de leite', 0.82, '', 1),
(9, 'Vitamina de acerola', 2.4, '', 1),
(10, 'Colher de sopa de leite em pó', 0.44, '', 1),
(11, 'Banana', 0.48, '', 1),
(12, 'Maçã', 0.5, '', 1),
(20, 'Vitamina de morango', 2.71, '', 1),
(22, 'Vitamina de açaí com polpa extra', 5.85, 'Contém uma polpa de açaí a mais.', 1),
(23, 'Suco de goiaba', 0.8, '', 1),
(24, 'Suco de maracujá', 1.3, '', 1),
(25, 'Copo de leite adoçado', 0.87, '', 1),
(27, 'Clube social', 0.45, '', 1),
(28, 'Fatia de pão de forma não chapada', 0.19, 'Fatia sem nada', 1),
(29, 'Fatia de pão de forma chapada', 0.33, '', 1),
(30, 'Pão de forma c/ margarina chapado', 0.53, '', 1),
(31, 'Pão de forma c/ requeijão não chapado', 0.75, '', 1),
(32, 'Sand. de queijo no pão de forma c/ margarina não chapado', 1.09, '', 1),
(33, 'Sand. de queijo no pão de forma c/ requeijão chapado', 1.32, '', 1),
(34, 'Sand. misto no pão de forma c/ margarina chapado', 1.55, '', 1),
(35, 'Sand. misto no pão de forma c/ requeijão chapado', 1.78, '', 1),
(36, 'Sand. de ovos no pão de forma c/ margarina chapado', 1.09, '', 1),
(37, 'Sand. de ovos no pão de forma c/ requeijão chapado', 1.33, '', 1),
(38, 'Sand. de queijo e ovo no pão de forma c/ margarina chapado', 1.68, '', 1),
(39, 'Sand. de queijo e ovo no pão de forma c/ requeijão chapado', 1.92, '', 1),
(40, 'Sand. completo no pão de forma c/ margarina chapado', 2.17, '', 1),
(41, 'Sand. completo no pão de forma c/ requeijão chapado', 2.4, '', 1),
(42, 'Fatia de pão integral não chapada', 0.28, '', 1),
(43, 'Pão de forma c/ margarina não chapado', 0.53, '', 1),
(44, 'Pão de forma c/ requeijão chapado', 0.75, '', 1),
(45, 'Sand. de queijo no pão de forma c/ margarina chapado', 1.09, '', 1),
(46, 'Sand. de queijo no pão de forma c/ requeijão não chapado', 1.32, '', 1),
(47, 'Sand. misto no pão de forma c/ margarina não chapado', 1.55, '', 1),
(48, 'Sand. misto no pão de forma c/ requeijão não chapado', 1.78, '', 1),
(49, 'Sand. de ovos no pão de forma c/ margarina não chapado', 1.09, '', 1),
(50, 'Sand. de ovos no pão de forma c/ requeijão não chapado', 1.33, '', 1),
(51, 'Sand. de queijo e ovo no pão de forma c/ margarina não chapado', 1.68, '', 1),
(52, 'Sand. de queijo e ovo no pão de forma c/ requeijão não chapado', 1.92, '', 1),
(53, 'Sand. completo no pão de forma c/ margarina não chapado', 2.17, '', 1),
(54, 'Sand. completo no pão de forma c/ requeijão não chapado', 2.4, '', 1),
(55, 'Fatia de pão integral chapada', 0.42, '', 1),
(56, 'Pão integral c/ margarina chapado', 0.71, '', 1),
(57, 'Pão integral c/ margarina não chapado', 0.71, '', 1),
(58, 'Pão integral c/ requeijão chapado', 0.93, '', 1),
(59, 'Pão integral c/ requeijão não chapado', 0.93, '', 1),
(60, 'Sand. de queijo no pão integral c/ margarina chapado', 1.27, '', 1),
(61, 'Sand. de queijo no pão integral c/ margarina não chapado', 1.27, '', 1),
(62, 'Sand. de queijo no pão integral c/ requeijão chapado', 1.49, '', 1),
(63, 'Sand. de queijo no pão integral c/ requeijão não chapado', 1.49, '', 1),
(64, 'Sand. misto no pão integral c/ margarina chapado', 1.73, '', 1),
(65, 'Sand. misto no pão integral c/ margarina não chapado', 1.73, '', 1),
(66, 'Sand. misto no pão integral c/ requeijão chapado', 1.96, '', 1),
(67, 'Sand. misto no pão integral c/ requeijão não chapado', 1.96, '', 1),
(68, 'Sand. de ovos no pão integral c/ margarina chapado', 1.23, '', 1),
(69, 'Sand. de ovos no pão integral c/ margarina não chapado', 1.23, '', 1),
(70, 'Sand. de ovos no pão integral c/ requeijão chapado', 1.47, '', 1),
(71, 'Sand. de ovos no pão integral c/ requeijão não chapado', 1.47, '', 1),
(72, 'Sand. de queijo e ovo no pão integral c/ margarina chapado', 1.83, '', 1),
(73, 'Sand. de queijo e ovo no pão integral c/ margarina não chapado', 1.83, '', 1),
(74, 'Sand. de queijo e ovo no pão integral c/ requeijão chapado', 2.06, '', 1),
(75, 'Sand. de queijo e ovo no pão integral c/ requeijão não chapado', 2.06, '', 1),
(76, 'Sand. completo no pão integral c/ margarina chapado', 2.35, '', 1),
(77, 'Sand. completo no pão integral c/ margarina não chapado', 2.35, '', 1),
(78, 'Sand. completo no pão integral c/ requeijão chapado', 2.59, '', 1),
(79, 'Sand. completo no pão integral c/ requeijão não chapado', 2.59, '', 1),
(80, 'Chá verde adoçado', 0.27, '', 1),
(81, 'Chá verde não adoçado', 0.24, '', 1),
(82, 'Café com leite', 0.35, '', 1),
(83, 'Bolo fofo c/ cobertura de chocolate', 0.99, '', 1),
(85, 'Vitamina de açaí com polpa extra sem açúcar', 5.7, '', 1),
(86, 'Iogute', 0, '', 1);

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
(460, 1, 2, 1),
(461, 2, 2, 1),
(462, 4, 2, 1),
(463, 5, 2, 1),
(464, 6, 2, 1),
(465, 7, 2, 1),
(466, 8, 2, 1),
(467, 9, 2, 1),
(468, 10, 2, 1),
(469, 11, 2, 1),
(470, 22, 2, 1),
(471, 23, 2, 1),
(472, 24, 2, 1),
(473, 25, 2, 1),
(1285, 2, 5, 1),
(1286, 4, 5, 1),
(1287, 5, 5, 1),
(1288, 7, 5, 1),
(1347, 7, 4, 1),
(1348, 8, 4, 1),
(1349, 11, 4, 1),
(1350, 25, 4, 1),
(1351, 28, 4, 1),
(1352, 29, 4, 1),
(1353, 30, 4, 1),
(1354, 31, 4, 1),
(1355, 32, 4, 1),
(1356, 33, 4, 1),
(1357, 34, 4, 1),
(1358, 35, 4, 1),
(1359, 36, 4, 1),
(1360, 37, 4, 1),
(1361, 38, 4, 1),
(1362, 39, 4, 1),
(1363, 40, 4, 1),
(1364, 41, 4, 1),
(1365, 42, 4, 1),
(1366, 43, 4, 1),
(1367, 44, 4, 1),
(1368, 45, 4, 1),
(1369, 46, 4, 1),
(1370, 47, 4, 1),
(1371, 48, 4, 1),
(1372, 49, 4, 1),
(1373, 50, 4, 1),
(1374, 51, 4, 1),
(1375, 52, 4, 1),
(1376, 53, 4, 1),
(1377, 54, 4, 1),
(1378, 55, 4, 1),
(1379, 56, 4, 1),
(1380, 57, 4, 1),
(1381, 58, 4, 1),
(1382, 59, 4, 1),
(1383, 60, 4, 1),
(1384, 61, 4, 1),
(1385, 62, 4, 1),
(1386, 63, 4, 1),
(1387, 64, 4, 1),
(1388, 65, 4, 1),
(1389, 66, 4, 1),
(1390, 67, 4, 1),
(1391, 68, 4, 1),
(1392, 69, 4, 1),
(1393, 70, 4, 1),
(1394, 71, 4, 1),
(1395, 72, 4, 1),
(1396, 73, 4, 1),
(1397, 74, 4, 1),
(1398, 75, 4, 1),
(1399, 76, 4, 1),
(1400, 77, 4, 1),
(1401, 78, 4, 1),
(1402, 79, 4, 1),
(1403, 82, 4, 1),
(1404, 83, 4, 1),
(1405, 1, 6, 1),
(1406, 2, 6, 1),
(1407, 4, 6, 1),
(1408, 2, 7, 1),
(1409, 2, 8, 1),
(1410, 4, 8, 1);

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
(25, 'Banana', 0.5, '2017-01-25', 0, 0.48, 0.24, 10, 1),
(26, 'Colher de sopa de leite em pó', 1, '2017-01-25', 0, 0.44, 0.44, 10, 1),
(28, 'Vitamina de banana', 0.5, '2017-01-25', 0, 1.86, 0.93, 12, 1),
(29, 'Vitamina de açaí com polpa extra', 1, '2017-01-25', 0, 5.85, 5.85, 13, 1),
(30, 'Colher de sopa de leite em pó', 1, '2017-01-25', 0, 0.44, 0.44, 13, 1),
(31, 'Vitamina de banana', 1, '2017-01-25', 0, 1.86, 1.86, 14, 1),
(33, 'Vitamina de açaí com polpa extra', 1, '2017-01-25', 0, 5.85, 5.85, 15, 1),
(34, 'Vitamina de açaí', 1, '2017-01-25', 0, 3.35, 3.35, 16, 1),
(35, 'Vitamina de maracujá', 1, '2017-01-25', 0, 2.15, 2.15, 16, 1),
(36, 'Copo de leite', 1, '2017-01-25', 0, 0.82, 0.82, 16, 1),
(37, 'Bolo fofo c/ cobertura de chocolate', 1, '2017-01-26', 1, 0.99, 0.99, 17, 1),
(38, 'Café com leite', 1, '2017-01-26', 1, 0.35, 0.35, 18, 1),
(39, 'Bolo fofo c/ cobertura de chocolate', 2, '2017-01-26', 1, 0.99, 1.98, 18, 1),
(46, 'Bolo fofo c/ cobertura de chocolate', 1, '2017-01-26', 1, 0.99, 0.99, 21, 1),
(47, 'Sand. misto no pão de forma c/ margarina chapado', 2, '2017-01-26', 1, 1.55, 3.1, 22, 1),
(48, 'Bolo fofo c/ cobertura de chocolate', 1, '2017-01-26', 1, 0.99, 0.99, 22, 1),
(49, 'Café com leite', 1, '2017-01-26', 1, 0.35, 0.35, 22, 1),
(50, 'Bolo fofo c/ cobertura de chocolate', 2, '2017-01-26', 1, 0.99, 1.98, 23, 1),
(51, 'Bolo fofo c/ cobertura de chocolate', 1, '2017-01-26', 1, 0.99, 0.99, 24, 1),
(52, 'Bolo fofo c/ cobertura de chocolate', 2, '2017-01-26', 1, 0.99, 1.98, 25, 1),
(53, 'Café com leite', 1, '2017-01-26', 1, 0.35, 0.35, 25, 1),
(55, 'Bolo fofo c/ cobertura de chocolate', 2, '2017-01-26', 1, 0.99, 1.98, 26, 1),
(56, 'Leite com nescau', 1, '2017-01-26', 1, 1.39, 1.39, 26, 1),
(57, 'Bolo fofo c/ cobertura de chocolate', 1, '2017-01-26', 1, 0.99, 0.99, 27, 1),
(58, 'Café com leite', 1, '2017-01-26', 1, 0.35, 0.35, 27, 1),
(59, 'Sand. de ovos no pão integral c/ margarina chapado', 1, '2017-01-26', 1, 1.23, 1.23, 28, 1),
(61, 'Pão de forma c/ margarina chapado', 1, '2017-01-26', 1, 0.53, 0.53, 29, 1),
(62, 'Café com leite', 1, '2017-01-26', 1, 0.35, 0.35, 29, 1),
(63, 'Bolo fofo c/ cobertura de chocolate', 1, '2017-01-26', 1, 0.99, 0.99, 19, 1),
(64, 'Sand. misto no pão de forma c/ margarina chapado', 2, '2017-01-26', 1, 1.55, 3.1, 19, 1),
(68, 'Bolo fofo c/ cobertura de chocolate', 1, '2017-01-26', 1, 0.99, 0.99, 31, 1),
(69, 'Sand. de queijo no pão integral c/ requeijão chapado', 1, '2017-01-26', 1, 1.49, 1.49, 32, 1),
(76, 'Sand. de queijo no pão integral c/ requeijão chapado', 0.5, '2017-01-26', 1, 1.49, 0.745, 33, 1),
(78, 'Bolo fofo c/ cobertura de chocolate', 1, '2017-01-26', 1, 0.99, 0.99, 34, 1),
(79, 'Pão de forma c/ requeijão não chapado', 1, '2017-01-26', 1, 0.75, 0.75, 34, 1),
(80, 'Café com leite', 1, '2017-01-26', 1, 0.35, 0.35, 34, 1),
(92, 'Vitamina de goiaba', 1, '2017-01-26', 0, 1.65, 1.65, 41, 1),
(93, 'Vitamina de goiaba', 1, '2017-01-26', 0, 1.65, 1.65, 42, 1),
(94, 'Leite com nescau', 0.5, '2017-01-26', 1, 1.39, 0.695, 20, 1),
(95, 'Banana', 1, '2017-01-26', 0, 0.48, 0.48, 43, 1),
(97, 'Leite com nescau', 1, '2017-01-26', 1, 1.39, 1.39, 44, 1),
(101, 'Leite com nescau', 1, '2017-01-27', 1, 1.39, 1.39, 45, 1),
(102, 'Vitamina de açaí', 1, '2017-01-27', 1, 3.35, 3.35, 45, 1),
(103, 'Vitamina de maracujá', 1, '2017-01-27', 1, 2.15, 2.15, 45, 1),
(105, 'Vitamina de maracujá', 1, '2017-02-01', 0, 2.15, 2.15, 46, 1),
(107, 'Vitamina de maracujá', 0.5, '2017-02-02', 1, 2.15, 1.075, 47, 1);

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
(1, 'Ruan Nícolas da Silva Matos', 'Nícolas Matos', 'nicolasmatos0905@gmail.com', '$2y$10$XCQe2tNa1wcnkBqcdtTeYuSoffokMp6iam0zdc16hhUPM6wTjYElq', 'nicolas.jpg', 1, '3', 'EqwmR6fUhBze3XcUXVXPxsU1d12vJfGO3yuBwkyFoCPJIiYjpP4K3BMUu08t', NULL, '2017-01-26 20:58:40', 1),
(2, 'Maria Giselly Rebouças Azevedo', 'Giselly Rebouças', 'giselly.reboucas@iteva.org.br', '$2y$10$qjUT.5/lYYK2UCZum4IK3Oemq6rMl0UWhT5cBdWQVgfGbycQJhHce', 'giselly.jpg', 1, '3', 'tC8njVdg9VfmnEWoK3oEjiVmTp4y61z9SjhSMoZilQVQEu6Kf2C27tJgn5WP', '2016-12-21 22:36:57', '2017-01-26 14:37:56', 1),
(3, 'Josinaldo da Silva Batista', 'Josinaldo Batista', 'josinaldo.batista@iteva.org.br', '$2y$10$odx2ginTQ.TpP7RNWICFauQTWBv2jmHDWRDdrEWC7AFxBOt/zN3XW', 'josinaldo.jpg', 1, '3', 'tjS7O5B2J5E0R6fMx7xhzTxBtNUlsHE0qbSEk5CvQomP7bXTEP8LzSPPPUn9', '2016-12-21 22:52:57', '2017-01-25 22:19:23', 1),
(4, 'Reginaldo Maranhão Sousa', 'Reginaldo Maranhão', 'reginaldo.maranhao@iteva.org.br', '$2y$10$pDdQmxcuXfU.dj.OC9.bOOFEDxkPvPK8wNfDvasrPZB730WmdRI2.', 'Reginaldo.jpg', 1, '3', 'OszfeMCUvSyBmT1BZxTyF7S7bBGqUVhgw0s6ZteNNBZzSKcGzJgWqMkG3sNz', '2016-12-22 14:47:54', '2017-01-25 22:09:04', 1),
(5, 'Antônio Miguel de Sousa Lima', 'Miguel Lima', 'miguel.lima@iteva.org.br', '$2y$10$jldOS53/emHSZPpDU69QYeGQHQA14.qE.qpoffzGr4XLdhuR14dMW', 'miguel.jpg', 1, '2', 'YF9wwhdRJoxZVfsaEt5MDAzIKvgODDIqy3mkOoKfLJPOlTng28kjeq2jpUGT', '2017-01-19 20:21:12', '2017-01-26 20:58:58', 1),
(6, 'Isabela Borges Pereira', 'Isabela Borges', 'isabela.borges@iteva.org.br', '$2y$10$0WHi3M27Cey//tcloBg1tOCSkkXb4/zXa.hAMeZr235E1C3TUGo0q', 'isabela.jpg', 1, '3', 'lDUHNhOCVEPM73mtjTC4u02PL78qFHoADKG0cuJYONKaWlm3HmEGr1K5ql5I', '2017-01-24 15:48:05', '2017-01-25 16:01:15', 1),
(7, 'Anderson Ribeiro Pires', 'Anderson Pires', 'anderson@iteva.org.br', '$2y$10$0cgniMvOeafNCGhc45ZWme5NFO06y/hkqtSUJI9JTANsT.AUmUvVe', 'anderson.jpg', 1, '2', NULL, '2017-01-24 15:48:54', '2017-01-24 15:59:41', 1),
(8, 'Fábio Cezar Aidar Beneduce', 'Fabio Beneduce', 'fabio@iteva.org.br', '$2y$10$iY.Qg6yi46mSn0CFV9cA.eHF9LSlBmKeXrGkgNPG.qqKS.f1H0wHW', 'fabio.jpg', 1, '2', 'pq0CNzZAn6uMiLs2VK7RhIWLkDOkhjTaOgRzzvoXZyj0lHqF2MGzKoHrz1Tu', '2017-01-24 15:49:23', '2017-01-26 14:39:34', 1),
(9, 'Israel Araújo de Oliveira', 'Israel de Oliveira', 'israel.araujo@iteva.org.br', '$2y$10$leKumKFev9LScHiLawMuHeWhgsN69pM2n/U6lI9NBvu/mD.6NJBpq', 'israel.jpg', 1, '2', NULL, '2017-01-24 15:50:05', '2017-01-24 16:00:17', 1),
(10, 'Jaqueline Thayná José Mendes', 'Jaqueline Thayná', 'jaqueline.thayna@iteva.org.br', '$2y$10$0ShijPHAz.ERjExID1wqvuKPYdAoGBCdmU5Y9m8IUiq/vWSpwm72S', 'jaquet.jpg', 1, '2', NULL, '2017-01-24 15:51:57', '2017-01-24 16:00:55', 1),
(11, 'Jaqueline da Silva Ferreira', 'Jaqueline Ferreira', 'jaqueline.ferreira@iteva.org.br', '$2y$10$pWP26.3UHN5qQZkM4Ju6W.XEFMrILMUOZ1/FVsfG4sY/xjbD2aWQG', 'jaquef.jpg', 1, '2', NULL, '2017-01-24 15:52:30', '2017-01-24 16:00:45', 1),
(12, 'João Lucas Rodrigues do Nascimento', 'João Lucas', 'joaolucas@iteva.org.br', '$2y$10$sAgvI.yJXefiB/EWWasyze4sSFJJKGEs8/Jt4zDEUc1HqQMtFk1y2', 'joao.jpg', 1, '2', NULL, '2017-01-24 15:53:16', '2017-01-24 16:01:30', 1),
(13, 'Kananda Menezes de Freitas', 'Kananda Freitas', 'kananda.freitas@iteva.org.br', '$2y$10$YFhCmgZ8TptVhe2MUYwSx.PP/A8ms4Ta.1IukNRlLcSvuRJsENdp.', 'kananda.jpg', 1, '3', 'QCdYIznyDGx3CP8dyPMvGBmisRwIMmAgcBvu5FfDiJiPRN0yw7fBp0CWwtag', '2017-01-24 15:54:54', '2017-01-25 20:56:16', 1),
(14, 'Vanessa Saraiva Belém', 'Vanessa Belém', 'vanessa@iteva.org.br', '$2y$10$j3lX9VKcbVaK8F1MApO45.F7yGYoFmDZTVabi.aei3OucDgWnjc3.', 'vanessa.jpg', 1, '2', NULL, '2017-01-24 15:55:30', '2017-01-24 16:02:43', 1),
(15, 'Francisco Dimas Silva da Rocha', 'Dimas Silva', 'dimas.silva@iteva.org.br', '$2y$10$6eeJguqr1NRpaNyny9xzhuaG7e/n/mXj5hX2nEXZ.fIJEr9i56eFG', 'dimas.jpg', 1, '2', 'iPGjeLfJWj2YrhrWlnqPEq98H10euMtPqHubhrLovcdYf8vOUi8SyzeLu49u', '2017-01-24 15:56:46', '2017-01-25 20:57:38', 1),
(16, 'Pedro Henrique Freitas Vasconselos', 'Pedro Henrique', 'pedro.henrique@iteva.org.br', '$2y$10$nzzbCNhebRI5unXvv9Z9.ODn1ihWzNpsEPwHI7g4AjBPSiWCjqsaC', 'pedro.jpg', 1, '2', 'PvxaYFI97GxnxrjbMI1cxpZtkyqWtuzf079W4WqwM60DNfBVbjMnT1bnerlR', '2017-01-24 15:57:56', '2017-01-26 14:02:19', 1),
(17, 'Sara Belém Beneduce', 'Sara Beneduce', 'sara@iteva.org.br', '$2y$10$hS0ENSYJYV9iEkS/wGMaZ.MT52cmIGjq3jW4r0mokYzAXtzmF5xAO', 'sara.jpg', 1, '2', 'mYCNQ25qhmYgLFFu8IQIM82XuRp3N5QU4N69Jor6ung9WiWlovU94wb1jPJ6', '2017-01-24 15:58:28', '2017-01-25 15:30:25', 1),
(18, 'Jair da Silva Ferreira', 'Jair Ferreira', 'jair.ferreira@iteva.org.br', '$2y$10$Ye4A9ciIMMiybj3cKPc/t.KqewPElQoLs6PD9Ms2B8hnUUy4PxuYu', 'jair.jpg', 1, '2', NULL, '2017-01-24 15:58:55', '2017-01-24 16:00:38', 1),
(19, 'Jefferson Wilker Souza Barreto', 'Jefferson Wilker', 'jefferson.wilker@iteva.org.br', '$2y$10$BwdCNPvma64ZiT9wIFBM1OwyE/QN7JqlXVdmzrvk.dP5qSG5Hb6fa', 'jefferson.jpg', 1, '2', NULL, '2017-01-24 15:59:30', '2017-01-24 16:01:01', 1),
(20, 'Aline Braga', 'Aline Braga', 'alinebraga1@hotmail.com', '$2y$10$SxEztmfaSR8u2RMAen.oWedI4aMnSKuPFlsMOZPpWZRnoTGy7U13S', 'Aline.jpg', 1, '2', NULL, '2017-01-25 15:56:11', '2017-01-25 15:56:11', 1),
(21, 'Cleilton Estevam do Nascimento', 'Cleilton Estevam', 'cleilton.estevam@iteva.org.br', '$2y$10$xVOTMtJ1Dnt6rI9gBxxhFezH2G/Kj97W.A2sUU2jiAtgrCd2KaZMO', 'cleilton.jpg', 1, '2', 'hJN07U0vOWgO4JNkUyHk0d4SNWlGSh1EH7qRWsWGnyhsyHqocwSd1oAaRkOD', '2017-01-25 17:08:24', '2017-01-25 21:36:42', 1),
(22, 'Diego Ferreira Rodrigues', 'Diego Ferreira', 'diego.ferreira@iteva.org.br', '$2y$10$q9OCibs6K2cy9v.Jq3H7PeFETnhsT4VXDxKFwJE13.9v0RFT4ZATS', 'diego.jpg', 1, '2', 'Pgh1dKYkmxT3ochxpGv4O0efuBy7OUbgNgoso2khd9zYv89mt8YOCoUywX1R', '2017-01-25 17:09:14', '2017-01-26 14:27:39', 1),
(23, 'Maria Zizi dos Santos', 'Maria Zizi', 'maria.zizi@iteva.org.br', '$2y$10$97Ou73lCdGk4nbHrvej.EujmxgU/zdsDAgvU7Vl0Z3Zh8YSaDlYda', 'zizi.jpg', 1, '2', NULL, '2017-01-25 17:10:08', '2017-01-25 17:10:08', 1),
(24, 'Natalia da Silva Costa', 'Natalia Costa', 'natalia.costa@iteva.org.br', '$2y$10$45tb0f7BtREDekf2VElegOhCuxvgKdEm0e/TLyjeHD5VrO2/1.Lxa', 'natalia.jpg', 1, '2', 'GAcIGDLQgTeu7X4M1c1yY17xAynfBytL1xp0YyUcy5rBf2hd50w6EYWjoUiq', '2017-01-25 17:11:37', '2017-01-26 14:17:40', 1),
(25, 'Leandro Barros dos Santos', 'Leandro Barros', 'leandro.barros@iteva.org.br', '$2y$10$kJvoxt1PvbY/KRZDviuxqOkpGXvk83WOEf0oUb9n2nD0.lgB4Ztj2', 'leandro.jpg', 1, '2', 'AQV63pI8omLik2TbWA5tRLY2vzbu3t1BPFQKPtg3f9WVIkK3HSt5FpEjxVoG', '2017-01-25 17:12:20', '2017-01-26 14:28:50', 1),
(26, 'João Paulo Sousa Lima', 'João Paulo', 'joao.paulo@iteva.org.br', '$2y$10$4cPuhmAVv5PFWuybvNEdkei5aewdObGgrrDNRzgXncJyTNDgZ2Cae', 'default_1.jpg', 1, '2', '9CrTiVXIyTh2ZIZywpPDPOOp5vJfrDfoLX4gZFQuM0U3xsdILYHtdq3oAF21', '2017-01-25 17:14:43', '2017-01-26 14:06:37', 1);

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
  ADD UNIQUE KEY `nome_UNIQUE` (`nome`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `permissoes`
--
ALTER TABLE `permissoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `permissoes_classes`
--
ALTER TABLE `permissoes_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;
--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;
--
-- AUTO_INCREMENT for table `produto_cardapio`
--
ALTER TABLE `produto_cardapio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1411;
--
-- AUTO_INCREMENT for table `produto_pedido`
--
ALTER TABLE `produto_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
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
