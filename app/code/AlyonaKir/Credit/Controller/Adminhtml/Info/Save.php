<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Controller\Adminhtml\Info;

use AlyonaKir\Credit\Model\Mail\TransportBuilder;
use Magento\Backend\App\Action\Context;
use AlyonaKir\Credit\Model\Credit\CreditRepository;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Backend\App\Action;

class Save extends Action
{
    protected $resultRedirectFactory;

    protected DateTime $date;
    private TransportBuilder $transportBuilder;


    protected CreditRepository $creditRepository;

    public function __construct(
        Context          $context,
        DateTime         $date,
        CreditRepository $creditRepository,
        TransportBuilder $transportBuilder
    )
    {
        $this->date = $date;
        $this->creditRepository = $creditRepository;
        $this->transportBuilder = $transportBuilder;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        $id = "";
        try {
            if (isset($_SESSION['id']) && $_SESSION['id'] != null) {
                $id = $_SESSION['id'];
            }
            $date = $this->date->gmtDate("Y-m-d",'+1 day');

            $credit = $this->creditRepository->getById((int)$id);
            $prevStatus = $credit->getPurchaseStatus();

            $credit->setCreditLimit((int)$data['credit_fieldset']['credit_limit']);
            $credit->setLockCreditLimit((int)$data['credit_fieldset']['lock_credit_limit']);
            $credit->setCreditAvailable((int)$data['credit_fieldset']['credit_available']);
            $credit->setPurchaseStatus((int)$data['credit_fieldset']['purchase_status']);
            $credit->setDateOfResponse($date);
            $credit->setAllowablePurchaseTime($data['credit_fieldset']['allowable_purchase_time']==""? $date: $data['credit_fieldset']['allowable_purchase_time']);
            $credit->setReason($data['credit_fieldset']['reason']==""?"No reason":$data['credit_fieldset']['reason']);
            $this->creditRepository->save($credit);
            if($prevStatus!=$credit->getPurchaseStatus()){
                $this->transportBuilder->sendEmail($credit->getApplicationId(), $credit->getCreditId());
            }
            $this->messageManager->addSuccessMessage(__('The Applicant has been saved.'));

        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Try again.'));
            return $resultRedirect->setPath('*/*/index');
        }
        if ($this->getRequest()->getParam('back')) {
            $this->messageManager->addSuccessMessage(__('The Applicant has been saved.'));
            return $resultRedirect->setPath('*/*/index', ['credit_id' => $id, '_current' => true]);
        }
        return $resultRedirect->setPath('*/*/index');
    }

}
