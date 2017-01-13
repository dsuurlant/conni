<?php


namespace Tests\AppBundle\Command;

use AppBundle\Command\DefaultCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
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

    /** @var Application */
    private $app;

    protected function setUp()
    {
        $app = new Application();
        $app->add(new DefaultCommand());
        $this->command = $app->find('default');
        $this->tester = new CommandTester($this->command);
    }

    protected function tearDown()
    {
        $this->command = null;
        $this->tester = null;
    }

    public function testName()
    {
        $this->tester->setInputs(array('John', 'Nothing'));
        $this->tester->execute(array('command' => $this->command->getName()));
        $this->assertContains('Hello, John!', $this->tester->getDisplay(true));
    }

    public function testWelcomeBack()
    {
        $this->tester->setInputs(array('John', 'Nothing'));
        $this->tester->execute(array('command' => $this->command->getName()));
        $this->assertContains('Hello, John!', $this->tester->getDisplay(true));

        $this->tester->setInputs(array('Nothing'));
        $this->tester->execute(array('command' => $this->command->getName()));
        $this->assertContains('Welcome back, John.', $this->tester->getDisplay(true));
    }

    public function testNormalNames()
    {
        $names = array(
          "Bruce",
          "Tony",
          "Steve",
          "Clint",
          "Natascha",
          "James",
          "Nick",
        );

        foreach ($names as $name) {
            $this->setUp();
            $this->tester->setInputs(array($name, 'Nothing'));
            $this->tester->execute(array('command' => $this->command->getName()));
            $this->assertContains("Hello, ".$name."!", $this->tester->getDisplay(true));
            $this->tearDown();
        }
    }

    public function testSpecialNames()
    {
        $names = array(
          "Daniëlle",
          "André",
          "Wojçek",
          "Björk",
          "María",
          "Shōji",
        );

        foreach ($names as $name) {
            $this->setUp();
            $this->tester->setInputs(array($name, 'Nothing'));
            $this->tester->execute(array('command' => $this->command->getName()));
            $this->assertContains("Hello, ".$name."!", $this->tester->getDisplay(true));
            $this->tearDown();
        }
    }

    public function testRudeNames()
    {
        $names = array(
          "Ass",
          "Butt",
          "Wanker",
          "Fuck",
          "Shit",
          "Bastard",
        );

        foreach ($names as $name) {
            $this->setUp();
            $this->tester->setInputs(array($name));
            $this->tester->execute(array('command' => $this->command->getName()));
            $this->assertContains('rude', $this->tester->getDisplay(true));
            $this->tearDown();
        }
    }

}
