<?php


namespace Magenest\Cybergame\Setup;

use Magento\Catalog\Model\Product;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;


class UpgradeData implements UpgradeDataInterface
{

    protected $customerSetupFactory;
    protected $_customerSetupAddAttribute;
    private $attributeSetFactory;
    private $eavSetupFactory;

    public function __construct
    (
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory,
        EavSetupFactory $eavSetupFactory
    )
    {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->eavSetupFactory = $eavSetupFactory;
    }


    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.1.0') < 0) {
            $this->addAttributeManager($setup);
        }
    }

    private function addAttributeManager($setup)
    {
        $setup->startSetup();
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
        $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();
        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
        $customerSetup->addAttribute(Customer::ENTITY, 'is_manager', [
            'type' => 'int',
            'label' => 'is_manager',
            'input' => 'boolean',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'required' => false,
            'sort_order' => 110,
            'visible' => true,
            'system' => false,
            'position' => 110,
            'default' => false
        ]);
        $image = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'is_manager')
            ->addData([
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
                'used_in_forms' => ['adminhtml_customer', 'adminhtml_checkout'],
            ]);
        $image->save();
        $setup->endSetup();
    }


}