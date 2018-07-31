<?php

    $title = $_POST['data'];
    $chunks = json_decode($_POST['arr'], true);

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

    try{

    for ($i=0; $i < $root->childNodes->length; $i++) { 
        //Checks that a tagname has been set for the node. This makes sure comments are exlucded as they do not have a tagname
        if(isset($root->childNodes[$i]->tagName)){

            

            //preg_match_all('/(\\S*):(\\S*)/', $chunks[$i][1], $matches, PREG_PATTERN_ORDER);
            
            //$replacement = new DOMDocument();
            //$replacement->strictErrorChecking = FALSE ;
            //$replacement->loadXml('<'.$chunks[$i][0].'>'.$chunks[$i][3].'</'.$chunks[$i][0].'>');

            //$newNode = $xml->importNode($replacement->documentElement, true);

            //Get namespaceUri for the given prefix
            $uri = $xml->documentElement->lookupnamespaceURI($root->childNodes[$i]->prefix);

            $replacement = $xml->createElementNS($uri, $chunks[$i][0], $chunks[$i][3]); //Create new node and update prefix, name and value

            //Separate the preifx and name.
            //preg_match_all('/(\\S*):(\\S*)/', $chunks[$i][1], $matches, PREG_PATTERN_ORDER);
            
            //If node has an attribute, add attribute field.
            if(isset($matches[0][0])){

                //Get namespaceUri for the given prefix
                $uri = $xml->documentElement->lookupnamespaceURI($matches[1][0]);

                $attribute = $xml->createAttributeNS($uri, $chunks[$i][1]); //Create the new attribute field
                $attribute->value = $chunks[$i][2]; //Add value to the attribute
    
                $replacement->appendChild($attribute); //Append attribute to the replacement element
            }
            //$root->childNodes[$i]->parentNode->replaceChild($replacement, $root->childNodes[$i]); //Replace the old element with the new updated replacement element
        }
    }
    }catch(Exception $e){
        echo 'Caught exception: ',  $e->getMessage(), "\n";
        var_dump($e->getTrace());
    }

    $counter = 0;
    //Loop through the array of elements from table and update the corresponding fields in the xml
    /*foreach ($root->childNodes as $node) {
        //Checks that a tagname has been set for the node. This makes sure comments are exlucded as they do not have a tagname
        if(isset($node->tagName)){

            $replacement = $xml->createElementNS('http://www.w3.org/1999/02/22-rdf-syntax-ns#', $chunks[$counter][0]); //Create new node and update name
            $replacement->nodeValue = $chunks[$counter][3]; //Update node value

            //Separate the preifx and name.
            preg_match_all('/(\\S*):(\\S*)/', $chunks[$counter][1], $matches, PREG_PATTERN_ORDER);
            
            //If node has an attribute, add attribute field.
            if(isset($matches[0][0])){
                echo 'TEST';
                $attribute = $xml->createAttributeNS('http://www.w3.org/1999/02/22-rdf-syntax-ns#', $chunks[$counter][1]); //Create the new attribute field
                $attribute->value = $chunks[$counter][2]; //Add value to the attribute
    
                $replacement->appendChild($attribute); //Append attribute to the replacement element
            }

            $node->parentNode->replaceChild($replacement, $node); //Replace the old element with the new updated replacement element
            $counter++;
        }
    }*/

    $xml->save('../../xml/modelkatalog.rdf.xml');
?>