-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27/11/2025 às 22:49
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
-- Banco de dados: `saga_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `aluno`
--

CREATE TABLE `aluno` (
  `iden_alun` int(11) NOT NULL,
  `regx_user` char(9) NOT NULL,
  `iden_curs` int(11) NOT NULL,
  `cicl_alun` int(11) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `aluno`
--

INSERT INTO `aluno` (`iden_alun`, `regx_user`, `iden_curs`, `cicl_alun`) VALUES
(1, '202410101', 1, 3),
(2, '202500000', 1, 1),
(3, '202550000', 3, 1),
(4, '202505000', 2, 1),
(5, '202555000', 4, 1),
(6, '202555001', 1, 1),
(7, '202555002', 3, 1),
(8, '202555003', 1, 1),
(9, '202555004', 1, 1),
(10, '202555005', 1, 1),
(11, '202555006', 1, 1),
(12, '202555007', 1, 1),
(13, '202555008', 1, 1),
(14, '202555009', 2, 1),
(15, '202555010', 4, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cursando`
--

CREATE TABLE `cursando` (
  `iden_crsn` int(11) NOT NULL,
  `regx_user` char(9) NOT NULL,
  `iden_matr` int(11) NOT NULL,
  `ntp1_crsn` decimal(5,2) NOT NULL DEFAULT 0.00,
  `ntp2_crsn` decimal(5,2) NOT NULL DEFAULT 0.00,
  `ntp3_crsn` decimal(5,2) NOT NULL DEFAULT 0.00,
  `nttt_crsn` decimal(5,2) NOT NULL DEFAULT 0.00,
  `falt_crsn` int(11) NOT NULL DEFAULT 0,
  `cicl_alun` enum('1','2','3','4','5','6','7','8','9','10') NOT NULL DEFAULT '1',
  `_ano_crsn` char(4) NOT NULL,
  `_sem_crsn` enum('1','2') NOT NULL DEFAULT '1',
  `situ_crsn` enum('Em Curso','Retido','Aprovado') NOT NULL DEFAULT 'Em Curso'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cursando`
--

INSERT INTO `cursando` (`iden_crsn`, `regx_user`, `iden_matr`, `ntp1_crsn`, `ntp2_crsn`, `ntp3_crsn`, `nttt_crsn`, `falt_crsn`, `cicl_alun`, `_ano_crsn`, `_sem_crsn`, `situ_crsn`) VALUES
(1, '202410101', 1, 9.00, 8.75, 0.00, 9.50, 8, '1', '2023', '2', 'Aprovado'),
(2, '202410101', 3, 9.85, 10.00, 0.00, 9.00, 0, '1', '2023', '2', 'Aprovado'),
(3, '202410101', 5, 8.50, 6.00, 0.00, 0.00, 16, '1', '2023', '2', 'Retido'),
(4, '202410101', 6, 9.75, 10.00, 0.00, 10.00, 4, '1', '2023', '2', 'Aprovado'),
(5, '202410101', 7, 9.25, 8.50, 0.00, 8.60, 0, '1', '2023', '2', 'Aprovado'),
(6, '202410101', 10, 7.60, 8.75, 0.00, 10.00, 16, '1', '2023', '2', 'Aprovado'),
(7, '202410101', 15, 10.00, 9.50, 0.00, 10.00, 0, '1', '2023', '2', 'Aprovado'),
(8, '202410101', 2, 6.50, 7.00, 0.00, 10.00, 0, '2', '2024', '1', 'Aprovado'),
(9, '202410101', 4, 9.50, 10.00, 0.00, 10.00, 10, '2', '2024', '1', 'Aprovado'),
(10, '202410101', 5, 10.00, 8.00, 0.00, 9.00, 10, '2', '2024', '1', 'Aprovado'),
(11, '202410101', 16, 8.00, 8.00, 0.00, 10.00, 4, '2', '2024', '1', 'Aprovado'),
(12, '202410101', 9, 9.75, 8.25, 0.00, 9.00, 0, '2', '2024', '1', 'Aprovado'),
(13, '202410101', 8, 10.00, 9.25, 0.00, 10.00, 8, '2', '2024', '1', 'Aprovado'),
(14, '202410101', 11, 10.00, 10.00, 0.00, 10.00, 8, '2', '2024', '1', 'Aprovado'),
(25, '202410101', 14, 8.25, 6.00, 0.00, 0.00, 0, '3', '2024', '2', 'Em Curso'),
(26, '202410101', 18, 8.00, 9.00, 0.00, 0.00, 10, '3', '2024', '2', 'Em Curso'),
(27, '202410101', 13, 10.00, 8.00, 0.00, 0.00, 10, '3', '2024', '2', 'Em Curso'),
(28, '202410101', 28, 9.25, 9.00, 0.00, 0.00, 4, '3', '2024', '2', 'Em Curso'),
(29, '202410101', 20, 7.50, 8.00, 0.00, 0.00, 0, '3', '2024', '2', 'Em Curso'),
(30, '202410101', 12, 10.00, 9.00, 0.00, 0.00, 8, '3', '2024', '2', 'Em Curso'),
(32, '202500000', 1, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(33, '202500000', 2, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(34, '202500000', 3, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(35, '202500000', 4, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(36, '202500000', 5, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(37, '202500000', 6, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(38, '202500000', 7, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(39, '202500000', 8, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(40, '202500000', 9, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(41, '202500000', 10, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(42, '202500000', 11, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(43, '202500000', 12, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(44, '202500000', 13, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(45, '202500000', 14, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(46, '202500000', 15, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(47, '202500000', 16, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(48, '202500000', 17, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(49, '202500000', 18, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(50, '202500000', 19, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(51, '202500000', 20, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(52, '202500000', 21, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(53, '202500000', 22, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(54, '202500000', 23, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(55, '202500000', 24, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(56, '202500000', 25, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(57, '202500000', 26, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(58, '202500000', 27, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(59, '202500000', 28, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(60, '202550000', 5, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(61, '202550000', 15, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(62, '202550000', 23, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(63, '202505000', 5, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(64, '202505000', 15, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(65, '202505000', 23, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(66, '202555000', 6, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(67, '202555000', 7, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(68, '202555000', 15, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(69, '202555000', 23, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(70, '202555001', 1, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(71, '202555001', 6, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(72, '202555001', 7, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(73, '202555001', 10, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(74, '202555001', 15, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(75, '202555001', 23, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(76, '202555002', 5, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(77, '202555002', 15, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(78, '202555002', 23, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(79, '202555003', 1, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(80, '202555003', 6, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(81, '202555003', 7, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(82, '202555003', 10, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(83, '202555003', 15, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(84, '202555003', 23, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(85, '202555004', 1, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(86, '202555004', 6, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(87, '202555004', 7, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(88, '202555004', 10, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(89, '202555004', 15, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(90, '202555004', 23, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(91, '202555005', 1, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(92, '202555005', 6, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(93, '202555005', 7, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(94, '202555005', 10, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(95, '202555005', 15, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(96, '202555005', 23, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(97, '202555006', 1, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(98, '202555006', 6, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(99, '202555006', 7, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(100, '202555006', 10, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(101, '202555006', 15, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(102, '202555006', 23, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(103, '202555007', 1, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(104, '202555007', 6, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(105, '202555007', 7, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(106, '202555007', 10, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(107, '202555007', 15, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(108, '202555007', 23, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(109, '202555008', 1, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(110, '202555008', 6, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(111, '202555008', 7, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(112, '202555008', 10, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(113, '202555008', 15, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(114, '202555008', 23, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(115, '202555009', 5, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(116, '202555009', 15, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(117, '202555009', 23, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(118, '202555010', 6, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(119, '202555010', 7, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(120, '202555010', 15, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso'),
(121, '202555010', 23, 0.00, 0.00, 0.00, 0.00, 0, '1', '2025', '2', 'Em Curso');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cursinho`
--

CREATE TABLE `cursinho` (
  `idcs_csrl` int(11) NOT NULL,
  `capa_csrl` varchar(255) DEFAULT NULL,
  `nome_csrl` varchar(255) DEFAULT NULL,
  `dura_csrl` int(11) DEFAULT NULL,
  `desc_csrl` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cursinho`
--

INSERT INTO `cursinho` (`idcs_csrl`, `capa_csrl`, `nome_csrl`, `dura_csrl`, `desc_csrl`) VALUES
(1, 'IMG_202410101', 'Curso de Teste 1', 40, 'Descrição do Curso 1'),
(2, 'IMG_202410102', 'Curso de Teste 2', 30, 'Descrição do Curso 2');

-- --------------------------------------------------------

--
-- Estrutura para tabela `curso`
--

CREATE TABLE `curso` (
  `iden_curs` int(11) NOT NULL,
  `nome_curs` varchar(50) NOT NULL,
  `abrv_curs` varchar(3) NOT NULL,
  `total_semestres` int(11) NOT NULL DEFAULT 6,
  `total_anos` int(11) NOT NULL DEFAULT 3,
  `ativo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `curso`
--

INSERT INTO `curso` (`iden_curs`, `nome_curs`, `abrv_curs`, `total_semestres`, `total_anos`, `ativo`) VALUES
(1, 'CIÊNCIAS DA COMPUTAÇÃO', 'CDC', 8, 4, 1),
(2, 'LOGÍSTICA', 'LOG', 6, 3, 1),
(3, 'ADMINISTRAÇÃO', 'ADM', 6, 3, 1),
(4, 'INFORMÁTICA PARA NEGÓCIOS', 'INF', 6, 3, 1),
(5, 'GESTÃO EMPRESARIAL', 'GES', 6, 3, 1),
(6, 'ENGENHARIA MECÂNICA', 'EGM', 10, 5, 1),
(7, 'DESENVOLVIMENTO DE PRODUTOS PLÁSTICOS', 'DPP', 6, 3, 1),
(8, 'DIREITO', 'DIR', 10, 5, 1),
(9, 'MEDICINA', 'MED', 12, 6, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `curso_materia`
--

CREATE TABLE `curso_materia` (
  `iden_curso_materia` int(11) NOT NULL,
  `iden_curs` int(11) NOT NULL,
  `iden_matr` int(11) NOT NULL,
  `ciclo_semestre` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `curso_materia`
--

INSERT INTO `curso_materia` (`iden_curso_materia`, `iden_curs`, `iden_matr`, `ciclo_semestre`) VALUES
(26, 1, 1, 1),
(32, 1, 2, 2),
(33, 1, 3, 2),
(27, 1, 6, 1),
(28, 1, 7, 1),
(34, 1, 8, 2),
(35, 1, 9, 2),
(29, 1, 10, 1),
(36, 1, 11, 2),
(30, 1, 15, 1),
(37, 1, 16, 2),
(31, 1, 23, 1),
(38, 1, 24, 2),
(39, 2, 5, 1),
(40, 2, 15, 1),
(41, 2, 23, 1),
(42, 3, 5, 1),
(43, 3, 15, 1),
(44, 3, 23, 1),
(45, 4, 6, 1),
(46, 4, 7, 1),
(47, 4, 15, 1),
(48, 4, 23, 1),
(49, 5, 5, 1),
(50, 5, 15, 1),
(51, 5, 23, 1),
(52, 6, 1, 1),
(53, 6, 14, 1),
(54, 6, 15, 1),
(55, 6, 23, 1),
(56, 7, 15, 1),
(57, 7, 23, 1),
(58, 8, 5, 1),
(59, 8, 15, 1),
(60, 8, 23, 1),
(61, 9, 5, 1),
(62, 9, 15, 1),
(63, 9, 23, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `evento`
--

CREATE TABLE `evento` (
  `iden_even` int(11) NOT NULL,
  `tipo_even` varchar(15) NOT NULL,
  `nome_even` varchar(60) NOT NULL,
  `data_even` date NOT NULL,
  `loca_even` varchar(20) NOT NULL,
  `desc_even` text NOT NULL,
  `dura_even` int(11) NOT NULL,
  `imgm_even` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `evento`
--

INSERT INTO `evento` (`iden_even`, `tipo_even`, `nome_even`, `data_even`, `loca_even`, `desc_even`, `dura_even`, `imgm_even`) VALUES
(1, 'Palestra', 'Interação Humano-Computador', '2024-11-29', 'Auditório', 'A revolução digital está em constante evolução, e a chave para moldar o futuro tecnológico reside na compreensão profunda da interação humano-computador. A Faculdade de Técnologia tem o prazer de apresentar uma palestra fascinante que mergulhará nas nuances dessa interação dinâmica, trazendo à tona insights cruciais e perspectivas inovadoras. Junte-se a renomados especialistas no campo da Interação Humano-Computador, cujas contribuições têm impactado significativamente a forma como interagimos com a tecnologia no nosso dia a dia. Eles compartilharão experiências práticas, pesquisas avançadas e visões futuras que prometem transformar a maneira como percebemos e utilizamos a tecnologia.', 2, '1'),
(2, 'Palestra', 'Programa InterStudy', '2024-11-27', 'Auditório', 'A MALTEC tem o prazer de convidar todos os estudantes para uma palestra exclusiva que abrirá portas para um emocionante programa de intercâmbio estudantil com o renomado Instituto de Tecnologia de Massachusetts (MIT). Durante esta palestra informativa, você terá a oportunidade única de aprender sobre as vantagens e experiências que aguardam aqueles que são selecionados para participar do programa de intercâmbio com o MIT. Professores e representantes do programa estarão presentes para compartilhar informações cruciais sobre os requisitos de inscrição, os benefícios acadêmicos e a vida no campus do MIT.', 2, '2'),
(3, 'Vestibular', 'Vestibular 2024', '2024-07-20', 'Maltec', 'Você está pronto para dar o próximo passo em direção a um futuro repleto de oportunidades inovadoras? A Faculdade de Tecnologia MALTEC está entusiasmada em anunciar o Vestibular para o Primeiro Semestre de 2024, convidando mentes curiosas e apaixonadas pela tecnologia a se juntarem a nós nesta jornada educacional excepcional.A Instituição é reconhecida nacional e internacionalmente por seu compromisso com a excelência acadêmica. Nossos programas de tecnologia são desenvolvidos em colaboração com líderes do setor, garantindo que nossos alunos estejam na vanguarda das últimas tendências e inovações.', 4, '3');

-- --------------------------------------------------------

--
-- Estrutura para tabela `livro`
--

CREATE TABLE `livro` (
  `iden_livr` int(11) NOT NULL,
  `idcs_livr` int(11) NOT NULL,
  `imge_livr` char(5) NOT NULL,
  `nome_livr` varchar(60) NOT NULL,
  `autr_livr` varchar(35) NOT NULL,
  `desc_livr` text NOT NULL,
  `link_livr` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `livro`
--

INSERT INTO `livro` (`iden_livr`, `idcs_livr`, `imge_livr`, `nome_livr`, `autr_livr`, `desc_livr`, `link_livr`) VALUES
(1, 1, '01-01', 'Ciência da Computação Uma Visão Abrangente 7ª Edição', 'J. Glenn Brookshear', 'Livro aí', 'https://www.kufunda.net/publicdocs/Ci%C3%AAncia%20da%20Computa%C3%A7%C3%A3o%20-%20Uma%20Vis%C3%A3o%20Abrangente%20(Glenn%20Brookshear).pdf'),
(2, 1, '01-02', 'Ciência da Computação Uma Visão Abrangente 11ª Edição', 'J. Glenn Brookshear', 'Livro aí', ''),
(3, 1, '01-03', 'Lógica Para Ciências da Computação e Áreas Afins', 'João Nunes de Souza', 'Livro aí', ''),
(4, 1, '01-04', 'Pense Java - Guia de Aprendizagem', 'Kathy Sierra & Bert Bates', 'Livro aí', ''),
(5, 1, '01-05', 'Java 9 Interativo, reativo e modularizado', 'Rodrigo Turn', 'Livro aí', ''),
(6, 1, '01-06', 'Arduino do Básico à Internet das Coisas', 'Altair dos Santos & Sylvio Ribeiro', 'Livro aí', '');


-- --------------------------------------------------------
-- Estrutura para tabela `faltas`
-- --------------------------------------------------------

CREATE TABLE `faltas` (
  `iden_att` int(11) NOT NULL,
  `regx_user` char(9) NOT NULL,         -- aluno
  `iden_matr` int(11) NOT NULL,         -- matéria
  `data_att` date NOT NULL,             -- data da aula
  `stat_att` enum('P','F') NOT NULL,    -- P = Presente / F = Falta
  `prof_att` char(9) NOT NULL           -- professor que lançou
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Índices
ALTER TABLE `faltas`
  ADD PRIMARY KEY (`iden_att`),
  ADD KEY `regx_user` (`regx_user`),
  ADD KEY `iden_matr` (`iden_matr`),
  ADD KEY `prof_att` (`prof_att`);

-- Auto Increment
ALTER TABLE `faltas`
  MODIFY `iden_att` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- Estrutura para tabela `materia`
--

CREATE TABLE `materia` (
  `iden_matr` int(11) NOT NULL,
  `nome_matr` varchar(30) NOT NULL,
  `chor_matr` int(11) NOT NULL,
  `abrv_matr` varchar(4) NOT NULL,
  `ccpv_matr` int(11) NOT NULL,
  `dias_matr` int(11) NOT NULL,
  `hora_matr` enum('A','B') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `materia`
--

INSERT INTO `materia` (`iden_matr`, `nome_matr`, `chor_matr`, `abrv_matr`, `ccpv_matr`, `dias_matr`, `hora_matr`) VALUES
(1, 'CÁLCULO I', 40, 'CAL1', 1, 1, 'A'),
(2, 'CÁLCULO II', 40, 'CAL2', 2, 1, 'A'),
(3, 'ENGENHARIA DE SOFTWARE I', 40, 'ENG1', 1, 1, 'B'),
(4, 'ENGENHARIA DE SOFTWARE II', 40, 'ENG2', 2, 1, 'B'),
(5, 'ÉTICA', 40, 'ETC', 1, 2, 'A'),
(6, 'TÉCNICAS DE PROGRAMAÇÃO I', 80, 'TCP1', 1, 3, 'A'),
(7, 'MODELAGEM DE BANCO DE DADOS ', 80, 'MBD', 1, 4, 'A'),
(8, 'BANCO DE DADOS RELACIONAL', 80, 'BDD', 2, 4, 'A'),
(9, 'TÉCNICAS DE PROGRAMAÇÃO II', 80, 'TCP2', 2, 3, 'A'),
(10, 'DESENVOLVIMENTO WEB I', 80, 'DVW1', 1, 5, 'A'),
(11, 'DESENVOLVIMENTO WEB II', 80, 'DVW2', 2, 5, 'A'),
(12, 'DESENVOLVIMENTO WEB III', 80, 'DVW3', 3, 5, 'A'),
(13, 'DESENVOLVIMENTO MOBILE I', 80, 'DVM1', 3, 2, 'A'),
(14, 'ÁLGEBRA LINEAR', 40, 'AGL', 3, 1, 'A'),
(15, 'INGLÊS INSTRUMENTAL I', 40, 'ING1', 1, 2, 'B'),
(16, 'INGLÊS INSTRUMENTAL II', 40, 'ING2', 2, 2, 'B'),
(17, 'GESTÃO ÁGIL DE PROJETOS', 40, 'GAP', 2, 2, 'A'),
(18, 'INGLÊS INSTRUMENTAL III', 40, 'ING3', 3, 1, 'B'),
(19, 'INGLÊS INSTRUMENTAL IV', 40, 'ING4', 4, 1, 'B'),
(20, 'BANCO DE DADOS NÃO-RELACIONAL', 80, 'BNR', 3, 4, 'A'),
(21, 'DESENVOLVIMENTO MOBILE II', 80, 'DVM2', 4, 2, 'A'),
(22, 'COMPUTAÇÃO EM NÚVEM', 40, 'CEN', 4, 1, 'A'),
(23, 'ELABORAÇÃO DE REDAÇÃO TÉCNICA', 40, 'ERT', 4, 3, 'A'),
(24, 'EXPERIÊNCIA DE USUÁRIO', 40, 'EXU', 4, 3, 'B'),
(25, 'INTERNET DAS COISAS', 80, 'IDC', 4, 4, 'A'),
(26, 'REDES DE COMPUTADORES', 40, 'RDC', 4, 5, 'A'),
(27, 'PROGRAMAÇÃO EMBARCADA', 40, 'PRE', 4, 5, 'B'),
(28, 'TÉCNICAS DE PROGRAMAÇÃO III', 80, 'TCP3', 3, 3, 'A');

-- --------------------------------------------------------

--
-- Estrutura para tabela `professor_materia`
--

CREATE TABLE `professor_materia` (
  `iden_prof_mat` int(11) NOT NULL,
  `regx_user` varchar(20) NOT NULL,
  `iden_matr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `professor_materia`
--

INSERT INTO `professor_materia` (`iden_prof_mat`, `regx_user`, `iden_matr`) VALUES
(1, '202555012', 1),
(2, '202555017', 23),
(3, '202555018', 9);

-- --------------------------------------------------------

--
-- Estrutura para tabela `solicitacao`
--

CREATE TABLE `solicitacao` (
  `iden_soli` int(11) NOT NULL,
  `regx_user` int(11) NOT NULL,
  `tipo_soli` enum('Passe Escolar','Aproveitamento','Rematrícula','Atestado','Papéis de Estágio') NOT NULL,
  `anex_soli` varchar(50) DEFAULT NULL,
  `cond_soli` varchar(10) DEFAULT NULL,
  `mtap_soli` varchar(26) DEFAULT NULL,
  `tpau_soli` varchar(20) DEFAULT NULL,
  `mtau_soli` varchar(50) DEFAULT NULL,
  `dtau_soli` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `solicitacao`
--

INSERT INTO `solicitacao` (`iden_soli`, `regx_user`, `tipo_soli`, `anex_soli`, `cond_soli`, `mtap_soli`, `tpau_soli`, `mtau_soli`, `dtau_soli`) VALUES
(11, 202410101, 'Passe Escolar', '1_202410101_1732118144.pdf', 'Linha A-15', NULL, NULL, NULL, NULL),
(13, 202410101, 'Aproveitamento', '2_202410101_1732120376.jpg', NULL, '[\"19\",\"22\",\"23\",\"25\"]', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `telefone`
--

CREATE TABLE `telefone` (
  `iden_fone` int(11) NOT NULL,
  `iden_user` int(11) NOT NULL,
  `nmro_fone` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `iden_user` int(11) NOT NULL,
  `regx_user` char(9) NOT NULL,
  `codg_user` char(14) NOT NULL,
  `nome_user` varchar(40) NOT NULL,
  `mail_user` varchar(40) NOT NULL,
  `senh_user` varchar(16) NOT NULL,
  `fone_user` char(15) NOT NULL,
  `foto_user` char(13) DEFAULT NULL,
  `flag_user` char(1) NOT NULL COMMENT 'A = Aluno, P = Professor, S = Secretaria'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`iden_user`, `regx_user`, `codg_user`, `nome_user`, `mail_user`, `senh_user`, `fone_user`, `foto_user`, `flag_user`) VALUES
(1, '202410101', '111.111.111-11', 'ROGÉRIO DA SILVA LOPES', 'rogerio.lopes@maltec.sp.gov.br', 'cocacolamata', '(11) 91234-5678', 'IMG_202410101', 'A'),
(2, '202410102', '222.222.222-22', 'MARCOS PEREIRA', 'marcos.pereira@maltec.sp.gov.br', 'professor123', '(11) 98765-4321', 'IMG_202410102', 'P'),
(3, '202410103', '333.333.333-33', 'ANA LIMA', 'ana.lima@maltec.sp.gov.br', 'secretaria123', '(11) 94567-8901', 'IMG_202410103', 'S'),
(4, '', '121.212.121-21', 'teste', 'teste@gmail.com', '$2y$10$.PxFeN4QQ', '1299999-9999', NULL, 'A'),
(5, '202500000', '123.123.123-33', 'teste 2', 'teste2@gmail.com', '$2y$10$qQe9./ZzL', '(12) 91234-5678', NULL, 'A'),
(6, '202550000', '133.133.133-33', 'teste 3', 'teste3@gmail.com', '$2y$10$P/W9OQol6', '(33) 93333-3333', NULL, 'A'),
(7, '202505000', '144.144.144-44', 'teste 4', 'teste4@gmail.com', '$2y$10$IIzLU/kdW', '(11) 94444-4444', NULL, 'A'),
(8, '202555000', '155.155.155-55', 'teste 5', 'teste5@gmail.com', '$2y$10$TYIyL8Ae9', '(11) 95555-5555', NULL, 'A'),
(9, '202555001', '166.666.666-66', 'teste 6', 'teste6@gmail.com', '$2y$10$CZOy35PHp', '(11) 96666-6666', NULL, 'A'),
(10, '202555002', '177.777.777-77', 'teste 7', 'teste7@gmail.com', '$2y$10$w.0DwzVAr', '(11) 97777-7777', NULL, 'A'),
(11, '202555003', '188.188.188-18', 'teste 8', 'teste8@gmail.com', '$2y$10$NF/vZy112', '(11) 98888-8888', NULL, 'A'),
(12, '202555004', '199.999.999-99', 'teste 9', 'teste9@gmail.com', '$2y$10$EXU1ILOka', '(11) 99999-9999', NULL, 'A'),
(13, '202555005', '101.010.101-01', 'teste 10', 'teste10@gmail.com', '$2y$10$STEXZ/WJB', '(11) 91010-1010', NULL, 'A'),
(14, '202555006', '110.110.110-11', 'teste 11', 'teste11@gmail.com', '$2y$10$rYj4QsaYp', '(11) 91101-1011', NULL, 'A'),
(15, '202555007', '111.222.333-44', 'Aluno 1', 'aluno1@gmail.com', '$2y$10$YuJcT.Tpk', '(11) 91234-5678', NULL, 'A'),
(16, '202555008', '222.233.344-22', 'Aluno 2', 'aluno2@gmail.com', '$2y$10$NAkDSylp6', '(11) 91234-5678', NULL, 'A'),
(17, '202555009', '154.154.154-54', 'ultimo teste', 'ultimo@gmail.com.br', '$2y$10$HwBkx7J4M', '(11) 95454-5454', NULL, 'A'),
(18, '202555010', '444.444.444-44', 'Wesley Antonio Rodrigues', 'wesley.rodrigues@maltec.sp.gov.br', '$2y$10$4fMJcdhgK', '(11) 94564-5565', NULL, 'A'),
(19, '202555011', '646.464.646-64', 'Anderson Oliveira', 'anderson.oliveira855@maltec.sp.gov.br', '$2y$10$qFZXDYhbg', '(11) 96464-6464', NULL, 'P'),
(20, '202555012', '646.464.646-65', 'Anderson Oliveira', 'anderson.oliveira849@maltec.sp.gov.br', '$2y$10$z7.M3vCAl', '(11) 91234-5678', NULL, 'P'),
(21, '202555013', '156.146.645-23', 'antonio rocha', 'antonio.rocha185@maltec.sp.gov.br', '$2y$10$Xs3BATbvP', '(11) 95956-6564', NULL, 'P'),
(22, '202555014', '484.186.512-52', 'Luiz Castro', 'luiz.castro242@maltec.sp.gov.br', '$2y$10$q0MoXa0q5', '(11) 91234-5678', NULL, 'P'),
(23, '202555015', '352352352', 'Luiz Castro', 'luiz.castro571@maltec.sp.gov.br', '$2y$10$2.zrMJkR2', '(11) 96464-6464', NULL, 'P'),
(24, '202555016', '352.352.352-35', 'Luiz Castro', 'luiz.castro186@maltec.sp.gov.br', '$2y$10$iJxqylAjr', '(11) 96464-6464', NULL, 'P'),
(25, '202555017', '654.654.645-65', 'Teste Prévio', 'teste.previo439@maltec.sp.gov.br', '$2y$10$FkWbdV3oL', '(11) 96464-6464', NULL, 'P'),
(26, '202555018', '133.133.133-35', 'Testinho', 'testinho043@maltec.sp.gov.br', '$2y$10$o/nu1KcVB', '(11) 96464-6464', NULL, 'P');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`iden_alun`),
  ADD UNIQUE KEY `regx_user` (`regx_user`);

--
-- Índices de tabela `cursando`
--
ALTER TABLE `cursando`
  ADD PRIMARY KEY (`iden_crsn`);

--
-- Índices de tabela `cursinho`
--
ALTER TABLE `cursinho`
  ADD PRIMARY KEY (`idcs_csrl`);

--
-- Índices de tabela `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`iden_curs`),
  ADD UNIQUE KEY `nome_curs` (`nome_curs`),
  ADD UNIQUE KEY `abrv_curs` (`abrv_curs`);

--
-- Índices de tabela `curso_materia`
--
ALTER TABLE `curso_materia`
  ADD PRIMARY KEY (`iden_curso_materia`),
  ADD UNIQUE KEY `unique_curso_materia_ciclo` (`iden_curs`,`iden_matr`,`ciclo_semestre`);

--
-- Índices de tabela `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`iden_even`),
  ADD UNIQUE KEY `nome_event` (`nome_even`);

--
-- Índices de tabela `livro`
--
ALTER TABLE `livro`
  ADD PRIMARY KEY (`iden_livr`),
  ADD UNIQUE KEY `imge_livr` (`imge_livr`);

--
-- Índices de tabela `materia`
--
ALTER TABLE `materia`
  ADD PRIMARY KEY (`iden_matr`);

--
-- Índices de tabela `professor_materia`
--
ALTER TABLE `professor_materia`
  ADD PRIMARY KEY (`iden_prof_mat`),
  ADD UNIQUE KEY `unique_professor_materia` (`regx_user`,`iden_matr`);

--
-- Índices de tabela `solicitacao`
--
ALTER TABLE `solicitacao`
  ADD PRIMARY KEY (`iden_soli`);

--
-- Índices de tabela `telefone`
--
ALTER TABLE `telefone`
  ADD PRIMARY KEY (`iden_fone`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`iden_user`),
  ADD UNIQUE KEY `mail_user` (`mail_user`),
  ADD UNIQUE KEY `codg_user` (`codg_user`),
  ADD UNIQUE KEY `regx_user` (`regx_user`),
  ADD UNIQUE KEY `foto_user` (`foto_user`);

  

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `aluno`
--
ALTER TABLE `aluno`
  MODIFY `iden_alun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `cursando`
--
ALTER TABLE `cursando`
  MODIFY `iden_crsn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT de tabela `cursinho`
--
ALTER TABLE `cursinho`
  MODIFY `idcs_csrl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `curso`
--
ALTER TABLE `curso`
  MODIFY `iden_curs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `curso_materia`
--
ALTER TABLE `curso_materia`
  MODIFY `iden_curso_materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de tabela `evento`
--
ALTER TABLE `evento`
  MODIFY `iden_even` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `livro`
--
ALTER TABLE `livro`
  MODIFY `iden_livr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `materia`
--
ALTER TABLE `materia`
  MODIFY `iden_matr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `professor_materia`
--
ALTER TABLE `professor_materia`
  MODIFY `iden_prof_mat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `solicitacao`
--
ALTER TABLE `solicitacao`
  MODIFY `iden_soli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `telefone`
--
ALTER TABLE `telefone`
  MODIFY `iden_fone` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `iden_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
