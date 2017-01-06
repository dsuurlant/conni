<?php


namespace AppBundle\Interpreter;

/**
 * The response sent back from the interpreter, including an HTTP status code and message content.
 *
 * Class InterpreterResponse
 * @package AppBundle\Interpreter
 */
class InterpreterResponse
{
    /**
     * @var int the HTTP status code for the response.
     */
    private $code;

    /**
     * @var array the line-by-line message from the interpreter.
     */
    private $message;

    public function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return array
     */
    public function getMessage()
    {
        return $this->message;
    }

}