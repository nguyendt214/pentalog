<?php
/**
 * User: ndotrong
 */
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$installer = $this;
//Insert Type default
$typeData = array(
    array(
        'title' => 'Pentalog',
        'style_name' => 'styles-pentalog.css'
    ),
    array(
        'title' => 'Magento',
        'style_name' => 'styles-magento.css'
    ),
);
foreach($typeData as $data){
    Mage::getModel('blog/type')->addData($data)->save();
}
//Insert Category default
$categoryData = array(
    array(
        'identifier' => 'pentalog',
        'url' => 'pentalog.html',
        'name' => 'Pentalog',
        'short_description' => 'short_description',
        'description' => 'description',
        'image' => '',
        'status' => 1,
        'created_time' => Mage::getModel('core/date')->gmtDate(),
        'update_time' => Mage::getModel('core/date')->gmtDate(),
        'store_id' => array(0),
        'type_id' => 1
    ),
    array(
        'identifier' => 'magento',
        'url' => 'magento.html',
        'name' => 'Magento',
        'short_description' => 'short_description',
        'description' => 'description',
        'image' => '',
        'status' => 1,
        'created_time' => Mage::getModel('core/date')->gmtDate(),
        'update_time' => Mage::getModel('core/date')->gmtDate(),
        'store_id' => array(0),
        'type_id' => 2
    ),
);
foreach ($categoryData as $data) {
    Mage::getModel('blog/category')->addData($data)->save();
}
//Insert Blog default
$blogData = array(
    array(
        'identifier' => 'first-article',
        'url' => 'first-article.html',
        'title' => 'First Article Title',
        'short_description' => 'Short Description',
        'description' => 'Description',
        'author' => 'Pentalog',
        'image' => '',
        'status' => 1,
        'type_id' => 1,
        'created_time' => Mage::getModel('core/date')->gmtDate(),
        'update_time' => Mage::getModel('core/date')->gmtDate(),
        'store_id' => array(0),
        'category_id' => array(1, 2)
    ),
    array(
        'identifier' => 'second-article',
        'url' => 'second-article.html',
        'title' => 'Second Article Title',
        'short_description' => 'Short Description',
        'description' => 'Description',
        'author' => 'Pentalog',
        'image' => '',
        'status' => 1,
        'type_id' => 1,
        'created_time' => Mage::getModel('core/date')->gmtDate(),
        'update_time' => Mage::getModel('core/date')->gmtDate(),
        'store_id' => array(0),
        'category_id' => array(1, 2)
    )
);
foreach($blogData as $data){
    Mage::getModel('blog/blog')->addData($data)->save();
}
$installer->endSetup();