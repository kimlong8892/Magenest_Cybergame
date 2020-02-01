<?php


namespace Magenest\Cybergame\Observer;

use Magento\Customer\Model\SessionFactory;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\App\Request\Http;

class EditManagerCyber implements ObserverInterface
{
    protected $customerSession;
    protected $customerRepositoryInterface;
    protected $http;
    public function __construct
    (
        SessionFactory $customerSession,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        Http $http
    )
    {
        $this->customerSession = $customerSession;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->http = $http;
    }
    public function execute(EventObserver $observer)
    {
        $isManager = $this->http->getParams()['is_cyber_manager'] ?? 0;
        $customer = $this->customerSession->create()->getCustomerDataObject();
        $customer->setCustomAttribute('is_manager', $isManager);
        $this->customerRepositoryInterface->save($customer);
    }
}