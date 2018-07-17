<?php

class XMLElement { 

//xml element attributes 
public $prefix;
public $name;
public $attribute;
public $value;
public $hasMultiplicity;
public $isRequired;
public $columns;
public $descriptionLabel;
public $ReadOnly;
public $Hidden;

//valid xml elements
public $title;
public $preferredNamespacePrefix;
public $preferredNamespaceUri;
public $altLabel;
public $description;
public $keyword;
public $versionNotes;
public $versionInfo;
public $identifier;
public $issued;
public $modified;
public $contactPoint;
public $page;
public $landingPage;
public $publisher;
public $dataset;
public $hasVersion;
public $isVersionOf;
public $type;
public $modellingRegime;
public $modellingLevel;
public $theme;
public $distribution;
public $fileSize;
public $accessURL;
public $license;
public $format;


    //Defines the properties of a valid xml element
    public function __construct($Prefix, $Name, $Attribute, $Value, $DescriptionLabel, $HasMultiplicity, $IsRequired, $Columns, $ReadOnly, $Hidden) {
        $this->prefix = $Prefix;
        $this->name = $Name;
        $this->attribute = $Attribute;
        $this->value = $Value;
        $this->descriptionLabel = $DescriptionLabel;
        $this->hasMultiplicity = $HasMultiplicity;
        $this->isRequired = $IsRequired;
        $this->columns = $Columns;
        $this->readOnly = $ReadOnly;
        $this->hidden = $Hidden;
    }
}

//Definitions of each possible xml element a model can contain
$title = new XMLElement('dct:', 'title', array('xml:lang="da"','xml:lang="en"'), '', '', false, true, 'doubleRow', true, false);
$preferredNamespacePrefix = new XMLElement('vann:', 'preferredNamespacePrefix', '', '', '', false, true, 'singleColumn', false, false);
$preferredNamespaceUri = new XMLElement('vann:', 'preferredNamespaceUri', '', '', '', false, true, 'singleColumn', false, false);
$altLabel = new XMLElement('skos:', 'altLabel', array('xml:lang="da"','xml:lang="en"'), '', '', true, false, 'buttonDoubleRow', true, false);
$description = new XMLElement('dct:', 'description', array('xml:lang="da"','xml:lang="en"'), '', '', false, true, 'doubleRow', true, false);
$keyword = new XMLElement('dcat:', 'keyword', array('xml:lang="da"','xml:lang="en"'), '', '', true, false, 'buttonDoubleRow', true, false);
$versionNotes = new XMLElement('adms:', 'versionNotes', array('xml:lang="da"','xml:lang="en"'), '', '', true, false, 'buttonDoubleRow', true, false);
$versionInfo = new XMLElement('owl:', 'versionInfo', '', '', '', true, false, 'buttonDouble', false, false);
$identifier = new XMLElement('dct:', 'identifier', '', '', '', true, false, 'buttonDouble', false, false);
$issued = new XMLElement('dct:', 'issued', 'http://www.w3.org/2001/XMLSchema#date', 'date', '', false, false, 'doubleColumn', true, true);
$modified = new XMLElement('dct:', 'modified', 'http://www.w3.org/2001/XMLSchema#date', 'date', '', false, false, 'doubleColumn', true, true);
$contactPoint = new XMLElement('vcard:', 'contactPoint', '', '', '', false, true, 'doubleColumn', false, false);    
$page = new XMLElement('adms:', 'page', '', '', '', true, false, 'buttonSingle', false, false);    
$landingPage = new XMLElement('adms:', 'landingPage', '', '', '', false, false, 'singleColumn', false, false);    
$publisher = new XMLElement('dct:', 'publisher', '', '', '', true, true, 'buttonSingle', false, false);   
$dataset = new XMLElement('dcat:', 'dataset', '', '', '', true, false, 'buttonDouble', false, false);   
$hasVersion = new XMLElement('dct:', 'hasVersion', '', '', '', true, false, 'buttonDouble', false, false);   
$isVersionOf = new XMLElement('dct:', 'isVersionOf', '', '', '', false, false, 'doubleColumn', false, false);   
$type = new XMLElement('dct:', 'type', getTypeAttributes(), '', getTypeDescriptions(), false, true, 'singleColumn', false, false); 
$modellingRegime = new XMLElement('mreg:', 'modellingRegime', getRegimeAttributes(), '', getRegimeDescriptions(), false, true, 'singleColumn', false, false); 
$modellingLevel = new XMLElement('mlev:', 'modellingLevel', getLevelAttributes(), '', getLevelDescriptions(), false, true, 'singleColumn', false, false); 
$theme = new XMLElement('dcat:', 'theme', '', '', '', false, false, 'singleColumn', false, false); 
$distribution = new XMLElement('adms:', 'distribution', '', '', '', true, false, 'buttonSingle', false, false); 
$fileSize = new XMLElement('schema:', 'fileSize', '', '', '', false, false, 'doubleColumn', false, false);
$accessURL = new XMLElement('dcat:', 'accessURL', '', '', '', true, true, 'singleColumn', false, false);
$license = new XMLElement('dct:', 'license', '', '', '', true, true, 'singleColumn', false, false);  
$format = new XMLElement('dct:', 'format', '', '', '', false, false, 'singleColumn', false, false);  

