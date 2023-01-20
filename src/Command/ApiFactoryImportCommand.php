<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\FactoryPrice;


#[AsCommand(
    name: 'factory:import',
    description: 'Add a short description for your command',
)]
class ApiFactoryImportCommand extends Command
{
    public $factoryPrice;

    public function __construct(FactoryPrice $factoryPrice)
    {
        parent::__construct();

        $this->factoryPrice = $factoryPrice;
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
        $this->factoryPrice->readFile();
        $this->factoryPrice->importProducts();
        return Command::SUCCESS;
    }
}
