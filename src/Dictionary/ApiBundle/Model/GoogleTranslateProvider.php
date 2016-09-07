<?php

namespace Dictionary\ApiBundle\Model;

// ENG 2 SRB http://translate.google.com/translate_a/t?client=p&sl=auto&tl=sr&hl=en&dt=bd&dt=ex&dt=ld&dt=md&dt=qc&dt=rw&dt=rm&dt=ss&dt=t&dt=at&dt=sw&ie=UTF-8&oe=UTF-8&oc=1&otf=1&ssel=0&tsel=0&q=nice
class GoogleTranslateProvider
{

    public function translate($word)
    {
        $word = urlencode($word);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://translate.google.com/translate_a/t?client=p&sl=auto&tl=sr&hl=en&dt=bd&dt=ex&dt=ld&dt=md&dt=qc&dt=rw&dt=rm&dt=ss&dt=t&dt=at&dt=sw&ie=UTF-8&oe=UTF-8&oc=1&otf=1&ssel=0&tsel=0&q=nice' . $word,
            CURLOPT_USERAGENT => 'Codular Sample cURL Request'
        ));
        $resp = curl_exec($curl);
		var_dump($resp);
        $output = json_decode($resp);
        return !empty($output) ? $output : false;
    }
}