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
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['client/edit'] = 'client/add_client';
$route['invoicing/edit_customer'] = 'invoicing/add_customer';
$route['invoicing/edit_supplier'] = 'invoicing/add_supplier';
$route['payments/cost'] = 'payments/payment_cfrb';
$route['payments/fee'] = 'payments/payment_cfrb';
$route['payments/refund'] = 'payments/payment_cfrb';
$route['payments/bank_charges'] = 'payments/payment_cfrb';
$route['payments/edit'] = 'payments/payment_cfrb';
$route['receipts/deposit'] = 'receipts/receipt_drc';
$route['receipts/rtd'] = 'receipts/receipt_drc';
$route['receipts/credit_interest'] = 'receipts/receipt_drc';
$route['receipts/edit'] = 'receipts/receipt_drc';

$route['invoicing/add_customer_invoice'] = 'invoicing/add_invoice/5';
$route['invoicing/add_customer_quote'] = 'invoicing/add_invoice/6';
$route['invoicing/add_supplier_invoice'] = 'invoicing/add_invoice/7';

$route['invoicing/edit_customer_invoice'] = 'invoicing/edit_invoice/5';
$route['invoicing/edit_customer_quote'] = 'invoicing/edit_invoice/6';
$route['invoicing/edit_supplier_invoice'] = 'invoicing/edit_invoice/7';

$route['invoicing/show_customer_invoice'] = 'invoicing/show_invoice/5';
$route['invoicing/show_customer_quote'] = 'invoicing/show_invoice/6';
$route['invoicing/show_supplier_invoice'] = 'invoicing/show_invoice/7';


$route['reports/invoice_ledger'] = 'reports/ledger_creation/1';
$route['reports/banktrans_ledger'] = 'reports/ledger_creation/2';

$route['reports/invoice_financial'] = 'reports/financial_statement_creation/1';
$route['reports/banktrans_financial'] = 'reports/financial_statement_creation/2';

$route['reports/invoice_trialbal'] = 'reports/trialbalance_creation/1';
$route['reports/banktrans_trialbal'] = 'reports/trialbalance_creation/2';

$route['reports/asset_register_invoice'] = 'reports/fixed_asset_register/1';
$route['reports/asset_register_bk'] = 'reports/fixed_asset_register/2';

$route['financialreport/financial_report_invoice'] = 'financialreport/index/1';
$route['financialreport/financial_report_bk'] = 'financialreport/index/2';