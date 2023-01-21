<?php

namespace App\Command;

use Doctrine\DBAL\Driver\IBMDB2\Exception\Factory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\Tbint;

#[AsCommand(
    name: 'tbint:import',
    description: 'Add a short description for your command',
)]
class ApiImportCommand extends Command
{
    public $tbint;

    public function __construct(Tbint $tbint)
    {
        parent::__construct();
        $this->tbint = $tbint;
    }
    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->tbint->getCSV();
        $this->tbint->importProducts();
        return Command::SUCCESS;
    }
}
