<?php
declare(strict_types=1);
namespace AlyonaKir\Credit\Block\Adminhtml\Buttons;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Send extends Generic implements ButtonProviderInterface
{

    public function getSendUrl():string
    {
        $id = $this->getEntityId();
        return $this->getUrl('*/*/send', ['id' => $id]);
    }
    public function getButtonData():array
    {
        return [
            'label' => __('Send email'),
            'sort_order' => 90,
        ];
    }
}
