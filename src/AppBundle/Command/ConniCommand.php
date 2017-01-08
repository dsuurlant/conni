<?php


namespace AppBundle\Command;


use Symfony\Component\Console\Command\Command;

/**
 * Extension of Command for Conni-specific functionality.
 *
 * Class ConniCommand
 * @package AppBundle\Command
 */
class ConniCommand extends Command
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