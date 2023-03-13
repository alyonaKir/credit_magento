<?php

namespace AlyonaKir\Credit\Controller\Adminhtml\Info;

use Magento\Backend\App\Action\Context;
use AlyonaKir\Credit\Model\Credit\Credit;
use AlyonaKir\Credit\Model\Credit\CreditFactory;
use AlyonaKir\Credit\Model\Credit\CreditRepository;

class Save extends \Magento\Backend\App\Action
{
    protected $request;
    protected $resultRedirectFactory;

    protected $date;
    protected $_publicActions;
    protected $creditFactory;
    protected $creditRepository;

    public function __construct(
        Context                                     $context,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Backend\Model\UrlInterface         $urlBuilder,
        CreditFactory                               $creditFactory,
        CreditRepository                            $creditRepository
    )
    {
        $this->date = $date;
        $this->urlBuilder = $urlBuilder;
        $this->creditFactory = $creditFactory;
        $this->creditRepository = $creditRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $_publicActions = ['save'];
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

            $postdata = [
                'credit_limit' => $data['credit_fieldset']['credit_limit'],
                'lock_credit_limit' => $data['credit_fieldset']['lock_credit_limit'],
                'credit_available' => $data['credit_fieldset']['credit_available'],
                'purchase_status' => $data['credit_fieldset']['purchase_status'],
                'date_of_response' => $data['credit_fieldset']['date_of_response'],
                'allowable_purchase_time' => $data['credit_fieldset']['allowable_purchase_time'],
                'reason' => $data['credit_fieldset']['reason'],
                'file' => $filepath,
                'updated_at' => $date
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
