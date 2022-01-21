(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";

var _checkbox = require("./modules/checkbox.js");

/* Import user-defined modules  */
//import { checkboxToggleStatus, add_click_event_listener_to_checkbox } from './admin-modules/checkbox.js';
//import 'code-prettify';

/* I. Vanilla JS - trigger when windows load */
window.addEventListener("load", function () {
  /* I. External module initialization */
  //PR.prettyPrint();

  /*** Dashboard page - toggle checkbox selection ****/
  (0, _checkbox.add_click_event_listener_to_checkbox)();
  /*** Dashboard page - tabs selection
   * 1. Store variables here
   * 2. Grab all the tabs in an array tabs
   ****/

  var tabs = document.querySelectorAll("ul.nav-tabs > li");
  /* Open the dedicated tabs when user click */

  /*** - Iterate through tabs array, add event listener to each tab ***/

  for (var i = 0; i < tabs.length; i++) {
    // console.log( 'Current tab item is : ' +  tabs[i] );
    tabs[i].addEventListener("click", switchTab);
  }

  function switchTab(event) {
    /* 1. Remove active class in tab panel in panel navigation & the corresponsding panels */
    //console.log(event); // OK
    document.querySelector("ul.nav-tabs li.active").classList.remove("active");
    document.querySelector("div.tab-pane.active").classList.remove("active");
    /* 2. Add active class to current tab navigation & tab container */

    /* 2.1. Tab navigations */
    // Get the current active tab naviagation:

    var clickedTab = event.currentTarget;
    /* event.currentTarget: <li><a href="#tab-2">Updates</a></li> */

    var anchor = event.target;
    /* event.target: <a href="#tab-2">Updates</a> */

    var activePaneID = anchor.getAttribute("href");
    /* .getAttribute("href") => #tab-2 */
    //console.log(activePaneID);
    // add active class to tab navigation

    clickedTab.classList.add("active"); //clickedTab.preventDefault();  // prevent from adding tab-2, tab-3

    /* 2.2. Tab container */
    // Find the tab-id, then assign class "active"

    document.querySelector(activePaneID).classList.add("active");
    window.scrollTo(1000, 0);
  }
}); //window.addEventListener("load", function(){

/* II. JS framework - jQuery - trigger when document is ready */

jQuery(document).ready(function ($) {
  /* Generic declaration */
  //let pluginRootDir = '/wp-content/plugins/devsunshine-plugin';

  /* I. Import scripts from external modules */

  /*let checkboxModuleScriptPath = pluginRootDir.concat('/assets/js/admin-modules/checkbox.js');
  let checkboxModuleScript = document.createElement("script");
  checkboxModuleScript.src = checkboxModuleScriptPath;  // OK
  document.head.appendChild(checkboxModuleScript);*/

  /* II. */

  /* Declare click event for button
  * - Tap the WordPress Media Uploader for the Upload Image of plugin Widget
  * (assigned the classname .devsunshine-widget-js-image-upload) */
  $(document).on('click', '.devsunshine-widget-js-image-upload', function (e) {
    e.preventDefault();
    var $uploadButton = $(this); // refer to $('.devsunshine-widget-js-image-upload')
    // Store WordPress Media Uploader

    var fileFrame = wp.media.frames.file_frame = wp.media({
      title: 'Select or Upload an Image',
      library: {
        type: 'image' // mime type

      },
      button: {
        text: 'Select Image'
      },
      multiple: false // select only single image

    }); // wp.media.frames.file_frame = wp.media({

    fileFrame.on('select', function () {
      /* Get attached file selected by user, store in the variable 'attachedItem'
      * (Ignore the order)
      * 1. Tap the file selected by the user via variable "fileFrame"
      * 2. Check the state if being selected or not - method state()
      * 3. Get users selection - method get('selection')
      * 4. Obtain the 1st item in user selection - method first()
      * 5. Convert to JSON format - method toJSON()
      * */
      var attachedItem = fileFrame.state().get('selection').first().toJSON();
      /*
      * - Find the sibling elements (elements have same depth in DOM structure)
      * + This element contains the classname '.devsunshine-widget-image-upload'
      * - Assign the value is URL of attached item (attachedItem.url)
      * - Trigger 'change' event to activate the "save change" button
      * */

      $uploadButton.siblings('.devsunshine-widget-image-upload').val(attachedItem.url).trigger('change');
    }); // Trigger the Media Uploader

    fileFrame.open(); // Enable the save button
  }); //$(document).on('click','.devsunshine-widget-js-image-upload', function(e){
}); //jQuery(document).ready(function($){

},{"./modules/checkbox.js":2}],2:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.add_click_event_listener_to_checkbox = add_click_event_listener_to_checkbox;
exports.checkboxToggleStatus = checkboxToggleStatus;

function add_click_event_listener_to_checkbox() {
  /*** Dashboard page - toggle checkbox selection ****/
  var settingCheckboxes = document.querySelectorAll("div.ui-toggle"); //console.log( 'Number of item ' + settingCheckboxes.length );

  for (var i = 0; i < settingCheckboxes.length; i++) {
    //console.log( 'Current checkbox item is : ' +  settingCheckboxes[i] );
    //let toggleBox = settingCheckboxes[i].querySelector('label');
    // settingCheckboxes[i].addEventListener("click", checkboxToggleStatus); // OK
    settingCheckboxes[i].querySelector('label.item-checkbox-label').addEventListener("click", checkboxToggleStatus); // toggleBox.addEventListener("click", checkboxToggleStatus);
  }
}

function checkboxToggleStatus(event) {
  event.preventDefault();
  var clickedCheckbox = event.currentTarget; //console.log('value of clicked checkbox : ');
  //console.log(  clickedCheckbox );   // Display a very detail objects

  var checkbox = clickedCheckbox.parentNode.querySelector('input.ui-toggle'); // Get HTML elements of input tab
  //let toggleBox = clickedCheckbox.querySelector('label');
  //console.log('value of input field : ');
  //console.log(  checkbox );

  if (checkbox.hasAttribute('checked')) {
    //console.log('Current checkbox is checked');
    checkbox.removeAttribute('checked');
  } else {
    //console.log('Current checkbox is NOT checked');
    checkbox.setAttribute('checked', '');
  }
}
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

},{}]},{},[1]);

//# sourceMappingURL=gutbcontent-admin.js.map
