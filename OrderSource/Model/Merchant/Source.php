<?php
namespace Toppik\OrderSource\Model\Merchant;

class Source {
	
    /**
     * Option values
     */
	CONST SOURCE_0 = 'VXPROHAIR';
	CONST SOURCE_1 = 'oralcare.com';
    
	protected $_options;
	
    /**
     * Retrieve default source
     *
     * @return string
     */
    public function getDefaultSource() {
		return self::SOURCE_0;
    }
	
    /**
     * Retrieve source by order
     *
     * @return string
     */
    public function getSourceByOrder($order = null) {
		$merchantSource = $this->getDefaultSource();
		
		if($order && $order->getPreconfiguredMerchantSource() && !empty($order->getPreconfiguredMerchantSource())) {
			$merchantSource = $order->getPreconfiguredMerchantSource();
		}
                else if($order->getStoreId() === 2) {
                    $merchantSource = self::SOURCE_1;
                }

		
		return $merchantSource;
    }
	
    /**
     * Retrieve all options array
     *
     * @return array
     */
    public function getAllOptions() {
        if($this->_options === null) {
            $this->_options = [
                ['label' => self::SOURCE_0, 'value' => self::SOURCE_0],
                ['label' => self::SOURCE_1, 'value' => self::SOURCE_1]
            ];
        }
		
        return $this->_options;
    }
	
    /**
     * Retrieve label
     *
     * @return string|null
     */
    public function getLabelByValue($value = null) {
		$label = null;
		
        foreach($this->getAllOptions() as $option) {
			if((int) $option['value'] === (int) $value) {
				$label = $option['label'];
			}
        }
		
		return $label;
    }
	
    /**
     * Retrieve option array
     *
     * @return array
     */
    public function getOptionArray() {
        $_options = [];
		
        foreach($this->getAllOptions() as $option) {
            $_options[$option['value']] = $option['label'];
        }
		
        return $_options;
    }
	
}
