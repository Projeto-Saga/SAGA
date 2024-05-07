-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 07-Maio-2024 às 00:31
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
  `regx_user` int NOT NULL,
  `iden_curs` int NOT NULL,
  `cicl_alun` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`iden_alun`),
  UNIQUE KEY `regx_user` (`regx_user`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `aluno`
--

INSERT INTO `aluno` (`iden_alun`, `regx_user`, `iden_curs`, `cicl_alun`) VALUES
(1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cursando`
--

DROP TABLE IF EXISTS `cursando`;
CREATE TABLE IF NOT EXISTS `cursando` (
  `iden_crsn` int NOT NULL AUTO_INCREMENT,
  `regx_user` int NOT NULL,
  `iden_matr` int NOT NULL,
  `ntp1_crsn` decimal(5,2) NOT NULL DEFAULT '0.00',
  `ntp2_crsn` decimal(5,2) NOT NULL DEFAULT '0.00',
  `ntp3_crsn` decimal(5,2) NOT NULL DEFAULT '0.00',
  `nttt_crsn` decimal(5,2) NOT NULL DEFAULT '0.00',
  `falt_crsn` int NOT NULL DEFAULT '0',
  `cicl_alun` int NOT NULL,
  `_ano_crsn` char(4) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `situ_crsn` enum('Em Aberto','Retido','Aprovado') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'Em Aberto',
  PRIMARY KEY (`iden_crsn`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `cursando`
--

INSERT INTO `cursando` (`iden_crsn`, `regx_user`, `iden_matr`, `ntp1_crsn`, `ntp2_crsn`, `ntp3_crsn`, `nttt_crsn`, `falt_crsn`, `cicl_alun`, `_ano_crsn`, `situ_crsn`) VALUES
(16, 1, 1, 9.00, 8.75, 0.00, 9.50, 8, 1, '2024', 'Aprovado'),
(17, 1, 3, 9.85, 10.00, 0.00, 9.00, 0, 1, '2024', 'Aprovado');

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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

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
  `tipo_even` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nome_even` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `data_even` date NOT NULL,
  `loca_even` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `desc_even` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `dura_even` int NOT NULL,
  `imgm_even` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`iden_even`),
  UNIQUE KEY `nome_event` (`nome_even`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Extraindo dados da tabela `evento`
--

INSERT INTO `evento` (`iden_even`, `tipo_even`, `nome_even`, `data_even`, `loca_even`, `desc_even`, `dura_even`, `imgm_even`) VALUES
(1, 'Palestra', 'Interação Humano-Computador', '2023-11-29', 'Auditório', 'A revolução digital está em constante evolução, e a chave para moldar o futuro tecnológico reside na compreensão profunda da interação humano-computador. A Faculdade de Técnologia tem o prazer de apresentar uma palestra fascinante que mergulhará nas nuances dessa interação dinâmica, trazendo à tona insights cruciais e perspectivas inovadoras. Junte-se a renomados especialistas no campo da Interação Humano-Computador, cujas contribuições têm impactado significativamente a forma como interagimos com a tecnologia no nosso dia a dia. Eles compartilharão experiências práticas, pesquisas avançadas e visões futuras que prometem transformar a maneira como percebemos e utilizamos a tecnologia.', 2, 'slide-1.png'),
(2, 'Palestra', 'Programa InterStudy', '2023-11-27', 'Auditório', 'A Faculdade de Tecnologia tem o prazer de convidar todos os estudantes para uma palestra exclusiva que abrirá portas para um emocionante programa de intercâmbio estudantil com o renomado Instituto de Tecnologia de Massachusetts (MIT). Durante esta palestra informativa, você terá a oportunidade única de aprender sobre as vantagens e experiências que aguardam aqueles que são selecionados para participar do programa de intercâmbio com o MIT. Professores e representantes do programa estarão presentes para compartilhar informações cruciais sobre os requisitos de inscrição, os benefícios acadêmicos e a vida no campus do MIT.', 2, 'slide-2.png'),
(3, 'Vestibular', 'Vestibular 2024', '2024-01-07', 'FATEC', 'Você está pronto para dar o próximo passo em direção a um futuro repleto de oportunidades inovadoras? A Faculdade de Tecnologia FATEC está entusiasmada em anunciar o Vestibular para o Primeiro Semestre de 2024, convidando mentes curiosas e apaixonadas pela tecnologia a se juntarem a nós nesta jornada educacional excepcional.A Instituição é reconhecida nacional e internacionalmente por seu compromisso com a excelência acadêmica. Nossos programas de tecnologia são desenvolvidos em colaboração com líderes do setor, garantindo que nossos alunos estejam na vanguarda das últimas tendências e inovações.', 4, 'slide-3.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `materia`
--

DROP TABLE IF EXISTS `materia`;
CREATE TABLE IF NOT EXISTS `materia` (
  `iden_matr` int NOT NULL AUTO_INCREMENT,
  `nome_matr` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `chor_matr` int NOT NULL,
  `abrv_matr` varchar(4) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `ccpv_matr` int NOT NULL,
  `dias_matr` int NOT NULL,
  `hora_matr` enum('A','B') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`iden_matr`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb3;

--
-- Extraindo dados da tabela `materia`
--

INSERT INTO `materia` (`iden_matr`, `nome_matr`, `chor_matr`, `abrv_matr`, `ccpv_matr`, `dias_matr`, `hora_matr`) VALUES
(1, 'CÁLCULO I', 80, 'CAL1', 1, 1, 'A'),
(2, 'CÁLCULO II', 80, 'CAL2', 2, 1, 'A'),
(3, 'ENGENHARIA DE SOFTWARE I', 80, 'ENGI', 1, 1, 'B'),
(4, 'ENGENHARIA DE SOFTWARE II', 80, 'ENG2', 2, 1, 'B'),
(5, 'ÉTICA', 80, 'ETC', 1, 2, 'A'),
(6, 'TÉCNICAS DE PROGRAMAÇÃO I', 160, 'TCP1', 1, 3, 'A'),
(7, 'MODELAGEM DE BANCO DE DADOS ', 160, 'MBD', 1, 4, 'A'),
(8, 'BANCO DE DADOS RELACIONAL', 160, 'BDD', 2, 4, 'A'),
(9, 'TÉCNICA DE PROGRAMAÇÃO II', 160, 'TCP2', 2, 3, 'A'),
(10, 'DESENVOLVIMENTO WEB I', 160, 'DVW1', 1, 5, 'A'),
(11, 'DESENVOLVIMENTO WEB II', 160, 'DVW2', 2, 5, 'A'),
(12, 'DESENVOLVIMENTO WEB III', 160, 'DVW3', 3, 5, 'A'),
(13, 'DESENVOLVIMENTO MOBILE I', 160, 'DVM1', 3, 2, 'A'),
(14, 'ÁLGEBRA LINEAR', 80, 'AGL', 3, 1, 'A'),
(15, 'INGLÊS INSTRUMENTAL I', 80, 'ING1', 1, 2, 'B'),
(16, 'INGLÊS INSTRUMENTAL II', 80, 'ING2', 2, 2, 'B'),
(17, 'GESTÃO ÁGIL DE PROJETOS', 80, 'GAP', 2, 2, 'A'),
(18, 'INGLÊS INSTRUMENTAL III', 80, 'ING3', 3, 1, 'B'),
(19, 'INGLÊS INSTRUMENTAL IV', 80, 'ING4', 4, 1, 'B'),
(20, 'BANCO DE DADOS NÃO-RELACIONAL', 160, 'BNR', 3, 4, 'A'),
(21, 'DESENVOLVIMENTO MOBILE II', 160, 'DVM2', 4, 2, 'A'),
(22, 'COMPUTAÇÃO EM NÚVEM', 80, 'CEN', 4, 1, 'A'),
(23, 'ELABORAÇÃO DE REDAÇÃO TÉCNICA', 80, 'ERT', 4, 3, 'A'),
(24, 'EXPERIÊNCIA DE USUÁRIO', 80, 'EXU', 4, 3, 'B'),
(25, 'INTERNET DAS COISAS', 160, 'IDC', 4, 4, 'A'),
(26, 'REDES DE COMPUTADORES', 80, 'RDC', 4, 5, 'A'),
(27, 'PROGRAMAÇÃO EMBARCADA', 80, 'PRE', 4, 5, 'B');

-- --------------------------------------------------------

--
-- Estrutura da tabela `solicitacao`
--

DROP TABLE IF EXISTS `solicitacao`;
CREATE TABLE IF NOT EXISTS `solicitacao` (
  `iden_soli` int NOT NULL AUTO_INCREMENT,
  `regx_user` int NOT NULL,
  `tipo_soli` enum('Passe Escolar','Aproveitamento','Rematrícula','Atestado','Papéis de Estágio') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `anex_soli` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `cond_soli` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `mtap_soli` varchar(26) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `tpau_soli` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `mtau_soli` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `dtau_soli` date DEFAULT NULL,
  PRIMARY KEY (`iden_soli`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `telefone`
--

DROP TABLE IF EXISTS `telefone`;
CREATE TABLE IF NOT EXISTS `telefone` (
  `iden_fone` int NOT NULL AUTO_INCREMENT,
  `iden_alun` int NOT NULL,
  `nmro_fone` char(15) NOT NULL,
  PRIMARY KEY (`iden_fone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `iden_user` int NOT NULL AUTO_INCREMENT,
  `regx_user` int NOT NULL,
  `codg_user` char(14) NOT NULL,
  `nome_user` varchar(40) NOT NULL,
  `mail_user` varchar(40) NOT NULL,
  `senh_user` varchar(16) NOT NULL,
  `fone_user` char(15) NOT NULL,
  `foto_user` char(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `flag_user` enum('A','P','S') NOT NULL,
  PRIMARY KEY (`iden_user`),
  UNIQUE KEY `mail_user` (`mail_user`),
  UNIQUE KEY `codg_user` (`codg_user`),
  UNIQUE KEY `foto_user` (`foto_user`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`iden_user`, `regx_user`, `codg_user`, `nome_user`, `mail_user`, `senh_user`, `fone_user`, `foto_user`, `flag_user`) VALUES
(1, 1, '111.111.111-11', 'ROGÉRIO DA SILVA LOPES', 'rogerio.lopes@maltec.sp.gov.br', '12345678', '', NULL, 'A');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
