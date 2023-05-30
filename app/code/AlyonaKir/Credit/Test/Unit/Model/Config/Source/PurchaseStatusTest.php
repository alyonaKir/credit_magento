<?php

namespace AlyonaKir\Credit\Test\Unit\Config;

use AlyonaKir\Credit\Model\Application\ApplicationSearchResults;
use AlyonaKir\Credit\Model\Config\Source\PurchaseStatus;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/** @covers PurchaseStatus */
class TestPurchaseStatus extends TestCase
{
    protected PurchaseStatus|MockObject $object;

    protected function setUp(): void
    {
        $this->object = new PurchaseStatus();
    }

    /** @test */
    public function testToOptionsArray()
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

        $this->assertSame($options, $this->object->toOptionArray());
    }
}
