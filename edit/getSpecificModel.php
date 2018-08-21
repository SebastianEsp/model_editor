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
            $root = $elements[$i]->parentNode;
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
    echo '<table class="table table-bordered table-hover table-sm" id="modelTable">
            <thead class="thead-dark">
                <th>Tag Name</th>
                <th>Atribute Name</th>
                <th>Atribute Value</th>
                <th>Value</th>
            </thead>
            <tbody>';
                
    foreach ($xmlElements as $elem) {
    echo '<tr>
            <td class="clickable-row"><input onfocus="expandInput(this)" value="'.$elem->tagName.'"></td>
            <td class="clickable-row"><input onfocus="expandInput(this)" value="'.$elem->attributeName.'"></td>
            <td class="clickable-row"><input onfocus="expandInput(this)" value="'.$elem->attributeValue.'"></td>
            <td class="clickable-row"><input onfocus="expandInput(this)" value="'.$elem->value.'"></td>
          </tr>';
    }        
    
    echo '</tbody>
          </table>';
?>