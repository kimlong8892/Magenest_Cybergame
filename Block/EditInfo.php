<?php


namespace Magenest\Cybergame\Block;
use Magento\Framework\View\Element\Template;
use Magento\Customer\Model\SessionFactory;

class EditInfo extends Template
{
    protected $customerSeesion;
    public function __construct
    (
        SessionFactory $customerSeesion,
        Template\Context $context, array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->customerSeesion = $customerSeesion;
    }
    public function checkManager()
    {
        $customer = $this->customerSeesion->create()->getCustomerDataObject();
        if(isset($customer->getCustomAttributes()['is_manager']) && $customer->getCustomAttribute('is_manager')->getValue() == 1)
            return true;
        return false;
    }
}