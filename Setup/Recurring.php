<?php

namespace MageSuite\ClearAttributes\Setup;

class Recurring implements \Magento\Framework\Setup\InstallSchemaInterface
{
    /**
     * @var \MageSuite\ClearAttributes\Service\ClearAttributesFactory
     */
    protected $serviceClearFactory;

    public function __construct(
        \MageSuite\ClearAttributes\Service\ClearAttributesFactory $serviceClearFactory
    )
    {
        $this->serviceClearFactory = $serviceClearFactory;
    }

    public function install(
        \Magento\Framework\Setup\SchemaSetupInterface $setup,
        \Magento\Framework\Setup\ModuleContextInterface $context
    )
    {
        /* @var $serviceClear \MageSuite\ClearAttributes\Service\ClearAttributes */
        $serviceClear = $this->serviceClearFactory->create();
        $serviceClear->clear();
    }
}
