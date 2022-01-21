
# I. Plugin generic information
# 1. Plugin directory: 
C:\WebPlatform\apache24\htdocs\vnlabwin\wp-content\plugins\gutbcontent
cd C:\WebPlatform\apache24\htdocs\vnlabwin\wp-content\plugins\gutbcontent

# 2. Plugin features
- Adding additional custom content to WordPress site. 

2.1. User can configure the content at backend. 
2.2. User can display the content customized at fronend using:
+ Custom widget (sidebar/widget area).
+ Shortcode (content area)
+ Posts/Pages template (for generic posts/pages)
+ Gutenberg content block 
(Probably too much)


# II. Plugin operation
# 1. Access the root folder of plugin directory: 
cd C:\WebPlatform\apache24\htdocs\vnlabwin\wp-content\plugins\gutbcontent


# 2. Implement task runners - Gulp
# 2.1. Distribute SCSS & JS for plugin:
# * 2.2.1. Comprehensive resources distributions
gulp distribute-plugin-styles-scripts

# 2.2.2. Plugin styles
gulp distribute-plugin-styles

# 2.2.3. Plugin scripts
gulp distribute-plugin-scripts

# Or using self-defined script: "distribute-plugin-resources": "gulp distribute-plugin-styles-scripts"
npm run distribute-plugin-resources


# 2.2. Distribute prerequsites/libray for plugin styles & scripts
# 2.2.1. Comprehensive prerequisite/library plugin resources: styles & scripts
gulp distribute-prerequisite-plugin-styles-scripts

# 2.2.2. Distribute plugin styles
gulp distribute-prerequisite-plugin-styles

# 2.2.3. Distribute plugin scripts
gulp distribute-prerequisites-plugin-scripts

# 2.3. Distribute plugins resources - icons - running task distribute-plugin-icons
gulp distribute-plugin-icons

