<?php

namespace App\Command;



use PDO;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use League\Csv\Reader;
use League\Csv\Statement;


#[AsCommand(
    name: 'app:import-ville-franche-comte',
    description: 'Add a short description for your command',
)]
class commadeImportVilles extends Command
{

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $csv = Reader::createFromPath('document/ville.csv', 'r');
        $csv->setHeaderOffset(0);
        $host = "host=localhost:3306";
        $baseDonnees = "db_fc_tourisme";
        $utilisateur = "root";
        $motPasse = "";
        $pdoConnexion = new PDO("mysql:$host;dbname=$baseDonnees;charset=utf8",$utilisateur,$motPasse);
        $sth = $pdoConnexion->exec("DELETE FROM `ville` ");
        $sth = $pdoConnexion->prepare(
            "INSERT INTO `ville`(`id`, `nom`, `cp`, `nom_dp`, `num_dp`, `nom_r`) VALUES (null,:nom,:cp,:nomDp,:numDp,:nomR)"
        );


        $records = $csv->getRecords();
        foreach ($records as $offset => $record) {
            $tabVille = explode(";", $record["Code postal;Commune;Ancienne commune;Département;Nom département;Région"]);//transforme $record(string) en tableau
            if($tabVille[3] == 25 || $tabVille[3] == 39 || $tabVille[3] == 70   ){ //recup seulement le cp de FC
                //var_export($record); //permet de voir tout le contenu

                $sth->bindValue(':nom', $tabVille[1], PDO::PARAM_STR);
                $sth->bindValue(':cp', $tabVille[0], PDO::PARAM_STR);
                $sth->bindValue(':nomDp', $tabVille[4], PDO::PARAM_STR);
                $sth->bindValue(':numDp', $tabVille[3], PDO::PARAM_STR);
                $sth->bindValue(':nomR', $tabVille[5], PDO::PARAM_STR);
                $sth->execute();
            }

        }





        return Command::SUCCESS;
    }
}
