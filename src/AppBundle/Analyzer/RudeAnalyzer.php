<?php


namespace AppBundle\Analyzer;


class RudeAnalyzer extends Analyzer implements AnalyzerInterface
{
    public function analyze($input)
    {
        // @TODO fix file paths
        if (file_exists(__DIR__.'/../Resources/translations/badwords_en-US.base64.json') === false) {
            $this->encodeBadWords();
        }
        $badwords = $this->decodeBadWords();
        foreach ($badwords as $badword) {
            $realbadword = base64_decode($badword);
            // @FIXME
            if (strpos(strtolower($input), $realbadword) !== false) {
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
    private function decodeBadWords($locale = null)
    {
        $locale = 'en-US';
        // @TODO fix file paths
        $badwords = json_decode(
          file_get_contents(__DIR__.'/../Resources/translations/badwords_'.$locale.'.base64.json')
        );

        return $badwords;
    }
}