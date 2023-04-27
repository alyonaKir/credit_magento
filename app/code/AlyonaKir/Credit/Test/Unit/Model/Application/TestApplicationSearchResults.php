<?php
declare(strict_types=1);
namespace AlyonaKir\Credit\Test\Unit\Model;

use AlyonaKir\Credit\Api\ApplicationSearchResultInterface;
use AlyonaKir\Credit\Model\Application\ApplicationSearchResults;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/** @covers ApplicationSearchResults */
class TestApplicationSearchResults extends TestCase
{
    protected ApplicationSearchResults|MockObject $object;

    protected function setUp(): void
    {
        $this->object = new ApplicationSearchResults();
    }

    /** @test */
    public function testGetItems()
    {
        $this->assertIsArray($this->object->getItems());
    }

    /** @test */
    public function testSetItems()
    {
        $this->assertInstanceOf(ApplicationSearchResultInterface::class, $this->object->setItems(array()));
    }
}
