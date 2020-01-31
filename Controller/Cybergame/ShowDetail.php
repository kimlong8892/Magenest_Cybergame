<?php


namespace Magenest\Cybergame\Controller\Cybergame;
use Magento\Framework\App\Action\Action;
use Magenest\Cybergame\Model\RoomExtraOptionFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class ShowDetail extends Action
{
    protected $roomExtraOptionFactory;
    protected $json;
    protected $jsonFactory;
    public function __construct
    (
        RoomExtraOptionFactory $roomExtraOptionFactory,
        \Magento\Framework\Serialize\Serializer\Json $json,
        JsonFactory $jsonFactory,
        Context $context
    )
    {
        $this->roomExtraOptionFactory = $roomExtraOptionFactory;
        $this->json = $json;
        $this->jsonFactory = $jsonFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->_request->getParam('id');
        $room = $this->roomExtraOptionFactory->create()->getCollection()->addFieldToFilter('product_id', $id)->getFirstItem()->getData();
        $json = $this->json->serialize($room);
        $result = $this->jsonFactory->create();
        $result->setData($json);
        return $result;
    }
}