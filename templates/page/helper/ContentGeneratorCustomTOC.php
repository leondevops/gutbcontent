<?php

class ContentGeneratorCustomTOC{
  public $tableOfContents;
  public $orderedTOC;
  private $index;
  private $tocPattern;

    /***
   * $customContentGenerator->tocResultMatches[0] contain all needed header <h2 class="eplus-Opk0ml">Sóng Wi-Fi là gì? </h2>
   * $customContentGenerator->tocResultMatches[1] header type: h2, h3
   * $customContentGenerator->tocResultMatches[2] class name :  class="eplus-Opk0ml"
   * $customContentGenerator->tocResultMatches[3] header name only:  Sóng Wi-Fi là gì?
   *
   ***/
  public array $originalHeadersList;
  public array $updatedHeadersList;
  public array $updatedHeadersIdList;
  public array $headersLevelList;

  // Migrate with PHP 7 - older version
  public string $originalHtmlData;
  public string $updatedHtmlData;

  // Toc result matched
  public $tocResultMatches;
  public $tocResultStatus;
  public $tocResult;

  // TOC items
  public int $totalTocItems;
  public array $tocItemsList;

  function __construct()
  {
    // Use HereDoc syntax


    $this->index = 1;

    $this->tocPattern = '#<(h[1-6])(.*?)>(.*?)</\1>#si';
    /* $this->tocPattern = '/<h[1,6](?:\sid=\"(.*)\")?(?:.*)?>(.*)<\/h[1,6]>/"';*/

    // Web content
    $this->originalHtmlData = $this->custom_template_load_the_content();
    $this->tocResultStatus = preg_match_all($this->tocPattern, $this->originalHtmlData, $matches);
    $this->tocResultMatches = $matches;

    /*** List of original header :
     * <h2 class="eplus-Opk0ml" id="song-wifi-la-gi">Sóng Wi-Fi là gì? </h2>
     ***/
    $this->originalHeadersList = $matches[0];

    /***
     * Also update an array of headers with new ID
     * public array $updatedHeadersList;
     * $this->totalTocItems
     * $this->tocItemsList
     * $this->updatedHeadersList
     *
     ***/
    $this->custom_template_generate_toc_items($matches);

    $this->updatedHtmlData = str_replace(
      $this->originalHeadersList,
      $this->updatedHeadersList,
      $this->originalHtmlData,
    );

    /**
     * $this->tableOfContents // general
     * $this->orderedTOC
     **/
    $this->orderedTOC = $this->custom_template_generate_ordered_list_toc($this->tocItemsList,$this->headersLevelList);
  }

  function custom_template_load_the_content($more_link_text = null, $strip_teaser = false): string
  {
    $content = get_the_content($more_link_text, $strip_teaser);

    /**
     * Filters the post content.
     *
     * @param string $content Content of the current post.
     * @since 0.71
     *
     */
    $content = apply_filters('the_content', $content);
    $result = str_replace(']]>', ']]&gt;', $content);
    return is_string($result) ? $result : (function($arg1){ob_start(); var_dump($arg1); return ob_get_clean();})($result);
    
  }

