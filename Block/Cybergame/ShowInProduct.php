<?php


namespace Magenest\Cybergame\Block\Cybergame;
use Magento\Catalog\Block\Product\View\AbstractView;
use Magento\Framework\View\Element\Template;
use Magenest\Cybergame\Model\RoomExtraOptionFactory;

class ShowInProduct extends AbstractView
{
    protected $roomExtraOptionFactory;
    protected $json;
    public function __construct
    (
        RoomExtraOptionFactory $roomExtraOptionFactory,
        \Magento\Framework\Serialize\Serializer\Json $json,
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Stdlib\ArrayUtils $arrayUtils,
        array $data = [])
    {
        $this->roomExtraOptionFactory = $roomExtraOptionFactory;
        $this->json = $json;
        parent::__construct($context, $arrayUtils, $data);
    }

    public function getProductId()
    {
        $id = $this->getProduct()->getId();
        return $id;
    }
}