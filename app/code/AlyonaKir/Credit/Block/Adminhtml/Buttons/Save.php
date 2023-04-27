<?php
declare(strict_types=1);
namespace AlyonaKir\Credit\Block\Adminhtml\Buttons;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;


class Save extends Generic implements ButtonProviderInterface
{

    /**
     * @return string
     */
    public function getSaveUrl():string
    {
        $id = $this->getEntityId();
        return $this->getUrl('*/*/save', ['id' => $id]);
    }
    public function getButtonData():array
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}
