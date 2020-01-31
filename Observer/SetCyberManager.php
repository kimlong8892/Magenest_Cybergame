<?php


namespace Magenest\Cybergame\Observer;


use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\App\Request\Http;

class SetCyberManager implements ObserverInterface
{
    protected $_customerRepositoryInterface;

    protected $_customerModelFactory;

    protected $request;

    public function __construct
    (
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        Http $request
    )
    {
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        $this->request= $request;
    }

    public function execute(EventObserver $observer)
    {
        $customer = $observer->getEvent()->getCustomer();
        $is_manager = $this->request->getParams()['is_cyber_manager'] ?? 0;
        $customer->setCustomAttribute('is_manager', $is_manager);
        $this->_customerRepositoryInterface->save($customer);
    }
}