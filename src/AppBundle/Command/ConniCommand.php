<?php


namespace AppBundle\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Extension of Command for Conni-specific functionality.
 *
 * Class ConniCommand
 * @package AppBundle\Command
 */
abstract class ConniCommand extends Command
{

    /**
     * @var string The name Conni addresses the user with.
     */
    private $username;

    /**
     * Get username.
     *
     * @return string The username.
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the username.
     *
     * @param $username The username.
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }
}