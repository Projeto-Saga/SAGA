-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 20-Nov-2024 às 21:57
-- Versão do servidor: 8.2.0
-- versão do PHP: 8.2.13

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
-- Estrutura da tabela `aluno`
--

DROP TABLE IF EXISTS `aluno`;
CREATE TABLE IF NOT EXISTS `aluno` (
  `iden_alun` int NOT NULL AUTO_INCREMENT,
  `regx_user` char(9) NOT NULL,
  `iden_curs` int NOT NULL,
  `cicl_alun` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`iden_alun`),
  UNIQUE KEY `regx_user` (`regx_user`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `aluno`
--

INSERT INTO `aluno` (`iden_alun`, `regx_user`, `iden_curs`, `cicl_alun`) VALUES
(1, '202410101', 1, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cursando`
--

DROP TABLE IF EXISTS `cursando`;
CREATE TABLE IF NOT EXISTS `cursando` (
  `iden_crsn` int NOT NULL AUTO_INCREMENT,
  `regx_user` char(9) NOT NULL,
  `iden_matr` int NOT NULL,
  `ntp1_crsn` decimal(5,2) NOT NULL DEFAULT '0.00',
  `ntp2_crsn` decimal(5,2) NOT NULL DEFAULT '0.00',
  `ntp3_crsn` decimal(5,2) NOT NULL DEFAULT '0.00',
  `nttt_crsn` decimal(5,2) NOT NULL DEFAULT '0.00',
  `falt_crsn` int NOT NULL DEFAULT '0',
  `cicl_alun` enum('1','2','3','4','5','6','7','8','9','10') NOT NULL DEFAULT '1',
  `_ano_crsn` char(4) NOT NULL,
  `_sem_crsn` enum('1','2') NOT NULL DEFAULT '1',
  `situ_crsn` enum('Em Curso','Retido','Aprovado') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Em Curso',
  PRIMARY KEY (`iden_crsn`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `cursando`
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
(30, '202410101', 12, 10.00, 9.00, 0.00, 0.00, 8, '3', '2024', '2', 'Em Curso');

-- --------------------------------------------------------

--
-- Estrutura da tabela `curso`
--

DROP TABLE IF EXISTS `curso`;
CREATE TABLE IF NOT EXISTS `curso` (
  `iden_curs` int NOT NULL AUTO_INCREMENT,
  `nome_curs` varchar(50) NOT NULL,
  `abrv_curs` varchar(3) NOT NULL,
  PRIMARY KEY (`iden_curs`),
  UNIQUE KEY `nome_curs` (`nome_curs`),
  UNIQUE KEY `abrv_curs` (`abrv_curs`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `curso`
--

INSERT INTO `curso` (`iden_curs`, `nome_curs`, `abrv_curs`) VALUES
(1, 'CIÊNCIAS DA COMPUTAÇÃO', 'CDC'),
(2, 'LOGÍSTICA', 'LOG'),
(3, 'ADMINISTRAÇÃO', 'ADM'),
(4, 'INFORMÁTICA PARA NEGÓCIOS', 'INF'),
(5, 'GESTÃO EMPRESARIAL', 'GES'),
(6, 'ENGENHARIA MECÂNICA', 'EGM'),
(7, 'DESENVOLVIMENTO DE PRODUTOS PLÁSTICOS', 'DPP'),
(8, 'DIREITO', 'DIR'),
(9, 'MEDICINA', 'MED');

-- --------------------------------------------------------

--
-- Estrutura da tabela `evento`
--

DROP TABLE IF EXISTS `evento`;
CREATE TABLE IF NOT EXISTS `evento` (
  `iden_even` int NOT NULL AUTO_INCREMENT,
  `tipo_even` varchar(15) NOT NULL,
  `nome_even` varchar(60) NOT NULL,
  `data_even` date NOT NULL,
  `loca_even` varchar(20) NOT NULL,
  `desc_even` text NOT NULL,
  `dura_even` int NOT NULL,
  `imgm_even` text NOT NULL,
  PRIMARY KEY (`iden_even`),
  UNIQUE KEY `nome_event` (`nome_even`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `evento`
--

INSERT INTO `evento` (`iden_even`, `tipo_even`, `nome_even`, `data_even`, `loca_even`, `desc_even`, `dura_even`, `imgm_even`) VALUES
(1, 'Palestra', 'Interação Humano-Computador', '2024-11-29', 'Auditório', 'A revolução digital está em constante evolução, e a chave para moldar o futuro tecnológico reside na compreensão profunda da interação humano-computador. A Faculdade de Técnologia tem o prazer de apresentar uma palestra fascinante que mergulhará nas nuances dessa interação dinâmica, trazendo à tona insights cruciais e perspectivas inovadoras. Junte-se a renomados especialistas no campo da Interação Humano-Computador, cujas contribuições têm impactado significativamente a forma como interagimos com a tecnologia no nosso dia a dia. Eles compartilharão experiências práticas, pesquisas avançadas e visões futuras que prometem transformar a maneira como percebemos e utilizamos a tecnologia.', 2, '1'),
(2, 'Palestra', 'Programa InterStudy', '2024-11-27', 'Auditório', 'A MALTEC tem o prazer de convidar todos os estudantes para uma palestra exclusiva que abrirá portas para um emocionante programa de intercâmbio estudantil com o renomado Instituto de Tecnologia de Massachusetts (MIT). Durante esta palestra informativa, você terá a oportunidade única de aprender sobre as vantagens e experiências que aguardam aqueles que são selecionados para participar do programa de intercâmbio com o MIT. Professores e representantes do programa estarão presentes para compartilhar informações cruciais sobre os requisitos de inscrição, os benefícios acadêmicos e a vida no campus do MIT.', 2, '2'),
(3, 'Vestibular', 'Vestibular 2024', '2024-07-20', 'Maltec', 'Você está pronto para dar o próximo passo em direção a um futuro repleto de oportunidades inovadoras? A Faculdade de Tecnologia MALTEC está entusiasmada em anunciar o Vestibular para o Primeiro Semestre de 2024, convidando mentes curiosas e apaixonadas pela tecnologia a se juntarem a nós nesta jornada educacional excepcional.A Instituição é reconhecida nacional e internacionalmente por seu compromisso com a excelência acadêmica. Nossos programas de tecnologia são desenvolvidos em colaboração com líderes do setor, garantindo que nossos alunos estejam na vanguarda das últimas tendências e inovações.', 4, '3');

-- --------------------------------------------------------

--
-- Estrutura da tabela `livro`
--

DROP TABLE IF EXISTS `livro`;
CREATE TABLE IF NOT EXISTS `livro` (
  `iden_livr` int NOT NULL AUTO_INCREMENT,
  `idcs_livr` int NOT NULL,
  `imge_livr` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nome_livr` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `autr_livr` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `desc_livr` text COLLATE utf8mb4_general_ci NOT NULL,
  `link_livr` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`iden_livr`),
  UNIQUE KEY `imge_livr` (`imge_livr`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `livro`
--

INSERT INTO `livro` (`iden_livr`, `idcs_livr`, `imge_livr`, `nome_livr`, `autr_livr`, `desc_livr`, `link_livr`) VALUES
(1, 1, '01-01', 'Ciência da Computação Uma Visão Abrangente 7ª Edição', 'J. Glenn Brookshear', 'Livro aí', 'https://www.kufunda.net/publicdocs/Ci%C3%AAncia%20da%20Computa%C3%A7%C3%A3o%20-%20Uma%20Vis%C3%A3o%20Abrangente%20(Glenn%20Brookshear).pdf'),
(2, 1, '01-02', 'Ciência da Computação Uma Visão Abrangente 11ª Edição', 'J. Glenn Brookshear', 'Livro aí', ''),
(3, 1, '01-03', 'Lógica Para Ciências da Computação e Áreas Afins', 'João Nunes de Souza', 'Livro aí', ''),
(4, 1, '01-04', 'Pense Java - Guia de Aprendizagem', 'Kathy Sierra & Bert Bates', 'Livro aí', ''),
(5, 1, '01-05', 'Java 9 Interativo, reativo e modularizado', 'Rodrigo Turn', 'Livro aí', ''),
(6, 1, '01-06', 'Arduino do Básico à Internet das Coisas', 'Altair dos Santos & Sylvio Ribeiro', 'Livro aí', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `materia`
--

DROP TABLE IF EXISTS `materia`;
CREATE TABLE IF NOT EXISTS `materia` (
  `iden_matr` int NOT NULL AUTO_INCREMENT,
  `nome_matr` varchar(30) NOT NULL,
  `chor_matr` int NOT NULL,
  `abrv_matr` varchar(4) NOT NULL,
  `ccpv_matr` int NOT NULL,
  `dias_matr` int NOT NULL,
  `hora_matr` enum('A','B') NOT NULL,
  PRIMARY KEY (`iden_matr`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `materia`
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
-- Estrutura da tabela `solicitacao`
--

DROP TABLE IF EXISTS `solicitacao`;
CREATE TABLE IF NOT EXISTS `solicitacao` (
  `iden_soli` int NOT NULL AUTO_INCREMENT,
  `regx_user` int NOT NULL,
  `tipo_soli` enum('Passe Escolar','Aproveitamento','Rematrícula','Atestado','Papéis de Estágio') NOT NULL,
  `anex_soli` varchar(50) DEFAULT NULL,
  `cond_soli` varchar(10) DEFAULT NULL,
  `mtap_soli` varchar(26) DEFAULT NULL,
  `tpau_soli` varchar(20) DEFAULT NULL,
  `mtau_soli` varchar(50) DEFAULT NULL,
  `dtau_soli` date DEFAULT NULL,
  PRIMARY KEY (`iden_soli`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `solicitacao`
--

INSERT INTO `solicitacao` (`iden_soli`, `regx_user`, `tipo_soli`, `anex_soli`, `cond_soli`, `mtap_soli`, `tpau_soli`, `mtau_soli`, `dtau_soli`) VALUES
(11, 202410101, 'Passe Escolar', '1_202410101_1732118144.pdf', 'Linha A-15', NULL, NULL, NULL, NULL),
(13, 202410101, 'Aproveitamento', '2_202410101_1732120376.jpg', NULL, '[\"19\",\"22\",\"23\",\"25\"]', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `telefone`
--

DROP TABLE IF EXISTS `telefone`;
CREATE TABLE IF NOT EXISTS `telefone` (
  `iden_fone` int NOT NULL AUTO_INCREMENT,
  `iden_user` int NOT NULL,
  `nmro_fone` char(15) NOT NULL,
  PRIMARY KEY (`iden_fone`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `iden_user` int NOT NULL AUTO_INCREMENT,
  `regx_user` char(9) NOT NULL,
  `codg_user` char(14) NOT NULL,
  `nome_user` varchar(40) NOT NULL,
  `mail_user` varchar(40) NOT NULL,
  `senh_user` varchar(16) NOT NULL,
  `fone_user` char(15) NOT NULL,
  `foto_user` char(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `flag_user` enum('A','P','S') NOT NULL,
  PRIMARY KEY (`iden_user`),
  UNIQUE KEY `mail_user` (`mail_user`),
  UNIQUE KEY `codg_user` (`codg_user`),
  UNIQUE KEY `regx_user` (`regx_user`),
  UNIQUE KEY `foto_user` (`foto_user`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`iden_user`, `regx_user`, `codg_user`, `nome_user`, `mail_user`, `senh_user`, `fone_user`, `foto_user`, `flag_user`) VALUES
(1, '202410101', '111.111.111-11', 'ROGÉRIO DA SILVA LOPES', 'rogerio.lopes@maltec.sp.gov.br', 'cocacolamata', '(11) 91234-5678', 'IMG_202410101', 'A');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
