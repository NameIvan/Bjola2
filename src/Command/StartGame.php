<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use GuzzleHttp\Client;

class StartGame extends Command
{
    protected static $defaultName = 'app:start-game';

    protected function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'Who do you want to greet?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $client = new Client();

        echo PHP_EOL . " \e[0;35;40mWelcome to Game Bjola 3\e[0m" . PHP_EOL;
        echo PHP_EOL . " Good luck \e[1;3" . rand(0,7) . ";40m$name\e[0m" . PHP_EOL;
        $response = $client->request('GET', 'http://localhost:58660/api/connect');

//$a = json_decode($response->getBody()->getContents(), true);
        var_dump($response->getBody());
    }
}