//Dynamicly add more input fields for input groups with the .entry class
$( document ).ready(function() {
  $("#wizard").steps();

  var modelGeneratorFirstEntry = $('.modelGeneratorFirst');
  var modelGeneratorSecondEntry = $('.modelGeneratorSecond');

  $.post(
    "generateHTML.php",
    {data: "ModelForm", num: "first"},
    function(data, status){
      modelGeneratorFirstEntry.append(data);
    });

    $.post(
      "generateHTML.php",
      {data: "ModelForm", num: "second"},
      function(data, status){
        modelGeneratorSecondEntry.append(data);
      });

  var distributionGeneratorFirstEntry = $('.distributionGeneratorFirst');
  var distributionGeneratorSecondEntry = $('.distributionGeneratorSecond');

  $.post(
    "generateHTML.php",
    {data: "DistributionForm", num: "first"},
    function(data, status){
      distributionGeneratorFirstEntry.append(data);
    });

    $.post(
      "generateHTML.php",
      {data: "DistributionForm", num: "second"},
      function(data, status){
        distributionGeneratorSecondEntry.append(data);
      });
});

//Click event handler
$(document).click(function(event) {
  if($(event.target).hasClass('dropdown-item'))
  {
    $( event.target ).parent().parent().children(':first-child').text($(event.target).text());
    $( event.target ).parent().parent().children(':first-child').attr('Value', ($(event.target).text()));
  }
});

$(function()
{
    $(document).on('click', '.btn-add', function(e)
    {
        e.preventDefault();

        //Find element with class "entry" within the form. Make a copy of the input group and append to parent 
        var controlForm = $('.xmlForm form:first'),
            currentEntry = $(this).parent('.entry:first'),
            newEntry = $(currentEntry.clone().appendTo(currentEntry.parent()));

        //If button is not the last element define as remove button.
        newEntry.find('input').val('');
        currentEntry.parent().find('.entry:not(:first) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<i class="fas fa-minus"></i>');
    }).on('click', '.btn-double-add', function(e){
      e.preventDefault();

      //Find element with class "entry" within the form. Make a copy of the input group and append to parent 
      var controlForm = $('.xmlForm form:first'),
          currentEntry = $(this).parent().parent('.entry:first'),
          tmp = $(currentEntry.parent().append('<div class="w-100"></div>')),
          newEntry = $(currentEntry.clone().appendTo(currentEntry.parent())),
          finalEntry = $(newEntry.find(".attribute_input").each(function () {
            $(this).removeAttr('placeholder');
        }));

      //If button is not the last element define as remove button.
      newEntry.find('input').val('');
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

  console.log($(btn));
  
  var inputs = [];
  //Find each input field in the Form. If the element contains a name, add the name, attribute and value paramaters to the inputs array.
  //Each entry in the inputs array corresponds to a single element in the xml document

  $(btn).find('.inputField').each(function(){
    console.log($(this));
    if($(this).attr('name') != null){

      if($(this).prop('tagName') == 'A'){
        inputs.push({
          key: $(this).attr('name'),
          attribute: $(this).attr('value'),
          value: $(this).parent().next().val()
        })
      }else if($(this).prop('tagName') == 'INPUT'){
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

function resizeInput() {
  $(this).attr('size', $(this).val().length);
}

$('input[type="text"]')
  // event handler
  .keyup(resizeInput)
  // resize on page load
  .each(resizeInput);
