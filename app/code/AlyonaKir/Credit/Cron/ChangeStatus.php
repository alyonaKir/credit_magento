<?php

namespace AlyonaKir\Credit\Cron;
use Psr\Log\LoggerInterface;
use AlyonaKir\Credit\Model\Credit\CreditRepositoryFactory;
use AlyonaKir\Credit\Model\Credit\CreditRepository;
use AlyonaKir\Credit\Model\Mail\TransportBuilder;
class ChangeStatus
{
    protected LoggerInterface $logger;
    protected CreditRepository $creditRepository;
    protected TransportBuilder $transportBuilder;
    public function __construct(
        CreditRepositoryFactory $creditRepositoryFactory,
        LoggerInterface $logger,
        TransportBuilder $transportBuilder
    )
    {
        $this->logger = $logger;
        $this->transportBuilder = $transportBuilder;
        $this->creditRepository = $creditRepositoryFactory->create();
    }

    public function execute()
    {
        $credits = $this->creditRepository->getList();
        $date = date("Y-m-d", time());

        foreach ($credits as $credit){
            if(($credit->getPurchaseStatus()!= 4 || $credit->getPurchaseStatus()!=3) && $credit->getAllowablePurchaseTime()==$date)
            {
                $credit->setPurchaseStatus(4);
                $credit->setReason("Expired allowable purchase time using credit");
                $this->creditRepository->save($credit);
                $this->transportBuilder->sendEmail($credit->getApplicationId(), $credit->getCreditId());
            }

        }

    }
}
