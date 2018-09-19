<?php

namespace MageSuite\ClearAttributes\Service;

class ClearAttributes
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \MageSuite\ClearAttributes\Service\TablesFactory
     */
    protected $tablesServiceFactory;

    public function __construct(
        \MageSuite\ClearAttributes\Service\TablesFactory $tablesServiceFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->tablesServiceFactory = $tablesServiceFactory;
        $this->scopeConfig = $scopeConfig;
    }

    public function clear()
    {
        $clearLeftoversEnabled = $this->scopeConfig->getValue(
            'clear_attributes/clear_attributes_group/enable_clear_attributes',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        if (!$clearLeftoversEnabled) {
            return;
        }

        /* @var $tablesService \MageSuite\ClearAttributes\Service\Tables */
        $tablesService = $this->tablesServiceFactory->create();
        $connection = $tablesService->getConnection();
        $tables = $tablesService->getTablesToClear();

        foreach ($tables as $table) {
            $sql = $tablesService->getDeleteSql($table);
            $connection->query($sql);
        }
    }
}
