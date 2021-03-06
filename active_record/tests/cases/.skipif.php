<?php
define('LIMB_TEST_DB_DSN', 'mysql://root:test@localhost/limb_test?charset=utf8');
require_once(dirname(__FILE__) . '/../../common.inc.php');

require_once('limb/core/tests/cases/init.inc.php');
lmb_tests_init_var_dir(dirname(__FILE__) . '/../../../var');

require_once('limb/dbal/tests/cases/init.inc.php');
lmb_tests_init_db_dsn();

return lmb_tests_db_dump_does_not_exist(dirname(__FILE__) . '/.fixture/init_tests.', 'ACTIVE_RECORD');