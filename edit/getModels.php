<?php

    generateDropdown();

    function generateDropdown(){
    $xml = simplexml_load_file("../../xml/modelkatalog.rdf.xml");

        $dropdown_1 =  '<div class="dropdown dropdown-scroll right-padding">
        <a class="btn btn-secondary dropdown-toggle inputField" href="#" name="TEST" role="input" id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">                
            Models
        </a>
        <div class="dropdown-menu" id="dropdown_search_hook" aria-labelledby="dropdown">
        <input type="text" placeholder="Search.." id="dropdown_search" onkeyup="dropdownSearch()">'; 
    
        $dropdown_2 = '';
        $models = $xml->xpath('//dct:title[@xml:lang="da"]');
        foreach($models as $model) {
            $dropdown_2 = $dropdown_2 . '<a class="dropdown-item" title="TEST" onclick="getModelFromTitle(\''.$model.'\');">'.$model.'</a>';
        }
    
        $dropdown_3 = '</div>
            </div>';
    
        $dropdown_final = $dropdown_1 . $dropdown_2 . $dropdown_3;
    
        echo $dropdown_final;
    }


?>