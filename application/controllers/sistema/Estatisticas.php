<?php
//
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

/**
 * Description of Estatisticas
 *
 * @author Galileu
 */
class Estatisticas extends CI_Controller {
    
    
    
    public function __construct() {
        parent::__construct();
        $this->load->model('MateriaModeloMonitor', 'MateriaModelo');
        $this->load->model('Graficos_Model', 'grafico');
    }

    
    private function avaliacao($chave) {
        $filtro = ['termo' => '', 'grupo-v' => 'off', 'grupo-av' => 'on', 'grupo_veiculo' => 'I', 'grupo_avaliacao' => 'P', 'ordem' => '0'];
        $this->session->set_userdata('filtro', $filtro);
        $materia_positiva = count($this->MateriaModelo->getConsulta($chave, null, null));

        $filtro = ['termo' => '', 'grupo-v' => 'off', 'grupo-av' => 'on', 'grupo_veiculo' => 'I', 'grupo_avaliacao' => 'N', 'ordem' => '0'];
        $this->session->set_userdata('filtro', $filtro);
        $materia_negativa = count($this->MateriaModelo->getConsulta($chave, null, null));
                
        $filtro = ['termo' => '', 'grupo-v' => 'off', 'grupo-av' => 'on', 'grupo_veiculo' => 'I', 'grupo_avaliacao' => 'T', 'ordem' => '0'];
        $this->session->set_userdata('filtro', $filtro);
        $materia_neutras = count($this->MateriaModelo->getConsulta($chave, null, null));
        
        return array('POSITIVAS' => $materia_positiva, 'NEGATIVAS' => $materia_negativa, 'NEUTRAS' => $materia_neutras);
    }
    
