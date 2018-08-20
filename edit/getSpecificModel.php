<?php

    //Class modelling the strcutre of an xml element
    class XMLElement {
        public $tagName;
        public $attributeName;
        public $attributeValue;
        public $value;

        public function __construct($TagName, $AttributeName, $AttributeValue, $Value) {
            $this->tagName = $TagName;
            $this->attributeName = $AttributeName;
            $this->attributeValue = $AttributeValue;
            $this->value = $Value;
        }
    } 

    $title = $_POST['data'];

    $xml = new DOMDocument;
    $xml->load('../../xml/modelkatalog.rdf.xml');

    $xpath = new DOMXpath($xml);
    $elements = $xpath->query('//dct:title[@xml:lang="da"]');                                          
    
    //Find model with a matching dct:title tag
    for ($i=0; $i < $elements->length; $i++) { 

        if($elements[$i]->nodeValue == $title){
            //$elements[$i]->nodeValue = "TEST";
            $root = $elements[$i]->parentNode;

            var_dump($root->childNodes);
        }
    }

    $xmlElements = [];

    //Loop trhough each node within the model and instantiate a new xml element with the proper attributes/values.
    foreach ($root->childNodes as $node) {

        if(isset($node->tagName) && isset($node->nodeValue) && isset($node->attributes[0]->nodeName) && isset($node->attributes[0]->nodeValue)){
            array_push($xmlElements, 
                new XMLElement($node->tagName, $node->attributes[0]->nodeName, $node->attributes[0]->nodeValue, $node->nodeValue)
            );
        }else if(isset($node->tagName) && isset($node->nodeValue)){
            array_push($xmlElements, 
                new XMLElement($node->tagName, '', '', $node->nodeValue)
            );
        }else if(isset($node->tagName) && isset($node->attributes[0]->nodeName) && isset($node->attributes[0]->nodeValue)){
            array_push($xmlElements, 
                new XMLElement($node->tagName, $node->attributes[0]->nodeName, $node->attributes[0]->nodeValue, '')
            );   
        }else if(isset($node->tagName)){
            array_push($xmlElements, 
                new XMLElement($node->tagName, '', '', '')
            );
        }
    }

    //Create a table and fill in the data form the model
    echo '<table class="table table-bordered table-hover table-sm">
            <thead class="thead-dark">
                <th>Tag Name</th>
                <th>Atribute Name</th>
                <th>Atribute Value</th>
                <th>Value</th>
            </thead>';
                
    foreach ($xmlElements as $elem) {
        echo '<tbody>
                <tr>
                    <td><input onfocus="expandInput(this)" value="'.$elem->tagName.'"></td>
                    <td><input onfocus="expandInput(this)" value="'.$elem->attributeName.'"></td>
                    <td><input onfocus="expandInput(this)" value="'.$elem->attributeValue.'"></td>
                    <td><input onfocus="expandInput(this)" value="'.$elem->value.'"></td>
                </tr>
              </tbody>';
    }        
    
    echo '</table>';

    //$xml->save('../xml/modelkatalog.rdf.xml');

    /*$xml = simplexml_load_file("../xml/modelkatalog.rdf.xml");
    $models = $xml->xpath('//dct:title[@xml:lang="da"]');

    foreach($models as $model) {
        if($model == $title){
            $element = $model; 
        }
    }

    $node = dom_import_simplexml($element);
    $start = $node->parentNode->getLineNo();*/

    $elementEnd = $root->xpath('..//dcat:distribution[last()]');
    $nodeEnd = dom_import_simplexml($elementEnd[0]);
    $end = $nodeEnd->getLineNo() + 1;

    echo $start . ' -- ' . $end;

    /*$currentElement = $element->xpath('..');

    var_dump($node->nodeValue);
    $node->nodeValue = "TEST";
    var_dump($node->nodeValue);*/
?>