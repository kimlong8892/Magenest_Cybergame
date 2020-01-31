<?php


namespace Magenest\Cybergame\Controller\Cybergame;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magenest\Cybergame\Model\GamerAccountListFactory;
use Magento\Framework\Controller\Result\JsonFactory;

class CheckAccount extends Action
{
    protected $modelGameAcountListFactory;
    protected $jsonFactory;
    public function __construct
    (
        GamerAccountListFactory $modelGameAcountListFactory,
        JsonFactory $jsonFactory,
        Context $context
    )
    {
        $this->modelGameAcountListFactory = $modelGameAcountListFactory;
        $this->jsonFactory = $jsonFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $row = $this->modelGameAcountListFactory->create()->getCollection()->addFieldToFilter('account_name', $this->_request->getParam('name'))->count();
        $result = $this->jsonFactory->create();
        $result->setData($row);
        return $result;
    }
}