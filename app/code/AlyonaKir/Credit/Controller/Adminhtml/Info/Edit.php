<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Controller\Adminhtml\Info;

use Magento\Backend\App\Action\Context;
use AlyonaKir\Credit\Model\Credit\CreditFactory;
use Magento\Framework\Registry;

class Edit extends \Magento\Backend\App\Action
{
    protected $_coreRegistry = null;
    protected $_publicActions = ['edit'];

    private CreditFactory $creditFactory;

    public function __construct(
        Context       $context,
        Registry      $coreRegistry,
        CreditFactory $creditFactory
    )
    {
        $this->_coreRegistry = $coreRegistry;
        $this->creditFactory = $creditFactory;
        parent::__construct($context);
    }

    public function execute(): void
    {
        $_publicActions = ['edit'];
        $FromModel = $this->_objectManager->create('AlyonaKir\Credit\Model\Credit\Credit');

        $FormId = $this->getRequest()->getParam('id');
        if ($FormId) {
            $FromModel->load($FormId);
        }

        $this->_coreRegistry->register('credit_form', $FromModel);
        $this->_view->loadLayout();
        $this->_setActiveMenu('AlyonaKir_Credit::module');

        if ($FromModel) {
            $breadcrumbTitle = __('Edit Form');
            $breadcrumbLabel = __('Edit Form');
        } else {
            $breadcrumbTitle = __('New Form');
            $breadcrumbLabel = __('New Form');
        }

        $this->_view->getPage()->getConfig()->getTitle()->prepend($FromModel->getId() ? __('Edit Form') : __('New Form'));
//        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Edit Form'));
        $this->_addBreadcrumb($breadcrumbLabel, $breadcrumbTitle);

        // restore data
        $values = $this->_getSession()->getData('credit_form', true);
        if ($values) {
            $FromModel->addData($values);
        }

        $this->_session->start();
        $_SESSION['id'] = $FormId;
        $this->_view->renderLayout();
    }
}
