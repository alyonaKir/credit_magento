<?php
declare(strict_types=1);
namespace AlyonaKir\Credit\Test\Unit\Block;

use AlyonaKir\Credit\Block\CreditAvailable;
use AlyonaKir\Credit\Model\Config\Source\PurchaseStatus;
use AlyonaKir\Credit\Model\Credit\Credit;
use AlyonaKir\Credit\Model\Credit\CreditRepositoryFactory;
use AlyonaKir\Credit\Model\Application\ApplicationRepositoryFactory;
use Magento\Framework\View\Element\Template\Context;
use PHPUnit\Framework\TestCase;

/** @covers CreditAvailable */
class TestCreditAvailable extends TestCase
{
    protected $objectManager;
    protected $creditRepositoryFactoryMock;
    protected $creditRepositoryMock;
    protected $applicationRepositoryFactoryMock;
    protected $purchaseStatusMock;
    protected $creditMock;
    protected $contextMock;
    protected $dataMock;
    protected $creditAvailable;

    protected function setUp(): void
    {
        $_SESSION['customer_base']['customer_id'] = 1;
        $applicationId = 2;
        $this->creditRepositoryFactoryMock = $this->getMockBuilder(CreditRepositoryFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->applicationRepositoryFactoryMock = $this->getMockBuilder(ApplicationRepositoryFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->purchaseStatusMock = $this->getMockBuilder(PurchaseStatus::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->creditMock = $this->getMockBuilder(Credit::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->contextMock = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->dataMock = $this->getMockBuilder(\Magento\Framework\DataObject::class)
            ->disableOriginalConstructor()
            ->getMock();

        $creditMock = $this->getMockBuilder(Credit::class)
            ->disableOriginalConstructor()
            ->getMock();

        $creditMock->expects($this->once())
            ->method('getApplicationId')
            ->willReturn($applicationId);


        $this->applicationRepositoryFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->createMock(\AlyonaKir\Credit\Model\Application\ApplicationRepository::class));

        $applicationRepositoryMock = $this->createMock(\AlyonaKir\Credit\Model\Application\ApplicationRepository::class);
        $this->applicationRepositoryFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($applicationRepositoryMock);


        $this->creditRepositoryMock = $this->createMock(\AlyonaKir\Credit\Model\Credit\CreditRepository::class);
        $this->creditRepositoryFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->creditRepositoryMock);

        $this->creditRepositoryMock->method('getList')
            ->willReturn([$creditMock]);

        $this->creditAvailable = new CreditAvailable(
            $this->creditRepositoryFactoryMock,
            $this->applicationRepositoryFactoryMock,
            $this->purchaseStatusMock,
            $this->creditMock,
            $this->contextMock,
            array()
        );
    }

    /** @test */
    public function testGetAllCreditInfo()
    {
        $credit = $this->creditAvailable->getAllCreditInfo();
        $this->assertNull($credit);
    }

    /** @test */
    public function testToHtml()
    {
        $expectedOutput = '<div>Apply for credit form</div>';
        $this->assertNotEquals($expectedOutput, $this->creditAvailable->toHtml());
    }
}
