<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use App\Entity\Currency;
use App\Helper\HelperCurrency;
use Doctrine\ORM\EntityManagerInterface;

class LoadRatesCommand extends Command
{
    protected static $defaultName = 'app:load-rates';
    protected static $defaultDescription = 'Add a short description for your command';
    private $em;
    
    public function __construct(EntityManagerInterface $em)
    {
    	parent::__construct();
    	$this->em = $em;
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
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }
        
        $currency_rate = HelperCurrency::get_euro_rate(  );
        
        $currency = new Currency(  );
        
        $currency->setEuro( $currency_rate );
        $currency->setCreateAtValue( );
        $currency->setUpdateAtValue( );
        $currency->setIsActive( 1 );
        
        $this->em->persist( $currency );
        $this->em->flush(  );
        
        $io->success('Currency rate loaded.');

        return Command::SUCCESS;
    }
}
