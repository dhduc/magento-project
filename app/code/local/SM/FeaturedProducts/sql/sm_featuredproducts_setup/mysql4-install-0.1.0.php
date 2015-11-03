<?php

/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$setup = new SM_FeaturedProducts_Model_Resource_Setup('core_setup');
$installer->startSetup();

/**
 * Add attribute 'is_featured' to products
 */
$setup->addAttribute('catalog_product', 'is_featured', array(
        'group' => 'General',
        'input' => 'boolean',
        'type' => 'int',
        'label' => 'Featured Product',
        'backend' => '',
        'visible' => 1,
        'required' => 0,
        'user_defined' => 1,
        'searchable' => 1,
        'filterable' => 1,
        'comparable' => 1,
        'visible_on_front' => 1,
        'visible_in_advanced_search' => 0,
        'is_html_allowed_on_front' => 0,
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    )
);

$installer->endSetup();