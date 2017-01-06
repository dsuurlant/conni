<?php

namespace AppBundle\Analyzer;

/**
 * Marker constants tell Conni what kind of input the user gave. For starters, are they being polite or rude?
 * What if they seem to be both?
 */
class Marker
{
    const M_NORMAL = 0;
    const M_POLITE = 1;
    const M_RUDE = 2;
}

