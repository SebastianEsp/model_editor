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

    //Defines the properties of a valid xml element
    public function __construct($Prefix, $Name, $Attribute, $Value, $DescriptionLabel, $HasMultiplicity, $IsRequired, $Columns) {
        $this->prefix = $Prefix;
        $this->name = $Name;
        $this->attribute = $Attribute;
        $this->value = $Value;
        $this->descriptionLabel = $DescriptionLabel;
        $this->hasMultiplicity = $HasMultiplicity;
        $this->isRequired = $IsRequired;
        $this->columns = $Columns;
    }
}

//Definitions of each possible xml element a model can contain
$title = new XMLElement('dct:', 'title', array('xml:lang="da"','xml:lang="en"'), '', '', false, true, 'doubleRow');
$preferredNamespacePrefix = new XMLElement('vann:', 'preferredNamespacePrefix', '', '', '', false, true, 'singleColumn');
$preferredNamespaceUri = new XMLElement('vann:', 'preferredNamespaceUri', '', '', '', false, true, 'singleColumn');
$altLabel = new XMLElement('skos:', 'altLabel', array('xml:lang="da"','xml:lang="en"'), '', '', true, false, 'buttonDoubleRow');
$description = new XMLElement('dct:', 'description', array('xml:lang="da"','xml:lang="en"'), '', '', false, true, 'doubleRow');
$keyword = new XMLElement('dcat:', 'keyword', array('xml:lang="da"','xml:lang="en"'), '', '', true, false, 'buttonDoubleRow');
$versionNotes = new XMLElement('adms:', 'versionNotes', array('xml:lang="da"','xml:lang="en"'), '', '', true, false, 'buttonDoubleRow');
$versionInfo = new XMLElement('owl:', 'versionInfo', '', '', '', true, false, 'buttonDouble');
$identifier = new XMLElement('dct:', 'identifier', '', '', '', true, false, 'buttonDouble');
$issued = new XMLElement('dct:', 'issued', 'rdf:datatype="http://www.w3.org/2001/XMLSchema#date"', 'date', '', false, false, 'doubleColumn');
$modified = new XMLElement('dct:', 'modified', 'rdf:datatype="http://www.w3.org/2001/XMLSchema#date"', 'date', '', false, false, 'doubleColumn');
$contactPoint = new XMLElement('vcard:', 'contactPoint', '', '', '', false, true, 'doubleColumn');    
$page = new XMLElement('adms:', 'page', '', '', '', true, false, 'buttonDouble');    
$landingPage = new XMLElement('adms:', 'landingPage', '', '', '', false, false, 'doubleColumn');    
$publisher = new XMLElement('dct:', 'publisher', '', '', '', true, true, 'buttonDouble');   
$dataset = new XMLElement('dcat:', 'dataset', '', '', '', true, false, 'buttonDouble');   
$hasVersion = new XMLElement('dct:', 'hasVersion', '', '', '', true, false, 'buttonDouble');   
$isVersionOf = new XMLElement('dct:', 'isVersionOf', '', '', '', false, false, 'doubleColumn');   
$type = new XMLElement('dct:', 'type', getAttributes(), '', getDescriptions(), false, true, 'doubleColumn'); 
$modellingRegime = new XMLElement('mreg:', 'modellingRegime', '', '', '', false, true, 'doubleColumn'); 
$modellingLevel = new XMLElement('mlev:', 'modellingLevel', '', '', '', false, true, 'doubleColumn'); 
$theme = new XMLElement('dcat:', 'theme', '', '', '', false, false, 'doubleColumn'); 
$distribution = new XMLElement('adms:', 'distribution', '', '', '', true, false, 'doubleColumn'); 
$fileSize = new XMLElement('schema:', 'fileSize', '', '', '', false, false, 'doubleColumn');
$accessURL = new XMLElement('dcat:', 'accessURL', '', '', '', true, true, 'singleColumn');  

function getValue($choice){
    $result = [];
    $tmp = [];
    $val = '';

    $xml = simplexml_load_file('http://data.gov.dk/modelcatalogue/ModelTypes.rdf.xml');

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

function getAttributes(){
    $result = [];
    $xml = simplexml_load_file('http://data.gov.dk/modelcatalogue/ModelTypes.rdf.xml');

    $choices = array('Model', 'ConceptModel', 'LogicalModel', 'CoreModel', 'Vocabulary', 'ApplicationModel', 'ApplicationProfile');

    for ($i=0; $i < sizeof($choices); $i++) { 
        $tmp = $xml->xpath('/rdf:RDF/rdf:Description[@rdf:about="http://data.gov.dk/model/concepts/ModelTypes#' . $choices[$i] . '"]/skos:prefLabel[@xml:lang="da"]');
        $result = array_merge($result, $tmp);   
    }

    return $result;
}

function getDescriptions(){
    $result = [];
    $xml = simplexml_load_file('http://data.gov.dk/modelcatalogue/ModelTypes.rdf.xml');

    $attr = array('Model', 'ConceptModel', 'LogicalModel', 'CoreModel', 'Vocabulary', 'ApplicationModel', 'ApplicationProfile');

    for ($i=0; $i < sizeof($attr); $i++) { 
        $tmp = $xml->xpath('/rdf:RDF/rdf:Description[@rdf:about="http://data.gov.dk/model/concepts/ModelTypes#' . $attr[$i] . '"]/dct:description[@xml:lang="da"]');
        $result = array_merge($result, $tmp);   
    }

    return $result;
}
?>