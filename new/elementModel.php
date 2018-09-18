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


    //Defines the possible properties of a field in the form
    public function __construct($Prefix, $Name, $Attribute, $Value, $TitelLabel, $HasMultiplicity, $IsRequired, $Columns, $ReadOnly, $Hidden) {
        $this->prefix = $Prefix; //Defines xml prefix
        $this->name = $Name; //Defines element name
        $this->attribute = $Attribute; //Use whenever an xml-element always has a specific xml-attribute
        $this->value = $Value; //Defines the html value property.
        $this->titelLabel = $TitelLabel; //Use to define the title attribute when generating an HTML-element
        $this->hasMultiplicity = $HasMultiplicity; //Defines if the editor should allow for multiple fields of the same element
        $this->isRequired = $IsRequired; //Defines whether or not the element must contain a value or attribute
        $this->columns = $Columns; //Defines the type of HTML-element the editor must create for the xml-element 
        $this->readOnly = $ReadOnly; //Defines whether or not a field in the editor can be edited
        $this->hidden = $Hidden; //Defines whether or not a field is visible. Used to hide fields that needs to be set, but not shown.
    }
}

//Definitions of each possible xml element a model can contain
//These definitions are used by generateHTML to determine the properties of each input field. 

$title = new XMLElement('dct:', //xml prefix
                        'title', //Element name
                        array('xml:lang="da"','xml:lang="en"'), //xml-attribute
                        '', //HTML value
                        '', //HTML title
                        false, //HasMultiplicity
                        true, //IsRequired
                        'doubleRow', //Element type
                        true, //ReadOnly
                        false); //Hidden

$preferredNamespacePrefix = new XMLElement('vann:', //xml prefix
                                           'preferredNamespacePrefix', //Element name
                                           '', //xml-attribute
                                           '', //HTML value
                                           '', //HTML title
                                           false, //HasMultiplicity
                                           true, //IsRequired
                                           'singleColumn', //Element type
                                           false, //ReadOnly
                                           false); //Hidden


$preferredNamespaceUri = new XMLElement('vann:', //xml prefix 
                                        'preferredNamespaceUri', //Element name
                                        '', //xml-attribute
                                        '', //HTML value
                                        '', //HTML title
                                        false, //HasMultiplicity
                                        true, //IsRequired
                                        'singleColumn', //Element type
                                        false, //ReadOnly
                                        false); //Hidden


$altLabel = new XMLElement('skos:', //xml prefix 
                           'altLabel', //Element name
                           array('xml:lang="da"','xml:lang="en"'), //xml-attribute
                           '', //HTML value
                           '', //HTML title
                           true, //HasMultiplicity
                           false, //IsRequired
                           'buttonDoubleRow', //Element type
                           true, //ReadOnly
                           false); //Hidden


$description = new XMLElement('dct:', //xml prefix 
                              'description', //Element name
                              array('xml:lang="da"','xml:lang="en"'), //xml-attribute
                              '', //HTML value
                              '', //HTML title
                              false, //HasMultiplicity
                              true, //IsRequired
                              'doubleRow', //Element type
                              true, //ReadOnly
                              false); //Hidden


$keyword = new XMLElement('dcat:', //xml prefix 
                          'keyword', //Element name
                          array('xml:lang="da"','xml:lang="en"'), //xml-attribute 
                          '', //HTML value
                          '', //HTML title
                          true, //HasMultiplicity
                          false, //IsRequired
                          'buttonDoubleRow', //Element type
                          true, //ReadOnly
                          false); //Hidden


$versionNotes = new XMLElement('adms:', //xml prefix
                               'versionNotes', //Element name
                               array('xml:lang="da"','xml:lang="en"'), //xml-attribute 
                                '', //HTML value
                                '', //HTML title
                                true, //HasMultiplicity
                                false, //IsRequired
                                'buttonDoubleRow', //Element type
                                true, //ReadOnly
                                false); //Hidden


