
function add_click_event_listener_to_checkbox(){
  /*** Dashboard page - toggle checkbox selection ****/
  let settingCheckboxes = document.querySelectorAll("div.ui-toggle");

  //console.log( 'Number of item ' + settingCheckboxes.length );
  for(let i = 0; i < settingCheckboxes.length; i++){
    //console.log( 'Current checkbox item is : ' +  settingCheckboxes[i] );
    //let toggleBox = settingCheckboxes[i].querySelector('label');
    // settingCheckboxes[i].addEventListener("click", checkboxToggleStatus); // OK
    settingCheckboxes[i].querySelector('label.item-checkbox-label').addEventListener("click", checkboxToggleStatus);
    // toggleBox.addEventListener("click", checkboxToggleStatus);
  }
}

function checkboxToggleStatus(event){
  event.preventDefault();
  let clickedCheckbox = event.currentTarget;
  //console.log('value of clicked checkbox : ');
  //console.log(  clickedCheckbox );   // Display a very detail objects

  let checkbox = clickedCheckbox.parentNode.querySelector('input.ui-toggle');  // Get HTML elements of input tab
  //let toggleBox = clickedCheckbox.querySelector('label');
  //console.log('value of input field : ');
  //console.log(  checkbox );
  if(checkbox.hasAttribute('checked')){
    //console.log('Current checkbox is checked');
    checkbox.removeAttribute('checked');
  }else{
    //console.log('Current checkbox is NOT checked');
    checkbox.setAttribute('checked','');
  }
}

export { checkboxToggleStatus, add_click_event_listener_to_checkbox };

/*

window.addEventListener("load", function(){

  /!*** Dashboard page - toggle checkbox selection ****!/
  var settingCheckboxes = document.querySelectorAll("div.ui-toggle");

  //console.log( 'Number of item ' + settingCheckboxes.length );
  for(let i = 0; i < settingCheckboxes.length; i++){
    //console.log( 'Current checkbox item is : ' +  settingCheckboxes[i] );
    //let toggleBox = settingCheckboxes[i].querySelector('label');
    settingCheckboxes[i].addEventListener("click", checkboxToggleStatus); //
    // toggleBox.addEventListener("click", checkboxToggleStatus);
  }

  function checkboxToggleStatus(event){
    let clickedCheckbox = event.currentTarget;
    //console.log('value of clicked checkbox : ');
    //console.log(  clickedCheckbox );   // Display a very detail objects

    let checkbox = clickedCheckbox.querySelector('input.ui-toggle');  // Get HTML elements of input tab
    let toggleBox = clickedCheckbox.querySelector('label');
    //console.log('value of input field : ');
    //console.log(  checkbox );
    if(checkbox.hasAttribute('checked')){
      //console.log('Current checkbox is checked');
      checkbox.removeAttribute('checked');
    }else{
      //console.log('Current checkbox is NOT checked');
      checkbox.setAttribute('checked','');
    }
  }

});*/
