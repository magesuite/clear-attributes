<?php

namespace MageSuite\ClearAttributes\Console\Command;

class ClearAttributes extends \Symfony\Component\Console\Command\Command
{
    /**
     * @var \MageSuite\ClearAttributes\Service\TablesFactory
     */
    protected $tablesFactory;

    public function __construct(
        \MageSuite\ClearAttributes\Service\TablesFactory $tablesFactory,
        $name = null
    )
    {
        $this->tablesFactory = $tablesFactory;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('cs:clear:attributes')->setDescription('Print sql queries which remove all leftover attributes data.');
    }

    protected function execute(
        \Symfony\Component\Console\Input\InputInterface $input,
        \Symfony\Component\Console\Output\OutputInterface $output
    )
    {
        /* @var $tablesService \MageSuite\ClearAttributes\Service\Tables */
        $tablesService = $this->tablesFactory->create();
        $tables = $tablesService->getTablesToClear();

        foreach ($tables as $table) {
            $output->writeln($tablesService->getDeleteSql($table));
        }

        return \Magento\Framework\Console\Cli::RETURN_SUCCESS;
    }
}
