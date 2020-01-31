<?php


namespace Magenest\Cybergame\Block\Cybergame;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\View\Element\Template;
use Magenest\Cybergame\Model\ResourceModel\RoomExtraOption\CollectionFactory;
use Magento\Catalog\Model\ProductFactory;

class Show extends Template
{
    protected $collectionRoomFactory;
    protected $productFactory;
    protected $customerSeesion;
    public function __construct
    (
        CollectionFactory $collectionRoomFactory,
        ProductFactory $productFactory,
        SessionFactory $customerSeesion,
        Template\Context $context, array $data = []
    )
    {
        $this->collectionRoomFactory = $collectionRoomFactory;
        $this->productFactory = $productFactory;
        $this->customerSeesion = $customerSeesion;
        parent::__construct($context, $data);
    }
    protected function _prepareLayout()
    {
        if ($this->getRoom()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager'
            )->setAvailableLimit([5 => 5, 10 => 10, 15 => 15])->setShowPerPage(true)->setCollection(
                $this->getRoom()
            );
            $this->setChild('pager', $pager);
            $this->getRoom()->load();
        }
        return parent::_prepareLayout();
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
    public function getRoom()
    {
        $roomCollection = $this->collectionRoomFactory->create();
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 5;
        $roomCollection->setPageSize($pageSize);
        $roomCollection->setCurPage($page);
        return $roomCollection;
    }
    public function getProduct($id)
    {
        return $this->productFactory->create()->load($id);
    }
    public function checkManager()
    {
        $customer = $this->customerSeesion->create()->getCustomerDataObject();
        if(isset($customer->getCustomAttributes()['is_manager']) && $customer->getCustomAttribute('is_manager')->getValue() == 1)
            return true;
        return false;
    }

}