<?php


namespace Magenest\Cybergame\Controller\Cybergame;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Add extends Action
{
    protected $resultPageFactory;
    protected $customerSeasion;
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Magento\Customer\Model\SessionFactory $customerSeasion
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
        $this->customerSeasion = $customerSeasion;
    }

    public function execute()
    {
        $customer = $this->customerSeasion->create();
        $is_manager = $customer->getCustomerData()->getCustomAttribute('is_manager');
        if(isset($this->_request->getParams()['id']))
            $this->_redirect('cybergame/cybergame/show');
        if($is_manager == null || $is_manager->getValue() == 0)
            $this->_redirect('customer/account/edit');
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }
}