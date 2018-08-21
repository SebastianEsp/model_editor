//Dynamicly add more input fields for input groups with the .entry class
$( document ).ready(function() {

  document.getElementById("overlay").style.display = "none";

});

//Click event handler
$(document).click(function(event) {
  if($(event.target).hasClass('dropdown-item')) //If click target is a dropdown item, set the innerhtml, value and data-* attributes of the parent
  {
    $( event.target ).parent().parent().children(':first-child').text($(event.target).text());
    $( event.target ).parent().parent().children(':first-child').attr('Value', ($(event.target).text()));
    $( event.target ).parent().parent().children(':first-child').data('foo', ($(event.target).data('foo')));
    $( event.target ).parent().parent().children(':first-child').attr('onclick', 'bringToFront();')
  }

  //If user is in "add row" mode, listen for click on table row
  if($('html,body').css('cursor') == 'cell' && $(event.target).hasClass('clickable-row')){
    $('html,body').css('cursor','auto');
    $("#modelTable :input").prop("disabled", false);

    var table = document.getElementById("modelTable");
    var row = table.insertRow($(event.target).parent().index() + 2);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
  
    row.className += 'new-row';
  
    cell1.innerHTML = '<td><input onfocus="expandInput(this)" value=""></td>';
    cell1.className += 'clickable-row';
    cell2.innerHTML = '<td><input onfocus="expandInput(this)" value=""></td>';
    cell2.className += 'clickable-row';
    cell3.innerHTML = '<td><input onfocus="expandInput(this)" value=""></td>';
    cell3.className += 'clickable-row';
    cell4.innerHTML = '<td><input onfocus="expandInput(this)" value=""></td>';
    cell4.className += 'clickable-row';
  }

  //If user is in "remove row" mode, listen for click on row
  if($('html,body').css('cursor') == 'url("https://data.gov.dk/test/catalogue/models/modeleditor/icons/remove-icon.cur"), auto' || $('html,body').css('cursor') == "url('../icons/remove-icon.cur')"){
    if( $(event.target).hasClass('clickable-row')){
      $('html,body').css('cursor','auto');
      $("#modelTable :input").prop("disabled", false);
  
      deletedRows.push($(event.target).parent().index() + 1);

      var table = document.getElementById("modelTable");
      ($(event.target).parent().css('display', 'none'));
    }
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

//Get a specific model based on the provided title.
function getModelFromTitle(title){
  $.post(
    "getSpecificModel.php",   
    {data: title},
    function(data, status){
      $('.modeldisplay').html(data);
    }
  );
}

//Adds a search bar to the dropdown menu, which allows filtering of the menu items
function dropdownSearch() {
  var input, filter, ul, li, a, i;
  input = document.getElementById("dropdown_search");
  filter = input.value.toUpperCase();
  div = document.getElementById("dropdown_search_hook");
  a = div.getElementsByTagName("a");
  for (i = 0; i < a.length; i++) {
    if (a[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
} 

//Dynamically expands a textarea to fit it's contents
$('textarea').on('keydown', function(e){
  if(e.which == 13) {e.preventDefault();}
}).on('input', function(){
  $(this).height(1);
  var totalHeight = $(this).prop('scrollHeight') - parseInt($(this).css('padding-top')) - parseInt($(this).css('padding-bottom'));
  $(this).height(totalHeight);
});

var lastScrollTop = 0
var scrollPercentage = 10;
var scroll;
//Scroll event handler. Dynamically moves the input box along with the scroll bar
$( window ).scroll(function() {
  var scroll = $(window).scrollTop();
  if (scroll > lastScrollTop){
    //If scrolling down
    $(".expanded-input textarea").css("top", scroll);
  } else {
    //If scrolling up
    $(".expanded-input textarea").css("top", scroll);
  }
});

var selectedInput;
//When input field is focused add overlay and expand to textarea
function expandInput(sender){
  document.getElementById("overlay").style.display = "block";
  selectedInput = $(sender);
  var selectedVal = sender.value;
  $(selectedInput).prop('disabled', true);
  $('.expanded-input textarea').val(selectedVal);
  $('.expanded-input').css('visibility', 'visible');
  $(".expanded-input textarea").css("margin-top", '0%');
  $(".expanded-input textarea").css("top", scroll);
}

//When textarea loose focus remove overlay and save changes
function lostFocus(sender){
  document.getElementById("overlay").style.display = "none";
  $(selectedInput).prop('disabled', false);
  selectedInput.attr('value', $(sender).val());
  sender.value = '';
  $('.expanded-input').css('visibility', 'hidden');
}

//Brings the dropdown menu to the front of the table.
function bringToFront(){
  $('.header-container').css('z-index', '2');
}

function addRow(){
  $('html,body').css('cursor','cell');
  $("#modelTable :input").prop("disabled", true);
}

var deletedRows = [];

function removeRow(){
  $('html,body').css('cursor','url(../icons/remove-icon.cur),auto');
  $("#modelTable :input").prop("disabled", true);
}

//Find each value in the table representing a given model. 
//Split these into chunks of four to represent individual elements within the model
//Finaly send the JSON representation of the chunks to the save.php script
function saveChanges(){

  var title = $('.dropdown-toggle').attr('value');
  var elements = [];
  var chunks = [];
  var temporary = [];
  var chunk = 4;

  $('.modeldisplay input').each(function(){
      elements.push($(this));
  });

  for (i=0,j=elements.length; i<j; i+=chunk) {
    temporary = elements.slice(i,i+chunk);
      var tmp = [temporary[0].attr('value'), temporary[1].attr('value'), temporary[2].attr('value'), temporary[3].attr('value')];
      chunks.push(tmp);
  }
  var newRows = []; 

  //Find all rows in table
  $('#modelTable tr:not(:first)').each(function()
  {
    if($(this).hasClass('new-row')){
      newRows.push($(this).index());
    }
  });

  var json = JSON.stringify(chunks, null, 2)  
  var jsonRowsNew = JSON.stringify(newRows, null, 2);
  var jsonRowsDel = JSON.stringify(deletedRows, null, 2);

  console.log(jsonRowsNew);
  console.log(jsonRowsDel);

  $.post(
      "../edit/save.php",   
      {data: title, arr: json, new: jsonRowsNew, deleted: jsonRowsDel},
      function(data, status){
        alert(data);
      }
    );
}
  