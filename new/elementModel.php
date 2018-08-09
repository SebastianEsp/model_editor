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
public $titelLabel;
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
public $modelType;
public $modellingRegime;
public $modellingLevel;
public $theme;
public $distribution;
public $fileSize;
public $accessURL;
public $license;
public $format;
public $rights;
public $rdfType;
public $dctType;


    //Defines the properties of a valid xml element
    public function __construct($Prefix, $Name, $Attribute, $Value, $TitelLabel, $HasMultiplicity, $IsRequired, $Columns, $ReadOnly, $Hidden) {
        $this->prefix = $Prefix; //Defines xml prefix
        $this->name = $Name; //Defines element name
        $this->attribute = $Attribute; //Use whenever an xml-element always has a specific xml-attribute
        $this->value = $Value; //Used to define custom data-* attributes. Precently used to give a field a datepicker.
        $this->titelLabel = $TitelLabel; //Use to define the title attribute when generating an HTML-element
        $this->hasMultiplicity = $HasMultiplicity; //Defines if the editor should allow for multiple fields of the same element
        $this->isRequired = $IsRequired; //Defines whether or not the element must contain a value or attribute
        $this->columns = $Columns; //Defines the type of HTML-element the editor must create for the xml-element 
        $this->readOnly = $ReadOnly; //Defines whether or not a field in the editor can be edited
        $this->hidden = $Hidden; //Defines whether or not a field is visible
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
$versionInfo = new XMLElement('owl:', 'versionInfo', 'http://www.w3.org/2001/XMLSchema#decimal', '', '', true, false, 'doubleColumn', true, true);
$identifier = new XMLElement('dct:', 'identifier', '', '', '', true, false, 'buttonDouble', false, false);
$issued = new XMLElement('dct:', 'issued', 'http://www.w3.org/2001/XMLSchema#date', 'date', '', false, false, 'doubleColumn', true, true);
$modified = new XMLElement('dct:', 'modified', 'http://www.w3.org/2001/XMLSchema#date', 'date', '', false, false, 'doubleColumn', true, true);
$contactPoint = new XMLElement('vcard:', 'contactPoint', '', '', '', false, false, 'doubleColumn', false, false);    
$page = new XMLElement('adms:', 'page', '', '', '', true, false, 'buttonSingle', false, false);    
$landingPage = new XMLElement('adms:', 'landingPage', '', '', '', false, false, 'singleColumn', false, false);    
$publisher = new XMLElement('dct:', 'publisher', '', '', '', true, true, 'buttonSingle', false, false);   
$dataset = new XMLElement('dcat:', 'dataset', '', '', '', true, false, 'buttonDouble', false, false);   
$hasVersion = new XMLElement('dct:', 'hasVersion', '', '', '', true, false, 'buttonDouble', false, false);   
$isVersionOf = new XMLElement('dct:', 'isVersionOf', '', '', '', false, false, 'doubleColumn', false, false);   
$modelType = new XMLElement('dadk:', 'modelType', getTypeTitle(), getTypeValue(), getTypeDescriptions(), false, true, 'singleDropdown', false, false); 
$modellingRegime = new XMLElement('mreg:', 'modellingRegime', getRegimeTitle(), getRegimeValue(), getRegimeDescriptions(), false, true, 'singleDropdown', false, false); 
$modellingLevel = new XMLElement('mlev:', 'modellingLevel', getLevelTitle(), getLevelValue(), getLevelDescriptions(), false, true, 'singleDropdown', false, false); 
$theme = new XMLElement('dcat:', 'theme', getThemeTitle(), getThemeValue(), getThemeDescriptions(), false, false, 'singleDropdown', false, false); 
$distribution = new XMLElement('dcat:', 'distribution', '', '', '', true, false, 'buttonSingle', false, false); 
$fileSize = new XMLElement('schema:', 'fileSize', '', '', '', false, false, 'doubleColumn', false, false);
$accessURL = new XMLElement('dcat:', 'accessURL', '', '', '', true, true, 'singleColumn', false, false);
$license = new XMLElement('cc:', 'license', '', '', '', true, false, 'singleColumn', false, false);  
$format = new XMLElement('dct:', 'format', '', '', '', false, false, 'singleColumn', false, false);
$rights = new XMLElement('dct:', 'rights', '', '', '', false, false, 'singleColumn', false, false);
$businessArea = new XMLElement('dadk:', 'businessArea', '', '', '', false, false, 'singleColumn', false, false);
$businessAreaCode = new XMLElement('dadk:', 'businessAreaCode', '', '', '', false, false, 'singleColumn', false, false);  
$dctType = new XMLElement('dct:', 'type', 'http://data.europa.eu/dr8/CoreDataModel', '', '', false, false, 'typeColumn', true, false);  
$rdfType = new XMLElement('rdf:', 'type', array('http://www.w3.org/ns/dcat#Dataset', 'http://www.w3.org/ns/dcat#Distribution'), '', '', false, false, 'typeColumn', true, false);  

function getValue($choice){
    $result = [];
    $tmp = [];
    $val = '';

    $xml = simplexml_load_file('../../../../model/core/modeltype.rdf');

    $tmp = $xml->xpath('//@rdf:about');
    $result = array_merge($result, $tmp);

    $test = array('Model', 'ConceptModel', 'LogicalModel');

    for ($i=0; $i < sizeof($result); $i++) { 
        //echo var_dump(($result[$i]->about));
        $tmp = $xml->xpath('/rdf:RDF/rdf:Description[@rdf:about="' . $result[$i]->about . '"]/skos:prefLabel[@xml:lang="da"]');
        
        $size = sizeof($tmp);

        if($size == 1 && $tmp[0] == $choice){
            $val = 'http://data.gov.dk/model/core/modeltype#' . $test[$i];
        }
    }

    return $val;
}

function getTypeValue(){
    $result = [];

    $choices = array('Model', 'ConceptModel', 'LogicalModel', 'CoreModel', 'Vocabulary', 'ApplicationModel', 'ApplicationProfile');

    for ($i=0; $i < sizeof($choices); $i++) { 
        $tmp = 'https://data.gov.dk/model/core/modeltype#' . $choices[$i];
        array_push($result, $tmp);    
    }

    return $result;
}

function getTypeDescriptions(){
    $result = [];
    $xml = simplexml_load_file('../../../../model/core/modeltype.rdf');

    $attr = array('Model', 'ConceptModel', 'LogicalModel', 'CoreModel', 'Vocabulary', 'ApplicationModel', 'ApplicationProfile');

    for ($i=0; $i < sizeof($attr); $i++) { 
        $tmp = $xml->xpath('/rdf:RDF/rdf:Description[@rdf:about="https://data.gov.dk/model/core/modeltype#' . $attr[$i] . '"]/dct:description[@xml:lang="da"]');
        $result = array_merge($result, $tmp);   
    }

    return $result;
}

function getTypeTitle(){
    $result = [];
    $xml = simplexml_load_file('../../../../model/core/modeltype.rdf');

    $choices = array('Model', 'ConceptModel', 'LogicalModel', 'CoreModel', 'Vocabulary', 'ApplicationModel', 'ApplicationProfile');

    for ($i=0; $i < sizeof($choices); $i++) { 
        $tmp = $xml->xpath('/rdf:RDF/rdf:Description[@rdf:about="https://data.gov.dk/model/core/modeltype#' . $choices[$i] . '"]/skos:prefLabel[@xml:lang="da"]');
        $result = array_merge($result, $tmp);   
    }

    return $result;
}

function getRegimeValue(){
    $result = [];

    $choices = array('FODS', 'Grunddata', 'International');

    for ($i=0; $i < sizeof($choices); $i++) { 
        $tmp = 'https://data.gov.dk/model/core/modellingregime#' . $choices[$i];
        array_push($result, $tmp);    
    }

    return $result;
}

function getRegimeDescriptions(){
    $result = [];
    $xml = simplexml_load_file('../../../../model/core/modellingregime.rdf');

    $attr = array('FODS', 'Grunddata', 'International');

    for ($i=0; $i < sizeof($attr); $i++) { 
        $tmp = $xml->xpath('/rdf:RDF/rdf:Description[@rdf:about="https://data.gov.dk/model/core/modellingregime#' . $attr[$i] . '"]/dct:description[@xml:lang="da"]');
        $result = array_merge($result, $tmp);   
    }

    return $result;
}

function getRegimeTitle(){
    $result = [];
    $xml = simplexml_load_file('../../../../model/core/modellingregime.rdf');

    $choices = array('FODS', 'Grunddata', 'International');

    for ($i=0; $i < sizeof($choices); $i++) { 
        $tmp = $xml->xpath('/rdf:RDF/rdf:Description[@rdf:about="https://data.gov.dk/model/core/modellingregime#' . $choices[$i] . '"]/skos:prefLabel[@xml:lang="da"]');
        $result = array_merge($result, $tmp);   
    }

    return $result;
}

function getLevelValue(){
    $result = [];

    $choices = array('Dissemination', 'Reuse', 'Cohesion');

    for ($i=0; $i < sizeof($choices); $i++) { 
        $tmp = 'https://data.gov.dk/model/core/modellinglevel#' . $choices[$i];
        array_push($result, $tmp);    
    }

    return $result;
}

function getLevelDescriptions(){
    $result = [];
    $xml = simplexml_load_file('../../../../model/core/modellinglevel.rdf');

    $attr = array('Dissemination', 'Reuse', 'Cohesion');

    for ($i=0; $i < sizeof($attr); $i++) { 
        $tmp = $xml->xpath('/rdf:RDF/rdf:Description[@rdf:about="https://data.gov.dk/model/core/modellinglevel#' . $attr[$i] . '"]/dct:description[@xml:lang="da"]');
        $result = array_merge($result, $tmp);   
    }

    return $result;
}

function getLevelTitle(){
    $result = [];
    $xml = simplexml_load_file('../../../../model/core/modellinglevel.rdf');

    $choices = array('Dissemination', 'Reuse', 'Cohesion');

    for ($i=0; $i < sizeof($choices); $i++) { 
        $tmp = $xml->xpath('/rdf:RDF/rdf:Description[@rdf:about="https://data.gov.dk/model/core/modellinglevel#' . $choices[$i] . '"]/skos:prefLabel[@xml:lang="da"]');
        $result = array_merge($result, $tmp);   
    }

    return $result;
}

function getThemeValue(){
    $result = [];

    $choices = array('AGRI', 'ECON', 'EDUC', 'ENER', 'ENVI', 'GOVE', 'HEAL', 'INTR', 'JUST', 'REGI', 'SOCI', 'TECH', 'TRAN', 'OP_DATPRO');

    for ($i=0; $i < sizeof($choices); $i++) { 
        $tmp = 'http://publications.europa.eu/resource/authority/data-theme/' . $choices[$i];
        array_push($result, $tmp);    
    }

    return $result;
}

function getThemeDescriptions(){
    $result = [];
    $xml = simplexml_load_file('../../xml/data-theme-skos-ap-act.rdf');

    $attr = array('AGRI', 'ECON', 'EDUC', 'ENER', 'ENVI', 'GOVE', 'HEAL', 'INTR', 'JUST', 'REGI', 'SOCI', 'TECH', 'TRAN', 'OP_DATPRO');

    for ($i=0; $i < sizeof($attr); $i++) { 
        $tmp = $xml->xpath('/rdf:RDF/skos:Concept[@rdf:about="http://publications.europa.eu/resource/authority/data-theme/' . $attr[$i] . '"]/skos:definition[@xml:lang="en"]');
        $result = array_merge($result, $tmp);   
    }

    return $result;
}

function getThemeTitle(){
    $result = [];
    $xml = simplexml_load_file('../../xml/data-theme-skos-ap-act.rdf');

    $choices = array('AGRI', 'ECON', 'EDUC', 'ENER', 'ENVI', 'GOVE', 'HEAL', 'INTR', 'JUST', 'REGI', 'SOCI', 'TECH', 'TRAN', 'OP_DATPRO');

    for ($i=0; $i < sizeof($choices); $i++) { 
        $tmp = $xml->xpath('/rdf:RDF/skos:Concept[@rdf:about="http://publications.europa.eu/resource/authority/data-theme/' . $choices[$i] . '"]/dc:identifier');
        $result = array_merge($result, $tmp);   
    }

    return $result;
}
?>