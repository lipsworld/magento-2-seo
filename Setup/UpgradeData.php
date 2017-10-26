<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_Seo
 * @copyright   Copyright (c) 2017 Mageplaza (https://www.mageplaza.com/)
 * @license     http://mageplaza.com/LICENSE.txt
 */
namespace Mageplaza\Seo\Setup;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;


/**
 * Class UpgradeData
 * @package Mageplaza\Seo\Setup
 */
class UpgradeData implements UpgradeDataInterface
{

	/**
	 * @var \Magento\Eav\Setup\EavSetupFactory
	 */
	private $eavSetupFactory;

	/**
	 * UpgradeData constructor.
	 * @param \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
	 */
	public function __construct(EavSetupFactory $eavSetupFactory)
	{
		$this->eavSetupFactory = $eavSetupFactory;
	}

	/**
	 * @param \Magento\Framework\Setup\ModuleDataSetupInterface $setup
	 * @param \Magento\Framework\Setup\ModuleContextInterface $context
	 */
	public function upgrade( ModuleDataSetupInterface $setup, ModuleContextInterface $context ) {
		$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
		if (version_compare($context->getVersion(), '1.1.2', '<' )) {
			$this->removeAttribute($eavSetup,\Magento\Catalog\Model\Product::ENTITY,'mp_meta_robots');
			$this->removeAttribute($eavSetup,\Magento\Catalog\Model\Product::ENTITY,'mp_seo_og_description');
			$this->removeAttribute($eavSetup,\Magento\Catalog\Model\Category::ENTITY,'mp_meta_robots');
		}
	}

	/**
	 * Remove attribute
	 * @param $eavSetup
	 * @param $model
	 * @param $id
	 */
	public function removeAttribute($eavSetup,$model,$id){
		if ($eavSetup->getAttributeId($model, $id)) {
			$eavSetup->removeAttribute(
				$model,
				$id);
		}
	}


}