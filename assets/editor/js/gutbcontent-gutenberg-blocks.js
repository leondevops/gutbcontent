(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.registerCustomCTABlock = void 0;

/*
* Package Gutbcontent plugin
* Page Editor: Gutenberg - Content Block Custom Call-To-Action (CTA)
* */

/* Utilize resources built by WordPress */
//import { registerBlockType } from '@wordpress/blocks'; // no need since can ultilize WordPress sources
//import React from "react";
var registerBlockType = wp.blocks.registerBlockType; //OK

var _wp$editor = wp.editor,
    RichText = _wp$editor.RichText,
    InspectorControls = _wp$editor.InspectorControls,
    ColorPalette = _wp$editor.ColorPalette,
    MediaUpload = _wp$editor.MediaUpload,
    InnerBlocks = _wp$editor.InnerBlocks,
    BlockControls = _wp$editor.BlockControls,
    AlignmentToolbar = _wp$editor.AlignmentToolbar;
var _wp$components = wp.components,
    PanelBody = _wp$components.PanelBody,
    IconButton = _wp$components.IconButton,
    RangeControl = _wp$components.RangeControl; // pre-defined Gutenberg button blocks. 

var ALLOWED_BLOCKS = ['core/button']; //import registerBlockType from wp.blocks; // Equivalent statement but not work.

/* 
Declare function to register Gutenberg custom Call-To-Action content block. 
This function needs to be exported in the end of JS ES5 scripts enqueued in WordPress */

var registerCustomCTABlock = function registerCustomCTABlock() {
  return registerBlockType('gutbcontent/custom-cta', {
    // 1. Built-in attributes
    title: 'GutbContent Call To Action',
    description: 'A custom Gutenberg block to generate custom Call-to-Action elements for Gutenberg editor',
    icon: 'format-image',
    keywords: "Call-To-Action",
    category: 'layout',
    // 2. Custom attributes
    attributes: {
      blockTitle: {
        type: 'string',
        source: 'html',
        selector: 'h3'
      },
      blockTitleAlignment: {
        type: 'string',
        "default": 'none'
      },
      blockTitleColor: {
        type: 'string',
        "default": 'black'
      },
      featuredImage: {
        type: 'string',
        "default": null
      },
      overlayColor: {
        type: 'string',
        "default": 'black'
      },
      overlayOpacity: {
        type: 'number',
        "default": 0.3
      },
      blockBody: {
        type: 'string',
        source: 'html',
        selector: 'p'
      },
      blockBodyAlignment: {
        type: 'string',
        "default": 'none'
      }
    },
    // 3. Custom functions
    // 3.1. Built-in functions
    edit: function edit(_ref) {
      var attributes = _ref.attributes,
          setAttributes = _ref.setAttributes;
      // Pulling properties from attributes
      var blockTitle = attributes.blockTitle,
          blockTitleColor = attributes.blockTitleColor,
          blockTitleAlignment = attributes.blockTitleAlignment,
          featuredImage = attributes.featuredImage,
          overlayColor = attributes.overlayColor,
          overlayOpacity = attributes.overlayOpacity,
          blockBody = attributes.blockBody,
          blockBodyAlignment = attributes.blockBodyAlignment; // Custom functions
      // 1. Title

      function updateBlockTitle(newTitle) {
        setAttributes({
          blockTitle: newTitle
        });
      }

      function updateBlockTitleColor(newTitleColor) {
        setAttributes({
          blockTitleColor: newTitleColor
        });
      }

      function updateBlockTitleAlignment(newAlignment) {
        setAttributes({
          blockTitleAlignment: newAlignment == undefined ? 'none' : newAlignment
        });
      } // 2. Featured image


      function updateFeaturedImage(newImage) {
        //console.log(newImage);
        setAttributes({
          featuredImage: newImage.sizes.full.url
        });
      }

      function updateOverlayColor(newColor) {
        setAttributes({
          overlayColor: newColor
        });
      }

      function updateOverlayOpacity(newOpacity) {
        setAttributes({
          overlayOpacity: newOpacity
        });
      } // 3. Body 


      function updateBlockBody(newBodyContent) {
        setAttributes({
          blockBody: newBodyContent
        });
      }

      function updateBlockBodyAlignment(newAlignment) {
        setAttributes({
          blockBodyAlignment: newAlignment == undefined ? 'none' : newAlignment
        });
      }

      return [/*#__PURE__*/React.createElement(InspectorControls, {
        style: {
          marginTop: '1em',
          marginBottom: '1em'
        }
      }, /*#__PURE__*/React.createElement(PanelBody, {
        title: 'Set title\'s text color',
        style: {
          marginTop: '0.5em',
          marginBottom: '0.5em'
        }
      }, /*#__PURE__*/React.createElement("p", null, /*#__PURE__*/React.createElement("strong", null, "Select a color for the title :")), /*#__PURE__*/React.createElement(ColorPalette, {
        value: blockTitleColor,
        onChange: updateBlockTitleColor
      })), /*#__PURE__*/React.createElement(PanelBody, {
        title: 'Block\'s featured image setting',
        style: {
          marginTop: '0.5em',
          marginBottom: '0.5em'
        }
      }, /*#__PURE__*/React.createElement("p", null, /*#__PURE__*/React.createElement("strong", null, "Select featured image for content block :")), /*#__PURE__*/React.createElement(MediaUpload, {
        onSelect: updateFeaturedImage,
        type: "image",
        value: featuredImage,
        render: function render(_ref2) {
          var open = _ref2.open;
          return [/*#__PURE__*/React.createElement(IconButton, {
            onClick: open,
            icon: "upload",
            style: {
              border: '2px groove grey'
            },
            className: "editor-media-placeholder__button is-button is-large"
          }, "Select featured image")];
        }
      }), /*#__PURE__*/React.createElement("div", {
        style: {
          marginTop: '0.5em',
          marginBottom: '0.5em'
        }
      }, /*#__PURE__*/React.createElement("p", null, /*#__PURE__*/React.createElement("strong", null, "Overlay color :")), /*#__PURE__*/React.createElement(ColorPalette, {
        value: overlayColor,
        onChange: updateOverlayColor
      })), /*#__PURE__*/React.createElement(RangeControl, {
        label: 'Overlay Opacity',
        value: overlayOpacity,
        onChange: updateOverlayOpacity,
        min: 0,
        max: 0.9,
        step: 0.01
      }))), /*#__PURE__*/React.createElement("div", {
        className: "custom-cta-container",
        style: {
          border: '2px groove grey'
        }
      }, /*#__PURE__*/React.createElement("div", {
        className: "cta-image-container",
        style: {
          backgroundImage: "url(".concat(featuredImage, ")")
        }
      }, /*#__PURE__*/React.createElement(BlockControls, null, /*#__PURE__*/React.createElement("p", null, "Align Title"), /*#__PURE__*/React.createElement(AlignmentToolbar, {
        value: blockTitleAlignment,
        onChange: updateBlockTitleAlignment
      })), /*#__PURE__*/React.createElement(RichText, {
        key: "editable",
        tagName: "h3",
        className: "custom-cta-title",
        placeholder: "Write your Call-To-Action title",
        value: blockTitle,
        onChange: updateBlockTitle,
        style: {
          color: blockTitleColor,
          textAlign: blockTitleAlignment
        }
      }), /*#__PURE__*/React.createElement(InnerBlocks, {
        allowedBlocks: ALLOWED_BLOCKS
      }), /*#__PURE__*/React.createElement("div", {
        className: "cta-image-overlay",
        style: {
          backgroundColor: overlayColor,
          opacity: overlayOpacity
        }
      })), /*#__PURE__*/React.createElement(BlockControls, null, /*#__PURE__*/React.createElement("p", null, "Align Description"), /*#__PURE__*/React.createElement(AlignmentToolbar, {
        value: blockBodyAlignment,
        onChange: updateBlockBodyAlignment
      })), /*#__PURE__*/React.createElement(RichText, {
        key: "editable",
        tagName: "p",
        className: "custom-cta-description",
        placeholder: "Write your Call-To-Action description within few sentences.",
        value: blockBody,
        onChange: updateBlockBody,
        style: {
          textAlign: blockBodyAlignment
        }
      }))];
    },
    // 3.2. Save methods
    save: function save(_ref3) {
      var attributes = _ref3.attributes;
      // Pulling properties from attributes
      var blockTitle = attributes.blockTitle,
          blockTitleColor = attributes.blockTitleColor,
          blockTitleAlignment = attributes.blockTitleAlignment,
          blockBody = attributes.blockBody,
          blockBodyAlignment = attributes.blockBodyAlignment,
          featuredImage = attributes.featuredImage,
          overlayColor = attributes.overlayColor,
          overlayOpacity = attributes.overlayOpacity;
      return /*#__PURE__*/React.createElement("div", {
        "class": "gutbcontent-wrapper custom-cta-container",
        style: {
          border: '2px groove grey'
        }
      }, /*#__PURE__*/React.createElement("label", null, "CTA title :"), /*#__PURE__*/React.createElement("div", {
        "class": "gutbcontent-featured-image",
        style: {
          backgroundImage: "url(" + featuredImage + ")"
        }
      }, /*#__PURE__*/React.createElement("h3", {
        style: {
          color: blockTitleColor,
          textAlign: blockTitleAlignment
        }
      }, blockTitle), /*#__PURE__*/React.createElement(InnerBlocks.Content, null), /*#__PURE__*/React.createElement("div", {
        "class": "cta-image-overlay",
        style: {
          backgroundColor: overlayColor,
          opacity: overlayOpacity
        }
      })), /*#__PURE__*/React.createElement("label", null, "CTA description :"), /*#__PURE__*/React.createElement(RichText.Content, {
        tagName: "p",
        value: blockBody,
        className: "custom-cta-description",
        style: {
          textAlign: blockBodyAlignment
        }
      }));
    }
  });
}; //registerBlockType('gutbcontent/custom-cta'


exports.registerCustomCTABlock = registerCustomCTABlock;
var registerCustomCTABlock;
exports.registerCustomCTABlock = registerCustomCTABlock;

},{}],2:[function(require,module,exports){
"use strict";

var _customCallToAction = require("./custom-call-to-action");

(0, _customCallToAction.registerCustomCTABlock)();

},{"./custom-call-to-action":1}]},{},[2]);

//# sourceMappingURL=gutbcontent-gutenberg-blocks.js.map
