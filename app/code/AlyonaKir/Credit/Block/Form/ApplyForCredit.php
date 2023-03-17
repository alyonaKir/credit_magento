<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Block\Form;

use AlyonaKir\Credit\Api\Data\CreditInterface;
use AlyonaKir\Credit\Model\Credit\Credit;
use Magento\Framework\View\Element\Template;
use AlyonaKir\Credit\Model\Credit\CreditRepositoryFactory;
use AlyonaKir\Credit\Model\Config\Source\PurchaseStatus;

class ApplyForCredit extends Template
{
    protected CreditRepositoryFactory $creditRepositoryFactory;
    protected PurchaseStatus $purchaseStatus;

    protected Credit $object;

    public function __construct(
        CreditRepositoryFactory $creditRepositoryFactory,
        PurchaseStatus          $purchaseStatus,
        Credit                  $object,
        Template\Context        $context,
        array                   $data = []
    )
    {
        $this->object = $object;
        $this->purchaseStatus = $purchaseStatus;
        $this->creditRepositoryFactory = $creditRepositoryFactory;
        parent::__construct($context, $data);
    }

    public function getStatus(): int
    {
        $userId = $_SESSION['customer_base']['customer_id'];
        $creditRepository = $this->creditRepositoryFactory->create();
        $credits = $creditRepository->getList();
        foreach ($credits as $credit) {
            if ($credit->getUserId() == $userId && $credit->getPurchaseStatus() != 4)
            return (int)$credit->getPurchaseStatus();
        }
        return -1;
    }

    public function getStatusFromOptionsArray(int $i): string
    {
        $options = $this->purchaseStatus->toOptionArray();
        return $options[$i]['label'];
    }

    public function statusDescribe(int $i): string
    {
        return match ($i) {
            0 => 'Please wait for our decision.',
            1 => 'Now we are checking your application.',
            2 => 'Congratulates. Below you\'ll find all information about your credit.',
            3 => 'Below you\'ll find a reason.'
        };
    }

    public function getAllCreditInfo()
    {
        $userId = $_SESSION['customer_base']['customer_id'];
        $creditRepository = $this->creditRepositoryFactory->create();
        $credits = $creditRepository->getList();
        foreach ($credits as $credit) {
            if ($credit->getUserId() == $userId && $credit->getPurchaseStatus() == 2)
                return $credit;
        }
        return null;
    }
}
