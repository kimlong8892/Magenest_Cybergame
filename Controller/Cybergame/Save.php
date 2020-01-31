<?php

namespace Magenest\Cybergame\Controller\Cybergame;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magenest\Cybergame\Model\RoomExtraOptionFactory;
use Magenest\Cybergame\Model\ResourceModel\RoomExtraOption;
use MongoDB\Driver\Exception\Exception;
use Magento\Catalog\Model\ProductFactory;


class Save extends Action
{
    protected $modelRoomExtraOptionFactory;
    protected $resourceRoomExtraOption;
    protected $modelProductFactory;
    public function __construct
    (
        RoomExtraOptionFactory $modelRoomExtraOptionFactory,
        RoomExtraOption $resourceRoomExtraOption,
        ProductFactory $modelProductFactory,
        Context $context
    )
    {
        $this->modelRoomExtraOptionFactory = $modelRoomExtraOptionFactory;
        $this->resourceRoomExtraOption = $resourceRoomExtraOption;
        $this->modelProductFactory = $modelProductFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $data = $this->_request->getParams();
        $modelRoom = $this->modelRoomExtraOptionFactory->create();
        if(isset($data['id']))
            $modelRoom->load($data['id']);
        else
        {
            $modelRoom->setData('product_id', $data['product-id']);
            $modelRoom->setData('name', $this->modelProductFactory->create()->load($data['product-id'])->getName());
        }

        $modelRoom->setData('number_pc', $data['number-pc']);
        $modelRoom->setData('address', $data['address']);
        $modelRoom->setData('food_price', $data['food-price']);
        $modelRoom->setData('drink_price', $data['drink-price']);
        try {
            $this->resourceRoomExtraOption->save($modelRoom);
        } catch (Exception $exception){

        };
        $this->_redirect('cybergame/cybergame/show');
    }
}
