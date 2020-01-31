<?php


namespace Magenest\Cybergame\Block\Cybergame;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\View\Element\Template;
use Magenest\Cybergame\Model\ResourceModel\RoomExtraOption\CollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as productCollectionFactory;

class AddOrEdit extends Template
{
    protected $productCollectionFactory;
    protected $collectionRoomFactory;
    protected $productFactory;
    public function __construct
    (
        productCollectionFactory $productCollectionFactory,
        CollectionFactory $collectionRoomFactory,
        ProductFactory $productFactory,
        Template\Context $context, array $data = []
    )
    {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->collectionRoomFactory = $collectionRoomFactory;
        $this->productFactory = $productFactory;
        parent::__construct($context, $data);
    }

    public function getProductSelect()
    {
        $product = $this->productCollectionFactory->create();
        $listRoom = $this->collectionRoomFactory->create();
        forEach($listRoom->getData() as $room)
            $product->addFieldToFilter('entity_id',array('neq' => $room['product_id']));
        return $product->getData();
    }

    public function getRoomEdit()
    {
        if(isset($this->_request->getParams()['id']))
            return $this->collectionRoomFactory->create()->addFieldToFilter('id', $this->_request->getParam('id'))->getFirstItem()->getData();
        return null;
    }
    public function getProduct($id)
    {
        return $this->productFactory->create()->load($id);
    }
}