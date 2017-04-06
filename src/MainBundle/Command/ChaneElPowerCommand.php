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
            ->setDescription('Change equipment state');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $equipments = $em->getRepository('MainBundle:Equipment')->findAll();

        $progress = new ProgressBar($output, count($equipments));

        $output->writeln("<info>START</info>");

        $progress->start();

        if($equipments)
        {
            foreach($equipments as $eq)
            {
                $elPower = $eq->getElPower();

                if(!$elPower) {
                    $elPower = 0;
                }

                $newElPower = new ElPower();
                $newElPower->setValue($elPower);
                $newElPower->setEquipment($eq);
                $em->persist($newElPower);

            }

            $output->writeln("<info>Success.Equipment elPower has been changed</info>");
        }

        $em->flush();
        $progress->finish();
    }
}