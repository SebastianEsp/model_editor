<?php 
    $choice = $_POST['choice'];

    $result = [];
    $tmp = [];
    $val = '';

    $xml = simplexml_load_file('../xml/ModelTypes.rdf.xml');

    $tmp = $xml->xpath('//@rdf:about');
    $result = array_merge($result, $tmp);

    $test = array('Model', 'ConceptModel', 'LogicalModel');

    for ($i=0; $i < sizeof($result); $i++) { 
        //echo var_dump(($result[$i]->about));
        $tmp = $xml->xpath('/rdf:RDF/rdf:Description[@rdf:about="' . $result[$i]->about . '"]/skos:prefLabel[@xml:lang="da"]');
        
        $size = sizeof($tmp);

        if($size == 1 && $tmp[0] == $choice){
            $val = 'http://data.gov.dk/model/concepts/ModelTypes#' . $test[$i];
        }
    }

    echo $val;
?>