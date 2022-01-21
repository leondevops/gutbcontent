<?php
/*
 * @package gutbcontent_plugin
 * @version 1.0.1
 */
?>
<h1>Custom Templates Manager</h1>
<p><b>Please read the 4 - instruction of how to use custom template.</b></p>

<p>This admin setting page will list all possible templates for WordPress pages, posts. Some templates are applicable for both posts & pages types</p>

<p><b>The plugin is still under development progress. There will be a lot of features will be added to this Gutbcontent plugin in the future. Essentially, Gutbcontent is designed to provide comprehensive content for WordPress website. </b></p>

<h3>1. Current page templates being used in the current theme :</h3>

<?php
// WP_Theme::get_post_templates()
$currentTheme = wp_get_theme();
$templates = $currentTheme->get_page_templates(null, 'page');

echo "<ul>";
foreach ( $templates as $templateFile => $templateName ) {
    echo "<li>" . $templateName . " (File : " . $templateFile . " )</li>";
}
echo "</ul>";

?>

<h3>2. Current post templates being used in the current thene :</h3>

<?php
$templates = $currentTheme->get_page_templates(null,'post');

echo "<ul>";
foreach ( $templates as $templateFile => $templateName ) {
    echo "<li>" . $templateName . " (File : " . $templateFile . " )</li>";
}
echo "</ul>";
?>

<h3>3. Current registered navigation menu</h3>

<?php 
    foreach(wp_get_nav_menus() as $item){
        //var_dump($item);
        echo sprintf('Menu name : "%s" - Menu ID :"%s"', $item->name, $item->term_id);
        echo '<br>';
    }
?>

<h3>4. Instructions of how to use custom template</h3>
<?php 
    $pluginUrl = plugin_dir_url( dirname(__FILE__, 2) );
    $instructionImageSrc = $pluginUrl.'assets/resources/images/';
    ?>
<h4> 4.1. Activate the custom template features </h4>
<p>After installing & activating the GutbContent plugin, users need to activate Custom template features: </p>

<img src="<?php echo $instructionImageSrc.'1-activate-custom-template.png'?>" alt="Activate the custom template plugin feature">

<h4> 4.2. Select navigation menu which will be used for custom template </h4>

<p>From WordPress admin setting page -> Appearance -> Menu -> Select the menu which will be displayed at custom template.  </p>
<p> (This will not affect to the display of other posts,pages.)</p>
<img src="<?php echo $instructionImageSrc.'2-select-menu-display-at-custom-template-1.png'?>" alt="Activate the custom template plugin feature">

<p> Assign the selected menu to Gutbcontent menu position </p>
<img src="<?php echo $instructionImageSrc.'3-select-menu-display-at-custom-template-2.png'?>" alt="Activate the custom template plugin feature">

<h4> 4.3. Assign Gutbcontent scientific template to the dedicated post</h4>
<img src="<?php echo $instructionImageSrc.'4-set-template-for-post-at-editor.png'?>" alt="Activate the custom template plugin feature">

<h4> 4.4. Open the designated post using its URL, the frontend display is as below </h4>
<p>You can toggle open/close the sticky TOC (table of content) via the cross ("X") button. </p>
<img src="<?php echo $instructionImageSrc.'5-template-frontend-display.png'?>" alt="Activate the custom template plugin feature">

<p><b>Thanks for using my product. If you have any comment or contribution which help us to improve our product, please contact via the Gutbcontent plugin information</b></p>


