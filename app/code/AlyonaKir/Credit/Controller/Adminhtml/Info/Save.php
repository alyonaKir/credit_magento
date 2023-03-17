<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Controller\Adminhtml\Info;

use Magento\Backend\App\Action\Context;
use AlyonaKir\Credit\Model\Credit\Credit;
use AlyonaKir\Credit\Model\Credit\CreditFactory;
use AlyonaKir\Credit\Model\Credit\CreditRepository;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action;

class Save extends Action
{
    protected $resultRedirectFactory;

    protected DateTime $date;

    protected CreditFactory $creditFactory;
    protected CreditRepository $creditRepository;

    public function __construct(
        Context          $context,
        DateTime         $date,
        CreditFactory    $creditFactory,
        CreditRepository $creditRepository
    )
    {
        $this->date = $date;
        $this->creditFactory = $creditFactory;
        $this->creditRepository = $creditRepository;
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
            $date = $this->date->gmtDate();
            $credit = $this->creditFactory->create();
            $filepath = $this->creditRepository->getById((int)$id)->getFile();
            $user_id = $this->creditRepository->getById((int)$id)->getUserId();

            $postdata = [
                'credit_limit' => $data['credit_fieldset']['credit_limit'],
                'lock_credit_limit' => $data['credit_fieldset']['lock_credit_limit'],
                'credit_available' => $data['credit_fieldset']['credit_available'],
                'purchase_status' => $data['credit_fieldset']['purchase_status'],
                'date_of_response' => $data['credit_fieldset']['date_of_response'],
                'allowable_purchase_time' => $data['credit_fieldset']['allowable_purchase_time'],
                'reason' => $data['credit_fieldset']['reason'],
                'file' => $filepath,
                'updated_at' => $date,
                'user_id' => $user_id
            ];
            $credit->setData($postdata);
            $this->creditRepository->save($credit);
            $this->messageManager->addSuccessMessage(__('The Applicant has been saved.'));

        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Try again.'));
            return $resultRedirect->setPath('*/*/edit');
        }
        if ($this->getRequest()->getParam('back')) {
            $this->messageManager->addSuccessMessage(__('The Applicant has been saved.'));
            return $resultRedirect->setPath('*/*/edit', ['credit_id' => $id, '_current' => true]);
        }
        return $resultRedirect->setPath('*/*/index');
    }

}
