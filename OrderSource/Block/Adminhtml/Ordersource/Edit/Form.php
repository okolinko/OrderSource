<?php

namespace Toppik\OrderSource\Block\Adminhtml\Ordersource\Edit;

use \Magento\Backend\Block\Widget\Form\Generic;

class Form extends Generic
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Init form
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('ordersource_form');
        $this->setTitle(__('Order Source Information'));
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('order_source');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );

        $form->setHtmlIdPrefix('ordersource_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General Information'), 'class' => 'fieldset-wide']
        );

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }

        $fieldset->addField(
            'label',
            'text',
            ['name' => 'label', 'label' => __('Label'), 'title' => __('Label'), 'required' => true]
        );

        $fieldset->addField(
            'value',
            'text',
            ['name' => 'value', 'label' => __('Value'), 'title' => __('Value'), 'required' => true]
        );

        $fieldset1 = $form->addFieldset(
            'defaults_fieldset',
            ['legend' => __('Defaults'), 'class' => 'fieldset-wide']
        );

        $fieldset1->addField(
            'default_autoship',
            'select',
            ['name' => 'default_autoship', 'label' => __('Default Autoship'), 'title' => __('Default Autoship'), 'values' => [0 => 'No',  1 => 'Yes'],  'required' => true]
        );

        $fieldset1->addField(
            'default_autoship_first_web',
            'select',
            ['name' => 'default_autoship_first_web', 'label' => __('Default Autoship (First Web Order)'), 'title' => __('Default Autoship (First Web Order)'), 'values' => [0 => 'No',  1 => 'Yes'],  'required' => true]
        );

        $fieldset1->addField(
            'default_autoship_first_cs',
            'select',
            ['name' => 'default_autoship_first_cs', 'label' => __('Default Autoship (First CS Order)'), 'title' => __('Default Autoship (First CS Order)'), 'values' => [0 => 'No',  1 => 'Yes'],  'required' => true]
        );

        $fieldset1->addField(
            'default_web',
            'select',
            ['name' => 'default_web', 'label' => __('Default Web'), 'title' => __('Default Web'), 'values' => [0 => 'No',  1 => 'Yes'],  'required' => true]
        );

        $fieldset1->addField(
            'default_cs',
            'select',
            ['name' => 'default_cs', 'label' => __('Default CS'), 'title' => __('Default CS'), 'values' => [0 => 'No',  1 => 'Yes'],  'required' => true]
        );

        $fieldset1->addField(
            'default_borderfree',
            'select',
            ['name' => 'default_borderfree', 'label' => __('Default Borderfree'), 'title' => __('Default Borderfree'), 'values' => [0 => 'No',  1 => 'Yes'],  'required' => true]
        );

        $fieldset1->addField(
            'default_free',
            'select',
            ['name' => 'default_free', 'label' => __('Default Free'), 'title' => __('Default Free'), 'values' => [0 => 'No',  1 => 'Yes'],  'required' => true]
        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}