$versionInfo = new XMLElement('owl:', //xml prefix
                              'versionInfo', //Element name
                              'http://www.w3.org/2001/XMLSchema#decimal', //xml-attribute 
                              '', //HTML value
                              '', //HTML title
                              true, //HasMultiplicity
                              false, //IsRequired
                              'doubleColumn', //Element type
                              true, //ReadOnly
                              true); //Hidden


$identifier = new XMLElement('dct:', //xml prefix
                             'identifier', //Element name
                             '', //xml-attribute 
                             '', //HTML value
                             '', //HTML title
                             true, //HasMultiplicity
                             false, //IsRequired
                             'buttonDouble', //Element type
                             false, //ReadOnly
                             false); //Hidden


$issued = new XMLElement('dct:', //xml prefix
                         'issued', //Element name
                         'http://www.w3.org/2001/XMLSchema#date', //xml-attribute
                         'date', //HTML value
                         '', //HTML title
                         false, //HasMultiplicity
                         false, //IsRequired
                         'doubleColumn', //Element type
                         true, //ReadOnly
                         true); //Hidden


$modified = new XMLElement('dct:', //xml prefix
                           'modified', //Element name
                           'http://www.w3.org/2001/XMLSchema#date', //xml-attribute
                           'date', //HTML value
                           '', //HTML title
                           false, //HasMultiplicity
                           false, //IsRequired
                           'doubleColumn', //Element type
                           true, //ReadOnly
                           true); //Hidden


$contactPoint = new XMLElement('vcard:', //xml prefix
                               'contactPoint', //Element name
                               '', //xml-attribute
                               '', //HTML value
                               '', //HTML title
                               false, //HasMultiplicity
                               false, //IsRequired
                               'doubleColumn', //Element type
                               false, //ReadOnly
                               false); //Hidden 


$page = new XMLElement('adms:', //xml prefix
                       'page', //Element name
                       '', //xml-attribute
                       '', //HTML value
                       '', //HTML title
                       true, //HasMultiplicity
                       false, //IsRequired
                       'buttonSingle', //Element type
                       false, //ReadOnly
                       false); //Hidden     


$landingPage = new XMLElement('adms:', //xml prefix 
                              'landingPage', //Element name
                              '', //xml-attribute
                              '', //HTML value
                              '', //HTML title
                              false, //HasMultiplicity
                              false, //IsRequired
                              'singleColumn', //Element type
                              false, //ReadOnly
                              false); //Hidden 


$publisher = new XMLElement('dct:', //xml prefix 
                            'publisher', //Element name
                            '', //xml-attribute
                            '', //HTML value
                            '', //HTML title
                            true, //HasMultiplicity
                            true, //IsRequired
                            'buttonSingle', //Element type
                            false, //ReadOnly
                            false); //Hidden


$dataset = new XMLElement('dcat:', //xml prefix 
                          'dataset', //Element name
                          '', //xml-attribute
                          '', //HTML value
                          '', //HTML title
                          true, //HasMultiplicity
                          false, //IsRequired
                          'buttonDouble', //Element type
                          false, //ReadOnly
                          false); //Hidden


$hasVersion = new XMLElement('dct:', //xml prefix 
                             'hasVersion', //Element name
                             '', //xml-attribute
                             '', //HTML value
                             '', //HTML title
                             true, //HasMultiplicity
                             false, //IsRequired
                             'buttonSingle', //Element type
                             false, //ReadOnly
                             false); //Hidden


$isVersionOf = new XMLElement('dct:', //xml prefix 
                              'isVersionOf', //Element name
                              '', //xml-attribute
                              '', //HTML value 
                              '', //HTML title
                              false, //HasMultiplicity
                              false, //IsRequired
                              'singleColumn', //Element type
                              false, //ReadOnly
                              false); //Hidden


