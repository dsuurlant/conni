<?php

namespace AppBundle\Analyzer;

interface AnalyzerInterface
{
    /**
     * Analyzes input for particular keywords and returns the found markers as a bit value.
     *
     * @param $input User input.
     * @return int The markers found in the input.
     */
    public function analyze($input);
}