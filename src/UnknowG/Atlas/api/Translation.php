<?php

namespace UnknowG\Atlas\api;

class Translation{

    public static function auto_translate($from_lang, $to_lan, $text)
    {

        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

          $htmlpage = html_entity_decode(file_get_contents("https://translate.google.fr/?hl=fr#view=home&op=translate&sl=".$from_lang."&tl=".$to_lan."&text=".$text, false, stream_context_create($arrContextOptions)));
        $doc = new \DOMDocument();
        $doc->loadHTMLFile("http://msrfzcwkvnthdxlb.neverssl.com/online");
        var_dump($doc->getElementsByTagName("container"));

/*
       // $json =
        $tags = get_meta_tags("https://translate.google.fr/?hl=fr#view=home&op=translate&sl=".$from_lang."&tl=".$to_lan."&text=".$text, false);

        var_dump($tags);
        var_dump($tags["result-shield-container tlid-copy-target"]);
        */


        return "cc";
    }




}