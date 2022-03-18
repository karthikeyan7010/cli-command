<?php
namespace Task\Customer\Command\Customer;

use Exception;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Console\Cli;
use Magento\Framework\Filesystem;
use Magento\Framework\App\State;
use Magento\Framework\App\Area;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Task\Customer\Model\Customer;

class Customers extends Command
{
    private $filesystem;
    private $customer;
    private $state;

    public function __construct(Filesystem $filesystem, Customer $customer, State $state)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
        $this->customer = $customer;
        $this->state = $state;
    }
    public function configure()
        {
            $this->setName('create:customers');
            $this->addArgument('import_path', InputArgument::REQUIRED, '/var/www/html/magento/pub/media/sample');
            $this->addOption('profile', null, InputOption::VALUE_REQUIRED, 'csv/json format ');
        }
        public function execute(InputInterface $input, OutputInterface $output)
            {
                if ($input->getOption('profile') == 'csv')
                {
                    try
                    {
                        $fixture = $input->getArgument('import_path');
                        $this
                            ->customer
                            ->install($fixture, $output);
                        return Cli::RETURN_SUCCESS;
                    }
                    catch(Exception $e)
                    {
                        $msg = $e->getMessage();
                        $output->writeln("<error>$msg</error>", OutputInterface::OUTPUT_NORMAL);
                        return Cli::RETURN_FAILURE;
                    }
                }
                else
                {
                    try
                    {

                        $fixture = $input->getArgument('import_path');
                        $this
                            ->customer
                            ->datainstall($fixture, $output);
                        return Cli::RETURN_SUCCESS;
                    }
                    catch(Exception $e)
                    {
                        $msg = $e->getMessage();
                        $output->writeln("<error>$msg</error>", OutputInterface::OUTPUT_NORMAL);
                        return Cli::RETURN_FAILURE;
                    }
                }
            }
        }
        
