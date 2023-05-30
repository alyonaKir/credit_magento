<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Test\Unit\Controller\Adminhtml\Info;

use AlyonaKir\Credit\Controller\Adminhtml\Info\Index;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Magento\Framework\View\Page\Config;
use Magento\Framework\View\Page\Title;

/** @covers Index */
class TestIndex extends TestCase
{
    private Index $indexController;
    private PageFactory|MockObject $pageFactory;

    protected function setUp(): void
    {
        $context = $this->createMock(Context::class);
        $this->pageFactory = $this->createMock(PageFactory::class);
        $this->indexController = new Index(
            $context,
            $this->pageFactory);
    }

    /** @test  */
    public function testExecute(): void
    {
        $result = $this->createMock(Page::class);
        $this->pageFactory->expects($this->once())
            ->method('create')
            ->willReturn($result);

        $getConfig = $this->createMock(Config::class);
        $result->method('getConfig')->willReturn($getConfig);
        $getTitle = $this->createMock(Title::class);
        $getConfig->method('getTitle')->willReturn($getTitle);
        $getTitle->method('prepend')->willReturnSelf();

        $this->assertEquals($result, $this->indexController->execute());
    }
}
