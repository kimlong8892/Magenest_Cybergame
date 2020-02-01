<?php


namespace Magenest\Cybergame\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\App\Request\Http;
use Magenest\Cybergame\Model\GamerAccountListFactory;
use Magenest\Cybergame\Model\ResourceModel\GamerAccountList;
use MongoDB\Driver\Exception\Exception;

class CheckOutCyber implements ObserverInterface
{
    protected $request;
    protected $modelGameAccountList;
    protected $gamerAccountList;
    public function __construct
    (
        Http $request,
        GamerAccountListFactory $modelGameAccountList,
        GamerAccountList $gamerAccountList
    )
    {
        $this->request= $request;
        $this->modelGameAccountList = $modelGameAccountList;
        $this->gamerAccountList = $gamerAccountList;
    }

    public function execute(EventObserver $observer)
    {
        $data = $this->request->getParams();
        if(isset($data['account-name']))
        {
            try {
                $modelGameAccount = $this->modelGameAccountList->create();
                $modelGameAccount->load($data['account-name'],'account_name');
                if($modelGameAccount->getData('id') != null){
                    $modelGameAccount->setData('hour', $data['qty'] + $modelGameAccount->getData('hour'));
                } else {
                    $modelGameAccount = $this->modelGameAccountList->create();
                    $modelGameAccount->setData('hour', $data['qty']);
                }
                $modelGameAccount->setData('product_id', 1);
                $modelGameAccount->setData('password', 1);
                $modelGameAccount->setData('account_name', $data['account-name']);
                $this->gamerAccountList->save($modelGameAccount);
            } catch (Exception $exception){
                // ...
            }
        }
    }
}