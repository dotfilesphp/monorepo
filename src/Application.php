<?php

/*
 * This file is part of the monorepo package.
 *
 *     (c) Anthonius Munthi
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dotfiles\Monorepo;

use Dotfiles\Monorepo\Command\AbstractCommand;
use Dotfiles\Monorepo\Command\SplitCommand;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Application.
 *
 * @author Anthonius Munthi <me@itstoni.com>
 */
class Application extends BaseApplication
{
    const VERSION = '1.0-dev';

    public function __construct()
    {
        parent::__construct('monorepo', static::VERSION);

        $this->setup();
    }

    private function setup()
    {
        $this->getDefinition()->addOptions(array(
            new InputOption(
                'config',
                '-c',
                InputOption::VALUE_OPTIONAL,
                'Configuration file to be used'
            ),
            new InputOption(
                'dry-run',
                'd',
                InputOption::VALUE_NONE,
                'Do not do real change, just show debug output only'
            ),
        ));

        $this->addCommands(array(
            new SplitCommand(),
        ));
    }

    protected function doRunCommand(Command $command, InputInterface $input, OutputInterface $output)
    {
        if (
            true === $input->hasParameterOption(array('--dry-run', '-d'), true)
            && $command instanceof AbstractCommand
        ) {
            $command->setDryRun(true);
            $output->writeln('Executing in dry-run mode. Nothing will change');
        }

        return parent::doRunCommand($command, $input, $output); // TODO: Change the autogenerated stub
    }
}
