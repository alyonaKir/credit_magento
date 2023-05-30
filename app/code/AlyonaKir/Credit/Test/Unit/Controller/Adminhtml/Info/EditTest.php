<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Test\Unit\Controller\Adminhtml\Info;

use AlyonaKir\Credit\Controller\Adminhtml\Info\Edit;
use AlyonaKir\Credit\Model\Credit\CreditRepository;
use AlyonaKir\Credit\Model\Credit\CreditRepositoryFactory;
use Magento\Backend\App\Action\Context;
use AlyonaKir\Credit\Model\Credit\CreditFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Magento\Framework\View\Page\Config;
use Magento\Framework\View\Page\Title;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\App\RequestInterface;
use AlyonaKir\Credit\Model\Credit\Credit;

/** @covers Edit */
class TestEdit extends TestCase
{
    private Edit $editController;
    private Registry|MockObject $coreRegistry;
    private PageFactory|MockObject $pageFactory;
    private CreditRepository|MockObject $creditRepository;
    private ManagerInterface|MockObject $messageManager;
    private Redirect|MockObject $resultRedirect;
    private RequestInterface|MockObject $request;
    private Credit|MockObject $credit;
    private int $creditId;

    protected function setUp(): void
    {
        $context = $this->createMock(Context::class);
        $this->coreRegistry = $this->createMock(Registry::class);
        $creditRepositoryFactory = $this->createMock(CreditRepositoryFactory::class);
        $this->creditRepository = $this->createMock(CreditRepository::class);
        $creditFactory = $this->createMock(CreditFactory::class);
        $this->pageFactory = $this->createMock(PageFactory::class);
        $resultFactory = $this->createPartialMock(ResultFactory::class, ['create']);
        $this->messageManager = $this->createMock(ManagerInterface::class);
        $this->resultRedirect = $this->createMock(Redirect::class);
        $this->request = $this->createMock(RequestInterface::class);
        $this->credit = $this->createMock(Credit::class);
        $this->creditId = 1;

        $context->method('getRequest')->willReturn($this->request);
        $context->method('getMessageManager')->willReturn($this->messageManager);
        $context->method('getResultFactory')->willReturn($resultFactory);
        $creditRepositoryFactory->method('create')->willReturn($this->creditRepository);
        $creditFactory->method('create')->willReturn($this->credit);
        $resultFactory->method('create')->willReturn($this->resultRedirect);

        $this->editController = new Edit(
            $context,
            $this->coreRegistry,
            $creditRepositoryFactory,
            $creditFactory,
            $this->pageFactory);
    }

    /** @test  */
    public function testExecuteWithValidCreditId(): void
    {
        $this->request->method('getParam')->willReturn($this->creditId);
        $this->creditRepository->method('getById')->willReturn($this->credit);

        $this->coreRegistry->expects($this->once())
            ->method('register')
            ->with('credit_form', $this->credit);
        $result = $this->createMock(Page::class);
        $this->pageFactory->expects($this->once())
            ->method('create')
            ->willReturn($result);

        $getConfig = $this->createMock(Config::class);
        $result->method('getConfig')->willReturn($getConfig);
        $getTitle = $this->createMock(Title::class);
        $getConfig->method('getTitle')->willReturn($getTitle);
        $getTitle->method('prepend')->willReturnSelf();

        $this->assertEquals($result, $this->editController->execute());
    }

    /** @test  */
    public function testExecuteWithInvalidCreditId(): void
    {
        $this->request->method('getParam')->willReturn($this->creditId);
        $this->creditRepository->method('getById')->willThrowException(new NoSuchEntityException());
        $this->messageManager->method('addError')
            ->with(__('This item no longer exists.'))
            ->willReturnSelf();
        $this->resultRedirect->method('setPath')
            ->with('*/*/')
            ->willReturnSelf();

        $this->assertEquals($this->resultRedirect, $this->editController->execute());
    }
}
