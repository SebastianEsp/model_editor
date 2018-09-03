<?php

$genType = $_POST['data'];
$genNum = $_POST['num'];
$elements;

//Creates a dropdown menu element. 
//The dropdown is sectioned into three parts: starting tags defining the dropdown menu, menu-items and closing tags
function generateDropdown($element){

    
    $dropdown_1 =  '<div class="dropdown dropdown-scroll-new">
                    <a class="btn btn-secondary dropdown-toggle inputField" href="#" name="'. $element->prefix . $element->name .'" role="input" id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">                
                        Attribute
                    </a>
                    <div class="dropdown-menu dropdown-menu-new" aria-labelledby="dropdown">'; 
    
    $dropdown_2 = '';
    for ($i=0; $i < sizeof($element->attribute); $i++) { 

        $dropdown_2 = $dropdown_2 . '<a class="dropdown-item dropdown-item-new" title="'. $element->titelLabel[$i]  .'" href="javascript:;" data-foo="'. $element->value[$i]  .'">' . $element->attribute[$i] .'</a>';
    }
    
    $dropdown_3 = '</div>
                </div>';

    $dropdown_final = $dropdown_1 . $dropdown_2 . $dropdown_3;

    return $dropdown_final;
}

//Generate a form creating either a model or a distribution
switch($genType){
    case 'ModelForm':
        generateModelForm();
        break;
    case 'DistributionForm':
        generateDistributionForm();
        break;
}

//Generate the first half of the form
function genFirst($elements){
    for ($i=0; $i < round(sizeof($elements)/2); $i++) { 
        generateElement($elements[$i]);
    }
}

//Generate the second half of the form
function genSecond($elements){
    for ($i=round(sizeof($elements)/2); $i < sizeof($elements); $i++) { 
        generateElement($elements[$i]);
    }
}

//Called when generationg the form for creating a distribution
function generateDistributionForm(){

    include_once 'elementModel.php';
    global $genNum;

    global $elements; 
    $elements = array($title, $description, $accessURL, $fileSize, $format, $rdfType, $issued, $license);

    switch($genNum){
        case 'first':
            genFirst($elements);
            break;
        case 'second':
            genSecond($elements);
            break;
    }
}

