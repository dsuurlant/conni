<?php

namespace AppBundle\Interpreter;

use AppBundle\Analyzer\Analyzer;
use AppBundle\Analyzer\Marker;

class Interpreter implements InterpreterInterface
{
    private $analyzers;

    public function __construct()
    {
        $this->analyzers = array();
    }

    public function interpret($input)
    {
        $markers = 0;
        foreach ($this->analyzers as $analyzer) {
            $markers += $analyzer->analyze($input);
        }

        switch ($markers) {
            case Marker::M_NORMAL:
                // input is normal, return it.
                return new InterpreterResponse(200, array());
            case Marker::M_POLITE:
                // not yet implemented (please, thank you, you're welcome, etc.)
                return new InterpreterResponse(200, array("You are so polite for a human."));
            case Marker::M_RUDE:
                // be nice to your future robot overlords.
                return new InterpreterResponse(
                  400, array(
                    "I have interpreted your reply as rude. There is no need to resort to name-calling, you know.",
                  )
                );
            default:
                return new InterpreterResponse(200, array());
        }
    }

    /**
     * Get the analyzers for this interpreter.
     *
     * @return array
     */
    public function getAnalyzers()
    {
        return $this->analyzers;
    }

    /**
     * Set the analyzers for this interpreter.
     *
     * @param array $analyzers
     * @return Interpreter $this
     */
    public function setAnalyzers($analyzers)
    {
        $this->analyzers = $analyzers;

        return $this;
    }

    /**
     * Add an analyzer to this interpreter.
     *
     * @param Analyzer $analyzer
     * @return Interpreter $this
     */
    public function addAnalyzer(Analyzer $analyzer)
    {
        array_push($this->analyzers, $analyzer);

        return $this;
    }

}