<?php

namespace AlyonaKir\Credit\Controller\Adminhtml\Info;

class Index extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('AlyonaKir_Credit::module');
        $resultPage->getConfig()->getTitle()->prepend((__('Credit info')));
        $_SESSION['id'] = null;
        return $resultPage;
    }
}