$modelType = new XMLElement('dadk:', //xml prefix 
                            'modelType', //Element name
                            getTitle('../../../../model/core/modeltype.rdf', 'https://data.gov.dk/model/core/modeltype#'), //xml-attribute
                            getValue('../../../../model/core/modeltype.rdf', 'https://data.gov.dk/model/core/modeltype#'), //HTML value 
                            getDescription('../../../../model/core/modeltype.rdf', 'https://data.gov.dk/model/core/modeltype#'), //HTML title
                            false, //HasMultiplicity
                            true, //IsRequired
                            'singleDropdown', //Element type
                            false, //ReadOnly
                            false); //Hidden


$modellingRegime = new XMLElement('mreg:', //xml prefix 
                                  'modellingRegime', //Element name
                                  getTitle('../../../../model/core/modellingregime.rdf', 'https://data.gov.dk/model/core/modellingregime#'), //xml-attribute
                                  getValue('../../../../model/core/modellingregime.rdf', 'https://data.gov.dk/model/core/modellingregime#'), //HTML value 
                                  getDescription('../../../../model/core/modellingregime.rdf', 'https://data.gov.dk/model/core/modellingregime#'), //HTML title
                                  false, //HasMultiplicity
                                  true, //IsRequired
                                  'singleDropdown', //Element type
                                  false, //ReadOnly
                                  false); //Hidden


$modellingLevel = new XMLElement('mlev:', //xml prefix
                                 'modellingLevel', //Element name
                                 getTitle('../../../../model/core/modellinglevel.rdf', 'https://data.gov.dk/model/core/modellinglevel#'), //xml-attribute
                                 getValue('../../../../model/core/modellinglevel.rdf', 'https://data.gov.dk/model/core/modellinglevel#'), //HTML value
                                 getDescription('../../../../model/core/modellinglevel.rdf', 'https://data.gov.dk/model/core/modellinglevel#'), //HTML title
                                 false, //HasMultiplicity
                                 true, //IsRequired
                                 'singleDropdown', //Element type
                                 false, //ReadOnly
                                 false); //Hidden


$theme = new XMLElement('dcat:', //xml prefix
                        'theme', //Element name
                        getThemeTitle(), //xml-attribute
                        getThemeValue(), //HTML value
                        getThemeDescriptions(), //HTML title
                        false, //HasMultiplicity
                        false, //IsRequired
                        'singleDropdown', //Element type
                        false, //ReadOnly 
                        false); //Hidden


$distribution = new XMLElement('dcat:', //xml prefix 
                               'distribution', //Element name
                               '', //xml-attribute
                               '', //HTML value
                               '', //HTML title
                               true, //HasMultiplicity
                               false, //IsRequired
                               'buttonSingle', //Element type
                               false, //ReadOnly 
                               false); //Hidden


$fileSize = new XMLElement('schema:', //xml prefix  
                           'fileSize', //Element name
                           'http://www.w3.org/2001/XMLSchema#string', //xml-attribute
                           '', //HTML value
                           '', //HTML title
                           false, //HasMultiplicity
                           false, //IsRequired
                           'doubleColumn', //Element type
                           false, //ReadOnly
                           true); //Hidden


$accessURL = new XMLElement('dcat:', //xml prefix 
                            'accessURL', //Element name
                            '', //xml-attribute
                            '', //HTML value
                            '', //HTML title
                            true, //HasMultiplicity
                            true, //IsRequired
                            'singleColumn', //Element type
                            false, //ReadOnly
                            false); //Hidden


$license = new XMLElement('cc:', //xml prefix
                          'license', //Element name
                          '', //xml-attribute
                          '', //HTML value
                          '', //HTML title
                          true, //HasMultiplicity
                          false, //IsRequired
                          'singleColumn', //Element type
                          false, //ReadOnly 
                          false); //Hidden


$format = new XMLElement('dct:', //xml prefix
                         'format', //Element name
                         getFormatTitle(), //xml-attribute 
                         getFormatValue(), //HTML value
                         getFormatDescriptions(), //HTML title
                         false, //HasMultiplicity
                         false, //IsRequired
                         'singleDropdown', //Element type
                         false, //ReadOnly 
                         false); //Hidden


