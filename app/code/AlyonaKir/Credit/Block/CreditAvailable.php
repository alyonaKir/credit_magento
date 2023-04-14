<?php

namespace AlyonaKir\Credit\Block;

use AlyonaKir\Credit\Block\Form\ApplyForCredit;
use AlyonaKir\Credit\Model\Config\Source\PurchaseStatus;
use AlyonaKir\Credit\Model\Credit\Credit;
use AlyonaKir\Credit\Model\Credit\CreditRepositoryFactory;
use AlyonaKir\Credit\Model\Application\ApplicationRepositoryFactory;
use Magento\Framework\View\Element\Template;

class CreditAvailable extends ApplyForCredit
{
    protected CreditRepositoryFactory $creditRepositoryFactory;
    protected ApplicationRepositoryFactory $applicationRepositoryFactory;

    public function __construct(
        CreditRepositoryFactory      $creditRepositoryFactory,
        ApplicationRepositoryFactory $applicationRepositoryFactory,
        PurchaseStatus               $purchaseStatus,
        Credit                       $object,
        Template\Context             $context,
        array                        $data = []
    )
    {
        $this->applicationRepositoryFactory = $applicationRepositoryFactory;
        $this->creditRepositoryFactory = $creditRepositoryFactory;
        parent::__construct($creditRepositoryFactory, $purchaseStatus, $applicationRepositoryFactory, $object, $context, $data);
    }

    public function toHtml(): string
    {
        return $this->getStatus() == 2 ? parent::toHtml() : 'No information';
    }

    public function getAllCreditInfo()
    {
        $userId = $_SESSION['customer_base']['customer_id'];
        $applicationRepository = $this->applicationRepositoryFactory->create();
        $creditRepository = $this->creditRepositoryFactory->create();
        $credits = $creditRepository->getList();
        foreach ($credits as $credit) {
            $application = $applicationRepository->getById($credit->getApplicationId());
            if( $application->getCustomerId() == $userId && $credit->getPurchaseStatus() == 2)
                return $credit;
        }
        return null;
    }
}
