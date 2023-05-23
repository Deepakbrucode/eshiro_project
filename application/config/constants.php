<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$base_url .= "://". @$_SERVER['HTTP_HOST'];
$base_url .=     str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
$base_url =$base_url;

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
defined('BASE_URL')            OR define('BASE_URL', $base_url);
defined('IMG_PATH')            OR define('IMG_PATH', BASE_URL.'images/');
defined('CSS_PATH')            OR define('CSS_PATH', BASE_URL.'css/');
defined('JS_PATH')             OR define('JS_PATH', BASE_URL.'js/');
defined('LIB_PATH')            OR define('LIB_PATH', BASE_URL.'lib/');

defined('SALES_COST_ID')            OR define('SALES_COST_ID', '1495');
defined('SALES_COST_CAT_ID')            OR define('SALES_COST_CAT_ID', '3');
defined('SALES_COST_SUBCAT_ID')            OR define('SALES_COST_SUBCAT_ID', '10');
defined('SALES_COST_NAME')            OR define('SALES_COST_NAME', 'Sales');
defined('SALES_COST_LINK')            OR define('SALES_COST_LINK', 'i.000.000');


defined('ACT_RECEIVABLE_COST_ID')            OR define('ACT_RECEIVABLE_COST_ID', '1450');
defined('ACT_RECEIVABLE_COST_NAME')            OR define('ACT_RECEIVABLE_COST_NAME', 'Accounts receivable');
defined('ACT_RECEIVABLE_COST_LINK')            OR define('ACT_RECEIVABLE_COST_LINK', 'ca.200.000');
defined('ACT_RECEIVABLE_COST_CAT_ID')            OR define('ACT_RECEIVABLE_COST_CAT_ID', '2');
defined('ACT_RECEIVABLE_COST_SUBCAT_ID')            OR define('ACT_RECEIVABLE_COST_SUBCAT_ID', '5');



defined('EXPENSE_COST_ID')            OR define('EXPENSE_COST_ID', '1479');
defined('EXPENSE_COST_NAME')            OR define('EXPENSE_COST_NAME', 'Accounts payable');
defined('EXPENSE_COST_LINK')            OR define('EXPENSE_COST_LINK', 'cl.500.000');
defined('EXPENSE_COST_CAT_ID')            OR define('EXPENSE_COST_CAT_ID', '2');
defined('EXPENSE_COST_SUBCAT_ID')            OR define('EXPENSE_COST_SUBCAT_ID', '6');

defined('BANKSTATEMENT_COST_ID')            OR define('BANKSTATEMENT_COST_ID', '95');
defined('BANKSTATEMENT_COST_NAME')            OR define('BANKSTATEMENT_COST_NAME', 'Bank Statement');
defined('BANKSTATEMENT_COST_LINK')            OR define('BANKSTATEMENT_COST_LINK', 'ca.810.001');
// $blink = array('ca.810.001','ca.810.002','ca.810.003','ca.810.004','ca.810.005','ca.810.006','ca.810.007','ca.810.008','ca.810.009','ca.810.0010','ca.810.0011','ca.810.0012','ca.810.0013','ca.810.0014','ca.810.0015','ca.810.0016','ca.810.0017','ca.810.0018','ca.810.0019','ca.810.0020','ca.810.0021');

// defined('BANKSTATEMENT_COST_LINK_ARRAY')            OR define('BANKSTATEMENT_COST_LINK_ARRAY', serialize(json_decode($blink, true)));
defined('BANKSTATEMENT_COST_CAT_ID')            OR define('BANKSTATEMENT_COST_CAT_ID', '2');
defined('BANKSTATEMENT_COST_SUBCAT_ID')            OR define('BANKSTATEMENT_COST_SUBCAT_ID', '5');


















