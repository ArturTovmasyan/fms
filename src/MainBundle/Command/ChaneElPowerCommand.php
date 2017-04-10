<?php

namespace MainBundle\Command;

use MainBundle\Entity\ElPower;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ChaneElPowerCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('fms:change:el-power')
            ->setDescription('Change el power values');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $elPowers = $em->getRepository('MainBundle:ElPower')->findAll();

        $progress = new ProgressBar($output, count($elPowers));

        $output->writeln("<info>START</info>");

        $progress->start();

        if($elPowers) {

            foreach ($elPowers as $power) {
                $value = $power->getValue();
                $value = str_replace(",", ".", $value);

                $text = $power->getText();
                $power->setValue($value);

                if ($text) {
                    $text = str_replace(",", ".", $text);
                    $power->setText($text);
                }

                $em->persist($power);
            }

            $em->flush();
        }

        $elPowers = $em->getRepository('MainBundle:ElPower')->findAll();

        if($elPowers) {

            foreach($elPowers as $power)
            {
                $value = $power->getValue();
                $text = $power->getText();

                if($text) {
                    $sum = $value + $text;
                }else{
                    $sum = $value;
                }

                $power->setValue($sum);
                $power->setText(null);
                $em->persist($power);
            }

            $em->flush();

            $output->writeln("<info>Success.Equipment elPower has been changed</info>");
        }

        $progress->finish();
    }
}