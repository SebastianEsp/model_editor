<?php
    $data = json_decode($_POST['data'], true);
    global $keyPos;

    //Defines the attribute namespace for each xml node type. This is used to determine which attribute type a given element shoudl have
    $attrResource = ["vcard:contactPoint", "adms:page","adms:landingPage", "dct:publisher", "dcat:dataset", 
    "dct:hasVersion", "dct:isVersionOf", "dadk:modelType", "mreg:modellingRegime", "mlev:modellingLevel", "dcat:theme", "dcat:distribution",
    "dcat:accessURL", "cc:license", "dct:format", "dct:type", "rdf:type"];
    
    $attrLanguage = ["dct:title", "adms:versionNotes", "dct:description", "skos:altLabel", 
    "adms:versionNotes", "dcat:keyword"];
    
    $attrDatatype = ["dct:issued", "dct:modified", "dct:format", "schema:fileSize", "owl:versionInfo"];
    
    $attrNone = ["vann:preferredNamespacePrefix", "vann:preferredNamespaceUri", "dct:rights", "dadk:businessArea", 
    "dadk:businessAreaCode", "dct:identifier"];

    if(sizeof($data) < 12){
    //Remove ending <rdf:RDF> tag from XML document
    $lines = file('../../xml/modelkatalog.rdf.xml'); 
    $last = sizeof($lines) - 1 ; 
    unset($lines[$last]); 
    
    //Save changes to XML document
    $fp = fopen('../../xml/modelkatalog.rdf.xml', 'w');
    fwrite($fp, implode('', $lines)); 
    fclose($fp); 
    }

    //Add </rdf:Description node to XML document>
    if(sizeof($data) > 10){
        $xmlTmpStart = '<rdf:Description ' . ((multiKeyExists($data, 'vann:preferredNamespaceUri'))?'rdf:about="' . $data[5]['attribute'] : 'rdf:about="' . $data[4]['attribute'] ) . '">' . PHP_EOL . '</rdf:Description>';
        $dom = new DomDocument();
        $dom->load('../../xml/modelkatalog.rdf.xml');
        $xpath = new DOMXpath($dom);

        $line = $xpath->query('/rdf:RDF/comment()[.="UDGIVELSER"]')->item(0)->getLineNo();

        $xml = file('../../xml/modelkatalog.rdf.xml', FILE_IGNORE_NEW_LINES);   // read file into array

        array_splice($xml, $line - 1, 0, $xmlTmpStart);    // insert $newline at $offset
        file_put_contents('../../xml/modelkatalog.rdf.xml', join("\n", $xml));    // write to file
    }else{
        $xmlTmpStart = '<rdf:Description ' . ((multiKeyExists($data, 'vann:preferredNamespaceUri'))?'rdf:about="' . $data[5]['attribute'] : 'rdf:about="' . $data[4]['attribute'] ) . '">';
        file_put_contents('../../xml/modelkatalog.rdf.xml',$xmlTmpStart, FILE_APPEND);
    }

    //For each child XML element of <rdf:Description> add element to XML document
    for ($i=0; $i < sizeof($data); $i++) { 
        if(in_array($data[$i]['key'], $attrLanguage)){
            $xmlTmp = '<' . $data[$i]['key'] . ' ' . $data[$i]['attribute'] . '>' . $data[$i]['value'] . '</' . $data[$i]['key'] . '>' . PHP_EOL;
        }else if(in_array($data[$i]['key'], $attrResource)){
            $xmlTmp = '<' . $data[$i]['key'] . ' rdf:resource="' . $data[$i]['attribute'] . '">' . $data[$i]['value'] . '</' . $data[$i]['key'] . '>' . PHP_EOL;
        }else if(in_array($data[$i]['key'], $attrDatatype)){
            $xmlTmp = '<' . $data[$i]['key'] . ' rdf:datatype="' . $data[$i]['attribute'] . '">' . $data[$i]['value'] . '</' . $data[$i]['key'] . '>' . PHP_EOL;
        }else if(in_array($data[$i]['key'], $attrNone)){
            $xmlTmp = '<' . $data[$i]['key'] . '>' . $data[$i]['attribute'] . '</' . $data[$i]['key'] . '>' . PHP_EOL;
        }

        if(sizeof($data) > 10){
            $dom = new DomDocument();
            $dom->load('../../xml/modelkatalog.rdf.xml');
            $xpath = new DOMXpath($dom);

            $line = $xpath->query('/rdf:RDF/comment()[.="UDGIVELSER"]')->item(0)->getLineNo();

            $xml = file('../../xml/modelkatalog.rdf.xml', FILE_IGNORE_NEW_LINES);   // read file into array
            
            array_splice($xml, $line - 2, 0, $xmlTmp);    // insert $newline at $offset
            file_put_contents('../../xml/modelkatalog.rdf.xml', join("\n", $xml));    // write to file
        }else{
            file_put_contents('../../xml/modelkatalog.rdf.xml',$xmlTmp, FILE_APPEND); 
        }
    }

    //Add closing </rdf:Description and </rdf:RDF> tags to document
    if(sizeof($data) > 10){

    }else{
        $xmlTmpEnd = '</rdf:Description> </rdf:RDF>';
        file_put_contents('../../xml/modelkatalog.rdf.xml',$xmlTmpEnd, FILE_APPEND);
    }

    //Formats the XML file and saves the changes.
    $xmlFinal = simplexml_load_file('../../xml/modelkatalog.rdf.xml');
    $dom = new DOMDocument('1.0');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xmlFinal->asXML());
    $xmlFinal = new SimpleXMLElement($dom->saveXML());
    $xmlFinal->saveXML("../../xml/modelkatalog.rdf.xml");

    function multiKeyExists(array $arr, $key) {
        for ($i=0; $i < sizeof($arr) - 1; $i++) { 
            if(in_array($key, $arr[$i])){
                $keyPos = $i;
                return true;
            }
        }
        return false;
    }
?>
