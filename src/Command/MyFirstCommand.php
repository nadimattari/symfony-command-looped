<?php

namespace App\Command;

use App\Services\MyService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name       : 'my:first:command',
    description: 'This is a simple command to send some mails',
)]
class MyFirstCommand extends Command
{
    public function __construct(readonly MyService $myService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::REQUIRED, 'Name')
            ->addArgument('mail', InputArgument::REQUIRED, 'Email')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $name = $input->getArgument('name');
        $mail = $input->getArgument('mail');

        $this->myService->execute($name, $mail);

        $io->success("Email sent to: $name ($mail)");
        return Command::SUCCESS;
    }
}
