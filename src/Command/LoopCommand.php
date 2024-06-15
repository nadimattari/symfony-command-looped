<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name       : 'my:loop:command',
    description: 'Execute my:first:command in loop',
)]
class LoopCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $params = [
            ['name' => 'Name 01', 'email' => 'email-01@domain.tld'],
            ['name' => 'Name 02', 'email' => 'email-02@domain.tld'],
            ['name' => 'Name 03', 'email' => 'email-03@domain.tld'],
            ['name' => 'Name 04', 'email' => 'email-04@domain.tld'],
            ['name' => 'Name 05', 'email' => 'email-05@domain.tld'],
            ['name' => 'Name 06', 'email' => 'email-06@domain.tld'],
            ['name' => 'Name 07', 'email' => 'email-07@domain.tld'],
            ['name' => 'Name 08', 'email' => 'email-08@domain.tld'],
            ['name' => 'Name 09', 'email' => 'email-09@domain.tld'],
            ['name' => 'Name 10', 'email' => 'email-10@domain.tld'],
        ];

        foreach ($params as $param) {
            $cmdInput = new ArrayInput([
                'command' => 'my:first:command',
                'name'    => $param['name'],
                'mail'    => $param['email'],
            ]);
            $this->getApplication()->doRun($cmdInput, $output);
        }

        $io->success('Command executed in batch.');
        return Command::SUCCESS;
    }
}
