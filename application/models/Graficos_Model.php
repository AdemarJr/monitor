<?php

/**
 * Description of Graficos_Model
 *
 * @author Galileu
 */
class Graficos_Model extends CI_Model{
        
    public function sqlCIDADE($chave) {
      $SQL = "SELECT 
       `TELEVISAO`.`CIDADE_TV` AS CIDADE,
       COUNT(`TELEVISAO`.`CIDADE_TV`) AS TOTAL
FROM   `MATERIA`
       JOIN `NOTA`
         ON `NOTA`.`SEQ_CLIENTE` = `MATERIA`.`SEQ_CLIENTE`
            AND `MATERIA`.`TIPO_MATERIA` =
                    IF(( NOTA.LISTA_SETOR = 83
                      OR `NOTA`.`TIPO_MATERIA` = ''
                      OR `NOTA`.`TIPO_MATERIA` IS
                    NULL ), MATERIA.TIPO_MATERIA, NOTA.TIPO_MATERIA)
       LEFT JOIN `TELEVISAO`
              ON `TELEVISAO`.`SEQ_TV` = `MATERIA`.`SEQ_TV`
       LEFT JOIN `SETOR`
              ON FIND_IN_SET(SETOR.SEQ_SETOR, MATERIA.SEQ_SETOR) > 0
WHERE  `MATERIA`.`TIPO_MATERIA` LIKE '%T%' ESCAPE '!'
       AND `MATERIA`.`SEQ_SETOR` NOT IN ( 316, 317, 318 )
       AND ( `IND_STATUS` = 'E'
              OR `IND_STATUS` = 'F' )
       AND `NOTA`.`CHAVE_NOTIFICACAO` = '".$chave."'
       AND ( `MATERIA`.`DATA_MATERIA_PUB` IS NOT NULL
             AND ( `MATERIA`.`SEQ_TV` > 0
                    OR `MATERIA`.`SEQ_PORTAL` > 0
                    OR `MATERIA`.`SEQ_RADIO` > 0
                    OR MATERIA.SEQ_VEICULO > 0 ) )
       AND `DATA_PUB_NUMERO` BETWEEN DATE_FORMAT(NOTA.DT_INICIO, '%Y%M%D') AND
                                     DATE_FORMAT(NOTA.DT_FIM, '%Y%M%D')
       AND `SETOR`.`SEQ_SETOR` IN ( 13 )
	  GROUP BY `TELEVISAO`.`CIDADE_TV`";
      
      $SQL_TV_CIDADE = $this->monitor->query($SQL)->result();
      
      $SQL = "SELECT 
       `RADIO`.`CIDADE_RADIO` AS CIDADE,
       COUNT(`RADIO`.`CIDADE_RADIO`) AS TOTAL
FROM   `MATERIA`
       JOIN `NOTA`
         ON `NOTA`.`SEQ_CLIENTE` = `MATERIA`.`SEQ_CLIENTE`
            AND `MATERIA`.`TIPO_MATERIA` =
                    IF(( NOTA.LISTA_SETOR = 83
                      OR `NOTA`.`TIPO_MATERIA` = ''
                      OR `NOTA`.`TIPO_MATERIA` IS
                    NULL ), MATERIA.TIPO_MATERIA, NOTA.TIPO_MATERIA)
       LEFT JOIN `RADIO`
              ON `RADIO`.`SEQ_RADIO` = `MATERIA`.`SEQ_RADIO`
       LEFT JOIN `SETOR`
              ON FIND_IN_SET(SETOR.SEQ_SETOR, MATERIA.SEQ_SETOR) > 0
WHERE  `MATERIA`.`TIPO_MATERIA` LIKE '%R%' ESCAPE '!'
       AND `MATERIA`.`SEQ_SETOR` NOT IN ( 316, 317, 318 )
       AND ( `IND_STATUS` = 'E'
              OR `IND_STATUS` = 'F' )
       AND `NOTA`.`CHAVE_NOTIFICACAO` = '".$chave."'
       AND ( `MATERIA`.`DATA_MATERIA_PUB` IS NOT NULL
             AND ( `MATERIA`.`SEQ_TV` > 0
                    OR `MATERIA`.`SEQ_PORTAL` > 0
                    OR `MATERIA`.`SEQ_RADIO` > 0
                    OR MATERIA.SEQ_VEICULO > 0 ) )
       AND `DATA_PUB_NUMERO` BETWEEN DATE_FORMAT(NOTA.DT_INICIO, '%Y%M%D') AND
                                     DATE_FORMAT(NOTA.DT_FIM, '%Y%M%D')
       AND `SETOR`.`SEQ_SETOR` IN ( 13 )
	  GROUP BY `RADIO`.`CIDADE_RADIO`";
      
      $SQL_RADIO_CIDADE = $this->monitor->query($SQL)->result();
      
      $SQL = "SELECT 
       `PORTAL`.`CIDADE_PORTAL` AS CIDADE,
       COUNT(`PORTAL`.`CIDADE_PORTAL`) AS TOTAL
FROM   `MATERIA`
       JOIN `NOTA`
         ON `NOTA`.`SEQ_CLIENTE` = `MATERIA`.`SEQ_CLIENTE`
            AND `MATERIA`.`TIPO_MATERIA` =
                    IF(( NOTA.LISTA_SETOR = 83
                      OR `NOTA`.`TIPO_MATERIA` = ''
                      OR `NOTA`.`TIPO_MATERIA` IS
                    NULL ), MATERIA.TIPO_MATERIA, NOTA.TIPO_MATERIA)
       LEFT JOIN `PORTAL`
              ON `PORTAL`.`SEQ_PORTAL` = `MATERIA`.`SEQ_PORTAL`
       LEFT JOIN `SETOR`
              ON FIND_IN_SET(SETOR.SEQ_SETOR, MATERIA.SEQ_SETOR) > 0
WHERE  `MATERIA`.`TIPO_MATERIA` LIKE '%S%' ESCAPE '!'
       AND `MATERIA`.`SEQ_SETOR` NOT IN ( 316, 317, 318 )
       AND ( `IND_STATUS` = 'E'
              OR `IND_STATUS` = 'F' )
       AND `NOTA`.`CHAVE_NOTIFICACAO` = '".$chave."'
       AND ( `MATERIA`.`DATA_MATERIA_PUB` IS NOT NULL
             AND ( `MATERIA`.`SEQ_TV` > 0
                    OR `MATERIA`.`SEQ_PORTAL` > 0
                    OR `MATERIA`.`SEQ_RADIO` > 0
                    OR MATERIA.SEQ_VEICULO > 0 ) )
       AND `DATA_PUB_NUMERO` BETWEEN DATE_FORMAT(NOTA.DT_INICIO, '%Y%M%D') AND
                                     DATE_FORMAT(NOTA.DT_FIM, '%Y%M%D')
       AND `SETOR`.`SEQ_SETOR` IN ( 13 )
       AND `PORTAL`.`CIDADE_PORTAL` != 'MANUAS'
	  GROUP BY `PORTAL`.`CIDADE_PORTAL`";
      
      $SQL_PORTAL_CIDADE = $this->monitor->query($SQL)->result();
      
      $SQL = "SELECT 
       `VEICULO`.`CIDADE_VEICULO` AS CIDADE,
       COUNT(`VEICULO`.`CIDADE_VEICULO`) AS TOTAL
FROM   `MATERIA`
       JOIN `NOTA`
         ON `NOTA`.`SEQ_CLIENTE` = `MATERIA`.`SEQ_CLIENTE`
            AND `MATERIA`.`TIPO_MATERIA` =
                    IF(( NOTA.LISTA_SETOR = 83
                      OR `NOTA`.`TIPO_MATERIA` = ''
                      OR `NOTA`.`TIPO_MATERIA` IS
                    NULL ), MATERIA.TIPO_MATERIA, NOTA.TIPO_MATERIA)
       LEFT JOIN `VEICULO`
              ON `VEICULO`.`SEQ_VEICULO` = `MATERIA`.`SEQ_VEICULO`
       LEFT JOIN `SETOR`
              ON FIND_IN_SET(SETOR.SEQ_SETOR, MATERIA.SEQ_SETOR) > 0
WHERE  `MATERIA`.`TIPO_MATERIA` LIKE '%I%' ESCAPE '!'
       AND `MATERIA`.`SEQ_SETOR` NOT IN ( 316, 317, 318 )
       AND ( `IND_STATUS` = 'E'
              OR `IND_STATUS` = 'F' )
       AND `NOTA`.`CHAVE_NOTIFICACAO` = '".$chave."'
       AND ( `MATERIA`.`DATA_MATERIA_PUB` IS NOT NULL
             AND ( `MATERIA`.`SEQ_TV` > 0
                    OR `MATERIA`.`SEQ_PORTAL` > 0
                    OR `MATERIA`.`SEQ_RADIO` > 0
                    OR MATERIA.SEQ_VEICULO > 0 ) )
       AND `DATA_PUB_NUMERO` BETWEEN DATE_FORMAT(NOTA.DT_INICIO, '%Y%M%D') AND
                                     DATE_FORMAT(NOTA.DT_FIM, '%Y%M%D')
       AND `SETOR`.`SEQ_SETOR` IN ( 13 )
	  GROUP BY `VEICULO`.`CIDADE_VEICULO`";
      
      $SQL_IMPRESSO_CIDADE = $this->monitor->query($SQL)->result();
      
      $dados = [
          'impresso' => $SQL_IMPRESSO_CIDADE,
          'radio' => $SQL_RADIO_CIDADE,
          'tv' => $SQL_TV_CIDADE,
          'portal' => $SQL_PORTAL_CIDADE
      ];
      return $dados;
    }
}
