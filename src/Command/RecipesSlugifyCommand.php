<?php

namespace App\Command;

use App\Repository\RecipeRepository;
use App\Service\MySlugger;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RecipesSlugifyCommand extends Command
{
    protected static $defaultName = 'RecipesSlugify';
    protected static $defaultDescription = 'Add a short description for your command';

    private $mySlugger;
    private $reciperepository;
    private $entityManager;


    public function __construct(RecipeRepository $reciperepository,MySlugger $mySlugger,ManagerRegistry $doctrine )
    {
        $this->reciperepository = $reciperepository;
        $this->mySlugger = $mySlugger;
        $this->entityManager = $doctrine->getManager();

        parent::__construct();
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

        $io->info('Mise a jour des slugs BDD');
        $recipes = $this->reciperepository->findAll();
        foreach($recipes as $recipe)
        {
            $recipe->setSlug($this->mySlugger->slugify($recipe->getName()));
        }

        $this->entityManager->flush();
        
        $io->success('Slugs mis à jours.');

        return Command::SUCCESS;
    }
}
