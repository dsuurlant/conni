<?php


namespace AppBundle\Analyzer;


class RudeAnalyzer extends Analyzer implements AnalyzerInterface
{
    public function analyze($input)
    {
        $badwords = $this->getBadWords();
        foreach ($badwords as $badword) {
            $evaluate = strpos(strtolower($input), base64_decode($badword));
            if ($evaluate !== false) {
                return Marker::M_RUDE;
            }
        }

        return parent::analyze($input);
    }

    /**
     * Retrieve the bad words list per the server locale.
     * Localisation not implemented at the moment.
     *
     * Word list is encoded to base64.
     *
     * @param string $locale
     *
     * @return array List of bad words.
     */
    private function getBadWords($locale = null)
    {
        $locale = 'en-US';
        $badwords = json_decode(
          file_get_contents(__DIR__.'/../Resources/translations/badwords_'.$locale.'.base64.json')
        );

        return $badwords;
    }
}