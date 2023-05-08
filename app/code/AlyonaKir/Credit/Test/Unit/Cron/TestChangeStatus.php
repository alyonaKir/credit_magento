<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Test\Unit\Cron;

use AlyonaKir\Credit\Cron\ChangeStatus;
use AlyonaKir\Credit\Model\Credit\CreditRepositoryFactory;
use AlyonaKir\Credit\Model\Credit\CreditRepository;
use AlyonaKir\Credit\Model\Mail\TransportBuilder;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/** @covers ChangeStatus */
class TestChangeStatus extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test  */
    public function testExecute()
    {
        $credits = [
            $this->createCreditMock(1, '2023-05-08', 4, 'Expired allowable purchase time using credit'),
            $this->createCreditMock(2, '2023-05-08', 3, 'Expired allowable purchase time using credit'),
            $this->createCreditMock(3, '2023-05-09', 1, ''),
        ];

        $creditRepositoryMock = $this->createMock(CreditRepository::class);
        $creditRepositoryMock->method('getList')->willReturn($credits);

        $creditRepositoryFactoryMock = $this->createMock(CreditRepositoryFactory::class);
        $creditRepositoryFactoryMock->method('create')->willReturn($creditRepositoryMock);

        $loggerMock = $this->createMock(LoggerInterface::class);
        $transportBuilderMock = $this->createMock(TransportBuilder::class);

        $changeStatus = new ChangeStatus($creditRepositoryFactoryMock, $loggerMock, $transportBuilderMock);
        $changeStatus->execute();
        $date = '2023-05-08';

        foreach ($credits as $credit) {

            if (($credit->getPurchaseStatus() != 4 || $credit->getPurchaseStatus() != 3) && $credit->getAllowablePurchaseTime() == $date) {
                $this->assertEquals('Expired allowable purchase time using credit', $credit->getReason());
            } else {
                $this->assertEquals('', $credit->getReason());
            }
        }
    }

    protected function createCreditMock($id, $allowablePurchaseTime, $purchaseStatus, string $reason)
    {
        $mock = $this->getMockBuilder(\AlyonaKir\Credit\Model\Credit\Credit::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getCreditId', 'getApplicationId', 'getAllowablePurchaseTime', 'getPurchaseStatus', 'setPurchaseStatus', 'setReason', 'getReason'])
            ->getMock();

        $mock->method('getCreditId')->willReturn($id);
        $mock->method('getApplicationId')->willReturn(1);
        $mock->method('getAllowablePurchaseTime')->willReturn($allowablePurchaseTime);
        $mock->method('getPurchaseStatus')->willReturn($purchaseStatus);

        $mock->expects($this->once())->method('getReason')->willReturn($reason);
        return $mock;
    }
}

