<?php

//namespace Vnlab\Gutbcontent\Inc\Helper;

use Vnlab\Gutbcontent\Troubleshoot\PluginCustomDebugger as PluginCustomDebugger;

class GutbcontentMenuWalker extends Walker_Nav_Menu{

	public static int $countInstance;	
	public static int $countMenuItem;
	public static int $countLevelItem;
	
	public array $createdMenuItemLi;
	public array $currentIndexedItem;

    public PluginCustomDebugger $debugger;

    public function __construct(){
        $this->debugger = new PluginCustomDebugger();
		//GutbcontentMenuWalker::$countInstance++;
		
		if( isset(GutbcontentMenuWalker::$countInstance) ){
			GutbcontentMenuWalker::$countInstance++;
		} else {
			GutbcontentMenuWalker::$countInstance = 1;
		}

		$this->createdMenuItemLi = array();
    }

	public function __destruct(){
		if( isset(GutbcontentMenuWalker::$countInstance) ){
			GutbcontentMenuWalker::$countInstance--;
		}  
	}

    // ul - call when having sub-menu items
	function start_lvl(&$output, $depth = 0, $args = null){

		if( isset(GutbcontentMenuWalker::$countLevelItem) ){
			GutbcontentMenuWalker::$countLevelItem++;
		} else {
			GutbcontentMenuWalker::$countLevelItem = 1;
		}

		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}

		$indent = str_repeat($t, $depth);

		$classes = ($depth >= 0)  ? array('sub-menu') : array();
		
