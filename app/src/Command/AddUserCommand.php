<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class AddUserCommand extends Command
{
    protected static $defaultName = 'app:add-user';
    protected static $defaultDescription = 'Add a short description for your command';
    private $em;
    private $passwordEncoder;
    
    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
    {
    	parent::__construct();
    	$this->em = $em;
    	$this->passwordEncoder = $passwordEncoder;
    }
    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addArgument('arg2', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');
        $arg2 = $input->getArgument('arg2');
        
        if ( $arg1 AND $arg2 ) {
        	$user = new User(  );
        	$password =$this->passwordEncoder->encodePassword( $user, $arg2 );
        	$user->setEmail( $arg1 );
        	$user->setPassword( $password );
        	$user->setRoles( array( 'ROLE_ADMIN' ) );
        	$user->setCreateAtValue(  );
        	$user->setUpdateAtValue(  );
        	$user->setCreateBy( 0 );
        	$user->setUpdateBy( 0 );
        	$user->setIsActive( 1 );
        	
        	$this->em->persist( $user );
        	$this->em->flush(  );
        	
        	$io->success('User added successfully.');
        	
        	return Command::SUCCESS;
        }
        
        $io->success('User NOT added.');
        
        return Command::FAILURE;
    }
}
