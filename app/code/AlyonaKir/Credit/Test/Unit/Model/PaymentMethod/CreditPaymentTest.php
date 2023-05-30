<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Test\Unit\Model\PaymentMethod;

use AlyonaKir\Credit\Model\Application\ApplicationRepositoryFactory;
use AlyonaKir\Credit\Model\Application\ApplicationRepository;
use AlyonaKir\Credit\Model\Credit\Credit;
use AlyonaKir\Credit\Model\Credit\CreditFactory;
use AlyonaKir\Credit\Model\Credit\CreditRepository;
use AlyonaKir\Credit\Model\Credit\CreditRepositoryFactory;
use AlyonaKir\Credit\Model\PaymentMethod\CreditPayment;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Payment\Helper\Data;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Payment\Model\Method\Logger;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Sales\Model\Order\Payment;
use Magento\Sales\Model\Order;

/** @covers CreditPayment */
class TestCreditPayment extends TestCase
{
    protected CreditPayment $object;
    protected CreditRepository|MockObject $creditRepository;
    protected CreditFactory|MockObject $creditFactory;
    protected ApplicationRepository|MockObject $applicationRepository;
    protected Payment|MockObject $paymentMock;
    protected Order|MockObject $orderMock;


    protected function setUp(): void
    {

        $this->paymentMock = $this->getMockBuilder(Payment::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->orderMock = $this->getMockBuilder(Order::class)
            ->disableOriginalConstructor()
            ->getMock();
        $creditRepositoryFactory = $this->createPartialMock(
            CreditRepositoryFactory::class,
            ['create']
        );

        $this->creditRepository = $this->getMockBuilder(CreditRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $creditRepositoryFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->creditRepository);

        $applicationRepositoryFactory = $this->createPartialMock(
            ApplicationRepositoryFactory::class,
            ['create']
        );
        $this->applicationRepository = $this->getMockBuilder(ApplicationRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $applicationRepositoryFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->applicationRepository);


        $this->creditFactory = $this->createPartialMock(
            CreditFactory::class,
            ['create']
        );

        $messageManager = $this->getMockBuilder(ManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $context = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();

        $registry = $this->getMockBuilder(Registry::class)
            ->disableOriginalConstructor()
            ->getMock();

        $extensionFactory = $this->createPartialMock(
            ExtensionAttributesFactory::class,
            ['create']
        );

        $customAttributeFactory = $this->createPartialMock(
            AttributeValueFactory::class,
            ['create']
        );

        $data = $this->getMockBuilder(Data::class)
            ->disableOriginalConstructor()
            ->getMock();

        $scopeConfig = $this->getMockForAbstractClass(ScopeConfigInterface::class);
        $logger = $this->getMockBuilder(Logger::class)
            ->disableOriginalConstructor()
            ->getMock();

        $resource = $this->getMockBuilder(AbstractResource::class)
            ->disableOriginalConstructor()
            ->getMock();

        $resourceCollection = $this->getMockBuilder(AbstractDb::class)
            ->disableOriginalConstructor()
            ->getMock();

        $directory = $this->getMockBuilder(DirectoryHelper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->object = new CreditPayment(
            $creditRepositoryFactory,
            $applicationRepositoryFactory,
            $this->creditFactory,
            $messageManager,
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $data,
            $scopeConfig,
            $logger,
            $resource,
            $resourceCollection,
            [],
            $directory
        );
    }

    /** @test */
    public function testCanUseCheckout()
    {
        $credit = $this->getMockBuilder(Credit::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->creditFactory->expects($this->any())
            ->method('create')
            ->willReturn($credit);

        $this->creditRepository->expects($this->any())
            ->method('getByApplicationId')
            ->willReturn($credit);

        $credit->setPurchaseStatus(1);

        $this->assertEquals(false, $this->object->canUseCheckout());
    }

    /** @test */
    public function testGetInstructions()
    {
        $credit = $this->getMockBuilder(Credit::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->creditFactory->expects($this->any())
            ->method('create')
            ->willReturn($credit);

        $this->creditRepository->expects($this->any())
            ->method('getByApplicationId')
            ->willReturn($credit);

        $this->assertEquals("Your available sum: 0$", $this->object->getInstructions());
    }

    /** @test */
    public function testValidateThrowsExceptionWhenNotEnoughCreditAvailable()
    {

        $this->orderMock->expects($this->once())
            ->method('getGrandTotal')
            ->willReturn(100.0);
        $this->paymentMock->expects($this->once())
            ->method('getOrder')
            ->willReturn($this->orderMock);

        $creditMock = $this->createMock(Credit::class);
        $creditMock->expects($this->once())
            ->method('getCreditAvailable')
            ->willReturn(50.0);
        $this->creditRepository->expects($this->any())
            ->method('getByApplicationId')
            ->willReturn($creditMock);

        $this->object->setInfoInstance($this->paymentMock);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Dont have enough money.");

        $this->object->validate();
    }

    /** @test */
    public function testValidateDeductsCreditAvailableWhenEnoughCreditAvailable()
    {
        $this->orderMock->expects($this->any())
            ->method('getGrandTotal')
            ->willReturn(100.0);

        $this->paymentMock->expects($this->any())
            ->method('getOrder')
            ->willReturn($this->orderMock);

        $creditMock = $this->createMock(Credit::class);
        $creditMock->expects($this->any())
            ->method('getCreditAvailable')
            ->willReturn(150.0);
        $this->creditRepository->expects($this->any())
            ->method('getByApplicationId')
            ->willReturn($creditMock);

        $this->object->setInfoInstance($this->paymentMock);

        $this->object->validate();

        // Verify that credit available has been reduced by order grand total
        $creditMock->expects($this->once())
            ->method('setCreditAvailable')
            ->with(50.0);
        $this->creditRepository->expects($this->once())
            ->method('save')
            ->with($creditMock);

        $this->object->validate();
    }
}