    private function chart($chave) {        
        $this->session->unset_userdata('filtro');
        
        //$avaliacao = $this->avaliacao($chave);
        
        // TOTAIS
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'off', 'grupo_veiculo' => 'S', 'grupo_avaliacao' => 'P', 'ordem' => '0'));
        $internet = count($this->MateriaModelo->getConsulta($chave, null, null));

        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'off', 'grupo_veiculo' => 'I', 'grupo_avaliacao' => 'P', 'ordem' => '0'));
        $impresso = count($this->MateriaModelo->getConsulta($chave, null, null));

        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'off', 'grupo_veiculo' => 'T', 'grupo_avaliacao' => 'P', 'ordem' => '0'));
        $tv = count($this->MateriaModelo->getConsulta($chave, null, null));

        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'off', 'grupo_veiculo' => 'R', 'grupo_avaliacao' => 'P', 'ordem' => '0'));
        $radio = count($this->MateriaModelo->getConsulta($chave, null, null));
        
        //INTERNET
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'on', 'grupo_veiculo' => 'S', 'grupo_avaliacao' => 'P', 'ordem' => '0'));
        $internet_av_positiva = count($this->MateriaModelo->getConsulta($chave, null, null));
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'on', 'grupo_veiculo' => 'S', 'grupo_avaliacao' => 'N', 'ordem' => '0'));
        $internet_av_negativa = count($this->MateriaModelo->getConsulta($chave, null, null));
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'on', 'grupo_veiculo' => 'S', 'grupo_avaliacao' => 'T', 'ordem' => '0'));
        $internet_av_neutras = count($this->MateriaModelo->getConsulta($chave, null, null));
        
        //RADIO
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'on', 'grupo_veiculo' => 'R', 'grupo_avaliacao' => 'P', 'ordem' => '0'));
        $radio_av_positiva = count($this->MateriaModelo->getConsulta($chave, null, null));
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'on', 'grupo_veiculo' => 'R', 'grupo_avaliacao' => 'N', 'ordem' => '0'));
        $radio_av_negativa = count($this->MateriaModelo->getConsulta($chave, null, null));
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'on', 'grupo_veiculo' => 'R', 'grupo_avaliacao' => 'T', 'ordem' => '0'));
        $radio_av_neutras = count($this->MateriaModelo->getConsulta($chave, null, null));
        
        //TV
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'on', 'grupo_veiculo' => 'T', 'grupo_avaliacao' => 'P', 'ordem' => '0'));
        $tv_av_positiva = count($this->MateriaModelo->getConsulta($chave, null, null));
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'on', 'grupo_veiculo' => 'T', 'grupo_avaliacao' => 'N', 'ordem' => '0'));
        $tv_av_negativa = count($this->MateriaModelo->getConsulta($chave, null, null));
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'on', 'grupo_veiculo' => 'T', 'grupo_avaliacao' => 'T', 'ordem' => '0'));
        $tv_av_neutras = count($this->MateriaModelo->getConsulta($chave, null, null));
        
        //IMPRESSO
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'on', 'grupo_veiculo' => 'I', 'grupo_avaliacao' => 'P', 'ordem' => '0'));
        $impresso_av_positiva = count($this->MateriaModelo->getConsulta($chave, null, null));
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'on', 'grupo_veiculo' => 'I', 'grupo_avaliacao' => 'N', 'ordem' => '0'));
        $impresso_av_negativa = count($this->MateriaModelo->getConsulta($chave, null, null));
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'on', 'grupo_veiculo' => 'I', 'grupo_avaliacao' => 'T', 'ordem' => '0'));
        $impresso_av_neutras = count($this->MateriaModelo->getConsulta($chave, null, null));
        
        $chart = [
            'AVALIACOES' => [
                'POSITIVAS' => $avaliacao['POSITIVAS'],
                'NEGATIVAS' => $avaliacao['NEGATIVAS'],
                'NEUTRAS' => $avaliacao['NEUTRAS']
            ],
            'MIDIAS' => [
                'INTERNET' => [
                    'POSITIVAS' => $internet_av_positiva,
                    'NEGATIVAS' => $internet_av_negativa,
                    'NEUTRAS' => $internet_av_neutras,
                    'TOTAL' => $internet
                ],
                'IMPRESSO' => [
                    'POSITIVAS' => $impresso_av_positiva,
                    'NEGATIVAS' => $impresso_av_negativa,
                    'NEUTRAS' => $impresso_av_neutras,
                    'TOTAL' => $impresso
                ],
                'TV' => [
                    'POSITIVAS' => $tv_av_positiva,
                    'NEGATIVAS' => $tv_av_negativa,
                    'NEUTRAS' => $tv_av_neutras,
                    'TOTAL' => $tv
                ],
                'RADIO' => [
                    'POSITIVAS' => $radio_av_positiva,
                    'NEGATIVAS' => $radio_av_negativa,
                    'NEUTRAS' => $radio_av_neutras,
                    'TOTAL' => $radio
                ]
            ]
        ];

        $this->session->unset_userdata('filtro');

        return $chart;
    }
    
    private function chartRadio($chave) {
        
        $this->session->unset_userdata('filtro');
        
        $avaliacao = $this->avaliacao($chave);
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'off', 'grupo_veiculo' => 'R', 'grupo_avaliacao' => 'P', 'ordem' => '0'));
        $radio = count($this->MateriaModelo->getConsulta($chave, null, null));
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'on', 'grupo_veiculo' => 'R', 'grupo_avaliacao' => 'P', 'ordem' => '0'));
        $radio_av_positiva = count($this->MateriaModelo->getConsulta($chave, null, null));
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'on', 'grupo_veiculo' => 'R', 'grupo_avaliacao' => 'N', 'ordem' => '0'));
        $radio_av_negativa = count($this->MateriaModelo->getConsulta($chave, null, null));
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'on', 'grupo_veiculo' => 'R', 'grupo_avaliacao' => 'T', 'ordem' => '0'));
        $radio_av_neutras = count($this->MateriaModelo->getConsulta($chave, null, null));
        
         $chart = [
            'AVALIACOES' => [
                'POSITIVAS' => $avaliacao['POSITIVAS'],
                'NEGATIVAS' => $avaliacao['NEGATIVAS'],
                'NEUTRAS' => $avaliacao['NEUTRAS']
            ],
            'MIDIAS' => [
                'RADIO' => [
                    'POSITIVAS' => $radio_av_positiva,
                    'NEGATIVAS' => $radio_av_negativa,
                    'NEUTRAS' => $radio_av_neutras,
                    'TOTAL' => $radio
                ]
            ]
    ];
        $this->session->unset_userdata('filtro');
        return $chart;
    }
    
    private function chartTV($chave) {
        
        $this->session->unset_userdata('filtro');
        
        $avaliacao = $this->avaliacao($chave);
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'off', 'grupo_veiculo' => 'T', 'grupo_avaliacao' => 'P', 'ordem' => '0'));
        $tv = count($this->MateriaModelo->getConsulta($chave, null, null));
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'on', 'grupo_veiculo' => 'T', 'grupo_avaliacao' => 'P', 'ordem' => '0'));
        $tv_av_positiva = count($this->MateriaModelo->getConsulta($chave, null, null));
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'on', 'grupo_veiculo' => 'T', 'grupo_avaliacao' => 'N', 'ordem' => '0'));
        $tv_av_negativa = count($this->MateriaModelo->getConsulta($chave, null, null));
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'on', 'grupo_veiculo' => 'T', 'grupo_avaliacao' => 'T', 'ordem' => '0'));
        $tv_av_neutras = count($this->MateriaModelo->getConsulta($chave, null, null));
        
         $chart = [
            'AVALIACOES' => [
                'POSITIVAS' => $avaliacao['POSITIVAS'],
                'NEGATIVAS' => $avaliacao['NEGATIVAS'],
                'NEUTRAS' => $avaliacao['NEUTRAS']
            ],
            'MIDIAS' => [
                'TV' => [
                    'POSITIVAS' => $tv_av_positiva,
                    'NEGATIVAS' => $tv_av_negativa,
                    'NEUTRAS' => $tv_av_neutras,
                    'TOTAL' => $tv
                ],
            ]
    ];
        $this->session->unset_userdata('filtro');
        return $chart;
    }
    
    private function chartInternet($chave) {
        
        $this->session->unset_userdata('filtro');
        
        $avaliacao = $this->avaliacao($chave);
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'off', 'grupo_veiculo' => 'S', 'grupo_avaliacao' => 'P', 'ordem' => '0'));
        $internet = count($this->MateriaModelo->getConsulta($chave, null, null));
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'on', 'grupo_veiculo' => 'S', 'grupo_avaliacao' => 'P', 'ordem' => '0'));
        $internet_av_positiva = count($this->MateriaModelo->getConsulta($chave, null, null));
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'on', 'grupo_veiculo' => 'S', 'grupo_avaliacao' => 'N', 'ordem' => '0'));
        $internet_av_negativa = count($this->MateriaModelo->getConsulta($chave, null, null));
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'on', 'grupo_veiculo' => 'S', 'grupo_avaliacao' => 'T', 'ordem' => '0'));
        $internet_av_neutras = count($this->MateriaModelo->getConsulta($chave, null, null));
        
         $chart = [
            'AVALIACOES' => [
                'POSITIVAS' => $avaliacao['POSITIVAS'],
                'NEGATIVAS' => $avaliacao['NEGATIVAS'],
                'NEUTRAS' => $avaliacao['NEUTRAS']
            ],
            'MIDIAS' => [
                'INTERNET' => [
                    'POSITIVAS' => $internet_av_positiva,
                    'NEGATIVAS' => $internet_av_negativa,
                    'NEUTRAS' => $internet_av_neutras,
                    'TOTAL' => $internet
                ],
            ]
    ];
        $this->session->unset_userdata('filtro');
        return $chart;
    }
    
    private function chartImpresso($chave) {
        
        $this->session->unset_userdata('filtro');
        
        $avaliacao = $this->avaliacao($chave);
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'off', 'grupo_veiculo' => 'I', 'grupo_avaliacao' => 'P', 'ordem' => '0'));
        $impresso = count($this->MateriaModelo->getConsulta($chave, null, null));
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'on', 'grupo_veiculo' => 'I', 'grupo_avaliacao' => 'P', 'ordem' => '0'));
        $impresso_av_positiva = count($this->MateriaModelo->getConsulta($chave, null, null));
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'on', 'grupo_veiculo' => 'I', 'grupo_avaliacao' => 'N', 'ordem' => '0'));
        $impresso_av_negativa = count($this->MateriaModelo->getConsulta($chave, null, null));
        
        $this->session->set_userdata('filtro', array('termo' => '', 'grupo-v' => 'on', 'grupo-av' => 'on', 'grupo_veiculo' => 'I', 'grupo_avaliacao' => 'T', 'ordem' => '0'));
        $impresso_av_neutras = count($this->MateriaModelo->getConsulta($chave, null, null));
        
         $chart = [
            'AVALIACOES' => [
                'POSITIVAS' => $avaliacao['POSITIVAS'],
                'NEGATIVAS' => $avaliacao['NEGATIVAS'],
                'NEUTRAS' => $avaliacao['NEUTRAS']
            ],
            'MIDIAS' => [
                'IMPRESSO' => [
                    'POSITIVAS' => $impresso_av_positiva,
                    'NEGATIVAS' => $impresso_av_negativa,
                    'NEUTRAS' => $impresso_av_neutras,
                    'TOTAL' => $impresso
                ],
            ]
    ];
        $this->session->unset_userdata('filtro');
        return $chart;
    }
    
    public function graficos($chave) {

        $dadosNota = $this->ComumModelo->getTableData('NOTA', array('CHAVE_NOTIFICACAO' => $chave))->row();
        
        if (empty($dadosNota->TIPO_MATERIA)) {
        $chart = $this->chart($chave);
        } else if ($dadosNota->TIPO_MATERIA == 'R') {
        //$chart = $this->chartRadio($chave);    
        } else if ($dadosNota->TIPO_MATERIA == 'S') {
        //$chart = $this->chartInternet($chave);     
        } else if ($dadosNota->TIPO_MATERIA == 'T') {
       // $chart = $this->chartTV($chave);     
        } else if ($dadosNota->TIPO_MATERIA == 'I') {
        //$chart = $this->chartImpresso($chave);         
        }
        
        $dados = [
            'clipping' => $dadosNota,
            'chart_avaliacao' => $chart
        ];
        $this->load->view('modulos/publico/alerta/includes/topo');
        $this->load->view('modulos/publico/alerta/graficos', $dados);
    }

    public function pdf($chave) {
        $cidade = $this->cidade($chave);

        $dados = [
            'chave' => $chave,
            'cidade' => $cidade
        ];
        $htm = $this->load->view('modulos/publico/alerta/includes/pdf/grafico', $dados, true);

        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->WriteHTML($htm);
        $pdf->charset_in = 'UTF-8';
        $pdf->Output((date('dmYHis')) . 'estatistica' . '.pdf', 'D');
    }

}
