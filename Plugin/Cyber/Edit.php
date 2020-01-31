<?php


namespace Magenest\Cybergame\Plugin\Cyber;

use Magento\Customer\Model\SessionFactory;

class Edit
{
    protected $customerSession;
    protected $customerRepositoryInterface;
    public function __construct
    (
        SessionFactory $customerSession,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
    )
    {
        $this->customerSession = $customerSession;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
    }

    public function beforeExecute(\Magento\Customer\Controller\Account\EditPost $subject)
    {
        $is_manager = $subject->getRequest()->getParams()['is_cyber_manager'] ?? 0;
        $customer = $this->customerSession->create()->getCustomerDataObject();
        $customer->setCustomAttribute('is_manager', $is_manager);
        $this->customerRepositoryInterface->save($customer);
    }
}