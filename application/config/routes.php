<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['login'] = 'login';
$route['logout'] = 'logout';
$route['inicio'] = 'principal/inicio';
$route['iniciousuario'] = 'principal/iniciousuario';
$route['iniciousuario/(:any)'] = 'principal/iniciousuario/$1';
$route['iniciousuario/(:any)/(:any)'] = 'principal/iniciousuario/$1/$2';
$route['iniciousuario/(:any)/(:any)/(:any)'] = 'principal/iniciousuario/$1/$2/$3';

// secretaria municipal de comunicacao
$route['pmm-semcom'] = 'publico/exibir/1';
$route['pmm-semcom/detalhar'] = 'publico/detalhar';
$route['pmm-semcom/detalhar/(:any)'] = 'publico/detalhar/$1';
$route['pmm-semcom/pesquisa'] = 'publico/pesquisa';
$route['pmm-semcom/imagem/(:num)'] = 'publico/imagem/$1';
$route['pmm-semcom/ajaxViewer/(:any)'] = 'publico/ajaxViewer/$1';

// secretaria estadual de comunicacao
$route['secom-am'] = 'publico/exibir/5';
$route['secom-am/detalhar'] = 'publico/detalhar';
$route['secom-am/detalhar/(:any)'] = 'publico/detalhar/$1';
$route['secom-am/pesquisa'] = 'publico/pesquisa';
$route['secom-am/imagem/(:num)'] = 'publico/imagem/$1';
$route['secom-am/ajaxViewer/(:any)'] = 'publico/ajaxViewer/$1';


// album fmm
$route['fmm'] = 'publico/fotos/fmm';
$route['album/(:any)'] = 'publico/fotos/$1';

// comunicacao plinio valerio
$route['pv'] = 'publico/exibir/4';
$route['pv/detalhar'] = 'publico/detalhar';
$route['pv/detalhar/(:any)'] = 'publico/detalhar/$1';
$route['pv/pesquisa'] = 'publico/pesquisa';
$route['pv/imagem/(:num)'] = 'publico/imagem/$1';
$route['pv/ajaxViewer/(:any)'] = 'publico/ajaxViewer/$1';

$route['c/(:any)'] = 'publico/consultar/$1';
$route['m/(:any)'] = 'publico/consultarMateria/$1';
$route['t/(:any)'] = 'publico/consultarMateriaTI/$1';
$route['dashboard'] = 'principal/dashboard';
$route['dashboard/(:num)'] = 'principal/dashboard/$1';
$route['default_controller'] = 'principal/inicio';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['gerarelatoriolink'] = 'RelatorioLink/relatorioPDFLink';
$route['alerta'] = 'sistema/alerta/tela/$1';
$route['alerta/(:any)/(:any)'] = 'sistema/alerta/tela/$1';
$route['alerta/(:any)'] = 'sistema/alerta/tela/$1';
$route['filtro'] = 'sistema/alerta/filtro';
$route['clipping'] = 'sistema/Clipping/tela';
$route['clipping/(:any)'] = 'sistema/Clipping/tela/$1';
$route['estatisticas/(:any)'] = 'sistema/Estatisticas/graficos/$1';
$route['estatisticas_pdf/(:any)'] = 'sistema/Estatisticas/pdf/$1';
$route['relatoriosistema'] = 'sistema/Relatorios/tela';
$route['meusrelatorios'] = 'sistema/Relatorios/rela';
$route['novosistema'] = 'sistema/Sistema/tela';
$route['relatorio/novo'] = 'sistema/Relatorios/rela';
$route['x/(:any)/(:any)'] = 'publico/redireciona/$1';
$route['dashboard'] = 'Dashboard/tela';
$route['geranota/(:any)'] = 'Dev/criaNota/$1';
$route['visualizar-materias/(:any)'] = 'Dashboard/materias/$1';

//$route['relatorio'] = 'sistema/Relatorios/rela';

$route['cc/(:any)'] = 'publico/consultarteste/$1';