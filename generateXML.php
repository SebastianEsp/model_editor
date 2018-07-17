<?php
    $data = json_decode($_POST['data'], true);
    global $keyPos;

    //Defines the attribute namespace for each xml node type
    $attrResource = ["vcard:contactPoint", "adms:page","adms:landingPage", "dct:publisher", "dcat:dataset", 
    "dct:hasVersion", "dct:isVersionOf", "dct:type", "mreg:modellingRegime", "mlev:modellingLevel", "dcat:theme", "adms:distribution",
    "dcat:accessURL", "dct:license", "dct:format"];
    
    $attrLanguage = ["dct:title", "adms:versionNotes", "dct:description", "skos:altLabel", "dcat:keyword", 
    "adms:versionNotes"];
    
    $attrDatatype = ["dct:issued", "dct:modified", "dct:format", "schema:fileSize"];
    
    $attrNone = ["vann:preferredNamespacePrefix", "vann:preferredNamespaceUri", "dct:rights", "dadk:businessArea", 
    "dadk:businessAreaCode", "dct:identifier", "owl:versionInfo"];

    //Remove ending <rdf:RDF> tag from XML document
    $lines = file('../xml/modelkatalog.rdf.xml'); 
    $last = sizeof($lines) - 1 ; 
    unset($lines[$last]); 
    
    //Save changes to XML document
    $fp = fopen('../xml/modelkatalog.rdf.xml', 'w');
    fwrite($fp, implode('', $lines)); 
    fclose($fp); 

    //echo var_dump($data);

    //Add </rdf:Description node to XML document>
    $xmlTmp = '<rdf:Description ' . ((multiKeyExists($data, 'vann:preferredNamespaceUri'))?'rdf:about="' . $data[2]['attribute'] : 'rdf:about="' . $data[1]['attribute'] ) . '">' . PHP_EOL;
    file_put_contents('../xml/modelkatalog.rdf.xml',$xmlTmp, FILE_APPEND);

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
        file_put_contents('../xml/modelkatalog.rdf.xml',$xmlTmp, FILE_APPEND); 
    }

    //Add closing </rdf:Description and </rdf:RDF> tags to document
    $xmlTmp = '</rdf:Description>' . PHP_EOL . '</rdf:RDF>';
    file_put_contents('../xml/modelkatalog.rdf.xml',$xmlTmp, FILE_APPEND);

    //Formats the XML file
    $xmlFinal = simplexml_load_file('../xml/modelkatalog.rdf.xml');
    $dom = new DOMDocument('1.0');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xmlFinal->asXML());
    $xmlFinal = new SimpleXMLElement($dom->saveXML());
    $xmlFinal->saveXML("../xml/modelkatalog.rdf.xml");

    function multiKeyExists(array $arr, $key) {

        for ($i=0; $i < sizeof($arr) - 1; $i++) { 
            //print_r ($arr[$i]);
            if(in_array($key, $arr[$i])){
                $keyPos = $i;
                return true;
            }
        }
        return false;
    }
?>
