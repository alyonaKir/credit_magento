<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Test\Unit\Controller\Adminhtml\Info;

use AlyonaKir\Credit\Controller\Adminhtml\Info\Edit;
use AlyonaKir\Credit\Controller\Adminhtml\Info\Save;
use AlyonaKir\Credit\Model\Credit\CreditRepository;
use AlyonaKir\Credit\Model\Credit\CreditRepositoryFactory;
use AlyonaKir\Credit\Model\Mail\TransportBuilder;
use Cassandra\Exception\AlreadyExistsException;
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
use Magento\Framework\Stdlib\DateTime\DateTime;

/** @covers Save */
class TestSave extends TestCase
{
    private Save $saveController;
    private Registry|MockObject $coreRegistry;
    private PageFactory|MockObject $pageFactory;
    private CreditRepository|MockObject $creditRepository;
    private ManagerInterface|MockObject $messageManager;
    private Redirect|MockObject $resultRedirect;
    private RequestInterface|MockObject $request;
    private Credit|MockObject $credit;
    private array $creditInfo;
    private DateTime|MockObject $date;
    private TransportBuilder|MockObject $transportBuilder;

    protected function setUp(): void
    {
        $this->creditInfo = array(
            'key' => 'testkey',
            'credit_fieldset' => array(
                'credit_limit' => 45.0,
                'lock_credit_limit' => 460.0,
                'credit_available' => 100.0,
                'purchase_status' => 0,
                'allowable_purchase_time' => '2024-05-07',
                'reason' => ''
            ),
            'form_key' => 'testkey'
        );
        $this->context = $this->createMock(Context::class);
        $this->date = $this->createMock(DateTime::class);
        $this->creditRepository = $this->createMock(CreditRepository::class);
        $this->transportBuilder = $this->createMock(TransportBuilder::class);
        $this->resultRedirect = $this->createMock(\Magento\Framework\Controller\Result\Redirect::class);
        $this->request = $this->createMock(\Magento\Framework\App\RequestInterface::class);
        $this->messageManager = $this->createMock(\Magento\Framework\Message\ManagerInterface::class);

        $resultRedirectFactory = $this->createPartialMock(\Magento\Framework\Controller\Result\RedirectFactory::class, ['create']);
        $resultRedirectFactory->method('create')
            ->willReturn($this->resultRedirect);

        $this->context->method('getRequest')->willReturn($this->request);
        $this->context->method('getMessageManager')->willReturn($this->messageManager);
        $this->context->method('getResultRedirectFactory')->willReturn($resultRedirectFactory);

        $this->saveController = new Save(
            $this->context,
            $this->date,
            $this->creditRepository,
            $this->transportBuilder
        );
    }

    /** @test  */
    public function testExecuteApplicationHasBeenSaved(): void
    {
        $this->request->method('getParams')->willReturn($this->creditInfo);
        $this->messageManager->method('addSuccessMessage')
            ->with(__('The Applicant has been saved.'))
            ->willReturnSelf();

        $this->request->method('getParam')->with('back')->willReturn(null);

        $this->resultRedirect->method('setPath')
            ->with('*/*/index')
            ->willReturnSelf();

        $this->assertEquals($this->resultRedirect, $this->saveController->execute());
    }

    /** @test */
    public function testExecuteApplicationHasNotBeenSaved(): void
    {
        $this->request->method('getParams')->willReturn(array());
        $this->messageManager->method('addErrorMessage')
            ->with(__('Try again.'))
            ->willReturnSelf();

        $this->request->method('getParam')->with('back')->willReturn(null);

        $this->resultRedirect->method('setPath')
            ->with('*/*/index')
            ->willReturnSelf();

        $this->assertEquals($this->resultRedirect, $this->saveController->execute());
    }

}
