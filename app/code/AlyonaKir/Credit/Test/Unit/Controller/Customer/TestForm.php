<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Test\Unit\Controller\Customer;

use AlyonaKir\Credit\Controller\Customer\Form;
use AlyonaKir\Credit\Model\Application\ApplicationFactory;
use AlyonaKir\Credit\Model\Application\ApplicationRepository;
use AlyonaKir\Credit\Model\Application\ApplicationRepositoryFactory;
use AlyonaKir\Credit\Model\Credit\Credit;
use AlyonaKir\Credit\Model\Credit\CreditFactory;
use AlyonaKir\Credit\Model\Credit\CreditRepository;
use AlyonaKir\Credit\Model\Credit\CreditRepositoryFactory;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Result\PageFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Magento\Framework\View\Result\Page;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Action\Context;


/** @covers Form */
class TestForm extends TestCase
{
    private Form|MockObject $formController;
    private PageFactory|MockObject $_pageFactory;
    private ApplicationFactory|MockObject $applicationFactory;
    private ApplicationRepositoryFactory|MockObject $applicationRepositoryFactory;
    private CreditFactory|MockObject $creditFactory;
    private CreditRepositoryFactory|MockObject $creditRepositoryFactory;
    private File|MockObject $file;
    private DirectoryList|MockObject $dir;
    private ManagerInterface|MockObject $messageManager;

    protected function setUp(): void
    {
        $context = $this->createMock(Context::class);
        $this->_pageFactory = $this->createPartialMock(PageFactory::class, ['create']);
        $page = $this->createMock(Page::class);
        $this->_pageFactory->method('create')
            ->willReturn($page);
        $this->creditFactory = $this->createPartialMock(CreditFactory::class, ['create']);
        $credit = $this->createMock(Credit::class);
        $this->creditFactory->method('create')
            ->willReturn($credit);
        $this->creditRepositoryFactory = $this->createPartialMock(CreditRepositoryFactory::class, ['create']);
        $creditRepository = $this->createMock(CreditRepository::class);
        $this->creditRepositoryFactory->method('create')
            ->willReturn($creditRepository);
        $this->applicationFactory = $this->createPartialMock(ApplicationFactory::class, ['create']);
        $application = $this->createMock(Credit::class);
        $this->applicationFactory->method('create')
            ->willReturn($application);
        $this->applicationRepositoryFactory = $this->createPartialMock(ApplicationRepositoryFactory::class, ['create']);
        $applicationRepository = $this->createMock(ApplicationRepository::class);
        $this->applicationRepositoryFactory->method('create')
            ->willReturn($applicationRepository);
        $this->messageManager = $this->createMock(ManagerInterface::class);
        $this->file = $this->createMock(File::class);
        $this->dir = $this->createMock(DirectoryList::class);

        $this->formController = new Form(
            $context,
            $this->_pageFactory,
            $this->creditFactory,
            $this->creditRepositoryFactory,
            $this->applicationFactory,
            $this->applicationRepositoryFactory,
            $this->messageManager,
            $this->file,
            $this->dir
        );

    }

    /** @test */
    public function testExecute()
    {
        $result = $this->formController->execute();
        $this->assertInstanceOf(Page::class, $result);
    }

}
