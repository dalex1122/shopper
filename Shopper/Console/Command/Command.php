<?php
namespace Alexsample\Shopper\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Alexsample\Shopper\Api\Service\TokenServiceInterface;

class Command extends \Symfony\Component\Console\Command\Command
{
    public function __construct(
        TokenServiceInterface $tokenService
    ) {
        $this->tokenService = $tokenService;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('alexsample:shopper')
            ->setDescription('Shopper');

        $this->addOption('create-token', null, null, 'Create token');
        $this->addOption('get-token', null, null, 'Get token');

        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('create-token')) {
            if ($token = $this->tokenService->getToken()) {
                $output->writeln('Token already exist: ' . $token);
            } else {
                $this->tokenService->createToken();
                $token = $this->tokenService->getToken();
                $output->writeln('Token has been created: ' . $token);
            }

        }

        if ($input->getOption('get-token')) {
            if ($token = $this->tokenService->getToken()) {
                $output->writeln('Token: ' . $token);
            } else {
                $output->writeln('Token doesn\'t exist');
            }

        }
    }
}