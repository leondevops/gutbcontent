(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";

// Equivalent Vanilla javaScript to toggle search button - OK but too dry
var searchArea = document.querySelector('div.custom-search-box');
var searchIcon = searchArea.querySelector('div.open-search.menu-item a');
var searchBox = searchArea.querySelector('div.search-form-container');
searchIcon.addEventListener('click', function (e) {
  e.preventDefault();
  searchBox.classList.toggle('show');
});
var menuButton = document.querySelector('div.custom-table-of-content span.gutbcontent-menu-icon');
var stickyMenu = document.querySelector('div.custom-table-of-content div.custom-toc-wrapper');
menuButton.addEventListener('click', function (e) {
  e.preventDefault();
  stickyMenu.classList.toggle('show');
  this.classList.toggle('gutbcontent-menu-classic');
  this.classList.toggle('gutbcontent-close-small');
});
jQuery(function ($) {
  // 1. Search box

  /*  $(document).on('click', 'div.open-search.menu-item a', function(e){
     e.preventDefault();
     //$('div.search-form-container').slideToggle(300);  //OK
     $('div.search-form-container').fadeToggle(300);  //OK    
   }); */
  // 2. Navigation menu
  var gutbcontentMainMenu = $('ul.gutbcontent-main-menu-wrapper');
  var menuItems = gutbcontentMainMenu.find('li.menu-item'); // traverse through tree menu - with pre-order algorithm

  for (var i = 0; i < menuItems.length; i++) {
    // Access current menu item by menuItems[i] / $(menuItems[i])
    var hasSubMenu = $(menuItems[i]).hasClass('menu-item-has-children');

    if (true === hasSubMenu) {
      // 1. Calculate menu item level  
      var itemClasses = menuItems[i].classList;
      var itemLevel = "0";

      for (var j = 0; j < itemClasses.length; j++) {
        if (itemClasses[j].includes('menu-level-')) {
          itemLevel = itemClasses[j].replace('menu-level-', '');
        }
      }

      itemLevel = parseInt(itemLevel); // 2. Add hover event listener to menu item which has submenu
      // if level 0 has submenu

      if (itemLevel == 0) {
        // 2. Add hover event listener to menu item which has submenu        
        $(menuItems[i]).on('mouseover', function (e) {
          e.preventDefault();
          $(this).children('ul').addClass('show').css({
            "position": "absolute",
            "top": "100%",
            "left": "0",
            "min-width": 0
          });
          $(this).children('a').addClass('show');
        }).on('mouseout', function (e) {
          e.preventDefault();
          $(this).children('ul').removeClass('show');
          $(this).children('a').removeClass('show');
        }); //continue;
        // 5. Recalculate the width for 1st level menu items 

        var menuItemWidth = $(menuItems[i]).outerWidth(true);
        var subMenuWidth = $(menuItems[i]).children('ul').outerWidth(true);
        var displayWidth = Math.abs(subMenuWidth) >= Math.abs(menuItemWidth) ? Math.abs(subMenuWidth) : Math.abs(menuItemWidth);
        displayWidth = Math.ceil(displayWidth);
        $(menuItems[i]).css('width', displayWidth + 'px');
        $(menuItems[i]).children('ul').css('width', displayWidth + 'px');
        $(menuItems[i]).children('a').css('width', displayWidth + 'px');
      } // if level 1 has submenu


      if (itemLevel > 0) {
        // 2. Add hover event listener to menu item which has submenu
        $(menuItems[i]).on('mouseover', function (e) {
          e.preventDefault();
          $(this).children('ul').addClass('show').css({
            "position": "absolute",
            "left": "100%",
            "top": "0"
          });
          $(this).children('a').addClass('show');
        }).on('mouseout', function (e) {
          e.preventDefault();
          $(this).children('ul').removeClass('show');
          $(this).children('a').removeClass('show');
        }); //continue;
      } // 3. Update click event: open a child referential link


      $(menuItems[i]).on('click', function (e) {
        window.open($(this).children('a').attr('href'), '_self');
      }); // 4. Stop propagating click event to children 

      $(menuItems[i]).children('ul').on('click', function (e) {
        e.stopPropagation();
      });
    } //end if( true === hasSubMenu ){

  } //end for

});

},{}]},{},[1]);

//# sourceMappingURL=template-scientific-post.js.map
