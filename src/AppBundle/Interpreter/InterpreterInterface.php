<?php

namespace AppBundle\Interpreter;

/**
 * Interface for the interpreter class.
 *
 * Interface InterpreterInterface
 */
interface InterpreterInterface
{

    /**
     * Interprets user input.
     *
     * @param string $input User input.
     * @return array $output Conni's output.
     */
    public function interpret($input);
}