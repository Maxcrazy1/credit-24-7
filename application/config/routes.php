<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Application';
$route['404_override'] = 'Application/error_404';
$route['translate_uri_dashes'] = FALSE;

#	Cliente Movil
$route['cobros'] = 'Application/mobile_index';
$route['cobros/error'] = 'Application/mobile_index';
$route['cobros/errorI'] = 'Application/mobile_index';
$route['cobros/clientes/(:num)'] = 'Client/mobile_index/$1';
$route['cobros/clientes'] = 'Application/client_index';
$route['cobros/gastos'] = 'Expense';
$route['cobros/gastos/agregar'] = 'Expense/addExpense';
$route['cobros/gastos/confirmarBorrar/(:num)'] = 'Expense/removeExpense/$1';
$route['cobros/contabilidad'] = 'Application/mobile_colaboratorDayAccounting';

$route['cobros/prestamos/confirmarPago'] = 'Loan/confirmPayment';
$route['cobros/prestamos/confirmarRenovar'] = 'Loan/confirmLoan';
$route['cobros/prestamos/pagar'] = 'Loan/storePayLoan';
$route['cobros/prestamos/renovar'] = 'Loan/renewLoan';
$route['cobros/prestamos/(:any)'] = 'Loan/mobile_index/$1';
$route['prestamos/hoy'] = 'Colaborator/displayLoanColaboratorToday';
$route['perfil'] = 'Colaborator/myProfile';

#	Applicacion Access
$route['ingresar'] = 'Application';
$route['login'] = 'Application/login';
$route['mlogin'] = 'Application/mobile_login';
$route['logout'] = 'Application/logout';
$route['error'] = 'Application';

$route['cobros/restaurar'] = 'User/changePassword';
$route['cobros/restaurar/error'] = 'User/changePassword';

#	Clientes
$route['clientes'] = 'Client';
$route['clientes/agregar'] = 'Client/addProfile';
$route['clientes/borrar'] = 'Client/deleteProfile';
$route['clientes/actualizar'] = 'Client/updateProfile';
$route['clientes/(:num)'] = 'Client/displayProfile/$1';

#	Colaboradores
$route['colaboradores'] = 'Colaborator';
$route['colaboradores/agregar'] = 'Colaborator/addProfile';
$route['colaboradores/borrar'] = 'Colaborator/deleteProfile';
$route['colaboradores/actualizar'] = 'Colaborator/updateProfile';
$route['colaboradores/(:num)'] = 'Colaborator/displayProfile/$1';
$route['colaboradores/alternar/todo/(:num)'] = 'Colaborator/toogleStatusAll/$1';
$route['colaboradores/alternar/(:num)/(:num)'] = 'Colaborator/toogleStatus/$1/$2';
$route['colaboradores/actualizar-disponible'] = 'Colaborator/updateAvailable';
$route['colaboradores/gastos/confirmarBorrar/(:num)/(:num)'] = 'Expense/removeExpense/$1/$2';

$route['prestamos/gastos/confirmarBorrar/(:num)'] = 'Expense/removeExpense/$1';

#	Prestamos
$route['prestamos'] = 'Loan';
$route['prestamos-dia'] = 'Loan/ListDay';
$route['prestamos/pagar'] = 'Loan/storePayLoan';
$route['prestamos/agregar-black'] = 'Loan/payBlackList';
$route['prestamos/agregar'] = 'Loan/addLoan';
$route['prestamos/borrar'] = 'Loan/removeLoan';
$route['prestamos/actualizar'] = 'Loan/updateLoan';
$route['prestamos/(:num)'] = 'Loan/displayLoanInfo/$1';
$route['prestamos/actualizar-monto'] = 'Loan/updateMonto';
$route['prestamos/actualizar-info/(:num)'] = 'Loan/updateInfoLoan/$1';

#	Reportes prestamos
$route['prestamos/reportes'] = 'Loan/reportLoanRange';
$route['prestamos/informes'] = 'Loan/reportLoanRangeRegion';

#	Reporte abonos
$route['abonos/reportes'] = 'Loan/reportPaymentRange/todo';
$route['abonos/confirmarBorrar/(:num)'] = 'Loan/confirmRepayLoan/$1';
$route['abonos/actualizar/(:num)'] = 'Loan/updatePayment/$1';

$route['abonos/borrar/(:num)'] = 'Loan/repayLoan/$1';
$route['abonos/reportes/rango'] = 'Loan/reportPaymentRange/rango';
$route['abonos/reportes/hoy'] = 'Loan/reportPaymentRange/hoy';
$route['abonos/reportes/semana'] = 'Loan/reportPaymentRange/semana';
$route['abonos/reportes/mes'] = 'Loan/reportPaymentRange/mes';

#	Configuracion
$route['horarios'] = 'Calendar';
$route['horarios/agregar'] = 'Calendar/addEntry';
$route['horarios/actualizar'] = 'Calendar/updateEntry';
$route['horarios/eliminar/(:num)'] = 'Calendar/deleteEntry/$1';

#Lista Negra de Clientes
$route['lista-negra'] = 'Region/blackListCli';

#Lista de clientes por semana
$route['primer-semana'] = 'Region/oneWeeksCli';
$route['segunda-semana'] = 'Region/twoWeeksCli';
$route['tercer-semana'] = 'Region/threeWeeksCli';
$route['cuarta-semana'] = 'Region/fourWeeksCli';
$route['quinta-semana'] = 'Region/fiveWeeksCli';

#	Regiones
$route['regiones'] = 'Region';
$route['regiones/(:num)'] = 'Region/displayRegion/$1';
$route['regiones/lista-negra'] = 'Region/blackListCli';
$route['regiones/agregar'] = 'Region/addRegion';
$route['regiones/borrar/(:num)'] = 'Region/removeRegion/$1';

#	Usuarios
$route['usuarios'] = 'User';
$route['usuarios/agregar'] = 'User/addProfile';
$route['usuarios/actualizar'] = 'User/updateProfile';
$route['usuarios/(:num)'] = 'User/displayProfile/$1';
$route['usuarios/borrar'] = 'User/removeUser';
$route['usuarios/eliminar'] = 'User/removeAdmin';
$route['usuarios/cambiar'] = 'User/changeAdminPassword';
$route['usuarios/restaurar'] = 'User/restoreAdminPassword';
$route['usuarios/restaurar/(:num)'] = 'User/restorePassword/$1';

#	Configuracion
$route['configuracion'] = 'Application/config_index';
$route['configuracion/actualizar'] = 'Application/updateConfig';

#   Consulta
$route['consulta'] = 'Credit';
$route['consulta/credito-usuario'] = 'Credit/displayUserCreditInfo';