//Called when generationg the form for creating a model
function generateModelForm(){

    include_once 'elementModel.php';
    global $genNum;

    global $elements;

    $elements = array($title, $description, $preferredNamespacePrefix, $preferredNamespaceUri, $altLabel, 
    $keyword, $versionNotes, $versionInfo, /*$identifier,*/ $issued, $modified, /*$contactPoint,*/ $page, $landingPage,
    $publisher, /*$dataset,*/ $hasVersion, $isVersionOf, $rdfType, $dctType, $license, $rights, $modelType, $modellingRegime, $modellingLevel, $businessArea, $businessAreaCode, $theme, $distribution);

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
    global $elements;

        //Generate html element with two input fields for xml attribute and value
        if( $element->columns == 'doubleColumn'){
            echo '
            <div class="form-group row no-gutters" > <!--Standard form group with two inputs-->
                <label class="col-sm-2 col-form-label col-form-label-sm" for="'. $element->name .'_attribute_input">'. $element->name . (($element->isRequired==true)?'*':'') .'</label>
                <div class="input-group col-sm-10" >'
                    .((is_array($element->attribute) == false)?'<input type="text" name="'. $element->prefix . $element->name .'" class="form-control form-control-sm inputField"' .(($element->value=='date')?'':/*'onfocus="expandInput(this)"'*/'') . 'id="'. $element->name .'_attribute_input" ' . ((is_array($element->attribute))?'value='. "'" . (string)$element->attribute[0] . "'" .'':'value='. "'" . (string)$element->attribute . "'" .'') . ' ' . (($element->readOnly==true)?'disabled="disabled"':'') . ' ' . (($element->hidden==true)?'hidden="true"':'') . '>':generateDropdown($element)) .
                    '<input type="'.(($element->value=='date')?'date':'text').'" ' .(($element->value=='date')?'':/*'onfocus="expandInput(this)"'*/'') .' class="form-control form-control-sm inputField" id="'. $element->name .'_value_input" value="">
                </div>
            </div>';
        //Generate html element with a single input field for either xml attribute or value
        }else if($element->columns == 'singleColumn'){
            echo ' 
            <div class="form-group row no-gutters"> <!--type-->  
            <label class="col-sm-2 col-form-label col-form-label-sm" for="'. $element->name .'_attribute_input">' . $element->name . (($element->isRequired==true)?'*':'') .'</label>
                <div class="input-group col-sm-10"> 
                        <input type="'.(($element->value=='date')?//If value field is == date, create add a datepicker
                            'date'
                        :'text').//Else mark as text element
                        '" name="'. $element->prefix . $element->name .'" class="form-control form-control-sm inputField" '.(($element->value=='date')?'':/*'onfocus="expandInput(this)"'*/'') .'id="'. $element->name .'_attribute_input"' . ((is_array($element->attribute))?'value='. "'" . (string)$element->attribute[0] . "'" .'':'value='. "'" . (string)$element->attribute . "'" .'') . ' ' . (($element->readOnly==true)?'disabled':'').'>
                </div>
            </div>';
        }else if($element->columns == 'typeColumn'){ //Special case for the type fields
                echo ' 
                <div class="form-group row no-gutters"> <!--type-->  
                <label class="col-sm-2 col-form-label col-form-label-sm" for="'. $element->name .'_attribute_input">' . $element->prefix . $element->name . (($element->isRequired==true)?'*':'') .'</label>
                    <div class="input-group col-sm-10"> 
                            <input type="text" name="'. $element->prefix . $element->name .'" class="form-control form-control-sm inputField" id="'. $element->name .'_attribute_input" value="'.((is_array($element->attribute))?''.((sizeof($elements) > 10))?(string)$element->attribute[0]:(string)$element->attribute[1].'':(string)$element->attribute).'" ' . (($element->readOnly==true)?'disabled':'').'>
                    </div>
                </div>';
        //Generate html element with two input fields for xml attribute and value and a button to dynamically add additional copies of this element
        }else if($element->columns == 'singleDropdown'){
            echo ' 
            <div class="form-group row no-gutters"> <!--type-->  
            <label class="col-sm-2 col-form-label col-form-label-sm" for="'. $element->name .'_attribute_input">' . $element->name . (($element->isRequired==true)?'*':'') .'</label>
                <div class="input-group col-sm-10">'
                    .generateDropdown($element).
                '</div>
            </div>';
        }else if($element->columns == 'buttonDouble'){
            echo '
            <div class="form-group row no-gutters justify-content-end"> <!--Form group with dynamic adding and removal of inputs-->
                <label class="col-sm-2 col-form-label col-form-label-sm" for="'. $element->name .'_attribute_input">'. $element->name . (($element->isRequired==true)?'*':'') .'</label>
                <div class="input-group entry col-sm-10 attribute_input">'
                    .((is_array($element->attribute) == false)? '<input type="text" name="'. $element->prefix . $element->name .'" class="form-control form-control-sm inputField" '.(($element->value=='date')?'':/*'onfocus="expandInput(this)"'*/'') .' id="'. $element->name .'_attribute_input"' . ((is_array($element->attribute))?'value='. "'" . (string)$element->attribute[0] . "'" .'':'value='. "'" . (string)$element->attribute . "'" .'') . ' >':generateDropdown($element)) .
                    '<input type="text" class="form-control form-control-sm inputField" '.(($element->value=='date')?'':/*'onfocus="expandInput(this)"'*/'') .' id="'. $element->name .'_value_input"  ' . ((is_array($element->attribute) && sizeOf($element->attribute)==1)?'value='. "'" . (string)$element->attribute[0] . "'" .'':'') . '>
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
                    <input type="text" name="'. $element->prefix . $element->name .'" class=" form-control form-control-sm inputField attribute_input" '.(($element->value=='date')?'':/*'onfocus="expandInput(this)"'*/'') .' id="'. $element->name .'_input" >
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
                            <input type="text" name="'. $element->prefix . $element->name .'" class="form-control form-control-sm inputField" '.(($element->value=='date')?'':/*'onfocus="expandInput(this)"'*/'') .' id="'. $element->name .'_attribute_input" ' . ((is_array($element->attribute))?'value='. "'" . (string)$element->attribute[0] . "'" .'':'value='. "'" . (string)$element->attribute . "'" .'') . ' ' . (($element->readOnly==true)?'disabled="disabled"':'') . '>
                            <input type="text" class="form-control form-control-sm inputField" '.(($element->value=='date')?'':/*'onfocus="expandInput(this)"'*/'') .' id="'. $element->name .'_value_input"  value="">
                        </div>
                            
                        <div class="w-100"></div>

                        <span class="col-2"></span>
                        <div class="col-12 input-group no-padding">
                            <input type="text" name="'. $element->prefix . $element->name .'" class="form-control form-control-sm inputField" '.(($element->value=='date')?'':/*'onfocus="expandInput(this)"'*/'') .'id="'. $element->name .'_attribute_input" ' . ((is_array($element->attribute))?'value='. "'" . (string)$element->attribute[1] . "'" .'':'value='. "'" . (string)$element->attribute . "'" .'') . ' ' . (($element->readOnly==true)?'disabled="disabled"':'') . '>
                            <input type="text" class="form-control form-control-sm inputField" '.(($element->value=='date')?'':/*'onfocus="expandInput(this)"'*/'') .'id="'. $element->name .'_value_input"  value="">
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
                            <input type="text" name="'. $element->prefix . $element->name .'" class="form-control form-control-sm inputField attribute_input" '.(($element->value=='date')?'':/*'onfocus="expandInput(this)"'*/'') .' id="'. $element->name .'_attribute_input" ' . ' ' . ((is_array($element->attribute))?'value='. "'" . (string)$element->attribute[0] . "'" .'':'value='. "'" . (string)$element->attribute . "'" .'') . (($element->readOnly==true)?'disabled="disabled"':'') . '>
                            <input type="text" class="form-control form-control-sm inputField" '.(($element->value=='date')?'':/*'onfocus="expandInput(this)"'*/'') .' id="'. $element->name .'_value_input"  value="">
                        </div>

                        <div class="w-100"></div>

                        <span class="col-2"></span>
                        <div class="input-group col-12">
                            <input type="text" name="'. $element->prefix . $element->name .'" class="form-control form-control-sm inputField attribute_input" '.(($element->value=='date')?'':/*'onfocus="expandInput(this)"'*/'') .' id="'. $element->name .'_attribute_input" ' . ' ' . ((is_array($element->attribute))?'value='. "'" . (string)$element->attribute[1] . "'" .'':'value='. "'" . (string)$element->attribute . "'" .'') . (($element->readOnly==true)?'disabled="disabled"':'') . '>
                            <input type="text" class="form-control form-control-sm inputField" '.(($element->value=='date')?'':/*'onfocus="expandInput(this)"'*/'') .' id="'. $element->name .'_value_input"  value="">
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