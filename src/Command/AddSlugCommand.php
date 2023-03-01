<?php

namespace App\Command;

use App\Entity\Product;
use Doctrine\DBAL\Driver\IBMDB2\Exception\Factory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\Tbint;

#[AsCommand(
    name: 'add:slug',
)]
class AddSlugCommand extends Command{

    public EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
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

        $products = $this->entityManager->getRepository(Product::class)->findAll();

        foreach ($products as $product){
            $product->setSlug($product->getName());
        }
        $this->entityManager->flush();
        return Command::SUCCESS;
    }
}
