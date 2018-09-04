<?php

    $title = $_POST['data'];
    $chunks = json_decode($_POST['arr'], true);
    $newRows = json_decode($_POST['new']); 
    $deletedRows = json_decode($_POST['deleted']); 

    $xml = new DOMDocument;
    $xml->strictErrorChecking = FALSE ;
    $xml->load('../../xml/modelkatalog.rdf.xml');

    $xpath = new DOMXpath($xml);
    $elements = $xpath->query('//dct:title[@xml:lang="da"]');                                          
    
    //Go through the xml document and find a model with a matching dct:title tag. 
    for ($i=0; $i < $elements->length; $i++) { 

        if($elements[$i]->nodeValue == $title){
            $root = $elements[$i]->parentNode;
        }
    }

    //Keep track of skips made due to comment elements. Used to sync up form row index'es with the position of the respective element in the xml doc 
    $skips = 0;

    for ($i=0; $i < $root->childNodes->length + sizeof($newRows); $i++) { 
        
        //Checks that a tagname has been set for the node. This makes sure comments are exlucded as they do not have a tagname
        if(isset($root->childNodes[$i]->tagName)){

            //Separate the preifx and name of the element.
            preg_match_all('/(\\S*):(\\S*)/', $chunks[$i - $skips][0], $matches_root, PREG_PATTERN_ORDER);

            //Prefix of the element
            $pfx = $matches_root[1][0];
            
            //Get namespaceUri for the given prefix
            $uri = $xml->documentElement->lookupnamespaceURI($pfx);

            $replacement = $xml->createElementNS($uri, $chunks[$i - $skips][0], $chunks[$i - $skips][3]); //Create new node and update prefix, name and value


            //Separate the preifx and name of an attribute.
            preg_match_all('/(\\S*):(\\S*)/', $chunks[$i - $skips][1], $matches_attr, PREG_PATTERN_ORDER);

            //If node needs an attribute, add attribute field.
            if(isset($matches_attr[0][0])){

                //Get namespaceUri for the given prefix
                $uri = $xml->documentElement->lookupnamespaceURI($matches_attr[1][0]);

                $attribute = $xml->createAttributeNS($uri, $chunks[$i - $skips][1]); //Create the new attribute field
                $attribute->value = $chunks[$i - $skips][2]; //Add value to the attribute

                $replacement->appendChild($attribute); //Append attribute to the replacement element
            }

            //Replace the old element with the new updated element.
            if(in_array($i - $skips + sizeof($newRows), $newRows)){ //If element is new insert element below
                $root->childNodes[$i]->parentNode->insertBefore($replacement, $root->childNodes[$i-1]->nextSibling);
            }else if(in_array($i - $skips + 1, $deletedRows)){//Else if element already exists and needs to be removed
                $root->childNodes[$i]->parentNode->removeChild($root->childNodes[$i]);
            }else{//Else if element already exists and needs to be updated
                $root->childNodes[$i]->parentNode->replaceChild($replacement, $root->childNodes[$i]);
            }

        }else{
            //When a comment node is encountered increment $skips
            $skips +=1;
        }
    }

    //Save changes to xml doc
    $xml->save('../../xml/modelkatalog.rdf.xml');

    //Format the xml doc
    $xmlFinal = simplexml_load_file('../../xml/modelkatalog.rdf.xml');
    $dom = new DOMDocument('1.0');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xmlFinal->asXML());
    $xmlFinal = new SimpleXMLElement($dom->saveXML());
    $xmlFinal->saveXML("../../xml/modelkatalog.rdf.xml");

?>