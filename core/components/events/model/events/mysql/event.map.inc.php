<?php
$xpdo_meta_map['Event']= array (
  'package' => 'events',
  'table' => 'events',
  'fields' =>
  array (
    'id' => NULL,
    'subtype' => NULL,
    'title' => NULL,
    'date' => NULL,
    'time' => NULL,
    'description' => NULL,
    'published' => 0,
    'datetime_created' => NULL,
    'datetime_modified' => 'CURRENT_TIMESTAMP',
  ),
  'fieldMeta' =>
  array (
    'id' =>
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => false,
      'index' => 'pk',
      'generated' => 'native',
    ),
    'subtype' =>
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
    ),
    'title' =>
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
    ),
    'date' =>
    array (
      'dbtype' => 'date',
      'phptype' => 'string',
      'null' => true,
    ),
    'time' =>
    array (
      'dbtype' => 'time',
      'phptype' => 'string',
      'null' => true,
    ),
    'description' =>
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'published' =>
    array (
      'dbtype' => 'varchar',
      'precision' => '1',
      'phptype' => 'int',
      'null' => false,
      'default' => '0',
    ),
    'datetime_created' =>
    array (
      'dbtype' => 'timestamp',
      'phptype' => 'string',
      'null' => true,
    ),
    'datetime_modified' =>
    array (
      'dbtype' => 'timestamp',
      'phptype' => 'string',
      'null' => false,
      'default' => 'CURRENT_TIMESTAMP',
    ),
  ),
  'indexes' =>
  array (
    'PRIMARY' =>
    array (
      'alias' => 'PRIMARY',
      'primary' => true,
      'unique' => true,
      'columns' =>
      array (
        'id' =>
        array (
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
);
