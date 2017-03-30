<?php

namespace MainBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ChangeEqStateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('fms:change:equipment_state')
            ->setDescription('Change equipment state');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();

        $equipments = $em->getRepository('MainBundle:Equipment')->findAll();

        $progress = new ProgressBar($output, count($equipments));
        $progress->start();

        if($equipments)
        {
            foreach($equipments as $eq)
            {
             $stateId = $eq->getState();

                 $eqState = $em->getRepository('MainBundle:EquipmentState')->find($stateId);
                 $eq->setEqState($eqState);
                 $em->persist($eq);
            }

            $output->writeln("<info>Success.Equipment state has been changed</info>");
        }

        $em->flush();
        $progress->finish();
    }
}