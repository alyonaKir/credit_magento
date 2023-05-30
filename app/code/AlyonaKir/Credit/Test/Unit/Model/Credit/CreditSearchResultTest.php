<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Test\Unit\Model;

use AlyonaKir\Credit\Api\CreditSearchResultInterface;
use AlyonaKir\Credit\Model\Credit\CreditSearchResult;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \AlyonaKir\Credit\Model\Credit\CreditSearchResult
 */
class TestCreditSearchResult extends TestCase
{
    protected CreditSearchResult|MockObject $object;

    protected function setUp(): void
    {
        $this->object = new CreditSearchResult();
    }

    /** @test */
    public function testGetItems()
    {
        $this->assertIsArray($this->object->getItems());
    }

    /** @test */
    public function testSetItems()
    {
        $this->assertInstanceOf(CreditSearchResultInterface::class, $this->object->setItems(array()));
    }
}
