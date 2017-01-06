<?php


namespace AppBundle\Analyzer;


class Analyzer implements AnalyzerInterface
{
    public function analyze($input)
    {
        $marker = Marker::M_NORMAL;

        return $marker;
    }
}