/*
* Package Gutbcontent plugin
* Page Editor: Gutenberg - Content Block Custom Call-To-Action (CTA)
* */

/* Utilize resources built by WordPress */
//import { registerBlockType } from '@wordpress/blocks'; // no need since can ultilize WordPress sources
//import React from "react";

const { registerBlockType } = wp.blocks; //OK
const { 
  RichText, 
  InspectorControls, 
  ColorPalette, 
  MediaUpload, 
  InnerBlocks,
  BlockControls,
  AlignmentToolbar 
} = wp.editor;

const { PanelBody, IconButton, RangeControl } = wp.components;
// pre-defined Gutenberg button blocks. 
const ALLOWED_BLOCKS = ['core/button']; 
//import registerBlockType from wp.blocks; // Equivalent statement but not work.

/* 
Declare function to register Gutenberg custom Call-To-Action content block. 
This function needs to be exported in the end of JS ES5 scripts enqueued in WordPress */ 
var registerCustomCTABlock = () => registerBlockType('gutbcontent/custom-cta',{
  // 1. Built-in attributes
  title:'GutbContent Call To Action',
  description:'A custom Gutenberg block to generate custom Call-to-Action elements for Gutenberg editor',
  icon: 'format-image',
  keywords: "Call-To-Action",
  category: 'layout',

  // 2. Custom attributes
  attributes:{
    blockTitle:{
      type: 'string',
      source: 'html',
      selector: 'h3'
    },
    blockTitleAlignment:{
      type: 'string',
      default: 'none'
    },
    blockTitleColor:{
      type: 'string',
      default: 'black',
    },    
    featuredImage:{
      type: 'string',
      default: null
    },
    overlayColor:{
      type: 'string',
      default: 'black'
    },
    overlayOpacity:{
      type: 'number',
      default: 0.3
    },
    blockBody: {
      type: 'string',
      source: 'html',
      selector: 'p'
    },
    blockBodyAlignment:{
      type: 'string',
      default: 'none'
    }
  },

  // 3. Custom functions

  // 3.1. Built-in functions
  edit: ({attributes, setAttributes}) => {
    // Pulling properties from attributes
    const { 
      blockTitle, blockTitleColor, blockTitleAlignment,
      featuredImage, overlayColor, overlayOpacity,
      blockBody, blockBodyAlignment
    } = attributes;

    // Custom functions
    // 1. Title
    function updateBlockTitle(newTitle){
      setAttributes( { blockTitle: newTitle } );
    }

    function updateBlockTitleColor(newTitleColor){
      setAttributes( { blockTitleColor: newTitleColor } );
    }    

    function updateBlockTitleAlignment(newAlignment){
      setAttributes( { 
        blockTitleAlignment: (newAlignment == undefined ? 'none' : newAlignment)
      } );
    }
    
    // 2. Featured image
    function updateFeaturedImage(newImage){
      //console.log(newImage);
      setAttributes({ featuredImage: newImage.sizes.full.url });
    }

    function updateOverlayColor(newColor){
      setAttributes( { overlayColor: newColor } );
    }

    function updateOverlayOpacity(newOpacity){
      setAttributes( { overlayOpacity: newOpacity } );
    }

    // 3. Body 
    function updateBlockBody(newBodyContent){
      setAttributes( { blockBody: newBodyContent } );
    }

    function updateBlockBodyAlignment(newAlignment){
      setAttributes( { 
        blockBodyAlignment: (newAlignment == undefined ? 'none' : newAlignment)
      } );
    }

    return ([
      <InspectorControls style={{marginTop:'1em',marginBottom:'1em'}}>
        <PanelBody title={'Set title\'s text color'} style={{marginTop:'0.5em',marginBottom:'0.5em'}}>
          <p><strong>Select a color for the title :</strong></p>
          <ColorPalette value={blockTitleColor} onChange={updateBlockTitleColor}/>
        </PanelBody>
        <PanelBody title={'Block\'s featured image setting'}
                  style={{marginTop:'0.5em',marginBottom:'0.5em'}}>
          <p><strong>Select featured image for content block :</strong></p>
          <MediaUpload onSelect={updateFeaturedImage} 
                      type="image" 
                      value={featuredImage}
                      render={ 
                        ( {open} ) => {
                          return ([
                            <IconButton onClick={open} icon="upload" 
                              style={{border:'2px groove grey'}}
                              className="editor-media-placeholder__button is-button is-large">
                              Select featured image
                            </IconButton>
                          ]);
                        } 
                      }
                    />
          <div style={{marginTop:'0.5em',marginBottom:'0.5em'}}>
            <p><strong>Overlay color :</strong></p>
            <ColorPalette value={overlayColor} onChange={updateOverlayColor}/>
          </div>
          <RangeControl label={'Overlay Opacity'} value={overlayOpacity}
                        onChange={updateOverlayOpacity}
                        min={0} max={0.9} step={0.01}/>
        </PanelBody>
      </InspectorControls>,
      <div className="custom-cta-container" style={ {border:'2px groove grey'} }>           
        <div className="cta-image-container" style={ { backgroundImage:`url(${featuredImage})` } }>
            <BlockControls>
              <p>Align Title</p>
              <AlignmentToolbar value={blockTitleAlignment}
                                onChange={updateBlockTitleAlignment}/>
            </BlockControls>
            <RichText key="editable"
              tagName="h3"
              className="custom-cta-title"
              placeholder="Write your Call-To-Action title"
              value={blockTitle}
              onChange={updateBlockTitle}
              style={ { color:blockTitleColor,textAlign:blockTitleAlignment } }/>   
            <InnerBlocks allowedBlocks={ ALLOWED_BLOCKS }/>            
          <div className="cta-image-overlay" 
                style={{backgroundColor:overlayColor,opacity:overlayOpacity}}> 
                        
          </div>          
        </div>
        <BlockControls>
          <p>Align Description</p>
          <AlignmentToolbar value={blockBodyAlignment}
            onChange={updateBlockBodyAlignment}/>
        </BlockControls>              
        <RichText key="editable"
                  tagName="p"
                  className="custom-cta-description"
                  placeholder="Write your Call-To-Action description within few sentences."
                  value={blockBody}
                  onChange={updateBlockBody}
                  style={ { textAlign:blockBodyAlignment } }/>
      </div>     
    ]);
  },

  // 3.2. Save methods
  save: ({attributes}) => {
    // Pulling properties from attributes
    const { 
      blockTitle, blockTitleColor, blockTitleAlignment,
      blockBody, blockBodyAlignment,
      featuredImage, overlayColor, overlayOpacity
    } = attributes;

    return (
      <div class="gutbcontent-wrapper custom-cta-container" style={{border:'2px groove grey'}}>
        <label>CTA title :</label>        
        <div class="gutbcontent-featured-image" 
            style={{backgroundImage:"url(" + featuredImage + ")"}}>
            <h3 style={ {color:blockTitleColor,textAlign:blockTitleAlignment} }>{blockTitle}</h3>
            <InnerBlocks.Content/>
            <div class="cta-image-overlay" 
                style={{backgroundColor:overlayColor,opacity:overlayOpacity}}>               
          </div>         
        </div>
        <label>CTA description :</label>
        <RichText.Content tagName="p" value={blockBody} 
                          className="custom-cta-description"
                          style={ {textAlign:blockBodyAlignment} }/>
      </div>
    );    
  }
}); //registerBlockType('gutbcontent/custom-cta'


export var registerCustomCTABlock;