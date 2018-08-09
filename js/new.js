//Dynamicly add more input fields for input groups with the .entry class
$( document ).ready(function() {

  document.getElementById("overlay").style.display = "none";

  $("#wizard").steps();

  var modelGeneratorFirstEntry = $('.modelGeneratorFirst');
  var modelGeneratorSecondEntry = $('.modelGeneratorSecond');

  $.post(
    "../new/generateHTML.php",
    {data: "ModelForm", num: "first"},
    function(data, status){
      modelGeneratorFirstEntry.append(data);
    });

  $.post(
    "../new/generateHTML.php",
    {data: "ModelForm", num: "second"},
    function(data, status){
      modelGeneratorSecondEntry.append(data);
    });

  var distributionGeneratorFirstEntry = $('.distributionGeneratorFirst');
  var distributionGeneratorSecondEntry = $('.distributionGeneratorSecond');

  $.post(
    "../new/generateHTML.php",
    {data: "DistributionForm", num: "first"},
    function(data, status){
      distributionGeneratorFirstEntry.append(data);
    });

  $.post(
    "../new/generateHTML.php",
    {data: "DistributionForm", num: "second"},
    function(data, status){
      distributionGeneratorSecondEntry.append(data);
    });
});

//Click event handler
$(document).click(function(event) {
  console.log(event.target);
  if($(event.target).hasClass('dropdown-item')) //If click target is a dropdown item, set the innerhtml, value and data-* attributes of the parent
  {
    $( event.target ).parent().parent().css('z-index', 'auto');
    $( event.target ).parent().parent().children(':first-child').text($(event.target).text());
    $( event.target ).parent().parent().children(':first-child').attr('Value', ($(event.target).text()));
    $( event.target ).parent().parent().children(':first-child').data('foo', ($(event.target).data('foo')));
  }
  else if($(event.target).hasClass('dropdown-toggle')){
    console.log('TEST');
    $( event.target ).parent().css('z-index', 10);
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

//Form validation
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
    console.log($(this).parent().next());
  });

  var json = JSON.stringify(inputs, null, 2)

  console.log(json);

  //Ajax post call to the generateXML.php script which appends the values from the form to an xml document.
  $.post(
    "generateXML.php",   
    {data: json},
    function(data, status){alert("Data: " + data + "\nStatus: " + status)}
  );
}; 

var scroll;
//Scroll event handler. Dynamically moves the input input box along wiht the scroll bar
$( window ).scroll(function() {
  scroll = $(this).scrollTop();
  $(".expanded-input textarea").css("top", scroll);
});

var selectedInput;
//When input field is focused expand to textarea
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

//When textarea loose focus remove overlay and save changes
function lostFocus(sender){
  document.getElementById("overlay").style.display = "none";
  console.log($(sender).val());
  $(selectedInput).prop('disabled', false);
  selectedInput.attr('value', $(sender).val());
  selectedInput.text($(sender).val());
  sender.value = '';
  $('.expanded-input').css('visibility', 'hidden');
}