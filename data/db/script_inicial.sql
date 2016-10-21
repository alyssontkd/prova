-- MySQL dump 10.16  Distrib 10.1.9-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: bdprovatudo
-- ------------------------------------------------------
-- Server version	10.1.9-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `bdprovatudo`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `bdprovatudo` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `bdprovatudo`;

--
-- Temporary table structure for view `acl`
--

DROP TABLE IF EXISTS `acl`;
/*!50001 DROP VIEW IF EXISTS `acl`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `acl` (
  `id_perfil` tinyint NOT NULL,
  `nm_resource` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `action`
--

DROP TABLE IF EXISTS `action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `action` (
  `id_action` int(11) NOT NULL AUTO_INCREMENT,
  `nm_action` varchar(200) DEFAULT NULL COMMENT '{"label":"Ação"}',
  PRIMARY KEY (`id_action`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action`
--

LOCK TABLES `action` WRITE;
/*!40000 ALTER TABLE `action` DISABLE KEYS */;
INSERT INTO `action` VALUES (1,'index'),(2,'course-information'),(3,'access-course'),(4,'view-pay'),(5,'list'),(6,'cadastro'),(7,'gravar'),(8,'excluir'),(9,'upload'),(10,'download-img-pay'),(11,'download-video-course'),(12,'up-line'),(13,'uni-level'),(14,'dados-pessoais'),(15,'atualizar-dados'),(16,'obter-cidades'),(17,'gravar-atualizacao'),(18,'extrato'),(19,'solicitar-saque'),(20,'liberar-pagamento'),(21,'list-pagamentos-realizados'),(22,'list-contratos-pendentes'),(23,'excluir-contrato'),(24,'enviar-codigo'),(25,'view-video'),(26,'solicitar-patrocinador'),(27,'enviar-id'),(28,'recusar-patrocinador'),(29,'list-ativacao'),(30,'ativar-id'),(31,'gerar-recibo'),(32,'list-saques-realizados'),(33,'liberar-saque'),(34,'negar-saque'),(35,'negar-id'),(36,'alterar-senha'),(37,'salvar-redefinicao-senha'),(38,'imprimir-boleto'),(39,'xxx'),(40,'autocompletecidade'),(41,'cadastrocustomizado'),(42,'cadastroviaacademia'),(43,'gravarviaacademia'),(44,'excluirviaacademia'),(45,'alterarviaacademia'),(46,'gravaralteracaoviaacademia'),(47,'autocompleteacademia'),(48,'carregarsugestaoidadeporcategoria'),(49,'realizarinscricoes'),(50,'autocompleteatleta'),(51,'index-pagination'),(52,'cadastroperiodoletivodetalhe'),(53,'detalhe-pagination'),(54,'adicionarperiodoletivodetalhe'),(55,'excluirvialistagemperiodoletivo'),(56,'teste'),(57,'listar-permissoes-acoes'),(58,'relacionar-materia'),(59,'excluir-relacao-materia-semestre'),(60,'cadastro-alternativas'),(61,'gravar-alternativas'),(62,'gerar-pdf-quantitativo-questoes-por-assunto'),(63,'gerar-relatorio-pdf'),(64,'cadastro-questao'),(65,'adicionar-questao-aleatoria'),(66,'gravar-questao-aleatoria'),(67,'imprimir-prova-pdf'),(68,'cadastro-via-prova'),(69,'imprimir-gabarito-pdf'),(70,'desativar'),(71,'adicionar-questao-manual'),(72,'adicionar-varias-questoes-aleatorias'),(73,'detalhes-filtros-pagination'),(74,'gravar-varias-questoes-aleatorias'),(75,'gravar-adicionar-varias-questoes-aleatorias'),(76,'gravar-questao-manual');
/*!40000 ALTER TABLE `action` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alternativa_questao`
--

DROP TABLE IF EXISTS `alternativa_questao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alternativa_questao` (
  `id_alternativa_questao` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_usuario_cadastro` int(11) DEFAULT NULL,
  `id_usuario_alteracao` int(11) DEFAULT NULL,
  `id_questao` bigint(20) DEFAULT NULL,
  `tx_alternativa_questao` text,
  `cs_correta` char(1) DEFAULT NULL,
  `tx_justificativa` text,
  `dt_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dt_alteracao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tx_caminho_imagem_alternativa` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id_alternativa_questao`),
  KEY `FK_Reference_58` (`id_usuario_cadastro`),
  KEY `FK_Reference_59` (`id_usuario_alteracao`),
  KEY `FK_Reference_60` (`id_questao`),
  CONSTRAINT `FK_Reference_58` FOREIGN KEY (`id_usuario_cadastro`) REFERENCES `usuario` (`id_usuario`),
  CONSTRAINT `FK_Reference_59` FOREIGN KEY (`id_usuario_alteracao`) REFERENCES `usuario` (`id_usuario`),
  CONSTRAINT `FK_Reference_60` FOREIGN KEY (`id_questao`) REFERENCES `questao` (`id_questao`)
) ENGINE=InnoDB AUTO_INCREMENT=178 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alternativa_questao`
--

LOCK TABLES `alternativa_questao` WRITE;
/*!40000 ALTER TABLE `alternativa_questao` DISABLE KEYS */;
INSERT INTO `alternativa_questao` VALUES (128,1,1,12,'0, 1 e 0 no caso de passagem de parâmetros por valor e 0, 1 e 0 no caso de passagem de parâmetros por referência','E','Justificativa Questão 1','2016-10-17 17:01:07','2016-10-17 17:01:07',NULL),(129,1,1,12,'0, 1 e 0 no caso de passagem de parâmetros por valor e 0, 1 e 1 no caso de passagem de parâmetros por referência.','C','Justificativa 2','2016-10-17 17:01:07','2016-10-17 17:01:07',NULL),(130,1,1,12,'0, 1 e 1 no caso de passagem de parâmetros por valor e 0, 1 e 0 no caso de passagem de parâmetros por referência.','E','Justificativa 3','2016-10-17 17:01:07','2016-10-17 17:01:07',NULL),(131,1,1,12,'0, 1 e 1 no caso de passagem de parâmetros por valor e 0, 1 e 1 no caso de passagem de parâmetros por referência.','E','Justificativa 4','2016-10-17 17:01:07','2016-10-17 17:01:07',NULL),(132,1,1,12,'0, 0 e 0 no caso de passagem de parâmetros por valor e 0, 1 e 1 no caso de passagem de parâmetros por referência.','E','Justificativa 5','2016-10-17 17:01:07','2016-10-17 17:01:07',NULL),(133,1,1,1,'percorrer a subárvore da direita, em seguida visitar a raiz e, finalmente, percorrer a subárvore da esquerda','E','Justificativa 1','2016-10-17 17:12:51','2016-10-17 17:12:51',NULL),(134,1,1,1,'percorrer a subárvore da esquerda, em seguida percorrer a subárvore da direita e, finalmente, visitar a raiz.','E','Justificativa 2','2016-10-17 17:12:51','2016-10-17 17:12:51',NULL),(135,1,1,1,'percorrer a subárvore da direita, em seguida percorrer a subárvore da esquerda e, finalmente, visitar a raiz.','E','Justificativa 3','2016-10-17 17:12:51','2016-10-17 17:12:51',NULL),(136,1,1,1,'percorrer a subárvore da esquerda, em seguida visitar a raiz e, finalmente, percorrer a subárvore da direita.','E','Justificativa 4','2016-10-17 17:12:51','2016-10-17 17:12:51',NULL),(137,1,1,1,'visitar a raiz, em seguida percorrer a subárvore da esquerda e, finalmente, percorrer a subárvore da direita.','C','Justificativa 5','2016-10-17 17:12:51','2016-10-17 17:12:51',NULL),(138,1,1,13,'hiberbólica','E','...','2016-10-17 17:14:46','2016-10-17 17:14:46',NULL),(139,1,1,13,'de busca binária.','E','...','2016-10-17 17:14:46','2016-10-17 17:14:46',NULL),(140,1,1,13,'ordenada.','E','...','2016-10-17 17:14:46','2016-10-17 17:14:46',NULL),(141,1,1,13,'AVL','C','...','2016-10-17 17:14:46','2016-10-17 17:14:46',NULL),(142,1,1,13,'binária','E','...','2016-10-17 17:14:46','2016-10-17 17:14:46',NULL),(143,1,1,14,'Uma árvore binária é aquela que tem como conteúdo somente valores binários.','E','...','2016-10-17 17:17:47','2016-10-17 17:17:47',NULL),(144,1,1,14,'O percurso de uma árvore binária, conhecido como préordem, visita a raiz, depois a sub-árvore esquerda e depois a sub-árvore direita.','C','...','2016-10-17 17:17:47','2016-10-17 17:17:47',NULL),(145,1,1,14,'Uma árvore é composta por duas raízes, sendo uma principal e a outra secundária.','E','...','2016-10-17 17:17:47','2016-10-17 17:17:47',NULL),(146,1,1,14,'As operações básicas sobre árvores são extrai-raiz e alterarfolha.','E','...','2016-10-17 17:17:47','2016-10-17 17:17:47',NULL),(147,1,1,14,'O percurso de uma árvore binária, conhecido como subordem, visita a sub-árvore direita, depois a raiz e depois a subárvore esquerda.','E','...','2016-10-17 17:17:47','2016-10-17 17:17:47',NULL),(148,1,1,15,'SelectionSort e InsertionSort','E','...','2016-10-17 17:24:05','2016-10-17 17:24:05',NULL),(149,1,1,15,'MergeSort e BubbleSort','E','...','2016-10-17 17:24:05','2016-10-17 17:24:05',NULL),(150,1,1,15,'QuickSort e SelectionSort','E','...','2016-10-17 17:24:05','2016-10-17 17:24:05',NULL),(151,1,1,15,'BubbleSort e QuickSort','C','...','2016-10-17 17:24:05','2016-10-17 17:24:05',NULL),(152,1,1,15,'InsertionSort e MergeSort','E','...','2016-10-17 17:24:05','2016-10-17 17:24:05',NULL),(153,1,1,16,'1','E','...','2016-10-17 17:27:26','2016-10-17 17:27:26',NULL),(154,1,1,16,'2','E','...','2016-10-17 17:27:26','2016-10-17 17:27:26',NULL),(155,1,1,16,'3','E','...','2016-10-17 17:27:26','2016-10-17 17:27:26',NULL),(156,1,1,16,'4','C','...','2016-10-17 17:27:26','2016-10-17 17:27:26',NULL),(157,1,1,16,'5','E','...','2016-10-17 17:27:26','2016-10-17 17:27:26',NULL),(158,1,1,17,'1','E','...','2016-10-17 17:32:58','2016-10-17 17:32:58',NULL),(159,1,1,17,'2','E','...','2016-10-17 17:32:59','2016-10-17 17:32:59',NULL),(160,1,1,17,'3','E','...','2016-10-17 17:32:59','2016-10-17 17:32:59',NULL),(161,1,1,17,'4','E','...','2016-10-17 17:32:59','2016-10-17 17:32:59',NULL),(162,1,1,17,'5','C','...','2016-10-17 17:32:59','2016-10-17 17:32:59',NULL),(163,1,1,18,'1','E','...','2016-10-17 17:40:07','2016-10-17 17:40:07',NULL),(164,1,1,18,'2','E','...','2016-10-17 17:40:07','2016-10-17 17:40:07',NULL),(165,1,1,18,'3','E','...','2016-10-17 17:40:07','2016-10-17 17:40:07',NULL),(166,1,1,18,'4','C','...','2016-10-17 17:40:08','2016-10-17 17:40:08',NULL),(167,1,1,18,'5','E','...','2016-10-17 17:40:08','2016-10-17 17:40:08',NULL),(168,1,1,19,'V  V  V','E','...','2016-10-17 17:44:43','2016-10-17 17:44:43',NULL),(169,1,1,19,'F  F  V','C','...','2016-10-17 17:44:43','2016-10-17 17:44:43',NULL),(170,1,1,19,'F  F  F','E','...','2016-10-17 17:44:43','2016-10-17 17:44:43',NULL),(171,1,1,19,'V V  F','E','...','2016-10-17 17:44:44','2016-10-17 17:44:44',NULL),(172,1,1,19,'F  V V','E','....','2016-10-17 17:44:44','2016-10-17 17:44:44',NULL),(173,1,1,20,'V - V - V','E','...','2016-10-17 17:46:48','2016-10-17 17:46:48',NULL),(174,1,1,20,'F - F - V','C','...','2016-10-17 17:46:48','2016-10-17 17:46:48',NULL),(175,1,1,20,'F - F - F','E','...','2016-10-17 17:46:48','2016-10-17 17:46:48',NULL),(176,1,1,20,'V - V - F','E','...','2016-10-17 17:46:48','2016-10-17 17:46:48',NULL),(177,1,1,20,'F - V - V','E','...','2016-10-17 17:46:48','2016-10-17 17:46:48',NULL);
/*!40000 ALTER TABLE `alternativa_questao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assunto_materia`
--

DROP TABLE IF EXISTS `assunto_materia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assunto_materia` (
  `id_assunto_materia` int(11) NOT NULL AUTO_INCREMENT,
  `id_materia` smallint(6) DEFAULT NULL,
  `nm_assunto_materia` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_assunto_materia`),
  KEY `FK_Reference_45` (`id_materia`),
  CONSTRAINT `FK_Reference_45` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assunto_materia`
--

LOCK TABLES `assunto_materia` WRITE;
/*!40000 ALTER TABLE `assunto_materia` DISABLE KEYS */;
INSERT INTO `assunto_materia` VALUES (1,1,'Noções Gerais de Direito Administrativo'),(2,1,'Organização Administrativa'),(3,1,'Regime Constitucional de Agente Público'),(4,2,'Noções de Direito Processual'),(5,2,'Principios Informativos do Direito Processual'),(6,2,'Principios Informativos do Procedimento');
/*!40000 ALTER TABLE `assunto_materia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `auth`
--

DROP TABLE IF EXISTS `auth`;
/*!50001 DROP VIEW IF EXISTS `auth`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `auth` (
  `id_usuario` tinyint NOT NULL,
  `id_perfil` tinyint NOT NULL,
  `em_email` tinyint NOT NULL,
  `pw_senha` tinyint NOT NULL,
  `nm_usuario` tinyint NOT NULL,
  `id_contrato` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `classificacao_semestre`
--

DROP TABLE IF EXISTS `classificacao_semestre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classificacao_semestre` (
  `id_classificacao_semestre` smallint(6) NOT NULL AUTO_INCREMENT,
  `nm_classificacao_semestre` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_classificacao_semestre`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classificacao_semestre`
--

LOCK TABLES `classificacao_semestre` WRITE;
/*!40000 ALTER TABLE `classificacao_semestre` DISABLE KEYS */;
INSERT INTO `classificacao_semestre` VALUES (1,'1º Semestre'),(2,'2º Semestre'),(3,'3º Semestre'),(4,'4º Semestre'),(5,'5º Semestre'),(6,'6º Semestre'),(7,'7º Semestre'),(8,'8º Semestre'),(9,'9º Semestre'),(10,'10º Semestre'),(11,'Pós-Graduação'),(12,'Mestrado'),(13,'Doutorado'),(14,'PHD');
/*!40000 ALTER TABLE `classificacao_semestre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `idconfigs` int(11) NOT NULL AUTO_INCREMENT,
  `nm_config` varchar(200) DEFAULT NULL COMMENT '{"label":"Nome da Configuração"}',
  `nm_valor` varchar(200) DEFAULT NULL COMMENT '{"label":"Valor"}',
  PRIMARY KEY (`idconfigs`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config`
--

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES (1,'valor_por','99.00'),(2,'valor_de','119.00'),(3,'agencia','0643'),(4,'op','013'),(5,'conta_corrente','782.632-8'),(6,'favorecido','Alysson Vicuña de Oliveira'),(7,'situacao_pagamento_pendente','1'),(8,'situacao_pagamento_atraso','3'),(9,'situacao_pagamento_pago','2'),(10,'situacao_ativo','1'),(11,'situacao_inativo','2'),(12,'tipo_pagamento_mensalidade','1'),(13,'tipo_usuario_administrador','1'),(14,'tipo_usuario_aluno','2'),(15,'situacao_usuario_ativo','1'),(16,'situacao_usuario_inativo','2'),(17,'situacao_usuario_congelado','3'),(19,'perfil_administrador','1'),(20,'perfil_aluno','3'),(21,'qtd_niveis','3'),(22,'qtd_por_nivel','5'),(23,'tipo_telefone_residencial','1'),(24,'tipo_telefone_comercial','2'),(25,'tipo_telefone_celular','3'),(26,'telefone_admin','6191123250'),(27,'email_admin','alyssontkd@gmail.com'),(28,'nome_admin','Alysson Vicuña de Oliveira'),(29,'telefone_cel_admin','61991123250'),(30,'tipo_pagamento_bonus','2'),(32,'tipo_pagamento_saque','3'),(33,'limite_minimo_saque','300'),(34,'situacao_usuario_atrasado','4'),(35,'situacao_empresa_contrato_ativo','1'),(36,'situacao_empresa_contrato_inativo','2'),(37,'situacao_empresa_contrato_congelado','3'),(38,'situacao_empresa_contrato_regusado','4'),(39,'situacao_solicitacao_empresa_recusado','3'),(40,'situacao_solicitacao_empresa_aprovado','2'),(41,'situacao_solicitacao_empresa_pendente','1'),(42,'codigo_video_apresentacao','UsSSUglRMAw'),(43,'link_conferencia','login.hotconference.net.br/conference'),(44,'cnpj','08.988.564/0001-30'),(45,'razao_social','MC DE SA LIMA EPP'),(46,'endereco','SIA TR 05 LT 05 35 SL 211 ED. IMPORT CENTER GUARA DISTRITO FEDERAL'),(47,'exibir_no_combo','S'),(48,'nao_exibir_no_combo','N'),(49,'masculino','1'),(50,'feminino','2'),(51,'perfil_professor','2');
/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `controller`
--

DROP TABLE IF EXISTS `controller`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `controller` (
  `id_controller` int(11) NOT NULL AUTO_INCREMENT,
  `nm_controller` varchar(400) DEFAULT NULL COMMENT '{"label":"Controller"}',
  `nm_modulo` varchar(50) DEFAULT NULL,
  `cs_exibir_combo` char(1) DEFAULT 'S',
  PRIMARY KEY (`id_controller`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `controller`
--

LOCK TABLES `controller` WRITE;
/*!40000 ALTER TABLE `controller` DISABLE KEYS */;
INSERT INTO `controller` VALUES (1,'arte_marcial-artemarcial','Arte Marcial','S'),(2,'estilo-estilo','Estilo da Arte','S'),(3,'usuario-usuario','Usuario','S'),(4,'application-index','Aplicação','N'),(5,'cidade-cidade','Cidade','S'),(6,'estado-estado','Estado','S'),(7,'graduacao-graduacao','Graduação','S'),(8,'pagamento-pagamento','Pagamento','S'),(9,'PhpBoletoZf2\\Controller\\Itau','Boleto do Itau','N'),(10,'banco-banco','Banco','S'),(11,'principal-principal','Principal','S'),(12,'perfil-perfil','Perfil','S'),(13,'tipo_evento-tipoevento','Tipo de Evento','S'),(14,'evento-evento','Evento','S'),(15,'graduacao','Teste de Action ','N'),(16,'academia-academia','Academia','S'),(17,'atleta-atleta','Atleta','S'),(18,'categoria_peso-categoriapeso','Categoria de Peso','S'),(19,'categoria_idade-categoriaidade','Categoria de Idade','S'),(20,'regras_lutas-regraslutas','Regras de Luta','S'),(21,'detalhes_regras_luta-detalhesregrasluta','Definição das Regras de Luta','S'),(22,'inscricoes_evento-inscricoesevento','Inscrições nos Eventos','S'),(23,'periodo_letivo-periodoletivo','Periodo Letivo','S'),(24,'detalhe_periodo_letivo','Detalhe Periodo Letivo','S'),(25,'controller-controller','Controller','S'),(26,'action-action','Actions','S'),(27,'teste-teste','Modulo teste','S'),(28,'prova-prova','Prova','S'),(29,'nivel_dificuldade-niveldificuldade','Nível de Dificuldade','S'),(30,'unidade_tempo-unidadetempo','Unidade de Tempo','S'),(31,'temporizacao-temporizacao','Temporização','S'),(32,'permissao-permissao','Gerenciador de Permissão','S'),(33,'tipo-questao_tipoquestao','Tipo de Questao','S'),(34,'assunto-materia_assuntomateria','Assunto Materia','S'),(35,'infra-infra','Infraestrutura','S'),(36,'fonte-fonte','Fonte da Questão','S'),(37,'classificacao-classificacao','Classificação de Semestre','S'),(38,'materia-materia','Matéria da Questão','N'),(39,'assunto_materia-assuntomateria','Assunto de Cada Matéria','S'),(40,'tipo_questao-tipoquestao','Tipo de Questão','S'),(41,'materia_semestre-materiasemestre','Matérias por Semestre','S'),(42,'questao-questao','Questao','S'),(43,'relatorio-relatorio','Relatorios','S'),(44,'questoes_prova-questoesprova','Questoes Prova','S'),(45,'filtro_prova-filtroprova','Filtros da prova','S');
/*!40000 ALTER TABLE `controller` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email`
--

DROP TABLE IF EXISTS `email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email` (
  `id_email` int(11) NOT NULL AUTO_INCREMENT,
  `em_email` varchar(200) DEFAULT NULL COMMENT '{"label":"E-mail"}',
  `id_situacao` int(11) NOT NULL,
  PRIMARY KEY (`id_email`),
  KEY `FK_Reference_32` (`id_situacao`),
  CONSTRAINT `FK_Reference_32` FOREIGN KEY (`id_situacao`) REFERENCES `situacao` (`id_situacao`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email`
--

LOCK TABLES `email` WRITE;
/*!40000 ALTER TABLE `email` DISABLE KEYS */;
INSERT INTO `email` VALUES (1,'administrador@gmail.com',1),(2,'alyssontkd@gmail.com',1),(3,'teste001@gmail.com',1),(4,'teste002@gmail.com',1);
/*!40000 ALTER TABLE `email` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `esqueci_senha`
--

DROP TABLE IF EXISTS `esqueci_senha`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `esqueci_senha` (
  `id_esqueci_senha` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `tx_identificacao` varchar(60) DEFAULT NULL,
  `id_situacao` int(11) DEFAULT NULL,
  `dt_solicitacao` datetime DEFAULT NULL,
  `dt_alteracao` datetime NOT NULL,
  PRIMARY KEY (`id_esqueci_senha`),
  KEY `fk_esqueci_senha_situacoes1` (`id_situacao`),
  KEY `fk_esqueci_senha_usuarios1` (`id_usuario`),
  CONSTRAINT `fk_esqueci_senha_situacoes1` FOREIGN KEY (`id_situacao`) REFERENCES `situacao` (`id_situacao`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_esqueci_senha_usuarios1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `esqueci_senha`
--

LOCK TABLES `esqueci_senha` WRITE;
/*!40000 ALTER TABLE `esqueci_senha` DISABLE KEYS */;
INSERT INTO `esqueci_senha` VALUES (1,3,'9cbf6bab3c6b428fafd6ebd7965df386',1,'2015-07-25 09:35:13','0000-00-00 00:00:00'),(2,4,'1e4bf63079dd38bff6fd2bcc65bcca4f',1,'2015-07-25 09:57:15','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `esqueci_senha` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `filtro_prova`
--

DROP TABLE IF EXISTS `filtro_prova`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `filtro_prova` (
  `id_filtro_prova` int(11) NOT NULL AUTO_INCREMENT,
  `id_prova` bigint(20) DEFAULT NULL,
  `id_tipo_questao` smallint(6) DEFAULT NULL,
  `id_fonte_questao` smallint(6) DEFAULT NULL,
  `id_assunto_materia` int(11) DEFAULT NULL,
  `id_nivel_dificuldade` tinyint(4) DEFAULT NULL,
  `id_classificacao_semestre` smallint(6) DEFAULT NULL,
  `nr_questoes` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_filtro_prova`),
  KEY `FK_Reference_119` (`id_prova`),
  KEY `FK_Reference_120` (`id_tipo_questao`),
  KEY `FK_Reference_121` (`id_fonte_questao`),
  KEY `FK_Reference_122` (`id_assunto_materia`),
  KEY `FK_Reference_123` (`id_nivel_dificuldade`),
  KEY `FK_Reference_124` (`id_classificacao_semestre`),
  CONSTRAINT `FK_Reference_119` FOREIGN KEY (`id_prova`) REFERENCES `prova` (`id_prova`),
  CONSTRAINT `FK_Reference_120` FOREIGN KEY (`id_tipo_questao`) REFERENCES `tipo_questao` (`id_tipo_questao`),
  CONSTRAINT `FK_Reference_121` FOREIGN KEY (`id_fonte_questao`) REFERENCES `fonte_questao` (`id_fonte_questao`),
  CONSTRAINT `FK_Reference_122` FOREIGN KEY (`id_assunto_materia`) REFERENCES `assunto_materia` (`id_assunto_materia`),
  CONSTRAINT `FK_Reference_123` FOREIGN KEY (`id_nivel_dificuldade`) REFERENCES `nivel_dificuldade` (`id_nivel_dificuldade`),
  CONSTRAINT `FK_Reference_124` FOREIGN KEY (`id_classificacao_semestre`) REFERENCES `classificacao_semestre` (`id_classificacao_semestre`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `filtro_prova`
--

LOCK TABLES `filtro_prova` WRITE;
/*!40000 ALTER TABLE `filtro_prova` DISABLE KEYS */;
INSERT INTO `filtro_prova` VALUES (1,14,1,1,2,4,3,6),(2,14,1,4,3,3,4,2);
/*!40000 ALTER TABLE `filtro_prova` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fonte_questao`
--

DROP TABLE IF EXISTS `fonte_questao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fonte_questao` (
  `id_fonte_questao` smallint(6) NOT NULL AUTO_INCREMENT,
  `nm_fonte_questao` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_fonte_questao`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fonte_questao`
--

LOCK TABLES `fonte_questao` WRITE;
/*!40000 ALTER TABLE `fonte_questao` DISABLE KEYS */;
INSERT INTO `fonte_questao` VALUES (1,'Projeção'),(2,'Universia'),(3,'CESPE'),(4,'Wikipedia');
/*!40000 ALTER TABLE `fonte_questao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historico_alternativas_questao`
--

DROP TABLE IF EXISTS `historico_alternativas_questao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historico_alternativas_questao` (
  `id_historico_alternativa_questao` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_historico_questao_prova` bigint(20) DEFAULT NULL,
  `id_alternativa_questao` bigint(20) DEFAULT NULL,
  `id_usuario_cadastro` int(11) DEFAULT NULL,
  `id_usuario_alteracao` int(11) DEFAULT NULL,
  `id_questao` bigint(20) DEFAULT NULL,
  `tx_alternativa_questao` text,
  `tx_caminho_imagem_alternativa` varchar(1000) DEFAULT NULL,
  `cs_correta` char(1) DEFAULT NULL,
  `tx_justificativa` text,
  `dt_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dt_alteracao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_historico_alternativa_questao`),
  KEY `FK_Reference_63` (`id_historico_questao_prova`),
  CONSTRAINT `FK_Reference_63` FOREIGN KEY (`id_historico_questao_prova`) REFERENCES `historico_questoes_prova` (`id_historico_questao_prova`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historico_alternativas_questao`
--

LOCK TABLES `historico_alternativas_questao` WRITE;
/*!40000 ALTER TABLE `historico_alternativas_questao` DISABLE KEYS */;
/*!40000 ALTER TABLE `historico_alternativas_questao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historico_prova`
--

DROP TABLE IF EXISTS `historico_prova`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historico_prova` (
  `id_prova_historico` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_prova` bigint(20) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `nm_prova` varchar(100) DEFAULT NULL,
  `ds_prova` text,
  `dt_aplicacao_prova` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `dt_geracao_prova` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_prova_historico`),
  KEY `FK_Reference_61` (`id_usuario`),
  CONSTRAINT `FK_Reference_61` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historico_prova`
--

LOCK TABLES `historico_prova` WRITE;
/*!40000 ALTER TABLE `historico_prova` DISABLE KEYS */;
/*!40000 ALTER TABLE `historico_prova` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historico_questoes_prova`
--

DROP TABLE IF EXISTS `historico_questoes_prova`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historico_questoes_prova` (
  `id_historico_questao_prova` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_prova_historico` bigint(20) DEFAULT NULL,
  `id_questao_prova` bigint(20) DEFAULT NULL,
  `id_questao` bigint(20) DEFAULT NULL,
  `id_prova` bigint(20) DEFAULT NULL,
  `tx_enunciado` text,
  `tx_caminho_imagem_questao` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id_historico_questao_prova`),
  KEY `FK_Reference_62` (`id_prova_historico`),
  CONSTRAINT `FK_Reference_62` FOREIGN KEY (`id_prova_historico`) REFERENCES `historico_prova` (`id_prova_historico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historico_questoes_prova`
--

LOCK TABLES `historico_questoes_prova` WRITE;
/*!40000 ALTER TABLE `historico_questoes_prova` DISABLE KEYS */;
/*!40000 ALTER TABLE `historico_questoes_prova` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login` (
  `id_Login` int(11) NOT NULL AUTO_INCREMENT,
  `pw_senha` varchar(40) DEFAULT NULL COMMENT '{"label":"Senha"}',
  `nr_tentativas` int(11) DEFAULT NULL COMMENT '{"label":"Tentativas"}',
  `dt_visita` datetime DEFAULT NULL COMMENT '{"label":"Data da última visita"}',
  `dt_registro` datetime DEFAULT NULL COMMENT '{"label":"Data de Registro"}',
  `id_usuario` int(11) NOT NULL,
  `id_email` int(11) NOT NULL,
  `id_situacao` int(11) NOT NULL,
  `id_perfil` int(11) NOT NULL,
  PRIMARY KEY (`id_Login`),
  KEY `ix_Login_emails` (`id_email`),
  KEY `FK_Reference_26` (`id_perfil`),
  KEY `FK_Reference_39` (`id_usuario`),
  KEY `fk_Login_situacao` (`id_situacao`),
  CONSTRAINT `FK_Reference_26` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`),
  CONSTRAINT `FK_Reference_39` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  CONSTRAINT `fk_Login_emails` FOREIGN KEY (`id_email`) REFERENCES `email` (`id_email`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Login_situacao` FOREIGN KEY (`id_situacao`) REFERENCES `situacao` (`id_situacao`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login`
--

LOCK TABLES `login` WRITE;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` VALUES (1,'e10adc3949ba59abbe56e057f20f883e',1,'2014-08-27 21:53:33','2014-08-27 21:53:37',1,1,1,1),(2,'d04cbb637213179e1f8269f75d5d7cfc',NULL,NULL,'2015-01-30 15:01:11',2,2,1,2),(3,'d04cbb637213179e1f8269f75d5d7cfc',NULL,NULL,'2015-02-20 17:02:55',3,3,1,2),(4,'d04cbb637213179e1f8269f75d5d7cfc',NULL,NULL,'2015-02-20 17:02:57',4,4,1,2);
/*!40000 ALTER TABLE `login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materia`
--

DROP TABLE IF EXISTS `materia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `materia` (
  `id_materia` smallint(6) NOT NULL AUTO_INCREMENT,
  `nm_materia` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_materia`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materia`
--

LOCK TABLES `materia` WRITE;
/*!40000 ALTER TABLE `materia` DISABLE KEYS */;
INSERT INTO `materia` VALUES (1,'Direito Administrativo'),(2,'Direito Processual'),(3,'Direito Penal'),(4,'Direito Processual Penal');
/*!40000 ALTER TABLE `materia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materia_semestre`
--

DROP TABLE IF EXISTS `materia_semestre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `materia_semestre` (
  `id_materia_semestre` int(11) NOT NULL AUTO_INCREMENT,
  `id_classificacao_semestre` smallint(6) DEFAULT NULL,
  `id_materia` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id_materia_semestre`),
  KEY `FK_Reference_117` (`id_classificacao_semestre`),
  KEY `FK_Reference_118` (`id_materia`),
  CONSTRAINT `FK_Reference_117` FOREIGN KEY (`id_classificacao_semestre`) REFERENCES `classificacao_semestre` (`id_classificacao_semestre`),
  CONSTRAINT `FK_Reference_118` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materia_semestre`
--

LOCK TABLES `materia_semestre` WRITE;
/*!40000 ALTER TABLE `materia_semestre` DISABLE KEYS */;
INSERT INTO `materia_semestre` VALUES (6,1,1),(10,1,2),(12,1,3),(15,1,4),(16,1,4);
/*!40000 ALTER TABLE `materia_semestre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nivel_dificuldade`
--

DROP TABLE IF EXISTS `nivel_dificuldade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nivel_dificuldade` (
  `id_nivel_dificuldade` tinyint(4) NOT NULL AUTO_INCREMENT,
  `nm_nivel_dificuldade` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_nivel_dificuldade`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nivel_dificuldade`
--

LOCK TABLES `nivel_dificuldade` WRITE;
/*!40000 ALTER TABLE `nivel_dificuldade` DISABLE KEYS */;
INSERT INTO `nivel_dificuldade` VALUES (2,'Fácil'),(3,'Muito fácil'),(4,'Intermediário'),(5,'Difícil'),(6,'Muito dificil'),(7,'Nível Ninja');
/*!40000 ALTER TABLE `nivel_dificuldade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perfil`
--

DROP TABLE IF EXISTS `perfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perfil` (
  `id_perfil` int(11) NOT NULL AUTO_INCREMENT COMMENT '{"label":"Id Perfil"}',
  `nm_perfil` varchar(100) NOT NULL COMMENT '{''label'':"Perfil"}',
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfil`
--

LOCK TABLES `perfil` WRITE;
/*!40000 ALTER TABLE `perfil` DISABLE KEYS */;
INSERT INTO `perfil` VALUES (1,'Administrador'),(2,'Professor'),(3,'Auxiliar');
/*!40000 ALTER TABLE `perfil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perfil_controller_action`
--

DROP TABLE IF EXISTS `perfil_controller_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perfil_controller_action` (
  `id_perfil_controller_action` int(11) NOT NULL AUTO_INCREMENT,
  `id_controller` int(11) NOT NULL,
  `id_action` int(11) NOT NULL,
  `id_perfil` int(11) NOT NULL,
  PRIMARY KEY (`id_perfil_controller_action`),
  KEY `ix_perfil_controller_action_controller` (`id_controller`),
  KEY `ix_perfil_controller_action_action` (`id_action`),
  KEY `ix_perfil_controller_action_perfil` (`id_perfil`),
  CONSTRAINT `fk_perfil_controller_action_action` FOREIGN KEY (`id_action`) REFERENCES `action` (`id_action`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_perfil_controller_action_controller` FOREIGN KEY (`id_controller`) REFERENCES `controller` (`id_controller`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_perfil_controller_action_perfil` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=480 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfil_controller_action`
--

LOCK TABLES `perfil_controller_action` WRITE;
/*!40000 ALTER TABLE `perfil_controller_action` DISABLE KEYS */;
INSERT INTO `perfil_controller_action` VALUES (1,1,1,1),(2,2,1,1),(4,4,1,1),(5,5,1,1),(6,6,1,1),(7,1,5,1),(8,6,6,1),(9,5,6,1),(10,5,7,1),(11,6,7,1),(12,6,8,1),(13,1,2,1),(14,1,3,1),(15,1,9,1),(16,7,1,1),(17,1,4,1),(18,1,10,1),(19,1,11,1),(21,2,5,1),(22,2,12,1),(23,2,13,1),(25,8,18,1),(26,5,16,1),(29,8,19,1),(30,1,1,2),(31,2,1,2),(32,3,1,2),(33,4,1,2),(34,5,1,2),(35,6,1,2),(36,1,5,2),(37,6,6,2),(38,5,6,2),(39,5,7,2),(40,6,7,2),(41,6,8,2),(42,1,2,2),(43,1,3,2),(44,1,9,2),(45,7,1,2),(46,1,4,2),(47,1,10,2),(48,1,11,2),(49,3,7,2),(50,2,5,2),(51,2,12,2),(52,2,13,2),(53,3,14,2),(54,8,18,2),(55,8,20,1),(56,8,21,1),(57,8,22,1),(58,8,23,1),(59,3,15,2),(60,1,24,1),(61,1,24,2),(63,2,25,1),(64,2,25,2),(65,2,26,1),(66,2,26,2),(67,2,27,1),(68,2,27,2),(69,2,28,1),(70,2,28,2),(71,2,29,1),(72,2,30,1),(73,8,9,1),(74,8,9,2),(75,8,31,1),(76,8,31,2),(77,8,32,1),(78,8,33,1),(79,8,34,1),(80,2,35,1),(82,3,36,2),(84,3,37,2),(85,5,16,2),(86,3,17,2),(87,9,1,1),(88,9,1,2),(93,11,1,1),(98,1,7,1),(99,1,6,1),(100,1,8,1),(101,2,6,1),(102,2,8,1),(103,2,7,1),(104,7,6,1),(105,7,7,1),(106,7,8,1),(107,13,1,1),(108,13,6,1),(109,13,7,1),(110,13,8,1),(111,14,1,1),(112,14,6,1),(113,14,7,1),(114,14,8,1),(115,7,39,1),(116,15,39,1),(117,15,1,1),(118,16,1,1),(119,16,6,1),(120,16,7,1),(121,16,8,1),(122,16,40,1),(123,16,41,1),(124,17,1,1),(125,17,6,1),(126,17,7,1),(127,17,8,1),(128,17,42,1),(129,17,43,1),(130,17,44,1),(131,17,45,1),(132,17,46,1),(133,17,47,1),(134,17,40,1),(135,18,1,1),(136,18,6,1),(137,18,7,1),(138,18,8,1),(139,19,1,1),(140,19,6,1),(141,19,7,1),(142,19,8,1),(143,20,1,1),(144,20,6,1),(145,20,7,1),(146,20,8,1),(147,21,1,1),(148,21,6,1),(149,21,7,1),(150,21,8,1),(151,19,48,1),(152,22,1,1),(153,22,6,1),(154,22,7,1),(155,22,8,1),(156,14,49,1),(157,5,40,1),(158,16,42,1),(159,16,47,1),(160,17,50,1),(161,17,51,1),(162,17,1,1),(163,5,51,1),(164,5,51,2),(165,16,51,1),(166,16,51,2),(167,23,1,1),(168,23,6,1),(169,23,7,1),(170,23,8,1),(171,23,51,1),(172,23,52,1),(173,23,53,1),(174,23,54,1),(175,24,55,1),(176,25,1,1),(177,25,6,1),(178,25,7,1),(179,25,8,1),(180,25,51,1),(181,26,1,1),(182,26,6,1),(183,26,7,1),(184,26,8,1),(185,26,51,1),(191,29,1,1),(192,29,6,1),(193,29,7,1),(194,29,8,1),(195,29,51,1),(196,30,1,1),(197,30,6,1),(198,30,7,1),(199,30,8,1),(200,30,51,1),(201,31,1,1),(202,31,6,1),(203,31,7,1),(204,31,8,1),(205,31,51,1),(206,32,1,1),(207,32,6,1),(208,32,7,1),(209,32,8,1),(210,32,51,1),(211,33,1,1),(212,33,6,1),(213,33,7,1),(214,33,8,1),(215,33,51,1),(216,33,1,1),(217,33,6,1),(218,33,7,1),(219,33,8,1),(220,33,51,1),(221,25,57,1),(222,32,57,1),(233,10,1,1),(234,10,6,1),(235,10,7,1),(236,10,8,1),(237,10,13,1),(238,10,22,1),(239,10,31,1),(240,10,40,1),(241,10,47,1),(242,10,51,1),(243,10,53,1),(244,35,1,1),(245,36,1,1),(246,36,6,1),(247,36,7,1),(248,36,8,1),(249,36,51,1),(250,37,1,1),(251,37,6,1),(252,37,7,1),(253,37,8,1),(254,37,51,1),(255,38,1,1),(256,38,6,1),(257,38,7,1),(258,38,8,1),(259,38,51,1),(260,39,1,1),(261,39,6,1),(262,39,7,1),(263,39,8,1),(264,39,51,1),(265,40,1,1),(266,40,6,1),(267,40,7,1),(268,40,8,1),(269,40,51,1),(288,41,1,1),(289,41,6,1),(290,41,7,1),(291,41,8,1),(292,41,51,1),(293,41,53,1),(294,41,58,1),(295,41,59,1),(296,11,1,2),(297,11,1,3),(315,12,1,1),(316,12,6,1),(317,12,7,1),(318,12,8,1),(334,43,62,1),(365,44,1,1),(366,44,6,1),(367,44,7,1),(368,44,8,1),(369,44,51,1),(390,42,1,1),(391,42,6,1),(392,42,7,1),(393,42,8,1),(394,42,9,1),(395,42,51,1),(396,42,60,1),(397,42,61,1),(398,42,68,1),(410,3,1,1),(411,3,6,1),(412,3,7,1),(413,3,14,1),(414,3,15,1),(415,3,17,1),(416,3,18,1),(417,3,36,1),(418,3,37,1),(419,3,51,1),(420,3,70,1),(441,28,1,1),(442,28,6,1),(443,28,7,1),(444,28,8,1),(445,28,51,1),(446,28,63,1),(447,28,64,1),(448,28,65,1),(449,28,66,1),(450,28,67,1),(451,28,69,1),(452,28,71,1),(453,28,72,1),(454,28,73,1),(455,28,74,1),(456,28,75,1),(457,28,76,1),(458,28,65,2),(459,28,66,2),(460,28,67,2),(461,28,68,2),(462,28,69,2),(463,28,71,2),(464,28,72,2),(465,28,73,2),(466,28,74,2),(467,28,75,2),(468,28,76,2),(469,45,1,1),(470,45,6,1),(471,45,7,1),(472,45,8,1),(473,45,51,1),(474,45,1,2),(475,45,6,2),(476,45,7,2),(477,45,8,2),(478,45,9,2),(479,45,51,2);
/*!40000 ALTER TABLE `perfil_controller_action` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prova`
--

DROP TABLE IF EXISTS `prova`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prova` (
  `id_prova` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `nm_prova` varchar(100) DEFAULT NULL,
  `ds_prova` text,
  `dt_aplicacao_prova` timestamp NULL DEFAULT NULL,
  `dt_geracao_prova` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_prova`),
  KEY `FK_Reference_47` (`id_usuario`),
  CONSTRAINT `FK_Reference_47` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prova`
--

LOCK TABLES `prova` WRITE;
/*!40000 ALTER TABLE `prova` DISABLE KEYS */;
INSERT INTO `prova` VALUES (13,1,'PROVA 01-2016','Orientações gerais:\r\n- Leia atentamente toda a prova;\r\n- Verifique o tempo de duração com o professor;\r\n- Utilize apenas caneta azul ou preta;\r\n- A prova é individual e sem consulta;\r\n- Não será considerada questão objetiva que estiver rasurada;\r\n- Saída permitida após 30 minutos do início de provas.','2016-07-08 03:00:00','2016-10-17 17:56:27'),(14,1,'Prova 02/2016','Instruções Gerais','2016-10-17 02:00:00','2016-10-17 19:44:26'),(15,1,'Institucional 02/2014','Nenhuma instrução adicional','2014-10-20 02:00:00','2016-10-18 14:57:39'),(16,1,'PROVA 01-2016','sddsdsds','2016-10-12 03:00:00','2016-10-21 03:00:54');
/*!40000 ALTER TABLE `prova` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questao`
--

DROP TABLE IF EXISTS `questao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questao` (
  `id_questao` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_usuario_cadastro` int(11) DEFAULT NULL,
  `id_usuario_alteracao` int(11) DEFAULT NULL,
  `id_classificacao_semestre` smallint(6) DEFAULT NULL,
  `id_nivel_dificuldade` tinyint(4) DEFAULT NULL,
  `id_temporizacao` smallint(6) DEFAULT NULL,
  `id_tipo_questao` smallint(6) DEFAULT NULL,
  `id_fonte_questao` smallint(6) DEFAULT NULL,
  `id_assunto_materia` int(11) DEFAULT NULL,
  `bo_utilizavel` char(1) DEFAULT 'S',
  `nm_titulo_questao` varchar(200) DEFAULT NULL,
  `tx_enunciado` text,
  `bo_ativo` char(1) DEFAULT NULL,
  `dt_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dt_alteracao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tx_caminho_imagem_questao` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id_questao`),
  KEY `FK_Reference_48` (`id_usuario_cadastro`),
  KEY `FK_Reference_49` (`id_usuario_alteracao`),
  KEY `FK_Reference_50` (`id_classificacao_semestre`),
  KEY `FK_Reference_51` (`id_nivel_dificuldade`),
  KEY `FK_Reference_52` (`id_temporizacao`),
  KEY `FK_Reference_53` (`id_tipo_questao`),
  KEY `FK_Reference_54` (`id_fonte_questao`),
  KEY `FK_Reference_55` (`id_assunto_materia`),
  CONSTRAINT `FK_Reference_48` FOREIGN KEY (`id_usuario_cadastro`) REFERENCES `usuario` (`id_usuario`),
  CONSTRAINT `FK_Reference_49` FOREIGN KEY (`id_usuario_alteracao`) REFERENCES `usuario` (`id_usuario`),
  CONSTRAINT `FK_Reference_50` FOREIGN KEY (`id_classificacao_semestre`) REFERENCES `classificacao_semestre` (`id_classificacao_semestre`),
  CONSTRAINT `FK_Reference_51` FOREIGN KEY (`id_nivel_dificuldade`) REFERENCES `nivel_dificuldade` (`id_nivel_dificuldade`),
  CONSTRAINT `FK_Reference_52` FOREIGN KEY (`id_temporizacao`) REFERENCES `temporizacao` (`id_temporizacao`),
  CONSTRAINT `FK_Reference_53` FOREIGN KEY (`id_tipo_questao`) REFERENCES `tipo_questao` (`id_tipo_questao`),
  CONSTRAINT `FK_Reference_54` FOREIGN KEY (`id_fonte_questao`) REFERENCES `fonte_questao` (`id_fonte_questao`),
  CONSTRAINT `FK_Reference_55` FOREIGN KEY (`id_assunto_materia`) REFERENCES `assunto_materia` (`id_assunto_materia`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questao`
--

LOCK TABLES `questao` WRITE;
/*!40000 ALTER TABLE `questao` DISABLE KEYS */;
INSERT INTO `questao` VALUES (1,1,1,9,2,2,1,1,1,'S','ESAF - 2002 - MPOG - Especialista em Políticas Públicas – Superior:','Considerando-se as formas de se percorrer os nós de uma árvore binária, no caminhamento pré-fixado deve-se',NULL,'2016-10-01 17:56:46','2016-10-01 17:56:46',NULL),(12,1,1,8,3,2,1,3,4,'S','Prova: FCC - 2012 - TJ-RJ - Analista Judiciário - Análise de Sistemas / Algoritmos e Estrutura de Dados / Algoritmos;','O seguinte trecho de pseudo-código representa a definição de uma função (sub-rotina) f com um único argumento x.\r\n\r\n´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´\r\nfunção f (inteiro x) {\r\n   x = x + 1;\r\n   retorna x;\r\n}\r\n´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´\r\nConsidere agora o seguinte trecho de código que invoca a função f definida acima.\r\n´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´\r\na = 0;\r\nescreva a;\r\nescreva f(a);\r\nescreva a;\r\n´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´\r\nA execução do trecho de código acima resultaria na escrita de:',NULL,'2016-10-02 03:45:56','2016-10-02 03:45:56',NULL),(13,1,1,8,5,2,1,4,2,'S','FCC - 2011 - TRE-RN - Técnico Judiciário - Programação de Sistemas','Uma estrutura de dados onde cada nó mantém uma informação adicional, chamada fator de balanceamento, que indica a diferença de altura entre as subárvores esquerda e direita, é conhecida por árvore:',NULL,'2016-10-15 17:58:58','2016-10-15 17:58:58',NULL),(14,1,1,4,4,1,1,3,5,'S','CETAP - 2010 - AL-RR - Analista de Sistemas.','Sobre as estruturas de dados conhecidas como árvores, selecione a alternativa CORRETA.',NULL,'2016-10-17 17:15:31','2016-10-17 17:15:31',NULL),(15,1,1,1,6,1,1,3,4,'S','Prova: FCC - 2009 - TRT - 15ª Região - Analista Judiciário - Tecnologia da Informação','São algoritmos de classificação por trocas apenas os métodos',NULL,'2016-10-17 17:22:21','2016-10-17 17:22:21',NULL),(16,1,1,4,3,2,1,4,3,'S','Analise o código abaixo e marque a alternativa que representa a saida do programa abaixo caso o usuario digite 12 para dd e 3 para dv.','#include <stdio.h>\r\n#include <stdlib.h>\r\n\r\nint main() {\r\n  	int dv, dd, n, i = 0;\r\n\r\n  	puts(\"digite o dd\");\r\n  	scanf(\"%i\",&dd);  \r\n  	puts(\"digite o dv\");\r\n  	scanf(\"%i\",&dv);  \r\n  	n = dv;\r\n  	while(n <= dd) {\r\n     		n = n + dv;\r\n     		i++;\r\n  	}\r\n\r\n 	printf(\"O resultado eh : %i .\\n\\n\", i);\r\n  	system(\"PAUSE\");\r\n  	return 0;\r\n}',NULL,'2016-10-17 17:26:42','2016-10-17 17:26:42',NULL),(17,1,1,4,4,2,1,4,3,'S','Analise o Código abaixo e indique quantos erros existem no código que o impedem de rodar sem problemas em um compilador C/C++','#include <stdlid.h>\r\n#include <stdio.h>\r\n\r\nvoid  main(){\r\n    int A, b, R;\r\n\r\n      printf(\"Digite um numero inteiro qualquer.\\n\"); //Escreva\r\n      scanf(\"%i\",&A); //Leia\r\n\r\n      printf(\"Digite outro numero inteiro qualquer.\\n\");\r\n      scanf(\"%f\",&B);\r\n\r\n      while (B != 0) { //Enquanto\r\n         R = (A % B); //(a mod b)\r\n         A = B;\r\n         B = R;\r\n        }\r\n      printf(\"O valor do MDC eh %i. \\n\\n\\n\",A);\r\n      system(\"PAUSE\");\r\n      returno 0;\r\n}',NULL,'2016-10-17 17:32:23','2016-10-17 17:32:23',NULL),(18,1,1,6,3,1,1,3,5,'S','Quantos dos itens destacados abaixo não podem ser utilizados como nomes de variaveis?','M234	void	$endereco	6six	Sete_seven	Return0	Sistema	__fita__\r\n_nome	_float	telefone	Endereço	beija-flor	variavel	idade	Cd',NULL,'2016-10-17 17:35:31','2016-10-17 17:35:31',NULL),(19,1,1,6,4,1,1,3,5,'S','Verifique se as afirmações sobre Grafos são verdadeiras (V) ou falsas (F) e assinale a alternativa que contém a sequência correta:','I.   Caminho é um circuito de um único nó.\r\nII.  Subgrafo é um subconjunto das arestas, com todos os nós do grafo original.\r\nIII. Na representação por lista de adjacência existe uma lista encadeada para cada nó.',NULL,'2016-10-17 17:43:42','2016-10-17 17:43:42',NULL),(20,1,1,3,4,2,1,1,2,'S','Verifique se as afirmações sobre Árvores são verdadeiras (V) ou falsas (F) e assinale a alternativa que contém a sequência correta:','I. Percorrer uma árvore significa visitar cada nó pelo menos uma vez.\r\nII. Nas árvores binárias o número de filhos de cada nó é sempre menor que dois.\r\nIII. Uma árvore binária é denominada AVL quando, para qualquer nó, as alturas das subárvores, esquerda e direita, diferem em módulo de até uma unidade.',NULL,'2016-10-17 17:45:30','2016-10-17 17:45:30',NULL);
/*!40000 ALTER TABLE `questao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questoes_prova`
--

DROP TABLE IF EXISTS `questoes_prova`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questoes_prova` (
  `id_questao_prova` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_questao` bigint(20) DEFAULT NULL,
  `id_prova` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_questao_prova`),
  KEY `FK_Reference_56` (`id_questao`),
  KEY `FK_Reference_57` (`id_prova`),
  CONSTRAINT `FK_Reference_56` FOREIGN KEY (`id_questao`) REFERENCES `questao` (`id_questao`),
  CONSTRAINT `FK_Reference_57` FOREIGN KEY (`id_prova`) REFERENCES `prova` (`id_prova`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questoes_prova`
--

LOCK TABLES `questoes_prova` WRITE;
/*!40000 ALTER TABLE `questoes_prova` DISABLE KEYS */;
INSERT INTO `questoes_prova` VALUES (1,20,14),(2,16,14);
/*!40000 ALTER TABLE `questoes_prova` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sexo`
--

DROP TABLE IF EXISTS `sexo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sexo` (
  `id_sexo` int(11) NOT NULL AUTO_INCREMENT,
  `nm_sexo` varchar(45) NOT NULL COMMENT '{"label":"Sexo"}',
  PRIMARY KEY (`id_sexo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sexo`
--

LOCK TABLES `sexo` WRITE;
/*!40000 ALTER TABLE `sexo` DISABLE KEYS */;
INSERT INTO `sexo` VALUES (1,'Masculino'),(2,'Feminino');
/*!40000 ALTER TABLE `sexo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `situacao`
--

DROP TABLE IF EXISTS `situacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `situacao` (
  `id_situacao` int(11) NOT NULL AUTO_INCREMENT,
  `nm_situacao` varchar(100) DEFAULT NULL COMMENT '{"label":"Situação"}',
  PRIMARY KEY (`id_situacao`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `situacao`
--

LOCK TABLES `situacao` WRITE;
/*!40000 ALTER TABLE `situacao` DISABLE KEYS */;
INSERT INTO `situacao` VALUES (1,'Ativo'),(2,'Inativo');
/*!40000 ALTER TABLE `situacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `situacao_usuario`
--

DROP TABLE IF EXISTS `situacao_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `situacao_usuario` (
  `id_situacao_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nm_situacao_usuario` varchar(100) DEFAULT NULL COMMENT '{"label":"Situação usuário"}',
  PRIMARY KEY (`id_situacao_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `situacao_usuario`
--

LOCK TABLES `situacao_usuario` WRITE;
/*!40000 ALTER TABLE `situacao_usuario` DISABLE KEYS */;
INSERT INTO `situacao_usuario` VALUES (1,'Ativo'),(2,'Inativo'),(3,'Congelado'),(4,'Atrasado');
/*!40000 ALTER TABLE `situacao_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telefone`
--

DROP TABLE IF EXISTS `telefone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telefone` (
  `id_telefone` int(11) NOT NULL AUTO_INCREMENT,
  `nr_ddd_telefone` varchar(3) DEFAULT NULL COMMENT '{"label":"ddd"}',
  `nr_telefone` varchar(20) DEFAULT NULL COMMENT '{"label":"Telefone"}',
  `id_tipo_telefone` int(11) NOT NULL,
  `id_situacao` int(11) NOT NULL,
  PRIMARY KEY (`id_telefone`),
  KEY `ix_telefones_situacao` (`id_situacao`),
  KEY `FK_Reference_24` (`id_tipo_telefone`),
  CONSTRAINT `FK_Reference_24` FOREIGN KEY (`id_tipo_telefone`) REFERENCES `tipo_telefone` (`id_tipo_telefone`),
  CONSTRAINT `fk_telefones_situacao` FOREIGN KEY (`id_situacao`) REFERENCES `situacao` (`id_situacao`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telefone`
--

LOCK TABLES `telefone` WRITE;
/*!40000 ALTER TABLE `telefone` DISABLE KEYS */;
INSERT INTO `telefone` VALUES (1,'12','34567890',1,1),(2,'61','91613193',1,1),(3,'61','91613193',1,1),(4,'61','989898989',1,1),(5,'56','576756756',1,1),(6,'87','878778787',1,1),(7,'78','787878787',1,1),(8,'87','878787878',1,1),(9,'61','98745741',1,1);
/*!40000 ALTER TABLE `telefone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temporizacao`
--

DROP TABLE IF EXISTS `temporizacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temporizacao` (
  `id_temporizacao` smallint(6) NOT NULL AUTO_INCREMENT,
  `id_unidade_tempo` smallint(6) DEFAULT NULL,
  `nm_temporizacao` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_temporizacao`),
  KEY `FK_Reference_46` (`id_unidade_tempo`),
  CONSTRAINT `FK_Reference_46` FOREIGN KEY (`id_unidade_tempo`) REFERENCES `unidade_tempo` (`id_unidade_tempo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temporizacao`
--

LOCK TABLES `temporizacao` WRITE;
/*!40000 ALTER TABLE `temporizacao` DISABLE KEYS */;
INSERT INTO `temporizacao` VALUES (1,NULL,'5'),(2,NULL,'12'),(3,NULL,'2');
/*!40000 ALTER TABLE `temporizacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_questao`
--

DROP TABLE IF EXISTS `tipo_questao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_questao` (
  `id_tipo_questao` smallint(6) NOT NULL AUTO_INCREMENT,
  `nm_tipo_questao` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_questao`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_questao`
--

LOCK TABLES `tipo_questao` WRITE;
/*!40000 ALTER TABLE `tipo_questao` DISABLE KEYS */;
INSERT INTO `tipo_questao` VALUES (1,'Multipla Escolha');
/*!40000 ALTER TABLE `tipo_questao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_telefone`
--

DROP TABLE IF EXISTS `tipo_telefone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_telefone` (
  `id_tipo_telefone` int(11) NOT NULL AUTO_INCREMENT,
  `nm_tipo_telefone` varchar(100) DEFAULT NULL COMMENT '{"label":"Tipo telefone"}',
  PRIMARY KEY (`id_tipo_telefone`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_telefone`
--

LOCK TABLES `tipo_telefone` WRITE;
/*!40000 ALTER TABLE `tipo_telefone` DISABLE KEYS */;
INSERT INTO `tipo_telefone` VALUES (1,'Residencial'),(2,'Comercial'),(3,'Celular');
/*!40000 ALTER TABLE `tipo_telefone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_usuario`
--

DROP TABLE IF EXISTS `tipo_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_usuario` (
  `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nm_tipo_usuario` varchar(100) DEFAULT NULL COMMENT '{"label":"Tipo usuário"}',
  PRIMARY KEY (`id_tipo_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_usuario`
--

LOCK TABLES `tipo_usuario` WRITE;
/*!40000 ALTER TABLE `tipo_usuario` DISABLE KEYS */;
INSERT INTO `tipo_usuario` VALUES (1,'Administrador'),(2,'Professor'),(3,'Auxiliar');
/*!40000 ALTER TABLE `tipo_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unidade_tempo`
--

DROP TABLE IF EXISTS `unidade_tempo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unidade_tempo` (
  `id_unidade_tempo` smallint(6) NOT NULL AUTO_INCREMENT,
  `nm_unidade_tempo` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_unidade_tempo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unidade_tempo`
--

LOCK TABLES `unidade_tempo` WRITE;
/*!40000 ALTER TABLE `unidade_tempo` DISABLE KEYS */;
INSERT INTO `unidade_tempo` VALUES (1,'Mes'),(2,'Semestre'),(3,'Ano'),(4,'Aplicaçao');
/*!40000 ALTER TABLE `unidade_tempo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nm_usuario` varchar(250) NOT NULL COMMENT '{"label":"Usuário"}',
  `nm_funcao` varchar(200) DEFAULT NULL COMMENT '{"label":"Profissão"}',
  `id_sexo` int(11) DEFAULT NULL,
  `id_perfil` int(11) DEFAULT NULL,
  `id_situacao_usuario` int(11) NOT NULL,
  `id_email` int(11) DEFAULT NULL,
  `id_telefone` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `ix_usuarios_sexo` (`id_sexo`),
  KEY `ix_usuarios_situacao_usuario` (`id_situacao_usuario`),
  KEY `ix_usuarios_emails` (`id_email`),
  KEY `ix_usuarios_telefones` (`id_telefone`),
  KEY `ix_usuarios_perfil` (`id_perfil`),
  CONSTRAINT `fk_usuarios_emails` FOREIGN KEY (`id_email`) REFERENCES `email` (`id_email`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuarios_sexo` FOREIGN KEY (`id_sexo`) REFERENCES `sexo` (`id_sexo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuarios_situacao_usuario` FOREIGN KEY (`id_situacao_usuario`) REFERENCES `situacao_usuario` (`id_situacao_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuarios_telefones` FOREIGN KEY (`id_telefone`) REFERENCES `telefone` (`id_telefone`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `ix_usuarios_tipo_usuario` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'Admin','Administrador',1,1,1,1,1),(2,'Alysson Vicuña de Oliveira','Professor',1,2,1,2,2),(3,'teste001',NULL,NULL,2,2,3,3),(4,'teste002',NULL,NULL,2,1,4,4);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Current Database: `bdprovatudo`
--

USE `bdprovatudo`;

--
-- Final view structure for view `acl`
--

/*!50001 DROP TABLE IF EXISTS `acl`*/;
/*!50001 DROP VIEW IF EXISTS `acl`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `acl` AS (select `perfil_controller_action`.`id_perfil` AS `id_perfil`,concat(`controller`.`nm_controller`,'/',`action`.`nm_action`) AS `nm_resource` from ((`perfil_controller_action` join `controller` on((`controller`.`id_controller` = `perfil_controller_action`.`id_controller`))) join `action` on((`action`.`id_action` = `perfil_controller_action`.`id_action`)))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `auth`
--

/*!50001 DROP TABLE IF EXISTS `auth`*/;
/*!50001 DROP VIEW IF EXISTS `auth`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `auth` AS (select `login`.`id_usuario` AS `id_usuario`,`perfil`.`id_perfil` AS `id_perfil`,`email`.`em_email` AS `em_email`,`login`.`pw_senha` AS `pw_senha`,`usuario`.`nm_usuario` AS `nm_usuario`,1 AS `id_contrato` from (((`usuario` join `login` on((`login`.`id_usuario` = `usuario`.`id_usuario`))) join `email` on((`email`.`id_email` = `login`.`id_email`))) join `perfil` on((`perfil`.`id_perfil` = `login`.`id_perfil`)))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-10-21  3:42:40
