<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$home = getenv("HOME");
if (!$home) {
    $user = posix_getpwuid(posix_getuid());
    $home = $user['dir'];
    unset($user);
}
if ($home . '/.my.cnf') {
    $mysql_config = parse_ini_file($home . '/.my.cnf', true);
    if (isset($mysql_config['client']['user'])) {
        $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['user'] = $mysql_config['client']['user'];
    }
    if (isset($mysql_config['client']['password'])) {
        $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['password'] = $mysql_config['client']['password'];
    }
}
unset($home);


$GLOBALS['TYPO3_CONF_VARS']['SYS']['fileCreateMask'] = '0640';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['folderCreateMask'] = '0750';

// Enable UTF-8 Filesystem (and implicitly prevent the notice in
// the install tool, that systemLocale is not set)
$GLOBALS['TYPO3_CONF_VARS']['SYS']['systemLocale'] = 'C.UTF-8';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['UTF8filesystem'] = true;
