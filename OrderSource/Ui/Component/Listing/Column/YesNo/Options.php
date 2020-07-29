<?php
namespace Toppik\OrderSource\Ui\Component\Listing\Column\YesNo;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Options
 */
class Options implements OptionSourceInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options === null) {
            $this->options = [
                [
                    'value' => 1,
                    'label' => __('Yes'),
                ],
                [
                    'value' => 0,
                    'label' => __('No'),
                ]
            ];
        }
        return $this->options;
    }
}