$rights = new XMLElement('dct:', //xml prefix
                         'rights', //Element name
                         '', //xml-attribute
                         '', //HTML value
                         '', //HTML title
                         false, //HasMultiplicity
                         false, //IsRequired
                         'singleColumn', //Element type
                         false, //ReadOnly 
                         false); //Hidden


$businessArea = new XMLElement('dadk:', //xml prefix 
                               'businessArea', //Element name 
                               '', //xml-attribute
                               '', //HTML value
                               '', //HTML title
                               false, //HasMultiplicity
                               false, //IsRequired
                               'singleColumn', //Element type
                               false, //ReadOnly 
                               false); //Hidden


$businessAreaCode = new XMLElement('dadk:', //xml prefix 
                                   'businessAreaCode', //Element name 
                                   '', //xml-attribute
                                   '', //HTML value
                                   '', //HTML title
                                   false, //HasMultiplicity
                                   false, //IsRequired
                                   'singleColumn', //Element type
                                   false, //ReadOnly 
                                   false); //Hidden


$dctType = new XMLElement('dct:', //xml prefix 
                          'type', //Element name
                          'http://data.europa.eu/dr8/CoreDataModel', //xml-attribute
                          '', //HTML value
                          '', //HTML title
                          false, //HasMultiplicity
                          false, //IsRequired 
                          'typeColumn', //Element type
                          true, //ReadOnly
                          false); //Hidden


$rdfType = new XMLElement('rdf:', //xml prefix 
                          'type', //Element name
                          array('http://www.w3.org/ns/dcat#Dataset', 'http://www.w3.org/ns/dcat#Distribution'), //xml-attribute
                          '', //HTML value
                          '', //HTML title
                          false, //HasMultiplicity
                          false, //IsRequired 
                          'typeColumn', //Element type
                          true, //ReadOnly
                          false)//Hidden
;  
                   
function getChoices($doc){
    $result = [];

    $xml = new DOMDocument();
    $xml->load($doc);
    $xpath = new DOMXpath($xml);
    $choices = $xpath->query('//rdf:Description[position() > 2]/@rdf:about'); //Find each 

    foreach($choices as $choice){

        preg_match('/#(\S*)/', $choice->nodeValue, $matches, PREG_OFFSET_CAPTURE);
        array_push($result, $matches[1][0]);
    }
    return $result;
}

//Gets the value of an xml-element. 
//Takes two params;
//$choice - an xml-element
//$doc - the xml doc in which the element is present
function getValue($doc, $path){
    $result = [];

    $choices = getChoices($doc);

    for ($i=0; $i < sizeof($choices); $i++) { 
        $tmp = $path . $choices[$i];
        array_push($result, $tmp);    
    }
    return $result;
}

function getDescription($doc, $path){
    $result = [];

    $xml = simplexml_load_file($doc);

    $choices = getChoices($doc);

    for ($i=0; $i < sizeof($choices); $i++) { 
        $tmp = $xml->xpath('/rdf:RDF/rdf:Description[@rdf:about="' . $path . $choices[$i] . '"]/dct:description[@xml:lang="da"]');
        $result = array_merge($result, $tmp);   
    }

    return $result;
}

