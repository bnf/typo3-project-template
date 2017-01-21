<?php
$EM_CONF[$_EXTKEY] = array(
    'title' => 'Site',
    'description' => 'Site Extension',
    'category' => 'distribution',
    'author' => 'Benjamin Franzke',
    'author_email' => 'benjaminfranzke@googlemail.com',
    'author_company' => '',
    'shy' => '',
    'priority' => '',
    'module' => '',
    'state' => 'beta',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'modify_tables' => '',
    'clearCacheOnLoad' => 0,
    'lockType' => '',
    'version' => '0.5',
    'constraints' => array(
        'depends' => array(
            'extbase' => '7.6',
            'fluid' => '7.6',
            'typo3' => '7.6',
            'skip_page_is_being_generated' => '1.1.1',
            'autoflush' => '1.3.1',
        ),
        'conflicts' => array(
        ),
        'suggests' => array(
        ),
    ),
);
