<?php

declare(strict_types=1);

namespace AlyonaKir\Credit\Test\Unit\Block\Form;

use AlyonaKir\Credit\Block\Form\ApplyForCredit;
use AlyonaKir\Credit\Model\Application\ApplicationRepository;
use AlyonaKir\Credit\Model\Credit\Credit;
use AlyonaKir\Credit\Model\Credit\CreditRepository;
use AlyonaKir\Credit\Model\Config\Source\PurchaseStatus;
use AlyonaKir\Credit\Model\Application\ApplicationRepositoryFactory;
use AlyonaKir\Credit\Model\Credit\CreditRepositoryFactory;
use Magento\Framework\View\Element\Template\Context;
use PHPUnit\Framework\TestCase;

/** @covers ApplyForCredit */
class TestApplyForCredit extends TestCase
{
    protected ApplyForCredit $block;
    protected CreditRepositoryFactory $creditRepositoryFactory;
    protected ApplicationRepositoryFactory $applicationRepositoryFactory;
    protected CreditRepository $creditRepository;
    protected ApplicationRepository $applicationRepository;

    protected function setUp(): void
    {
        $this->creditRepository = $this->createMock(CreditRepository::class);
        $this->applicationRepository = $this->createMock(ApplicationRepository::class);
        $this->creditRepositoryFactory = $this->createMock(CreditRepositoryFactory::class);
        $this->creditRepositoryFactory->method('create')
            ->willReturn($this->creditRepository);

        $this->applicationRepositoryFactory = $this->createMock(ApplicationRepositoryFactory::class);
        $this->applicationRepositoryFactory->method('create')
            ->willReturn($this->applicationRepository);


        $context = $this->createMock(Context::class);
        $credit = $this->createMock(Credit::class);
        $data = [];
        $_SESSION['customer_base']['customer_id'] = 123;

        $this->block = new ApplyForCredit(
            $this->creditRepositoryFactory,
            new PurchaseStatus(),
            $this->applicationRepositoryFactory,
            $credit,
            $context,
            $data
        );
    }

    /** @test  */
    public function testGetStatus(): void
    {
        $userId = 123;
        $credit = $this->createMock(Credit::class);
        $credit->method('getApplicationId')
            ->willReturn(1);
        $credit->method('getPurchaseStatus')
            ->willReturn(4);

        $application = $this->createMock(\AlyonaKir\Credit\Model\Application\Application::class);
        $application->expects($this->once())
            ->method('getCustomerId')
            ->willReturn($userId);

        $this->creditRepository->expects($this->once())
            ->method('getList')
            ->willReturn([$credit]);

        $this->applicationRepository->expects($this->once())
            ->method('getById')
            ->with($credit->getApplicationId())
            ->willReturn($application);

        $status = $this->block->getStatus();

        $this->assertSame(null, $status);
    }

    /** @test */
    public function testGetStatusReturnsNullIfNoCreditFound(): void
    {
        $this->creditRepository->expects($this->once())
            ->method('getList')
            ->willReturn([]);

        $status = $this->block->getStatus();

        $this->assertNull($status);
    }

    /** @test */
    public function testGetStatusReturnsNullIfCreditIsRejected(): void
    {
        $userId = 123;
        $credit = $this->createMock(Credit::class);
        $credit->method('getApplicationId')
            ->willReturn(1);
        $credit->method('getPurchaseStatus')
            ->willReturn(4);

        $application = $this->createMock(\AlyonaKir\Credit\Model\Application\Application::class);
        $application->expects($this->once())
            ->method('getCustomerId')
            ->willReturn($userId);

        $this->creditRepository->expects($this->once())
            ->method('getList')
            ->willReturn([$credit]);

        $this->applicationRepository->expects($this->once())
            ->method('getById')
            ->with($credit->getApplicationId())
            ->willReturn($application);

        $status = $this->block->getStatus();

        $this->assertNull($status);
    }

    /** @test */
    public function testGetStatusFromOptionsArray(): void
    {
        $label = $this->block->getStatusFromOptionsArray(1);

        $this->assertSame('Under Review', $label);
    }

    /** @test */
    public function testStatusDescribe(): void
    {
        $description = $this->block->statusDescribe(2);

        $this->assertSame('Congratulates. Below you\'ll find all information about your credit.', $description);
    }
}
