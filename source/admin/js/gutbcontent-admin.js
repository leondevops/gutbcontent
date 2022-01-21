
/* Import user-defined modules  */
import {add_click_event_listener_to_checkbox} from './modules/checkbox.js';

//import { checkboxToggleStatus, add_click_event_listener_to_checkbox } from './admin-modules/checkbox.js';
//import 'code-prettify';


/* I. Vanilla JS - trigger when windows load */
window.addEventListener("load", function(){
  /* I. External module initialization */
  //PR.prettyPrint();

  /*** Dashboard page - toggle checkbox selection ****/
  add_click_event_listener_to_checkbox();


  /*** Dashboard page - tabs selection
   * 1. Store variables here
   * 2. Grab all the tabs in an array tabs
   ****/

  let tabs = document.querySelectorAll("ul.nav-tabs > li");

  /* Open the dedicated tabs when user click */
  /*** - Iterate through tabs array, add event listener to each tab ***/
  for(let i = 0; i < tabs.length; i++){
    // console.log( 'Current tab item is : ' +  tabs[i] );
    tabs[i].addEventListener("click", switchTab);
  }

  function switchTab(event){
    /* 1. Remove active class in tab panel in panel navigation & the corresponsding panels */
    //console.log(event); // OK
    document.querySelector("ul.nav-tabs li.active").classList.remove("active");
    document.querySelector("div.tab-pane.active").classList.remove("active");

    /* 2. Add active class to current tab navigation & tab container */
    /* 2.1. Tab navigations */
    // Get the current active tab naviagation:
    let clickedTab = event.currentTarget; /* event.currentTarget: <li><a href="#tab-2">Updates</a></li> */
    let anchor = event.target; /* event.target: <a href="#tab-2">Updates</a> */
    let activePaneID = anchor.getAttribute("href"); /* .getAttribute("href") => #tab-2 */
    //console.log(activePaneID);

    // add active class to tab navigation
    clickedTab.classList.add("active");
    //clickedTab.preventDefault();  // prevent from adding tab-2, tab-3

    /* 2.2. Tab container */
    // Find the tab-id, then assign class "active"
    document.querySelector(activePaneID).classList.add("active");
    window.scrollTo(1000, 0);

  }

});//window.addEventListener("load", function(){

/* II. JS framework - jQuery - trigger when document is ready */
jQuery(document).ready(function($){
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
  $(document).on('click','.devsunshine-widget-js-image-upload', function(e){
    e.preventDefault();

    let $uploadButton = $(this); // refer to $('.devsunshine-widget-js-image-upload')

    // Store WordPress Media Uploader
    let fileFrame = wp.media.frames.file_frame = wp.media({
      title: 'Select or Upload an Image',
      library:{
        type: 'image' // mime type
      },
      button:{
        text:'Select Image'
      },
      multiple: false // select only single image
    }); // wp.media.frames.file_frame = wp.media({

    fileFrame.on('select', function(){
      /* Get attached file selected by user, store in the variable 'attachedItem'
      * (Ignore the order)
      * 1. Tap the file selected by the user via variable "fileFrame"
      * 2. Check the state if being selected or not - method state()
      * 3. Get users selection - method get('selection')
      * 4. Obtain the 1st item in user selection - method first()
      * 5. Convert to JSON format - method toJSON()
      * */
      let attachedItem = fileFrame.state().get('selection').first().toJSON();

      /*
      * - Find the sibling elements (elements have same depth in DOM structure)
      * + This element contains the classname '.devsunshine-widget-image-upload'
      * - Assign the value is URL of attached item (attachedItem.url)
      * - Trigger 'change' event to activate the "save change" button
      * */
      $uploadButton.siblings('.devsunshine-widget-image-upload').val(attachedItem.url).trigger('change');

    });

    // Trigger the Media Uploader
    fileFrame.open();

    // Enable the save button
  });//$(document).on('click','.devsunshine-widget-js-image-upload', function(e){

});//jQuery(document).ready(function($){
