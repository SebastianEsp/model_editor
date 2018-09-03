<?php

    $type = $_POST["type"];

    switch ($type) {
        case 'model':
            model();
        break;
        case 'dist':
            dist();
        break;
    }


    function model(){
        $xml = simplexml_load_file("../../xml/modelkatalog.rdf.xml");

        $dropdown_1 =  '<div class="dropdown dropdown-scroll right-padding">
        <a class="btn btn-secondary dropdown-toggle inputField" href="#" name="" role="input" id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onClick="bringToFront()">                
            Models
        </a>
        <div class="dropdown-menu" id="dropdown_search_hook" aria-labelledby="dropdown">
        <input type="text" placeholder="Search.." id="dropdown_search" onkeyup="dropdownSearch()">'; 
    
        $dropdown_2 = '';
        $models = $xml->xpath('//dcat:distribution[@rdf:resource]/../dct:title[@xml:lang="da"]');
        foreach($models as $model) {
            $dropdown_2 = $dropdown_2 . '<a class="dropdown-item" title="" onclick="getModelFromTitle(\''.$model.'\');">'.$model.'</a>';
        }
    
        $dropdown_3 = '</div>
            </div>';
    
        $dropdown_final = $dropdown_1 . $dropdown_2 . $dropdown_3;
        
        echo $dropdown_final;
    }

    function dist(){
        $xml = simplexml_load_file("../../xml/modelkatalog.rdf.xml");
        $dropdown_1 =  '<div class="dropdown dropdown-scroll right-padding">
        <a class="btn btn-secondary dropdown-toggle inputField" href="#" name="" role="input" id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onClick="bringToFront()">                
            Distributions
        </a>
        <div class="dropdown-menu" id="dropdown_search_hook" aria-labelledby="dropdown">
        <input type="text" placeholder="Search.." id="dropdown_search" onkeyup="dropdownSearch()">'; 
    
        $dropdown_2 = '';
        $distributions = $xml->xpath('//rdf:type[@rdf:resource="http://www.w3.org/ns/dcat#Distribution"]/../dct:title[@xml:lang="da"]');
        foreach($distributions as $dist) {
            $dropdown_2 = $dropdown_2 . '<a class="dropdown-item" title="" onclick="getModelFromTitle(\''.$dist.'\');">'.$dist.'</a>';
        }
    
        $dropdown_3 = '</div>
            </div>';
    
        $dropdown_final_dist = $dropdown_1 . $dropdown_2 . $dropdown_3;
    
        echo $dropdown_final_dist;
    }
?>