function getTitle($doc, $path){
    $result = [];

    $xml = simplexml_load_file($doc);

    $choices = getChoices($doc);

    for ($i=0; $i < sizeof($choices); $i++) { 
        $tmp = $xml->xpath('/rdf:RDF/rdf:Description[@rdf:about="' . $path . $choices[$i] . '"]/skos:prefLabel[@xml:lang="da"]');
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

function getFormatValue(){
    $result = [];

    $choices = array('TAR', 'GZIP', 'ZIP', 'AZW', 'EPUB', 'MOBI', 'GIF', 'JPEG', 'TIFF', 'PNG', 'EPS', 'CSS', 'PDF', 'PDFA1A', 'PDFA1B', 'PDFX', 'METS', 'METS_ZIP', 'PPSX', 'PPS', 'PPT', 'PPTX', 'XLS', 'XLSX', 'XLSXFO', 'XSLT', 'DTD_SGML', 'DTD_XML', 'SCHEMA_XML', 'FMX2', 'FMX3', 'FMX4', 'RDF_XML', 'RDF_TURTLE', 'SGML', 'SKOS_XML', 'OWL', 'XML', 'SPARQLQ', 'SPARQLQRES', 'DOC', 'DOCX', 'ODT', 'TXT', 'RTF', 'HTML', 'XHTML', 'CSV', 'MDB', 'DBF', 'MOP', 'E00', 'MXD', 'KML', 'TSV', 'JSON', 'KMZ', 'GML', 'RSS', 'ODS', 'INDD', 'PSD', 'PS', 'ODF', 'TAR_XZ', 'TAR_GZ', 'RDF', 'XLIFF', 'OVF', 'JSON_LD', 'RDF_N_TRIPLES', 'HDF', 'NETCDF', 'SDMX', 'JPEG2000', 'SHP', 'GDB', 'GMZ', 'ECW', 'GRID_ASCII', 'DMP', 'LAS', 'LAZ', 'TAB', 'TAB_RSTR', 'WORLD', 'TMX', 'ATOM', 'OCTET', 'BIN', 'ODC', 'ODB', 'ODG', 'BMP', 'DCR', 'XYZ', 'MAP_PRVW', 'MAP_SRVC', 'REST', 'MSG_HTTP', 'TIFF_FX', 'PDF1X', 'WARC_GZ', 'RDF_N_QUADS', 'RDF_TRIG', 'RDFA', 'ARC', 'HTML_SIMPL', 'XHTML_SIMPL', 'SQL', 'PDFA2A', 'PDFA2B', 'PDFA3', 'MBOX', 'MPEG2', 'MPEG4', 'MPEG4_AVC', 'BWF', 'MHTML', 'ARC_GZ', 'WARC', 'PDFX1A', 'PDFX2A', 'PDFX4', 'GEOJSON', 'GRID', 'JATS', 'BTIS', 'PWP', 'OP_DATPRO');

    for ($i=0; $i < sizeof($choices); $i++) { 
        $tmp = 'http://publications.europa.eu/resource/authority/file-type/' . $choices[$i];
        array_push($result, $tmp);    
    }

    return $result;
}

function getFormatDescriptions(){
    $result = [];
    $xml = simplexml_load_file('../../filetypes-skos.rdf');

    $attr = array('TAR', 'GZIP', 'ZIP', 'AZW', 'EPUB', 'MOBI', 'GIF', 'JPEG', 'TIFF', 'PNG', 'EPS', 'CSS', 'PDF', 'PDFA1A', 'PDFA1B', 'PDFX', 'METS', 'METS_ZIP', 'PPSX', 'PPS', 'PPT', 'PPTX', 'XLS', 'XLSX', 'XLSXFO', 'XSLT', 'DTD_SGML', 'DTD_XML', 'SCHEMA_XML', 'FMX2', 'FMX3', 'FMX4', 'RDF_XML', 'RDF_TURTLE', 'SGML', 'SKOS_XML', 'OWL', 'XML', 'SPARQLQ', 'SPARQLQRES', 'DOC', 'DOCX', 'ODT', 'TXT', 'RTF', 'HTML', 'XHTML', 'CSV', 'MDB', 'DBF', 'MOP', 'E00', 'MXD', 'KML', 'TSV', 'JSON', 'KMZ', 'GML', 'RSS', 'ODS', 'INDD', 'PSD', 'PS', 'ODF', 'TAR_XZ', 'TAR_GZ', 'RDF', 'XLIFF', 'OVF', 'JSON_LD', 'RDF_N_TRIPLES', 'HDF', 'NETCDF', 'SDMX', 'JPEG2000', 'SHP', 'GDB', 'GMZ', 'ECW', 'GRID_ASCII', 'DMP', 'LAS', 'LAZ', 'TAB', 'TAB_RSTR', 'WORLD', 'TMX', 'ATOM', 'OCTET', 'BIN', 'ODC', 'ODB', 'ODG', 'BMP', 'DCR', 'XYZ', 'MAP_PRVW', 'MAP_SRVC', 'REST', 'MSG_HTTP', 'TIFF_FX', 'PDF1X', 'WARC_GZ', 'RDF_N_QUADS', 'RDF_TRIG', 'RDFA', 'ARC', 'HTML_SIMPL', 'XHTML_SIMPL', 'SQL', 'PDFA2A', 'PDFA2B', 'PDFA3', 'MBOX', 'MPEG2', 'MPEG4', 'MPEG4_AVC', 'BWF', 'MHTML', 'ARC_GZ', 'WARC', 'PDFX1A', 'PDFX2A', 'PDFX4', 'GEOJSON', 'GRID', 'JATS', 'BTIS', 'PWP', 'OP_DATPRO');

    for ($i=0; $i < sizeof($attr); $i++) { 
        $tmp = $xml->xpath('/rdf:RDF/skos:Concept[@rdf:about="http://publications.europa.eu/resource/authority/file-type/' . $attr[$i] . '"]/skos:prefLabel[@xml:lang="en"]');
        $result = array_merge($result, $tmp);   
    }

    return $result;
}

function getFormatTitle(){
    $result = [];
    $xml = simplexml_load_file('../../filetypes-skos.rdf');

    $choices = array('TAR', 'GZIP', 'ZIP', 'AZW', 'EPUB', 'MOBI', 'GIF', 'JPEG', 'TIFF', 'PNG', 'EPS', 'CSS', 'PDF', 'PDFA1A', 'PDFA1B', 'PDFX', 'METS', 'METS_ZIP', 'PPSX', 'PPS', 'PPT', 'PPTX', 'XLS', 'XLSX', 'XLSXFO', 'XSLT', 'DTD_SGML', 'DTD_XML', 'SCHEMA_XML', 'FMX2', 'FMX3', 'FMX4', 'RDF_XML', 'RDF_TURTLE', 'SGML', 'SKOS_XML', 'OWL', 'XML', 'SPARQLQ', 'SPARQLQRES', 'DOC', 'DOCX', 'ODT', 'TXT', 'RTF', 'HTML', 'XHTML', 'CSV', 'MDB', 'DBF', 'MOP', 'E00', 'MXD', 'KML', 'TSV', 'JSON', 'KMZ', 'GML', 'RSS', 'ODS', 'INDD', 'PSD', 'PS', 'ODF', 'TAR_XZ', 'TAR_GZ', 'RDF', 'XLIFF', 'OVF', 'JSON_LD', 'RDF_N_TRIPLES', 'HDF', 'NETCDF', 'SDMX', 'JPEG2000', 'SHP', 'GDB', 'GMZ', 'ECW', 'GRID_ASCII', 'DMP', 'LAS', 'LAZ', 'TAB', 'TAB_RSTR', 'WORLD', 'TMX', 'ATOM', 'OCTET', 'BIN', 'ODC', 'ODB', 'ODG', 'BMP', 'DCR', 'XYZ', 'MAP_PRVW', 'MAP_SRVC', 'REST', 'MSG_HTTP', 'TIFF_FX', 'PDF1X', 'WARC_GZ', 'RDF_N_QUADS', 'RDF_TRIG', 'RDFA', 'ARC', 'HTML_SIMPL', 'XHTML_SIMPL', 'SQL', 'PDFA2A', 'PDFA2B', 'PDFA3', 'MBOX', 'MPEG2', 'MPEG4', 'MPEG4_AVC', 'BWF', 'MHTML', 'ARC_GZ', 'WARC', 'PDFX1A', 'PDFX2A', 'PDFX4', 'GEOJSON', 'GRID', 'JATS', 'BTIS', 'PWP', 'OP_DATPRO');

    for ($i=0; $i < sizeof($choices); $i++) { 
        $tmp = $xml->xpath('/rdf:RDF/skos:Concept[@rdf:about="http://publications.europa.eu/resource/authority/file-type/' . $choices[$i] . '"]/dc:identifier');
        $result = array_merge($result, $tmp);   
    }

    return $result;
}
?>