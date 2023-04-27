<?php
declare(strict_types=1);
namespace AlyonaKir\Credit\Model\Config\Source;
use Magento\Framework\Option\ArrayInterface;
class PurchaseStatus implements ArrayInterface
{
    public function toOptionArray(): array
    {
        $options = [
            0 => [
                'label' => 'Application Received',
                'value' => 0
            ],
            1 => [
                'label' => 'Under Review',
                'value' => 1
            ],
            2 => [
                'label' => 'Approved',
                'value' => 2
            ],
            3 => [
                'label' => 'Declined',
                'value' => 3
            ],
            4 => [
                'label' => 'Closed',
                'value' => 4
            ]
        ];
        return $options;
    }
}
