<?php

$genType = $_POST['data'];
$genNum = $_POST['num'];

function generateDropdown($element){

    $dropdown_1 =  '<div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle inputField" href="#" name="'. $element->prefix . $element->name .'" role="input" id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">                
                        Attribute
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdown">'; 
    
    $dropdown_2 = '';
    for ($i=0; $i < sizeof($element->attribute); $i++) { 
        //$tmp .= $element.getValue('Model');

        $dropdown_2 = $dropdown_2 . '<a class="dropdown-item" title="'. $element->descriptionLabel[$i]  .'" href="javascript:;" >' . $element->attribute[$i] .'</a>';
    }
    
    $dropdown_3 = '</div>
                </div>';

    $dropdown_final = $dropdown_1 . $dropdown_2 . $dropdown_3;

    return $dropdown_final;
}

switch($genType){
    case 'ModelForm':
        generateModelForm();
        break;
    case 'DistributionForm':
        generateDistributionForm();
        break;
}

function genFirst($elements){
    for ($i=0; $i < round(sizeof($elements)/2); $i++) { 
        generateElement($elements[$i]);
    }
}

function genSecond($elements){
    for ($i=round(sizeof($elements)/2); $i < sizeof($elements); $i++) { 
        generateElement($elements[$i]);
    }
}

function generateDistributionForm(){

    include_once 'elementModel.php';
    global $genNum;

    $elements = array($title, $description, $accessURL, $fileSize, $type, $issued, $license, $format);

    switch($genNum){
        case 'first':
            genFirst($elements);
            break;
        case 'second':
            genSecond($elements);
            break;
    }
}

function generateModelForm(){

    include_once 'elementModel.php';
    global $genNum;

    $elements = array($title, $description, $preferredNamespacePrefix, $preferredNamespaceUri, $altLabel, 
    $keyword, $versionNotes, $versionInfo, $identifier, $issued, $modified, $contactPoint, $page, $landingPage,
    $publisher, $dataset, $hasVersion, $isVersionOf, $type, $modellingRegime, $modellingLevel, $theme, $distribution);

    switch($genNum){
        case 'first':
            genFirst($elements);
            break;
        case 'second':
            genSecond($elements);
            break;
    }
}