  /***
   * Same size of array
   * $customContentGenerator->tocResultMatches[0] contain all needed original header
   *    <h2 class="eplus-Opk0ml" id="song-wifi-la-gi">Sóng Wi-Fi là gì? </h2>
   * $customContentGenerator->tocResultMatches[1] header type: h2, h3
   * $customContentGenerator->tocResultMatches[2] HTML properties of header tags :  class="eplus-Opk0ml" id="song-wifi-la-gi"
   * $customContentGenerator->tocResultMatches[3] header name only:  Sóng Wi-Fi là gì?
   *
   * Already have $this->originalHeadersList:
   *  <h2 class="eplus-Opk0ml" id="song-wifi-la-gi">Sóng Wi-Fi là gì? </h2>
   ***/
  function custom_template_generate_toc_items(array $matches): array
  {
    /*** Use native PHP array - start index is 0 ***/

    $this->totalTocItems = count($matches[1]);
    // $this->hasIdStatus = array();

    $index = 0;
    // $this->tempMatchedIds = array();
    $this->tocItemsList = array();
    $this->updatedHeadersList = array();
    $this->headersLevelList = array();
    // global $matchedIds;
    // $this->strReplaceStatus = array();
    while ($index < $this->totalTocItems) {
      $tag = $matches[1][$index];  // header type: h2, h3
      $tagProperties = $matches[2][$index]; // HTML properties of header tags :  class="eplus-Opk0ml" id="song-wifi-la-gi"
      $title = $matches[3][$index]; // header name only:  Sóng Wi-Fi là gì?
      /**sample regrex match style : '%<style.*?>.*?<\/style.*?>%is' **/
      /**
       * Regrex to filter id="..." is '%id=["\'].*?["\']%'
       **/

      // If matched, $hasId = 1 ; header id only = $matchedIds[1].
      $hasId = preg_match('%id=["\'](.*?)["\']%', $tagProperties, $matchedIds);
      // If matched, $hasId = 1 ; class name only = $matchedIds[1]. full match
      $hasClassNames = preg_match('%class=["\'](.*?)["\']%', $tagProperties, $matchedClassNames);

      $newIdToc = $hasId ? 'toc-item-' . ($index + 1) . '-' . $matchedIds[1] : 'toc-item-' . ($index + 1);
      $newHtmlClassName = $hasClassNames ? $matchedClassNames[0] : '';
      // $this->tempMatchedIds[] = $matchedIds;

      $this->updatedHeadersIdList[] = $newIdToc;   // Add new header id: toc-item-1-song-wifi-la-gi

      /** 1. Generate a single TOC items, then add to the list: $this->tocItemsList
       *<li class="toc-item-custom-h2">
       *   <a href="#toc-item-1-song-wifi-la-gi">Sóng Wi-Fi là gì?</a>
       * </li>
       ***/
      $tmpTocItem = '<li class="toc-item-custom-'.$tag.'">';
      $tmpTocItem .= '<a href="#' . $newIdToc . '">' . $title . '</a>';
      $tmpTocItem .= '</li>';

      $this->tocItemsList[] = $tmpTocItem;

      /** 2. Update new ID list : $this->updatedHeadersList  **/
      $newHtmlHeadingItem = '<' . $tag . ' ' . $newHtmlClassName . ' id="' . $newIdToc . '">' . $title . '</' . $tag . '>';

      // Add original ID to comment if exist :
      $this->updatedHeadersList[] = $hasId ? '<!-- Original Id : ' . $matchedIds[1] . ' -->' . $newHtmlHeadingItem : $newHtmlHeadingItem;

      /** 3. Update new html content - NOT WORKING ???
       * $updatedHtmlData
       **/  

      /** 4. Update header level : $this->headersLevelList  **/

      switch ($tag) {
        case "h1":
          $this->headersLevelList[] = 1 ; break;
        case "h2":
          $this->headersLevelList[] = 2 ; break;
        case "h3":
          $this->headersLevelList[] = 3 ; break;
        case "h4":
          $this->headersLevelList[] = 4 ; break;
        case "h5":
          $this->headersLevelList[] = 5 ; break;
        case "h6":
          $this->headersLevelList[] = 6 ; break;
      }

      /*** === Increase the index before moving to the next loop ***/
      $index++;
    }

    return $this->tocItemsList;
  }

  /***
   * 1. Examples of a single TOC item in $tocItemsList
   *    <li class="toc-item-custom-tpl">
   *      <a href="#toc-item-10-loi-khuyen-chuyen-gia">Lời khuyên từ các chuyên gia</a>
   *    </li>
   ***/

