-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 04-Maio-2024 às 14:19
-- Versão do servidor: 5.7.36
-- versão do PHP: 8.1.3

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

CREATE TABLE `aluno` (
  `rmat_alun` int(11) NOT NULL,
  `codg_alun` char(14) NOT NULL,
  `mail_alun` varchar(100) NOT NULL,
  `nome_alun` varchar(60) NOT NULL,
  `senh_alun` varchar(24) NOT NULL,
  `fone_alun` char(15) NOT NULL,
  `curs_alun` int(11) NOT NULL,
  `cicl_alun` int(11) NOT NULL DEFAULT '1',
  `foto_alun` char(18) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `aluno`
--

INSERT INTO `aluno` (`rmat_alun`, `codg_alun`, `mail_alun`, `nome_alun`, `senh_alun`, `fone_alun`, `curs_alun`, `cicl_alun`, `foto_alun`) VALUES
(1, '111.111.111-11', 'rogerio.gomes@maltec.sp.gov.br', 'ROGÉRIO DA SILVA GOMES', 'pamonão', '(11) 91234-4567', 1, 2, NULL),
(2, '222.222.222-22', 'ariel.souza@maltec.sp.gov.br', 'ARIEL SOUZA', 'cocacolamata', '(11) 95412-5345', 1, 1, 'IMG_0000000002.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cursando`
--

CREATE TABLE `cursando` (
  `mater_curs` int(11) NOT NULL,
  `rmat_alun` int(11) NOT NULL,
  `cod_materia` int(11) NOT NULL,
  `notap1_curs` int(11) NOT NULL DEFAULT '0',
  `notap2_curs` int(11) NOT NULL DEFAULT '0',
  `notap3_curs` int(11) NOT NULL DEFAULT '0',
  `notatt_curs` int(11) NOT NULL DEFAULT '0',
  `faltas_curs` int(11) NOT NULL DEFAULT '0',
  `cicl_curs` int(11) NOT NULL,
  `ano_curs` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `situac_curs` enum('Em Aberto','Retido','Aprovado') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Em Aberto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `cursando`
--

INSERT INTO `cursando` (`mater_curs`, `rmat_alun`, `cod_materia`, `notap1_curs`, `notap2_curs`, `notap3_curs`, `notatt_curs`, `faltas_curs`, `cicl_curs`, `ano_curs`, `situac_curs`) VALUES
(1, 1, 1, 5, 3, 1, 7, 8, 1, '2023', 'Retido'),
(2, 1, 3, 10, 9, 0, 10, 0, 1, '2023', 'Aprovado'),
(3, 1, 6, 9, 8, 0, 10, 4, 1, '2023', 'Aprovado'),
(4, 1, 7, 10, 10, 0, 9, 0, 1, '2023', 'Aprovado'),
(5, 1, 1, 6, 0, 0, 8, 12, 2, '2023', 'Em Aberto'),
(6, 1, 4, 9, 0, 0, 8, 8, 2, '2023', 'Em Aberto'),
(7, 1, 8, 8, 0, 0, 7, 0, 2, '2023', 'Em Aberto'),
(8, 1, 9, 6, 0, 0, 8, 4, 2, '2023', 'Em Aberto'),
(9, 2, 1, 10, 10, 0, 10, 0, 1, '2023', 'Aprovado'),
(10, 2, 3, 10, 10, 0, 10, 0, 1, '2023', 'Aprovado'),
(11, 2, 5, 3, 6, 6, 7, 0, 1, '2023', 'Aprovado'),
(12, 2, 6, 10, 10, 0, 10, 0, 1, '2023', 'Aprovado'),
(13, 2, 7, 10, 10, 0, 10, 0, 1, '2023', 'Aprovado'),
(14, 2, 10, 10, 10, 0, 10, 0, 1, '2023', 'Aprovado'),
(15, 2, 15, 10, 10, 0, 10, 0, 1, '2023', 'Aprovado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `curso`
--

CREATE TABLE `curso` (
  `codg_curs` int(11) NOT NULL,
  `nome_curs` varchar(50) NOT NULL,
  `abrv_curs` varchar(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `curso`
--

INSERT INTO `curso` (`codg_curs`, `nome_curs`, `abrv_curs`) VALUES
(1, 'ENGENHARIA DA COMPUTAÇÃO', 'EGC'),
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
-- Estrutura da tabela `eventos`
--

CREATE TABLE `eventos` (
  `id_evento` int(11) NOT NULL,
  `tipo_event` varchar(15) NOT NULL,
  `nome_event` varchar(60) NOT NULL,
  `data_event` date NOT NULL,
  `local_event` varchar(20) NOT NULL,
  `descricao_event` text NOT NULL,
  `duracao` int(11) NOT NULL,
  `imagem_event` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `eventos`
--

INSERT INTO `eventos` (`id_evento`, `tipo_event`, `nome_event`, `data_event`, `local_event`, `descricao_event`, `duracao`, `imagem_event`) VALUES
(1, 'Palestra', 'Interação Humano-Computador', '2023-11-29', 'Auditório', 'A revolução digital está em constante evolução, e a chave para moldar o futuro tecnológico reside na compreensão profunda da interação humano-computador. A Faculdade de Técnologia tem o prazer de apresentar uma palestra fascinante que mergulhará nas nuances dessa interação dinâmica, trazendo à tona insights cruciais e perspectivas inovadoras. Junte-se a renomados especialistas no campo da Interação Humano-Computador, cujas contribuições têm impactado significativamente a forma como interagimos com a tecnologia no nosso dia a dia. Eles compartilharão experiências práticas, pesquisas avançadas e visões futuras que prometem transformar a maneira como percebemos e utilizamos a tecnologia.', 2, 'slide-1.png'),
(2, 'Palestra', 'Programa InterStudy', '2023-11-27', 'Auditório', 'A Faculdade de Tecnologia tem o prazer de convidar todos os estudantes para uma palestra exclusiva que abrirá portas para um emocionante programa de intercâmbio estudantil com o renomado Instituto de Tecnologia de Massachusetts (MIT). Durante esta palestra informativa, você terá a oportunidade única de aprender sobre as vantagens e experiências que aguardam aqueles que são selecionados para participar do programa de intercâmbio com o MIT. Professores e representantes do programa estarão presentes para compartilhar informações cruciais sobre os requisitos de inscrição, os benefícios acadêmicos e a vida no campus do MIT.', 2, 'slide-2.png'),
(3, 'Vestibular', 'Vestibular 2024', '2024-01-07', 'FATEC', 'Você está pronto para dar o próximo passo em direção a um futuro repleto de oportunidades inovadoras? A Faculdade de Tecnologia FATEC está entusiasmada em anunciar o Vestibular para o Primeiro Semestre de 2024, convidando mentes curiosas e apaixonadas pela tecnologia a se juntarem a nós nesta jornada educacional excepcional.A Instituição é reconhecida nacional e internacionalmente por seu compromisso com a excelência acadêmica. Nossos programas de tecnologia são desenvolvidos em colaboração com líderes do setor, garantindo que nossos alunos estejam na vanguarda das últimas tendências e inovações.', 4, 'slide-3.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `id_func` int(11) NOT NULL,
  `codg_func` char(14) COLLATE utf8_unicode_ci NOT NULL,
  `mail_func` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nome_func` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `senh_func` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `fone_func` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `flag_func` enum('S','P') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `materia`
--

CREATE TABLE `materia` (
  `cod_materia` int(11) NOT NULL,
  `nome_materia` varchar(30) NOT NULL,
  `carga_horaria` int(11) NOT NULL,
  `abrv_materia` varchar(4) NOT NULL,
  `ciclprev_materia` int(11) NOT NULL,
  `dia_materia` int(11) NOT NULL,
  `hor_materia` enum('A','B') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `materia`
--

INSERT INTO `materia` (`cod_materia`, `nome_materia`, `carga_horaria`, `abrv_materia`, `ciclprev_materia`, `dia_materia`, `hor_materia`) VALUES
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
(17, 'GESTÃO ÁGIL DE PROJETOS', 80, 'GAP', 2, 2, 'A');

-- --------------------------------------------------------

--
-- Estrutura da tabela `solicitacoes`
--

CREATE TABLE `solicitacoes` (
  `id_solc` int(11) NOT NULL,
  `rmat_alun` int(11) NOT NULL,
  `tipo_solc` enum('Passe Escolar','Aproveitamento','Rematrícula','Atestado','Papéis de Estágio') COLLATE utf8_unicode_ci NOT NULL,
  `anexo_solc` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trans_solc` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mtap_solc` varchar(26) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tpau_solc` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mtau_solc` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dtau_solc` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `solicitacoes`
--

INSERT INTO `solicitacoes` (`id_solc`, `rmat_alun`, `tipo_solc`, `anexo_solc`, `trans_solc`, `mtap_solc`, `tpau_solc`, `mtau_solc`, `dtau_solc`) VALUES
(24, 2, 'Passe Escolar', '2_1701126352_imagem_2023-11-27_200545599.png', 'Linha A-09', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `telefone`
--

CREATE TABLE `telefone` (
  `iden_fone` int(11) NOT NULL,
  `idal_fone` int(11) NOT NULL,
  `nmro_fone` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `telefone`
--

INSERT INTO `telefone` (`iden_fone`, `idal_fone`, `nmro_fone`) VALUES
(12, 2, '(11) 98737-6222');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`rmat_alun`),
  ADD UNIQUE KEY `codg_alun` (`codg_alun`),
  ADD UNIQUE KEY `mail_alun` (`mail_alun`);

--
-- Índices para tabela `cursando`
--
ALTER TABLE `cursando`
  ADD PRIMARY KEY (`mater_curs`);

--
-- Índices para tabela `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`codg_curs`),
  ADD UNIQUE KEY `nome_curs` (`nome_curs`),
  ADD UNIQUE KEY `abrv_curs` (`abrv_curs`);

--
-- Índices para tabela `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id_evento`),
  ADD UNIQUE KEY `nome_event` (`nome_event`);

--
-- Índices para tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`id_func`),
  ADD UNIQUE KEY `codg_prof` (`codg_func`),
  ADD UNIQUE KEY `mail_prof` (`mail_func`);

--
-- Índices para tabela `materia`
--
ALTER TABLE `materia`
  ADD PRIMARY KEY (`cod_materia`);

--
-- Índices para tabela `solicitacoes`
--
ALTER TABLE `solicitacoes`
  ADD PRIMARY KEY (`id_solc`);

--
-- Índices para tabela `telefone`
--
ALTER TABLE `telefone`
  ADD PRIMARY KEY (`iden_fone`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `aluno`
--
ALTER TABLE `aluno`
  MODIFY `rmat_alun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `cursando`
--
ALTER TABLE `cursando`
  MODIFY `mater_curs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `curso`
--
ALTER TABLE `curso`
  MODIFY `codg_curs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `id_func` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `materia`
--
ALTER TABLE `materia`
  MODIFY `cod_materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `solicitacoes`
--
ALTER TABLE `solicitacoes`
  MODIFY `id_solc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `telefone`
--
ALTER TABLE `telefone`
  MODIFY `iden_fone` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