		// $submenu = $depth > 0  ? 'sub-menu' : '';
		/**
		 * Filters the CSS class(es) applied to a menu list element.
		 *
		 * @since 4.8.0
		 *
		 * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
		 * @param stdClass $args    An object of `wp_nav_menu()` arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$class_names_array = apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth );

		//$this->debugger->write_log_simple($class_names_array);
		$class_names = implode(' ', $class_names_array);	
		$class_names = $class_names ? sprintf(' class="%s"', esc_attr($class_names)) : '';
		

		//$output .= $n.$indent.'<ul'.$class_names.'>'.$n;
		$output .= "{$n}{$indent}<ul$class_names>{$n}";
		
	}

	// li a span
	/* $args is arguments list parsing from wp_nav_menu() at dedicated page templates */
	function start_el(&$output, $item, $depth = 0, $args = array() , $id = 0){
		
		if( isset(GutbcontentMenuWalker::$countMenuItem) ){
			GutbcontentMenuWalker::$countMenuItem++;
		} else {
			GutbcontentMenuWalker::$countMenuItem = 1;
		}
		//$this->debugger->write_log_simple('------> $output : ');
		//$this->debugger->write_log_simple($output);	// Output of HTML of navigation menu
		//$this->debugger->write_log_simple('------> $item property : ');
		//$this->debugger->write_log_simple($item);

		/* $itemReflect = new ReflectionClass($item);
		foreach($itemReflect->getProperties() as $property){
			$this->debugger->write_log_simple($property->name);
		} */
		
		/* --> 1. Number of indent - basing on depth. Item spacing can receive values 'preseved*/
		if ( isset($args->item_spacing) && 'discard' === $args->item_spacing ){
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		
		// The number of indent tab corresponding with menu item depth.
		$indent = $depth ? str_repeat($t, $depth) : '';
		$classes = isset($item->classes) && !empty($item->classes) ? (array)$item->classes : array();
				
		$classes[] = 'menu-item-' . $item->ID;
		$classes[] = 'menu-level-' . $depth;

		/**
		 * --> 2. Update input arguments parsing from wp_nav_menu();
		 * Filters the arguments for a single nav menu item.
		 *
		 * @since 4.4.0
		 *
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param WP_Post  $item  Menu item data object.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );
		// $this->debugger->write_log_simple('------> $args : ');
		// $this->debugger->write_log_simple($args);

		$this->update_index_menu_item($depth);
		$currentMenuItemLi = array(
			'No'                        => GutbcontentMenuWalker::$countMenuItem ?? 1,
			'Id'                        => 'nav-menu-item-'.$item->ID,
			'depth'                     => $depth,
			'registered-classnames'     => $item->classes,
			'heading-index'             => $this->currentIndexedItem,
		);
		
		$this->createdMenuItemLi[] = $currentMenuItemLi;
		
		$classes[] = $this->get_custom_nav_menu_walker_classname($currentMenuItemLi);

		// --> 3. Classname
		$class_names_array = apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth );
		$class_names = implode( ' ', $class_names_array );
		$class_names = $class_names ? sprintf( 'class="%s"', esc_attr($class_names) ) : '';

		/**
		 * 4. --> ID
		 * Filters the ID applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
		 * @param WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
		$id = $id ? sprintf( 'id="%s"', esc_attr($id) )	: '';
		
		// --> 1+2+3+4 ==> Append output HTML data of menu item - using indent, id, class_names
		$output .= sprintf('%s<li %s %s>',$indent, $id, $class_names);		

		// --> 5. Start building attributes for Menu Item HTML element.
		$atts = array();		
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';

		if ( '_blank' === $item->target && empty( $item->xfn ) ) {
			$atts['rel'] = 'noopener';
		} else {
			$atts['rel'] = $item->xfn;
		}

		$atts['href']         = ! empty( $item->url ) ? $item->url : '';

		// 2022-Jan-14 Adding Bootstrap frameworks property
		/* if($this->has_children && 0 === $depth ){
			$atts['data-bs-toggle'] = 'dropdown';
			$atts['aria-haspopup'] = 'true';
			$atts['aria-expanded'] = 'false';
			$atts['class'] = 'dropdown-toggle nav-link menu-level-'.$depth;
			$atts['id'] = 'menu-item-dropdown-' . $item->ID;
		} else if( $this->has_children && $depth >= 1 ){
			$atts['data-bs-toggle'] = 'dropdown';
			$atts['aria-haspopup'] = 'true';
			$atts['aria-expanded'] = 'false';
			$atts['class'] = 'dropdown-toggle nav-link menu-level-'.$depth;
			$atts['id'] = 'menu-item-dropdown-' . $item->ID;
		} else{
			if ($depth > 0) {
				$atts['class'] = 'dropdown-item menu-level-'.$depth;
			} else {
				$atts['class'] = 'nav-link menu-level-'.$depth;
			}
		} */

		$atts['aria-current'] = $item->current ? 'page' : '';

		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title        Title attribute.
		 *     @type string $target       Target attribute.
		 *     @type string $rel          The rel attribute.
		 *     @type string $href         The href attribute.
		 *     @type string $aria-current The aria-current attribute.
		 * }
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach($atts as $attribute => $value){
			if( is_scalar( $value ) && ( '' !== $value) && ( false !== $value ) ){
				// Sanitize attribute values				
				$value = ('href' === $attribute) ? esc_url( $value ) : esc_attr( $value );
				// Building HTML strcture for attributes
				$attributes.= sprintf(' %s="%s"', $attribute, $value);
			}
		}

		// 6. --> Titles
		$title = apply_filters( 'the_title', $item->title, $item->ID );
		/**
		 * Filters a menu item's title.
		 *
		 * @since 4.4.0
		 *
		 * @param string   $title The menu item's title.
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

		// --> 5 + 6 
		$current_item_output = $args->before;
		$current_item_output .= sprintf('<a%s>', $attributes);
		$current_item_output .= $args->link_before.$title.$args->link_after;
		$current_item_output .= '</a>';
		$current_item_output .= $args->after;

		/**
		 * Filters a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string   $item_output The menu item's starting HTML output.
		 * @param WP_Post  $item        Menu item data object.
		 * @param int      $depth       Depth of menu item. Used for padding.
		 * @param stdClass $args        An object of wp_nav_menu() arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $current_item_output, $item, $depth, $args );
				
		// Stop execution after nth time (GutbcontentMenuWalker::$countMenuItem)
		// Control print how many menu item elements then pause scripts - for debugging
		//if(GutbcontentMenuWalker::$countMenuItem == 6) die();
	}

	// 2021-Sep add custom class
    // Update style : array &$createdMenuItemLi

    private function update_index_menu_item(int $depth): bool
    {

      if (count($this->createdMenuItemLi) === 0 || $this->createdMenuItemLi === NULL ) {
        $this->currentIndexedItem['level-0'] = 1;
        return true;
      }

      $previousItem = end($this->createdMenuItemLi);

      $keyCurrentLevel = 'level-'.$depth;
      // $keyParentLevel = $depth > 0 ? 'level-'.($depth-1) : 'level-0';


      if( $depth === $previousItem['depth']) {
        $this->currentIndexedItem[$keyCurrentLevel]= $previousItem['heading-index'][$keyCurrentLevel] + 1;
      }
      elseif ($depth > $previousItem['depth'] ) {  // moving to lower level
        $this->currentIndexedItem[$keyCurrentLevel] = 1;
      }
      elseif ($depth < $previousItem['depth'] ) { // problem
        // $keyParentLevel = 'level-'.($previousItem['depth']-1);
        $tmpDepth = $depth;
        while($tmpDepth <= $previousItem['depth']){
          $this->currentIndexedItem[$keyCurrentLevel]= 0; // reset up to previous depth
          $tmpDepth++;
          $keyCurrentLevel = 'level-'.$tmpDepth;
        }

        $keyCurrentLevel = 'level-'.$depth;
        $this->currentIndexedItem[$keyCurrentLevel] = $previousItem['heading-index'][$keyCurrentLevel] + 1;

      }

      return true;
    }

	private function get_custom_nav_menu_walker_classname(array $createdMenuItemLi): string
    {
      $customClassNamePrefix = 'custom-menu-item-';

      if (count($this->createdMenuItemLi) === 0 || $this->createdMenuItemLi === NULL ) {
        $returnedClassName = $customClassNamePrefix.'1';
        return in_array($returnedClassName, $createdMenuItemLi['registered-classnames'] ) ? '' : $returnedClassName;
      }

      $tmpIndexArray = $this->currentIndexedItem;

      foreach (array_keys($tmpIndexArray, 0, true) as $key) {
        unset($tmpIndexArray[$key]);
      }

      // $this->createdMenuItemLi['heading-index']
      $strArray = array_map(function($num){return strval($num);}, $tmpIndexArray);
      $indexedClassName = implode('-',$strArray);

      $returnedClassName = $customClassNamePrefix.$indexedClassName;
      return in_array($returnedClassName, $createdMenuItemLi['registered-classnames'] ) ? '' : $returnedClassName;
    }


	/* function start_el(&$output, $item, $depth = 0, $args = array() , $id = 0){}
		$indent = ( $depth ) ? str_repeat("\t", $depth) : '';

		$li_attributes = '';
		$class_names = $value = '';

		// Create a class name
		$class_names_arr = empty($item->classes) ? array() : (array) $item->classes;

		$class_names_arr[] = ($args->walker->has_children) ? 'dropdown' : '';
		$class_names_arr[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
		$class_names_arr[] = 'menu-item-'.$item->ID;
        
		if($depth && $args->walker->has_children){
			$class_names_arr[] = 'dropdown-submenu';
		}

		$class_names = join(' ', apply_filters('nav_menu_css_class',
															array_filter($class_names_arr),
															$item, $args) );

		$class_names_list = ' class="'.esc_attr($class_names). ' px-2 nav-item' . '"';

		// Construct an ID
		$id = apply_filters('nav_menu_item_id', 'menu-item-'.$item->ID, $item, $args);
		$id = strlen($id) ? ' id="'.esc_attr($class_names).'"' : '';

		// 1. Generate a 'li' element
		$output .= $indent.'<li '. $id . $value . $class_names_list . $li_attributes . '>';

		// 2. Generate a 'a' element
		$attributes = ! empty($item->attr_title) ? ' title="'.esc_attr($item->attr_title).'"' : '';
		$attributes .= ! empty($item->target) ? ' target="'.esc_attr($item->target).'"' : '';
		$attributes .= ! empty($item->xfn) ? ' role="'.esc_attr($item->xfn).'"' : '';
		$attributes .= ! empty($item->url) ? ' href="'.esc_attr($item->url).'"'.' style="color:black;text-decoration:none;"' : '';

		// Assign dropdown link if "a" element has children
		$attributes .= ($args->walker->has_children) ? ' class="dropdown-toggle"'.' data-bs-toggle="dropdown"' : '';

		$item_output = $args->before;
		$item_output .= '<a' .$attributes. '>' ;
		$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID). $args->link_after;
		$item_output .= ( $depth == 0 && $args->walker->has_children) ? ' <b class="caret"></b></a>' : '</a>';
		$item_output .= $args->after;

		// 3. Generate a 'span' element - with $attributeSpans

		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	} */

	// closing li a span - use method inherited from parent class Walker_Nav_Menu
/*	function end_el(){

	}*/

	// closing ul - use method inherited from parent class Walker_Nav_Menu
/*	function end_lvl(){

	}*/


}//End of custom walker class definition. 

