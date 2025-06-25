<?php
// Set BASEPATH for CodeIgniter core
define('BASEPATH', __DIR__ . '/../system/');

// Minimal stubs for CI helper functions used by the DB layer
if (!function_exists('log_message')) {
    function log_message($level, $message)
    {
        // no-op during testing
    }
}

if (!function_exists('show_error')) {
    function show_error($message, $status_code = 500, $heading = 'Error')
    {
        throw new Exception($message, $status_code);
    }
}

require_once BASEPATH . 'core/Model.php';
require_once BASEPATH . 'database/DB.php';

// Provide get_instance() for CI_Model
function &get_instance()
{
    return CI_Test::$ci;
}

class CI_Test
{
    public static $ci;

    public static function init()
    {
        // configuration for in-memory sqlite
        $config = [
            'dsn'      => 'sqlite::memory:',
            'dbdriver' => 'sqlite3',
            'database' => ':memory:',
            'db_debug' => true,
            'char_set' => 'utf8',
            'dbcollat' => 'utf8_general_ci',
            'cachedir' => '',
            'save_queries' => true,
        ];

        self::$ci = new stdClass();
        self::$ci->db = DB($config, true);
    }
}

CI_Test::init();

require_once __DIR__ . '/../application/models/M_case.php';
