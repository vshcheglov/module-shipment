<?php

/**
 * @author Mygento Team
 * @copyright 2016-2019 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model;

class Carrier
{
    /**
     * @var \Mygento\Shipment\Helper\Data $helper
     */
    private $helper;

    /**
     * @var \Magento\Shipping\Model\Rate\ResultFactory
     */
    private $rateResultFactory;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    private $checkoutSession;

    /**
     * @var \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory
     */
    private $rateMethodFactory;

    /**
     * @param \Mygento\Shipment\Helper\Data $helper
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory
     * @param \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
     */
    public function __construct(
        \Mygento\Shipment\Helper\Data $helper,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
    ) {
        $this->helper = $helper;
        $this->rateResultFactory = $rateResultFactory;
        $this->rateMethodFactory = $rateMethodFactory;
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * @return \Magento\Quote\Model\Quote\Address\RateResult
     */
    public function getResult()
    {
        return $this->rateResultFactory->create();
    }

    /**
     *
     * @return \Magento\Quote\Model\Quote\Address\RateResult\Method
     */
    public function getRateMethod()
    {
        return $this->rateMethodFactory->create();
    }

    /**
     * @return float
     */
    public function getCartTotal()
    {
        $quote = $this->helper->getCurrentQuote();
        $totals = $quote->getTotals();
        $subtotal = $totals['subtotal']->getValue();
        if (isset($totals['discount'])) {
            $subtotal = $subtotal + $totals['discount']->getValue();
        }
        return $subtotal;
    }
}
