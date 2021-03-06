<?php

namespace Instapp\Command;

use InstagramAPI\Exception\InstagramException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Instapp\Command\Traits\Data;

class FollowUserFollowersCommand extends InstagramCommand
{
    use
        Data\Persons,
        Data\FollowCount,
        Data\WaitTime
    ;

    protected function config()
    {
        $this
            ->setName('follow:user:follower')
            ->setDescription('Follow a user\'s followers')
            ->setHelp('Follow all users in a user\'s follower list')

            ->addOption('max', null, InputArgument::OPTIONAL, 'Max follow count')
            ->addOption('persons', null, InputArgument::OPTIONAL, 'Users (username or id) (commas)')
        ;
    }

    protected function init()
    {
        $persons = $this->getPersons();

        $this->instapp['follow']->waitTime = $this->getWaitTime();
        $this->instapp['follow']->maxFollowCount = $this->getFollowCount();

        foreach ($persons as $personId)
        {
            $this->instapp['follow']->followUserFollowers($personId);
        }
    }
}