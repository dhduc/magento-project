<?php
/**
 * @category SM
 * @package SM_Slider
 */

$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

/**
 * Create table 'sm_slider/slider'
 */
$tableName = $installer->getTable('sm_slider/slider');
if ($installer->getConnection()->isTableExists($tableName) != true) {
    $table = $installer->getConnection()->newTable($tableName)
        ->addColumn('slider_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary'  => true,
            ), 'Slider ID')
        ->addColumn('slider_title', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable' => false,
            ), 'Slider Title')
        ->addColumn('slider_description', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable' => true,
            ), 'Slider Description')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            ), 'Creation At')
        ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            ), 'Update At')
        ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, 1, array(
            'nullable' => false,
            'default'  => 1,
            ), 'Status')
        ->addIndex($installer->getIdxName(
            $installer->getTable('sm_slider/slider'),
            array('slider_id'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX
        ),
            array('slider_id'),
            array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX)
        )
        ->setComment('SM Slider Table');
    $installer->getConnection()->createTable($table);
}

/**
 * Create table 'sm_slider/slide'
 */
$tableName = $installer->getTable('sm_slider/slide');
if ($installer->getConnection()->isTableExists($tableName) != true) {
    $table = $installer->getConnection()->newTable($tableName)
        ->addColumn('slide_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary'  => true,
            ), 'Slide ID')
        ->addColumn('slide_title', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable' => false,
            ), 'Slide Title')
        ->addColumn('text', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable' => true,
            ), 'Text')
        ->addColumn('photo', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable' => true,
            ), 'Photo')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            ), 'Creation Time')
        ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            ), 'Update Time')
        ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, 1, array(
            'nullable' => false,
            'default' => 1
            ), 'Status')
        ->addIndex($installer->getIdxName(
            $installer->getTable('sm_slider/slide'),
            array('slide_id'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX
        ),
            array('slide_id'),
            array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX)
        )
        ->setComment('SM Slide Table');
    $installer->getConnection()->createTable($table);
}

$tableName = $installer->getTable('sm_slider/slideshow');
if ($installer->getConnection()->isTableExists($tableName) != true) {
    $table = $installer->getConnection()->newTable($tableName)
        ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary'  => true,
            ), 'Slideshow ID')
        ->addColumn('slider_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
            'nullable' => false,
            ), 'Slider ID')
        ->addColumn('slide_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
            'nullable' => false,
            ), 'Slide ID')
        ->addColumn('sort_order', Varien_Db_Ddl_Table::TYPE_INTEGER, 3, array(
            'nullable' => false,
            ), 'Sort Order')
        ->addIndex($installer->getIdxName('sm_slider/slideshow', 'slider_id'), 'slider_id')
        ->addForeignKey($installer->getFkName('sm_slider/slideshow', 'slider_id', 'sm_slider/slider', 'slider_id'),
            'slider_id', $installer->getTable('sm_slider/slider'), 'slider_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->addIndex($installer->getIdxName('sm_slider/slideshow', 'slide_id'), 'slide_id')
        ->addForeignKey($installer->getFkName('sm_slider/slideshow', 'slide_id', 'sm_slider/slide', 'slide_id'),
            'slide_id', $installer->getTable('sm_slider/slide'), 'slide_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->setComment('SM Slideshow Table');
    $installer->getConnection()->createTable($table);
}

$installer->endSetup();