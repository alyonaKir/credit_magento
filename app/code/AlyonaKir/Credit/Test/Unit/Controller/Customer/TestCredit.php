<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Test\Unit\Controller\Customer;

use AlyonaKir\Credit\Controller\Customer\Credit;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Magento\Framework\Message\ManagerInterface;

/** @covers Credit */
class TestCredit extends TestCase
{
    private Credit $creditController;
    private PageFactory|MockObject $pageFactory;

    protected function setUp(): void
    {
        $this->pageFactory = $this->createMock(PageFactory::class);
        $messageManager = $this->createMock(ManagerInterface::class);
        $this->creditController = new Credit(
            $this->pageFactory,
            $messageManager
        );
    }

    /** @test  */
    public function testExecute(): void
    {
        $result = $this->createMock(Page::class);
        $this->pageFactory->expects($this->once())
            ->method('create')
            ->willReturn($result);

        $this->assertEquals($result, $this->creditController->execute());
    }
}
