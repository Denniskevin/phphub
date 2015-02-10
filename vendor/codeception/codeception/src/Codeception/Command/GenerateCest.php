<?php
namespace Codeception\Command;

use Codeception\Lib\Generator\Cest as CestGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Generates Cest (scenario-driven object-oriented test) file:
 *
 * * `codecept generate:cest suite Login`
 * * `codecept g:cest suite subdir/subdir/testnameCest.php`
 * * `codecept g:cest suite LoginCest -c path/to/project`
 * * `codecept g:cest "App\Login"`
 *
 */
class GenerateCest extends Command
{
    use Shared\FileSystem;
    use Shared\Config;

    protected function configure()
    {
        $this->setDefinition(array(
            new InputArgument('suite', InputArgument::REQUIRED, 'suite where tests will be put'),
            new InputArgument('class', InputArgument::REQUIRED, 'test name'),
            new InputOption('config', 'c', InputOption::VALUE_OPTIONAL, 'Use custom path for config'),
        ));
    }

    public function getDescription() {
        return 'Generates empty Cest file in suite';
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $suite = $input->getArgument('suite');
        $class = $input->getArgument('class');

        $config = $this->getSuiteConfig($suite, $input->getOption('config'));
        $className = $this->getClassName($class);
        $path = $this->buildPath($config['path'], $class);

        $filename = $this->completeSuffix($className, 'Cest');
        $filename = $path.$filename;

        if (file_exists($filename)) {
            $output->writeln("<error>Test $filename already exists</error>");
            return;
        }
        $gen = new CestGenerator($class, $config);
        $res = $this->save($filename, $gen->produce());
        if (!$res) {
            $output->writeln("<error>Test $filename already exists</error>");
            return;
        }

        $output->writeln("<info>Test was created in $filename</info>");
    }
}
