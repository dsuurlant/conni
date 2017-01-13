<?php


namespace Tests\AppBundle\Command;

use AppBundle\Command\ConniCommand;
use AppBundle\Command\DefaultCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Tester\CommandTester;


/**
 * Tests whether the default command runs as expected.
 *
 * Class DefaultCommandTest
 * @package AppBundle\Command
 */
class DefaultCommandTest extends \PHPUnit_Framework_TestCase
{
    /** @var Command */
    protected $command;

    /** @var CommandTester */
    protected $tester;

    protected function tearDown()
    {
        $this->command = null;
        $this->tester = null;
    }

    /**
     * Test asking for user's name.
     */
    public function testAskForName()
    {
        $app = new Application();
        $app->add(new DefaultCommand());
        $this->command = $app->find('default');
        $this->tester = new CommandTester($this->command);
        $this->tester->setInputs(array('John', 'Nothing'));

        $this->tester->execute(array('command' => $this->command->getName()));
        $this->assertContains('Hello, John!', $this->tester->getDisplay(true));
    }


}
