<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2023-04-27 10:55:27 --> Severity: 8192 --> Function get_magic_quotes_runtime() is deprecated C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\third_party\fpdf\fpdf.php 1043
ERROR - 2023-04-27 10:55:37 --> Severity: 8192 --> Function get_magic_quotes_runtime() is deprecated C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\third_party\fpdf\fpdf.php 1043
ERROR - 2023-04-27 11:00:33 --> Query error: FUNCTION monitor.OLD_PASSWORD does not exist - Invalid query: SELECT concat(DATA_PUB_NUMERO, replace(HORA_MATERIA, ':', '')) as DATA_NUMERO, `MATERIA`.`SEQ_RELEASE`, `SETOR`.`DESC_SETOR`, `SETOR`.`SIG_SETOR`, OLD_PASSWORD(MATERIA.SEQ_MATERIA) AS CHAVE, DATE_FORMAT(DATA_MATERIA_PUB, '%d/%m/%Y') as DIA, `MATERIA`.*
FROM `MATERIA`
LEFT JOIN `SETOR` ON `SETOR`.`SEQ_SETOR`=`MATERIA`.`SEQ_SETOR`
WHERE (`MATERIA`.`SEQ_SETOR` <> 83 or `IND_FILTRO` = 'N')
AND `MATERIA`.`SEQ_SETOR` NOT IN (316,317,318)
AND `MATERIA`.`DATA_MATERIA_PUB` BETWEEN 20230426 and 20230427
AND `MATERIA`.`SEQ_CLIENTE` = '1'
AND `MATERIA`.`TIPO_MATERIA` IN('T', 'S', 'R', 'I')
AND (`MATERIA`.`SEQ_VEICULO` IS NOT NULL OR `MATERIA`.`SEQ_PORTAL` IS NOT NULL OR `MATERIA`.`SEQ_RADIO` IS NOT NULL OR `MATERIA`.`SEQ_TV` IS NOT NULL) AND `MATERIA`.`SEQ_SETOR` IS NOT NULL AND `MATERIA`.`IND_AVALIACAO` IS NOT NULL
ORDER BY `MATERIA`.`TIPO_MATERIA` ASC, `DATA_PUB_NUMERO` ASC, 1 ASC, `MATERIA`.`SEQ_MATERIA` ASC, `MATERIA`.`IND_AVALIACAO` ASC
ERROR - 2023-04-27 11:00:33 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\models\MateriaModelo.php 1959
ERROR - 2023-04-27 11:00:58 --> Severity: Notice --> Undefined variable: tipoMat C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 373
ERROR - 2023-04-27 11:00:58 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 380
ERROR - 2023-04-27 11:00:58 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 429
ERROR - 2023-04-27 11:00:58 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 471
ERROR - 2023-04-27 11:00:58 --> Query error: FUNCTION monitor.OLD_PASSWORD does not exist - Invalid query: SELECT concat(DATA_PUB_NUMERO, replace(HORA_MATERIA, ':', '')) as DATA_NUMERO, `MATERIA`.`SEQ_RELEASE`, `SETOR`.`DESC_SETOR`, `SETOR`.`SIG_SETOR`, OLD_PASSWORD(MATERIA.SEQ_MATERIA) AS CHAVE, DATE_FORMAT(DATA_MATERIA_PUB, '%d/%m/%Y') as DIA, `MATERIA`.*
FROM `MATERIA`
LEFT JOIN `SETOR` ON `SETOR`.`SEQ_SETOR`=`MATERIA`.`SEQ_SETOR`
WHERE (`MATERIA`.`SEQ_SETOR` <> 83 or `IND_FILTRO` = 'N')
AND `MATERIA`.`SEQ_SETOR` NOT IN (316,317,318)
AND `MATERIA`.`DATA_MATERIA_PUB` BETWEEN 20230426 and 20230427
AND `MATERIA`.`SEQ_CLIENTE` = '1'
AND `MATERIA`.`TIPO_MATERIA` IN('T', 'S', 'R', 'I')
AND (`MATERIA`.`SEQ_VEICULO` IS NOT NULL OR `MATERIA`.`SEQ_PORTAL` IS NOT NULL OR `MATERIA`.`SEQ_RADIO` IS NOT NULL OR `MATERIA`.`SEQ_TV` IS NOT NULL) AND `MATERIA`.`SEQ_SETOR` IS NOT NULL AND `MATERIA`.`IND_AVALIACAO` IS NOT NULL
ORDER BY `MATERIA`.`TIPO_MATERIA` ASC, `DATA_PUB_NUMERO` ASC, 1 ASC, `MATERIA`.`SEQ_MATERIA` ASC, `MATERIA`.`IND_AVALIACAO` ASC
ERROR - 2023-04-27 11:01:47 --> Severity: Notice --> Undefined variable: tipoMat C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 373
ERROR - 2023-04-27 11:01:47 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 380
ERROR - 2023-04-27 11:01:47 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 429
ERROR - 2023-04-27 11:01:47 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 471
ERROR - 2023-04-27 11:06:20 --> Severity: Warning --> ini_set(): Headers already sent. You cannot change the session module's ini settings at this time C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\system\libraries\Session\Session.php 284
ERROR - 2023-04-27 11:06:20 --> Severity: Warning --> session_set_cookie_params(): Cannot change session cookie parameters when headers already sent C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\system\libraries\Session\Session.php 296
ERROR - 2023-04-27 11:06:20 --> Severity: Warning --> ini_set(): Headers already sent. You cannot change the session module's ini settings at this time C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\system\libraries\Session\Session.php 306
ERROR - 2023-04-27 11:06:20 --> Severity: Warning --> ini_set(): Headers already sent. You cannot change the session module's ini settings at this time C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\system\libraries\Session\Session.php 316
ERROR - 2023-04-27 11:06:20 --> Severity: Warning --> ini_set(): Headers already sent. You cannot change the session module's ini settings at this time C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\system\libraries\Session\Session.php 317
ERROR - 2023-04-27 11:06:20 --> Severity: Warning --> ini_set(): Headers already sent. You cannot change the session module's ini settings at this time C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\system\libraries\Session\Session.php 318
ERROR - 2023-04-27 11:06:20 --> Severity: Warning --> ini_set(): Headers already sent. You cannot change the session module's ini settings at this time C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\system\libraries\Session\Session.php 319
ERROR - 2023-04-27 11:06:20 --> Severity: Warning --> ini_set(): Headers already sent. You cannot change the session module's ini settings at this time C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\system\libraries\Session\Session.php 377
ERROR - 2023-04-27 11:06:20 --> Severity: Warning --> ini_set(): Headers already sent. You cannot change the session module's ini settings at this time C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\system\libraries\Session\drivers\Session_files_driver.php 108
ERROR - 2023-04-27 11:06:20 --> Severity: Warning --> session_set_save_handler(): Cannot change save handler when headers already sent C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\system\libraries\Session\Session.php 110
ERROR - 2023-04-27 11:06:20 --> Severity: Warning --> session_start(): Cannot start session when headers already sent C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\system\libraries\Session\Session.php 143
ERROR - 2023-04-27 11:06:20 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\helpers\phpquery_helper.php:2171) C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\system\helpers\url_helper.php 561
ERROR - 2023-04-27 11:08:24 --> 404 Page Not Found: Assets/plugins
ERROR - 2023-04-27 11:08:24 --> 404 Page Not Found: Assets/plugins
ERROR - 2023-04-27 11:08:24 --> 404 Page Not Found: Assets/plugins
ERROR - 2023-04-27 11:33:41 --> Severity: Warning --> Illegal offset type C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\helpers\porto_helper.php 55
ERROR - 2023-04-27 11:52:41 --> Query error: Unknown column 'DATA_NUMERO' in 'field list' - Invalid query: INSERT INTO `AUDITORIA` (`SEQ_USUARIO`, `TIPO_AUDITORIA`, `OPER_AUDITORIA`, `OBS_AUDITORIA`, `SESSION_ID`, `DATA_NUMERO`) VALUES ('1', 'C', 'CONSULTA-ALERTAS', '', '76o8r6bg8irja7ouclgaeq75cbqpdgc2', '20230427')
ERROR - 2023-04-27 12:02:51 --> Query error: Unknown column '2022-12-27' in 'where clause' - Invalid query: SELECT *
FROM `NOTA`
WHERE `2022-12-27` BETWEEN DATE(DT_INICIO)  and DATE(DT_FIM)
AND `IND_ATIVO` = 'S'
ERROR - 2023-04-27 12:04:54 --> Query error: Unknown column '$periodo' in 'where clause' - Invalid query: SELECT *
FROM `NOTA`
WHERE `$periodo` BETWEEN DATE(DT_INICIO)  and DATE(DT_FIM)
AND `IND_ATIVO` = 'S'
ERROR - 2023-04-27 12:34:44 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 380
ERROR - 2023-04-27 12:34:44 --> Severity: 8192 --> implode(): Passing glue string after array is deprecated. Swap the parameters C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 393
ERROR - 2023-04-27 12:34:44 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 429
ERROR - 2023-04-27 12:34:44 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 471
ERROR - 2023-04-27 12:34:50 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 380
ERROR - 2023-04-27 12:34:50 --> Severity: 8192 --> implode(): Passing glue string after array is deprecated. Swap the parameters C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 393
ERROR - 2023-04-27 12:34:50 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 429
ERROR - 2023-04-27 12:34:50 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 471
ERROR - 2023-04-27 12:55:03 --> Severity: Warning --> Illegal offset type C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\helpers\porto_helper.php 55
ERROR - 2023-04-27 13:54:44 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and 
AND ((MATERIA.SEQ_TV IS NULL AND `MATERIA`.`SEQ_VEICULO` IS NULL AND `MATER' at line 7 - Invalid query: SELECT *
FROM `MATERIA`
WHERE `MATERIA`.`SEQ_SETOR` <> 83
AND `MATERIA`.`SEQ_SETOR` IN (316,317,318)
AND `MATERIA`.`SEQ_CLIENTE` = '1'
AND `MATERIA`.`TIPO_MATERIA` IN('T', 'S', 'R', 'I')
AND MATERIA.DATA_MATERIA_PUB BETWEEN  and 
AND ((MATERIA.SEQ_TV IS NULL AND `MATERIA`.`SEQ_VEICULO` IS NULL AND `MATERIA`.`SEQ_PORTAL` IS NULL AND `MATERIA`.`SEQ_RADIO` IS NULL) OR `MATERIA`.`SEQ_SETOR` IS NULL OR `MATERIA`.`IND_AVALIACAO` IS NULL)
AND `MATERIA`.`IND_STATUS` IN('E', 'F')
ERROR - 2023-04-27 13:54:44 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\models\MateriaModelo.php 2159
ERROR - 2023-04-27 14:00:59 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and 
AND ((MATERIA.SEQ_TV IS NULL AND `MATERIA`.`SEQ_VEICULO` IS NULL AND `MATER' at line 7 - Invalid query: SELECT *
FROM `MATERIA`
WHERE `MATERIA`.`SEQ_SETOR` <> 83
AND `MATERIA`.`SEQ_SETOR` IN (316,317,318)
AND `MATERIA`.`SEQ_CLIENTE` = '1'
AND `MATERIA`.`TIPO_MATERIA` IN('T', 'S', 'R', 'I')
AND MATERIA.DATA_MATERIA_PUB BETWEEN  and 
AND ((MATERIA.SEQ_TV IS NULL AND `MATERIA`.`SEQ_VEICULO` IS NULL AND `MATERIA`.`SEQ_PORTAL` IS NULL AND `MATERIA`.`SEQ_RADIO` IS NULL) OR `MATERIA`.`SEQ_SETOR` IS NULL OR `MATERIA`.`IND_AVALIACAO` IS NULL)
AND `MATERIA`.`IND_STATUS` IN('E', 'F')
ERROR - 2023-04-27 14:00:59 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\models\MateriaModelo.php 2159
ERROR - 2023-04-27 21:08:48 --> Severity: Error --> Allowed memory size of 1073741824 bytes exhausted (tried to allocate 3632200 bytes) C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2023-04-27 21:28:07 --> Severity: Warning --> mysqli::query(): (HY000/2006): MySQL server has gone away C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2023-04-27 21:28:07 --> Query error: MySQL server has gone away - Invalid query: SELECT concat(DATA_PUB_NUMERO, replace(HORA_MATERIA, ':', '')) as DATA_NUMERO, `MATERIA`.`SEQ_RELEASE`, `SETOR`.`DESC_SETOR`, `SETOR`.`SIG_SETOR`, OLD_PASSWORD(MATERIA.SEQ_MATERIA) AS CHAVE, DATE_FORMAT(DATA_MATERIA_PUB, '%d/%m/%Y') as DIA, `MATERIA`.*
FROM `MATERIA`
LEFT JOIN `SETOR` ON `SETOR`.`SEQ_SETOR`=`MATERIA`.`SEQ_SETOR`
WHERE `MATERIA`.`TIPO_MATERIA` LIKE '%S%' OR `MATERIA`.`TIPO_MATERIA` LIKE '%I%'
AND (`MATERIA`.`SEQ_SETOR` <> 83 or `IND_FILTRO` = 'N')
AND `MATERIA`.`SEQ_SETOR` NOT IN (316,317,318)
AND `MATERIA`.`DATA_MATERIA_PUB` BETWEEN 20230426 and 20230426
AND `MATERIA`.`SEQ_CLIENTE` = '1'
AND `MATERIA`.`TIPO_MATERIA` IN('T', 'S', 'R', 'I')
AND (`MATERIA`.`SEQ_VEICULO` IS NOT NULL OR `MATERIA`.`SEQ_PORTAL` IS NOT NULL OR `MATERIA`.`SEQ_RADIO` IS NOT NULL OR `MATERIA`.`SEQ_TV` IS NOT NULL) AND `MATERIA`.`SEQ_SETOR` IS NOT NULL AND `MATERIA`.`IND_AVALIACAO` IS NOT NULL
ORDER BY `MATERIA`.`TIPO_MATERIA` ASC, `DATA_PUB_NUMERO` ASC, 1 ASC, `MATERIA`.`SEQ_MATERIA` ASC, `MATERIA`.`IND_AVALIACAO` ASC
ERROR - 2023-04-27 21:28:07 --> Severity: error --> Exception: Call to a member function result_array() on bool C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\models\MateriaModelo.php 1959
ERROR - 2023-04-27 21:43:54 --> Severity: Notice --> Undefined variable: tipoMat C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 373
ERROR - 2023-04-27 21:43:54 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 380
ERROR - 2023-04-27 21:43:54 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 429
ERROR - 2023-04-27 21:43:54 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 471
ERROR - 2023-04-27 21:43:54 --> Severity: Notice --> Undefined variable: mat C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 542
ERROR - 2023-04-27 21:46:41 --> 404 Page Not Found: Assets/plugins
ERROR - 2023-04-27 21:46:41 --> 404 Page Not Found: Assets/plugins
ERROR - 2023-04-27 21:46:42 --> 404 Page Not Found: Assets/plugins
ERROR - 2023-04-27 21:47:26 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 380
ERROR - 2023-04-27 21:47:26 --> Severity: 8192 --> implode(): Passing glue string after array is deprecated. Swap the parameters C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 393
ERROR - 2023-04-27 21:47:26 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 429
ERROR - 2023-04-27 21:47:26 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 471
ERROR - 2023-04-27 21:47:26 --> Severity: Warning --> explode() expects parameter 2 to be string, array given C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\models\MateriaModelo.php 1967
ERROR - 2023-04-27 21:47:26 --> Severity: Warning --> Invalid argument supplied for foreach() C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\models\MateriaModelo.php 1969
ERROR - 2023-04-27 21:47:26 --> 404 Page Not Found: Assets/plugins
ERROR - 2023-04-27 21:47:26 --> 404 Page Not Found: Assets/plugins
ERROR - 2023-04-27 21:47:27 --> 404 Page Not Found: Assets/plugins
ERROR - 2023-04-27 21:47:40 --> Severity: Warning --> explode() expects parameter 2 to be string, array given C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\models\MateriaModelo.php 1967
ERROR - 2023-04-27 21:47:40 --> Severity: Warning --> Invalid argument supplied for foreach() C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\models\MateriaModelo.php 1969
ERROR - 2023-04-27 21:47:40 --> 404 Page Not Found: Assets/plugins
ERROR - 2023-04-27 21:47:40 --> 404 Page Not Found: Assets/plugins
ERROR - 2023-04-27 21:47:40 --> 404 Page Not Found: Assets/plugins
ERROR - 2023-04-27 21:50:42 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 380
ERROR - 2023-04-27 21:50:42 --> Severity: 8192 --> implode(): Passing glue string after array is deprecated. Swap the parameters C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 393
ERROR - 2023-04-27 21:50:42 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 429
ERROR - 2023-04-27 21:50:42 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 471
ERROR - 2023-04-27 21:50:42 --> Severity: Notice --> Undefined variable: mat C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 542
ERROR - 2023-04-27 21:52:00 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 380
ERROR - 2023-04-27 21:52:00 --> Severity: 8192 --> implode(): Passing glue string after array is deprecated. Swap the parameters C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 393
ERROR - 2023-04-27 21:52:00 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 429
ERROR - 2023-04-27 21:52:00 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 471
ERROR - 2023-04-27 21:52:00 --> Severity: Notice --> Undefined variable: mat C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 542
ERROR - 2023-04-27 21:54:51 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 380
ERROR - 2023-04-27 21:54:51 --> Severity: 8192 --> implode(): Passing glue string after array is deprecated. Swap the parameters C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 393
ERROR - 2023-04-27 21:54:51 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 429
ERROR - 2023-04-27 21:54:51 --> Severity: Notice --> Undefined variable: setor C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 471
ERROR - 2023-04-27 21:54:51 --> Severity: Notice --> Undefined variable: mat C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 542
ERROR - 2023-04-27 21:56:20 --> Severity: Notice --> Undefined variable: mat C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 542
ERROR - 2023-04-27 21:57:50 --> Severity: Warning --> Illegal offset type C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\helpers\porto_helper.php 55
ERROR - 2023-04-27 22:04:14 --> Severity: Notice --> Undefined variable: where C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\views\modulos\relatorio\arquivo-alerta-texto-exp.php 84
ERROR - 2023-04-27 22:19:57 --> Severity: Notice --> Undefined variable: aval C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\views\modulos\relatorio\arquivo-alerta-texto-exp.php 148
ERROR - 2023-04-27 22:19:57 --> Severity: Notice --> Undefined variable: horair C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\views\modulos\relatorio\arquivo-alerta-texto-exp.php 148
ERROR - 2023-04-27 22:19:57 --> Severity: Notice --> Undefined variable: horafr C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\views\modulos\relatorio\arquivo-alerta-texto-exp.php 148
ERROR - 2023-04-27 22:19:57 --> Severity: Notice --> Undefined variable: datai2 C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\views\modulos\relatorio\arquivo-alerta-texto-exp.php 148
ERROR - 2023-04-27 22:19:57 --> Severity: Notice --> Undefined variable: dataf2 C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\views\modulos\relatorio\arquivo-alerta-texto-exp.php 148
ERROR - 2023-04-27 22:19:57 --> Severity: Notice --> Undefined variable: release C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\views\modulos\relatorio\arquivo-alerta-texto-exp.php 148
ERROR - 2023-04-27 22:19:57 --> Severity: Notice --> Undefined variable: grupo C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\views\modulos\relatorio\arquivo-alerta-texto-exp.php 148
ERROR - 2023-04-27 22:19:57 --> Severity: Notice --> Undefined variable: usuario C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\views\modulos\relatorio\arquivo-alerta-texto-exp.php 148
ERROR - 2023-04-27 22:19:57 --> Severity: Notice --> Undefined variable: isrelease C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\views\modulos\relatorio\arquivo-alerta-texto-exp.php 148
ERROR - 2023-04-27 22:21:13 --> Severity: Notice --> Undefined variable: release C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\views\modulos\relatorio\arquivo-alerta-texto-exp.php 148
ERROR - 2023-04-27 22:21:13 --> Severity: Notice --> Undefined variable: grupo C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\views\modulos\relatorio\arquivo-alerta-texto-exp.php 148
ERROR - 2023-04-27 22:21:13 --> Severity: Notice --> Undefined variable: usuario C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\views\modulos\relatorio\arquivo-alerta-texto-exp.php 148
ERROR - 2023-04-27 22:21:13 --> Severity: Notice --> Undefined variable: isrelease C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\views\modulos\relatorio\arquivo-alerta-texto-exp.php 148
ERROR - 2023-04-27 22:21:48 --> Severity: Notice --> Undefined variable: usuario C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\views\modulos\relatorio\arquivo-alerta-texto-exp.php 148
ERROR - 2023-04-27 23:29:26 --> Severity: error --> Exception: Call to undefined function utf8_deocde() C:\Users\galil\OneDrive\Documentos\NetBeansProjects\monitor\application\controllers\Relatorio.php 881
