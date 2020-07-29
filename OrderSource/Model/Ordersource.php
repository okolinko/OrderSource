<?php

namespace Toppik\OrderSource\Model;

use Magento\Framework\Exception\LocalizedException as CoreException;

class Ordersource extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Toppik\OrderSource\Model\ResourceModel\Ordersource');
    }

    public function getDefaultAutoship() {

        return $this->load(1, 'default_autoship')->getLabel();

    }

    public function getDefaultAutoshipFirstWeb() {
        return $this->load(1, 'default_autoship_first_web')->getLabel();
    }

    public function getDefaultAutoshipFirstCs() {
        return $this->load(1, 'default_autoship_first_cs')->getLabel();
    }

    public function getDefaultWeb() {
        return $this->load(1, 'default_web')->getLabel();
    }

    public function getDefaultCs() {
        return $this->load(1, 'default_cs')->getLabel();
    }

    public function getDefaultBorderfree() {
        return $this->load(1, 'default_borderfree')->getLabel();
    }

    public function getDefaultFree() {
        return $this->load(1, 'default_free')->getLabel();
    }
}