function getValue($choice){
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

    return $val;
}

function getTypeAttributes(){
    $result = [];
    $xml = simplexml_load_file('../xml/ModelTypes.rdf.xml');

    $choices = array('Model', 'ConceptModel', 'LogicalModel', 'CoreModel', 'Vocabulary', 'ApplicationModel', 'ApplicationProfile');

    for ($i=0; $i < sizeof($choices); $i++) { 
        $tmp = $xml->xpath('/rdf:RDF/rdf:Description[@rdf:about="http://data.gov.dk/model/concepts/ModelTypes#' . $choices[$i] . '"]/skos:prefLabel[@xml:lang="da"]');
        $result = array_merge($result, $tmp);   
    }

    return $result;
}

function getTypeDescriptions(){
    $result = [];
    $xml = simplexml_load_file('../xml/ModelTypes.rdf.xml');

    $attr = array('Model', 'ConceptModel', 'LogicalModel', 'CoreModel', 'Vocabulary', 'ApplicationModel', 'ApplicationProfile');

    for ($i=0; $i < sizeof($attr); $i++) { 
        $tmp = $xml->xpath('/rdf:RDF/rdf:Description[@rdf:about="http://data.gov.dk/model/concepts/ModelTypes#' . $attr[$i] . '"]/dct:description[@xml:lang="da"]');
        $result = array_merge($result, $tmp);   
    }

    return $result;
}

function getRegimeAttributes(){
    $result = [];
    $xml = simplexml_load_file('../xml/ModellingRegimes.rdf.xml');

    $choices = array('FODS', 'Grunddata', 'International');

    for ($i=0; $i < sizeof($choices); $i++) { 
        $tmp = $xml->xpath('/rdf:RDF/rdf:Description[@rdf:about="http://data.gov.dk/model/concepts/ModellingRegimes#' . $choices[$i] . '"]/skos:prefLabel[@xml:lang="da"]');
        $result = array_merge($result, $tmp);   
    }

    return $result;
}

function getRegimeDescriptions(){
    $result = [];
    $xml = simplexml_load_file('../xml/ModellingRegimes.rdf.xml');

    $attr = array('FODS', 'Grunddata', 'International');

    for ($i=0; $i < sizeof($attr); $i++) { 
        $tmp = $xml->xpath('/rdf:RDF/rdf:Description[@rdf:about="http://data.gov.dk/model/concepts/ModellingRegimes#' . $attr[$i] . '"]/dct:description[@xml:lang="da"]');
        $result = array_merge($result, $tmp);   
    }

    return $result;
}

function getLevelAttributes(){
    $result = [];
    $xml = simplexml_load_file('../xml/ModellingLevels.rdf.xml');

    $choices = array('Formidling', 'Genbrug', 'Sammenhæng');

    for ($i=0; $i < sizeof($choices); $i++) { 
        $tmp = $xml->xpath('/rdf:RDF/rdf:Description[@rdf:about="http://data.gov.dk/model/concepts/ModellingLevels#' . $choices[$i] . '"]/skos:prefLabel[@xml:lang="da"]');
        $result = array_merge($result, $tmp);   
    }

    return $result;
}

function getLevelDescriptions(){
    $result = [];
    $xml = simplexml_load_file('../xml/ModellingLevels.rdf.xml');

    $attr = array('Formidling', 'Genbrug', 'Sammenhæng');

    for ($i=0; $i < sizeof($attr); $i++) { 
        $tmp = $xml->xpath('/rdf:RDF/rdf:Description[@rdf:about="http://data.gov.dk/model/concepts/ModellingLevels#' . $attr[$i] . '"]/dct:description[@xml:lang="da"]');
        $result = array_merge($result, $tmp);   
    }

    return $result;
}
?>