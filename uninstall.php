<?php
/* trigger when uninstalling this plugin */

/*
 * @package Devsunshine_Plugin
 * @version 1.0.1
 */

if( !defined('WP_UNINSTALL_PLUGIN') ){
  die;
}

/** Clear the data stored in WordPress database **/
/* For book custom post type :
 - Clear "book" custom post type.
 - Clear "book" meta data
 - Clear all relationships of "book" custom post type
*/

/* Method 1: Use existed WordPress functions - for simple custom post types */
// - numberposts = -1 => get all posts

/*
$books = get_posts(
  array(
    'post_type'     => 'book',
    'numberposts'   => -1,
  )
);

foreach($books as $book){
  // Do not delete posts in trash, private.
  wp_delete_post($book->ID, false);
}
*/

/* Method 2: Interact with database directly using SQL commands */
/*global $wpdb;
$wpdb->query("DELETE FROM wp_posts WHERE post_type = 'book'");
$wpdb->query("DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)");
$wpdb->query("DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)");*/


