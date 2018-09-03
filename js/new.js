//On document ready
$( document ).ready(function() {

  //Disable overlay
  document.getElementById("overlay").style.display = "none";

  //Init the 
  $("#wizard").steps();

  var modelGeneratorFirstEntry = $('.modelGeneratorFirst');
  var modelGeneratorSecondEntry = $('.modelGeneratorSecond');

  //Ajax post call to generate the first half of the model form
  $.post(
    "../new/generateHTML.php",
    {data: "ModelForm", num: "first"},
    function(data, status){
      modelGeneratorFirstEntry.append(data);
    });

  //Ajax post call to generate the second half of the model form
  $.post(
    "../new/generateHTML.php",
    {data: "ModelForm", num: "second"},
    function(data, status){
      modelGeneratorSecondEntry.append(data);
    });

  var distributionGeneratorFirstEntry = $('.distributionGeneratorFirst');
  var distributionGeneratorSecondEntry = $('.distributionGeneratorSecond');

  //Ajax post call to generate the second half of the form
  $.post(
    "../new/generateHTML.php",
    {data: "DistributionForm", num: "first"},
    function(data, status){
      distributionGeneratorFirstEntry.append(data);
    });

  //Ajax post call to generate the first second of the form
  $.post(
    "../new/generateHTML.php",
    {data: "DistributionForm", num: "second"},
    function(data, status){
      distributionGeneratorSecondEntry.append(data);
    });
});

//Click event handler
$(document).click(function(event) {
  if($(event.target).hasClass('dropdown-item')) //If click target is a dropdown item, set the innerhtml, value and data-* attributes of the parent
  {
    $( event.target ).parent().parent().css('z-index', 'auto');
    $( event.target ).parent().parent().children(':first-child').text($(event.target).text());
    $( event.target ).parent().parent().children(':first-child').attr('Value', ($(event.target).text()));
    $( event.target ).parent().parent().children(':first-child').data('foo', ($(event.target).data('foo')));
  }
  else if($(event.target).hasClass('dropdown-toggle')){ //If click target is a dropdown menu, push in front of other elements.
    $( event.target ).parent().css('z-index', 10);
  }
  else if($(event.target).attr('href') == '#next'){
    distLink();
  }
});

//On lost focus
$(document).focusout(function(event) {
  //If dropdown menu losses focus, push dropdown menu back behind table.
  if($(event.target).hasClass('dropdown-toggle'))
  {
      $('.header-container').css('z-index', '0');
  }
});

$(function()
{
    $(document).on('click', '.btn-add', function(e) //On Click event for buttons belonging to elements with one element
    {
        e.preventDefault();

        //Find element with class "entry" within the form. Make a copy of the input group and append to parent 
        var controlForm = $('.xmlForm form:first'),
            currentEntry = $(this).parent('.entry:first'),
            newEntry = $(currentEntry.clone().appendTo(currentEntry.parent()));

        //If button is not the first element define as remove button. 
        //This ensures that the first button within an input group as can add aditional fields, and that all other buttons can remove their respctive field.
        newEntry.find('input').val('');
        currentEntry.parent().find('.entry:not(:first) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<i class="fas fa-minus"></i>');
    }).on('click', '.btn-double-add', function(e) //On Click event for buttons belonging to elements with two elements
    {
      e.preventDefault();

      //Find element with class "entry" within the form. Make a copy of the input group and append to parent 
      var controlForm = $('.xmlForm form:first'),
          currentEntry = $(this).parent().parent('.entry:first'),
          tmp = $(currentEntry.parent().append('<div class="w-100"></div>')),
          newEntry = $(currentEntry.clone().appendTo(currentEntry.parent()));

      //Find each input field of the new element. If the disabled property is not set the value should be removed
      //This means that an element with already filled out fields will not have their values copied unless, the input field is marked disabled
      newEntry.find('input').each(function() {
        if($(this).prop('disabled') == false){ //TODO Fix wrongful removal of value when expanded textarea is used.
          //console.log($(this));
          //$(this).val('');
        }  
      });

      //Remove the label text for all children so only one label is displayed per form-group
      $(this).parent().parent().parent().find('label').last().text('');

      //If button is not the first element define as remove button.
      currentEntry.parent().find('.entry:not(:first) .btn-double-add')
          .removeClass('btn-double-add').addClass('btn-double-remove')
          .removeClass('btn-success').addClass('btn-danger')
          .html('<i class="fas fa-minus"></i>');
    }).on('click', '.btn-remove', function(e)
    {
		$(this).parent('.entry:first').remove();

		e.preventDefault();
		return false;
	}).on('click', '.btn-double-remove', function(e){
    console.log($(this).parent().parent())
		$(this).parent().parent('.entry:first').remove();

		e.preventDefault();
		return false;
  });
});

//Bootstrap form validation
(function() {
  'use strict';
  window.addEventListener('load', function() {
    var forms = document.getElementsByClassName('needs-validation');
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

//ajax callback
function submitForm(btn){
  
  var inputs = [];
  //Find each input field in the Form. If the element contains a name, add the name, attribute and value paramaters to the inputs array.
  //Each entry in the inputs array corresponds to a single element in the xml document

  $(btn).find('.inputField').each(function(){
    if($(this).attr('name') != null){

      if($(this).prop('tagName') == 'A'){ //If element is a dropdown menu item
        inputs.push({
          key: $(this).attr('name'),
          attribute: $(this).data('foo'),
          value: $(this).parent().next().data('foo')
        })
      }else if($(this).prop('tagName') == 'INPUT'){ //If element is an input field
        inputs.push({
          key: $(this).attr('name'),
          attribute: $(this).val(),
          value: $(this).next().val()
        })
      }
    }
  });

  //Convert array to json to send to php via ajax
  var json = JSON.stringify(inputs, null, 2)

  //Ajax post call to the generateXML.php script which appends the values from the form to an xml document.
  $.post(
    "generateXML.php",   
    {data: json},
    function(data, status){
      if(status == 'success'){
        alert('The model was added successfully')
      }
    }
  );
}; 

var scroll;
//Scroll event handler. Dynamically moves the input box along wiht the scroll bar
$( window ).scroll(function() {
  scroll = $(this).scrollTop();
  $(".expanded-input textarea").css("top", scroll);
});

var selectedInput;
//When an input field is focused add overlay and expand to textarea
function expandInput(sender){
  document.getElementById("overlay").style.display = "block";
  selectedInput = $(sender);
  var selectedVal = sender.value;
  console.log(selectedInput);
  $(selectedInput).prop('disabled', true);
  $('.expanded-input textarea').val(selectedVal);
  $('.expanded-input').css('visibility', 'visible');
  $(".expanded-input textarea").css("top", scroll);
}

//When textarea loose focus remove overlay and save changes from textarea to input field.
function lostFocus(sender){
  document.getElementById("overlay").style.display = "none";
  console.log($(sender).val());
  $(selectedInput).prop('disabled', false);
  selectedInput.attr('value', $(sender).val());
  selectedInput.text($(sender).val());
  sender.value = '';
  $('.expanded-input').css('visibility', 'hidden');
}

//Links the value from the distribution field to the accessURL field
function distLink(){
  if($('#distribution_input').val() != ''){
    $('#accessURL_attribute_input').val($('#distribution_input').val());
  }
}

function viewOutput(){
  var win = window.open('https://data.gov.dk/test/catalogue/models/xml/modelkatalog.rdf.xml#FOAF', '_blank');
  win.focus();
}
