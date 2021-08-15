<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;


class AddDefaultMenuCommand extends Command
{
    protected static $defaultName = 'app:add-default-menu';
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
        
        $arr = array(
        		array(  'name' => 'Главная 22', 'link' => 'home', 'order' => 10 ),
        		array(  'name' => 'Калькулятор', 'link' => 'calc', 'order' => 20 ),
        		array(  'name' => 'Переход на сайт', 'link' => 'home', 'order' => 10, 'is_admin' => 1 ),
        		array(  'name' => 'Пользователи', 'link' => 'admin_user', 'order' => 20, 'is_admin' => 1 ),
        		array(  'name' => 'Роли', 'link' => 'admin_role', 'order' => 30, 'is_admin' => 1 ),
        		array(  'name' => 'Меню', 'link' => 'admin_menu', 'order' => 40, 'is_admin' => 1 ),
        		array(  'name' => 'Курсы евро', 'link' => 'admin_currency', 'order' => 50, 'is_admin' => 1 ),
        		array(  'name' => 'Страницы', 'link' => 'admin_page', 'order' => 60, 'is_admin' => 1 )
        );
        
        foreach ( $arr as $unit ) { $is_admin = ( @$unit['is_admin'] ) ? true : false;
        		$menu = new Menu(  );
        		
        		$menu->setName( $unit['name'] );
        		$menu->setLink( $unit['link'] );
        		$menu->setOrderPriority( $unit['order'] );
        		$menu->setIsAdmin( $is_admin );
        		
        		$menu->setParent( 0 );
        		$menu->setCreateAtValue( );
        		$menu->setUpdateAtValue( );
        		$menu->setIsActive( 1 );
        		
        		$this->em->persist( $menu );
        		$this->em->flush(  );
        		
        		unset( $menu );
        }

        $io->success('Menu added succseefully.');

        return Command::SUCCESS;
    }
}