//Based on the provided $element, the function will generate the proper html element.
//An element may be labeled as required, as well as contain a drop down list as defined by the inline if expressions
function generateElement($element){
    global $dropdown;

        //Generate html element with two input fields for xml attribute and value
        if( $element->columns == 'doubleColumn'){
            echo '
            <div class="form-group row no-gutters" > <!--Standard form group with two inputs-->
                <label class="col-sm-2 col-form-label col-form-label-sm" for="'. $element->name .'_attribute_input">'. $element->name . (($element->isRequired==true)?'*':'') .'</label>
                <div class="input-group col-sm-10" >'
                    .((is_array($element->attribute) == false)?'<input type="text" name="'. $element->prefix . $element->name .'" class="form-control form-control-sm inputField" id="'. $element->name .'_attribute_input" ' . ((is_array($element->attribute))?'value='. "'" . (string)$element->attribute[0] . "'" .'':'value='. "'" . (string)$element->attribute . "'" .'') . ' placeholder="Attribute"' . (($element->readOnly==true)?'disabled="disabled"':'') . ' ' . (($element->hidden==true)?'hidden="true"':'') . '>':generateDropdown($element)) .
                    '<input type="'.(($element->value=='date')?'date':'text').'" class="form-control form-control-sm inputField" id="'. $element->name .'_value_input" placeholder="Value" value="">
                </div>
            </div>';
        //Generate html element with a single input field for either xml attribute or value
        }else if($element->columns == 'singleColumn'){
            echo ' 
            <div class="form-group row no-gutters"> <!--type-->  
            <label class="col-sm-2 col-form-label col-form-label-sm" for="'. $element->name .'_attribute_input">' . $element->name . (($element->isRequired==true)?'*':'') .'</label>
                <div class="input-group col-sm-10">'
                .((is_array($element->attribute) == false)? '<input type="'.(($element->value=='date')?'date':'text').'" name="'. $element->prefix . $element->name .'" class="form-control form-control-sm inputField" id="'. $element->name .'_attribute_input"' . ((is_array($element->attribute))?'value='. "'" . (string)$element->attribute[0] . "'" .'':'value='. "'" . (string)$element->attribute . "'" .'') . ' placeholder="Attribute">':generateDropdown($element)) .'       
                </div>
            </div>';
        //Generate html element with two input fields for xml attribute and value and a button to dynamically add additional copies of this element
        }else if($element->columns == 'buttonDouble'){
            echo '
            <div class="form-group row no-gutters justify-content-end"> <!--Form group with dynamic adding and removal of inputs-->
                <label class="col-sm-2 col-form-label col-form-label-sm" for="'. $element->name .'_attribute_input">'. $element->name . (($element->isRequired==true)?'*':'') .'</label>
                <div class="input-group entry col-sm-10 attribute_input">'
                    .((is_array($element->attribute) == false)? '<input type="text" name="'. $element->prefix . $element->name .'" class="form-control form-control-sm inputField" id="'. $element->name .'_attribute_input"' . ((is_array($element->attribute))?'value='. "'" . (string)$element->attribute[0] . "'" .'':'value='. "'" . (string)$element->attribute . "'" .'') . ' placeholder="Attribute">':generateDropdown($element)) .
                    '<input type="text" class="form-control form-control-sm inputField" id="'. $element->name .'_value_input" placeholder="Value" ' . ((is_array($element->attribute) && sizeOf($element->attribute)==1)?'value='. "'" . (string)$element->attribute[0] . "'" .'':'') . '>
                    <button class="btn btn-success btn-add" type="button" tabindex="-1">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>';
        //Generate html element with a single input field for xml attribute or value and a button to dynamically add additional copies of this element
         }else if($element->columns == 'buttonSingle'){
            echo '
            <div class="form-group row no-gutters justify-content-end">
                <label class="col-sm-2 col-form-label col-form-label-sm" for="'. $element->name .'_input">'. $element->name . (($element->isRequired==true)?'*':'') .'</label>
                <div class="input-group entry col-sm-10">
                    <input type="text" name="'. $element->prefix . $element->name .'" class=" form-control form-control-sm inputField attribute_input" id="'. $element->name .'_input" placeholder="Attribute">
                    <button class="btn btn-success btn-add" type="button" tabindex="-1">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>';
         }else if( $element->columns == 'doubleRow'){
            echo '
            <div>
            <div class="form-group row no-gutters justify-content-end" > <!--Standard form group with two inputs-->
                 <div class="col">   
                    <div class="form-group row no-gutters justify-content-end"> 
                        <label class="col-2 col-form-label col-form-label-sm" for="'. $element->name .'_attribute_input">'. $element->name . (($element->isRequired==true)?'*':'') .'</label> 
                        <span class="col">
                        <div class="input-group col-12 no-padding">
                            <input type="text" name="'. $element->prefix . $element->name .'" class="form-control form-control-sm inputField" id="'. $element->name .'_attribute_input" ' . ((is_array($element->attribute))?'value='. "'" . (string)$element->attribute[0] . "'" .'':'value='. "'" . (string)$element->attribute . "'" .'') . ' placeholder="Attribute"' . (($element->readOnly==true)?'disabled="disabled"':'') . '>
                            <input type="text" class="form-control form-control-sm inputField" id="'. $element->name .'_value_input" placeholder="Value" value="">
                        </div>
                            
                        <div class="w-100"></div>

                        <span class="col-2"></span>
                        <div class="col-12 input-group no-padding">
                            <input type="text" name="'. $element->prefix . $element->name .'" class="form-control form-control-sm inputField" id="'. $element->name .'_attribute_input" ' . ((is_array($element->attribute))?'value='. "'" . (string)$element->attribute[1] . "'" .'':'value='. "'" . (string)$element->attribute . "'" .'') . ' placeholder="Attribute"' . (($element->readOnly==true)?'disabled="disabled"':'') . '>
                            <input type="text" class="form-control form-control-sm inputField ' .(($element->value=='date')?'datepicker':'') .'" id="'. $element->name .'_value_input" placeholder="Value" value="">
                        </div>
                        </span>
                    </div>
                </div>    
            </div>
            </div>';
         }
         else if( $element->columns == 'buttonDoubleRow'){
            echo '
            <div>
            <div class="form-group row no-gutters justify-content-end entry"> <!--Form group with dynamic adding and removal of inputs-->
                <div class="col">
                    <div class="form-group row no-gutters justify-content-end">
                        <label class="col-2 col-form-label col-form-label-sm" for="'. $element->name .'_attribute_input">'. $element->name . (($element->isRequired==true)?'*':'') .'</label>
                        <span class="col">
                        <div class="input-group col-12">
                            <input type="text" name="'. $element->prefix . $element->name .'" class="form-control form-control-sm inputField attribute_input" id="'. $element->name .'_attribute_input" ' . ' placeholder="Attribute"' . ((is_array($element->attribute))?'value='. "'" . (string)$element->attribute[0] . "'" .'':'value='. "'" . (string)$element->attribute . "'" .'') . (($element->readOnly==true)?'disabled="disabled"':'') . '>
                            <input type="text" class="form-control form-control-sm inputField" id="'. $element->name .'_value_input" placeholder="Value" value="">
                        </div>

                        <div class="w-100"></div>

                        <span class="col-2"></span>
                        <div class="input-group col-12">
                            <input type="text" name="'. $element->prefix . $element->name .'" class="form-control form-control-sm inputField attribute_input" id="'. $element->name .'_attribute_input" ' . ' placeholder="Attribute"' . ((is_array($element->attribute))?'value='. "'" . (string)$element->attribute[1] . "'" .'':'value='. "'" . (string)$element->attribute . "'" .'') . (($element->readOnly==true)?'disabled="disabled"':'') . '>
                            <input type="text" class="form-control form-control-sm inputField" id="'. $element->name .'_value_input" placeholder="Value" value="">
                        </div>
                        </span>
                    </div>
                </div>
                <div style="padding-top: 5px;">
                    <button class="btn btn-success btn-double-add" style="height: 100%;" type="button" tabindex="-1">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            </div>';
         }
    }
?>