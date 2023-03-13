<?php

namespace AlyonaKir\Credit\Block\Adminhtml\Buttons;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class SendEmail extends Generic implements ButtonProviderInterface
{

    public function getSaveUrl()
    {
        $id = $this->getEntityId();
        return $this->getUrl('*/*/send', ['id' => $id]);
    }
    public function getButtonData()
    {
        return [
            'label' => __('Send email'),
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}