  function custom_template_generate_unordered_list_toc(array $tocItemsList)
  {
    $this->tableOfContents = <<<EOD
      
      <div class="sticky-top custom-toc-wrapper show">
        <br>    
        <div class='h5 custom-toc-title'>
            Mục Lục <span class='toggle'>+ Hiển thị chi tiết</span>
        </div>
        <div class='items custom-toc-list'>            
      EOD;

    $this->tableOfContents .= '<ul>';
    /** Adding the toc items here
     *
     **/
    foreach ($tocItemsList as $tocItem) {
      $this->tableOfContents .= $tocItem;
    }
    $this->tableOfContents .= '</ul>';

    $this->tableOfContents .= '</div> <!--End of div tcustom-toc-list-->';
    $this->tableOfContents .= '</div> <!--End of div custom-toc-wrapper-->';

    return $this->tableOfContents;

    
  }

  /***
   * 1. Examples of a single TOC item in $tocItemsList
   *    <li class="toc-item-custom-tpl">
   *      <a href="#toc-item-10-loi-khuyen-chuyen-gia">Lời khuyên từ các chuyên gia</a>
   *    </li>
   *
   * 2. The result is stored in variable : $this->tableOfContents
   * - Using $this->tocItemsList, $this->headersLevelList
   ***/

  function custom_template_generate_ordered_list_toc(array $tocItemsList, array $headersLevelList)
  {
    $maxHeaderItem = count($tocItemsList);
    if ( $maxHeaderItem != count($headersLevelList) ) { return false;}

    $this->tableOfContents = <<<EOD
      
      <div class="sticky-top custom-toc-wrapper show">
        <br>    
        <div class='h5 custom-toc-title'>
            Mục Lục <span class='toggle'> chi tiết</span>
        </div>
        <div class='items custom-toc-list'>            
      EOD;

    /** === If too few headings or no heading,s end the list === **/
    if ($maxHeaderItem < 1){
      $this->tableOfContents .= '</div> <!--End of div custom-toc-list-->';
      $this->tableOfContents .= '</div> <!--End of div custom-toc-wrapper-->';

      return $this->tableOfContents;
    }

    /** === If there are enough heading, start building ordered list of TOC === **/
    $itemLevel = 1; // initial value
    $this->tableOfContents .= '<ol class="custom-toc-ol custom-toc-lvl-'.$itemLevel.'">';
    /** Adding the toc items - without nested ordered list **/
    // 1. Adding first item to ordered list
    $index = 0; // Check against $maxHeaderItem
    $this->tableOfContents .= $tocItemsList[$index];
    $index++;

    // 2. Adding 2nd item - last item to ordered list
    while($index < $maxHeaderItem){

      // Start with $index already > 0
      if ($headersLevelList[$index] === $headersLevelList[$index-1]){
        $this->tableOfContents .= $tocItemsList[$index];
      }
      else if ($headersLevelList[$index] > $headersLevelList[$index-1]) {
        $itemLevel++;
        $this->tableOfContents .= '<ol class="custom-toc-ol custom-toc-lvl-'.$itemLevel.'">'; //Start sub ordered list
        $this->tableOfContents .= $tocItemsList[$index];
      }
      else if (($headersLevelList[$index] < $headersLevelList[$index-1])){
        $itemLevel--;
        $this->tableOfContents .= '</ol>'; //End sub ordered list
        $this->tableOfContents .= $tocItemsList[$index];
      }

      $index++;
    }

    $this->tableOfContents .= '</ol>';

    $this->tableOfContents .= '</div> <!--End of div custom-toc-list-->';
    $this->tableOfContents .= '</div> <!--End of div custom-toc-wrapper-->';

    return $this->tableOfContents;
  }

  function custom_template_get_registered_scripts(): array
  {
    global $wp_scripts;
    $result = [];
    $count = 1;

    foreach($wp_scripts->queue as $handler){
      $result[] = $wp_scripts->registered[$handler]->src;
      $count++;
    }

    return $result;
  }

  function custom_template_get_registered_styles():array
  {
    global $wp_styles;
    $result = [];
    $count = 1;
    foreach( $wp_styles->queue as $handle ) {
      $result[] = $wp_styles->registered[$handle]->src;
      $count++;
    }

    return $result;
  }

}

