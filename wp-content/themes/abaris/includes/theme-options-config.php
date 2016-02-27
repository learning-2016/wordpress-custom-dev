<?php
/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://github.com/ReduxFramework/ReduxFramework/wiki
 * */

if (!class_exists("Redux_Framework_sample_config")) {

    class Redux_Framework_sample_config {

        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {
            // This is needed. Bah WordPress bugs.  ;)
            if ( strpos( Redux_Helpers::cleanFilePath( __FILE__ ), Redux_Helpers::cleanFilePath( get_template_directory() ) ) !== false) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);    
            }
        }

        public function initSettings() {

            if ( !class_exists("ReduxFramework" ) ) {
                return;
            }       
            
            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/plugin/hooks', array( $this, 'remove_demo' ) );
            // Function to test the compiler hook and demo CSS output.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2); 
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            // Dynamically add a section. Can be also used to modify sections/fields
            add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css) {
            //echo "<h1>The compiler hook has run!";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
              require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
              $wp_filesystem->put_contents(
              $filename,
              $css,
              FS_CHMOD_FILE // predefined mode settings for WP files
              );
              }
             */
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'abaris'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'abaris'),
                'icon' => 'el el-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = "Testing filter hook!";

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::get_instance(), 'plugin_meta_demo_mode_link'), null, 2);
            }

            // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
            remove_action('admin_notices', array(ReduxFrameworkPlugin::get_instance(), 'admin_notices'));
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode(".", $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[] = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct = wp_get_theme();
            $this->theme = $ct;
            $item_name = $this->theme->get('Name');
            $tags = $this->theme->Tags;
            $screenshot = $this->theme->get_screenshot();
            $class = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'abaris'), $this->theme->display('Name'));
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview','abaris'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview','abaris'); ?>" />
            <?php endif; ?>

                <h4>
            <?php echo $this->theme->display('Name'); ?>
                </h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'abaris'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'abaris'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'abaris') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
                <?php
                if ($this->theme->parent()) {
                    printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'abaris') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'abaris'), $this->theme->parent()->display('Name'));
                }
                ?>

                </div>

            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }

            $featuresHTML = <<< FEATURES
            <div class="one-third column">
                <div class="icon-wrap"><i class="el el-cog-alt"></i></div>
                <h3>Page Builder</h3>
                <p>Abaris Pro supports Page Builder. All our shortcodes can be used as widgets too. You can drag and drop our widgets with page builder visual editor.</p>
            </div>
            <div class="one-third column">
                <div class="icon-wrap"><i class="el el-th-large"></i></div>
                <h3>Page Layout</h3>
                <p>Abaris Pro offers many different page layouts so you can quickly and easily create your pages with various layout without any hassle!</p>
            </div>            
            <div class="one-third column">
                <div class="icon-wrap"><i class="el el-adjust-alt"></i></div>
                <h3>Unlimited Sidebar</h3>
                <p>Unlimited sidebars allows you to create multiple sidebars. Check out our demo site to see how different pages displays different sidebars!</p>
            </div>
            <div class="one-third column">
                <div class="icon-wrap"><i class="el el-fork"></i></div>
                <h3>Shortcode Builder</h3>
                <p>With our shortcode builder and lots of shortcodes, you can easily create nested shortcodes and build custom pages!</p>
            </div>
            <div class="one-third column">
                <div class="icon-wrap"><i class="el el-camera"></i></div>
                <h3>Multi Portfolio</h3>
                <p>7 portfolio layouts with Isotope filtering, 3 blog layouts and multiple other alternate layouts for interior pages!</p>
            </div>
            <div class="one-third column">
                <div class="icon-wrap"><i class="el el-fontsize"></i></div>
                <h3>Typography</h3>
                <p>Abaris Pro loves typography, you can choose from over 500+ Google Fonts and Standard Fonts to customize your site!</p>
            </div>
            <div class="one-third column">
                <div class="icon-wrap"><i class="el el-slideshare"></i></div>
                <h3>Awesome Sliders</h3>
                <p>Abaris Pro includes two types of slider. You can use both Flex and Elastic sliders anywhere in your site.</p>
            </div>
            <div class="one-third column">
                <div class="icon-wrap"><i class="el el-dashboard"></i></div>
                <h3>Woo Commerce</h3>
                <p>Abaris Pro has full design/code integration for WooCommerce, your shop will look as good as the rest of your site!</p>
            </div>
            <div class="one-third column">
                <div class="icon-wrap"><i class="el el-tasks"></i></div>
                <h3>Custom Widget</h3>
                <p>We offer many custom widgets that are stylized and ready for use. Simply drag &amp; drop into place to activate!</p>
            </div>
            <div class="one-third column">
                <div class="icon-wrap"><i class="el el-leaf"></i></div>
                <h3>Advanced Admin</h3>
                <p>Advanced Redux Framework for theme options panel, you can customize any part of your site quickly and easily!</p>
            </div>            
            <div class="one-third column">
                <div class="icon-wrap"><i class="el el-magic"></i></div>
                <h3>Font Awesome</h3>
                <p>Font Awesome icons are fully integrated into the theme. Use them anywhere in your site in 6 different sizes!</p>
            </div>
            <div class="one-third column">
                <div class="icon-wrap"><i class="el el-resize-full"></i></div>
                <h3>Responsive Layout</h3>
                <p>Abaris Pro is fully responsive and can adapt to any screen size. Resize your browser window to view it!</p>
            </div>  

            <div class="one-third column">
                <div class="icon-wrap"><i class="el el-magic"></i></div>
                <h3>Testimonials</h3>
                <p>With our testimonial post type, shortcode and widget, Displaying testimonials is a breeze.</p>
            </div>
            <div class="one-third column">
                <div class="icon-wrap"><i class="el el-smiley-alt"></i></div>
                <h3>Social Media</h3>
                <p>Want your users to stay in touch? No problem, Abaris Pro has Social Media icons all throughout the theme!</p>
            </div>
            <div class="one-third column">
                <div class="icon-wrap"><i class="el el-map-marker-alt"></i></div>
                <h3>Google Map</h3>
                <p>Abaris Pro includes Goole Map as shortcode and widget. So, you can use it anywhere in your site!</p>
            </div>
        </div>
FEATURES;

            // ACTUAL DECLARATION OF SECTIONS

            $this->sections[] = array(
                'title' => __('General Settings', 'abaris'),
                'desc' => __('General Settings of Theme to change look and feel through out the site', 'abaris'),
                'icon' => 'el el-cogs',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields' => array(  
                    array(
                        'id'=>'breadcrumb',
                        'type' => 'switch', 
                        'title' => __('Enable Breadcrumb Navigation', 'abaris'),
                        'subtitle'=> __('Check to display breadcrumb navigation.', 'abaris'),
                        'default' => 1,
                        'on' => 'Enable',
                        'off' => 'Disable',
                        ),      

                    array(
                        'id'=>'breadcrumb-char',
                        'type' => 'select',
                        'title' => __('Breadcrumb Character', 'abaris'),
                        'subtitle'=> __('Check to display breadcrumb navigation.', 'abaris'),
                        'options' => array( '1' => ' &raquo; ', '2' => ' / ', '3' => ' > ' ),
                        'default' => '1'
                        ),

                    array(
                        'id'=>'pagenavi',
                        'type' => 'switch', 
                        'title' => __('Enable Numeric Page Navigation', 'abaris'),
                        'subtitle'=> __('Check to display numeric page navigation, instead of Previous Posts / Next Posts links.', 'abaris'),
                        'default'       => 1,
                        'on' => 'Enable',
                        'off' => 'Disable',
                        ),

                    array(
                        'id'=>'animate',
                        'type' => 'switch', 
                        'title' => __('Enable Home page animation effects', 'abaris'),
                        'subtitle'=> __('Check to enable home page css3 animation effects.', 'abaris'),
                        'default'       => 1,
                        'on' => 'Enable',
                        'off' => 'Disable',
                        ),

                    array(
                        'id'=>'layout',
                        'type' => 'image_select',
                        'compiler'=>true,
                        'title' => __('Main Layout', 'abaris' ), 
                        'subtitle' => __('Select main content and sidebar alignment.', 'abaris' ),
                        'options' => array(
                                '2' => array('alt' => 'Right Sidebar', 'img' => ReduxFramework::$_url.'assets/img/2cl.png'),
                                '3' => array('alt' => 'Left Sidebar', 'img' => ReduxFramework::$_url.'assets/img/2cr.png'),
                            ),
                        'default' => '3'
                        ),

                    array(
                        'id'=>'custom-js',
                        'type' => 'textarea',
                        'title' => __('Custom Javascript', 'abaris'), 
                        'subtitle' => __('Quickly add some Javascript to your theme by adding it to this block.', 'abaris'),
                        'validate' => 'js',
                        'desc' => 'Validate that it\'s javascript!',
                        ),      
               array(
                        'id'=>'custom-css',
                        'type' => 'ace_editor',
                        'title' => __('Custom CSS', 'abaris'), 
                        'subtitle' => __('Quickly add some CSS to your theme by adding it to this block.', 'abaris'),
                        'mode' => 'css',
                  'theme' => 'monokai',
                        'desc' => 'Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.',
                        )
                )
            );


            $this->sections[] = array(
                'title' => __('Header', 'abaris'),
                'desc' => __('Theme options related to header section', 'abaris'),
                'icon' => 'el el-arrow-up',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields' => array(  

                    array(
                        'id'=>'site-title',
                        'type' => 'switch', 
                        'title' => __('Logo as site title', 'abaris'),
                        'subtitle'=> __('Enable to load custom logo as site title in header.', 'abaris'),
                        "default"       => 0,
                        'on' => 'Enable',
                        'off' => 'Disable',
                        ),

                    array(
                        'id'=>'custom-logo',
                        'type' => 'media', 
                        'url'=> true,
                        'title' => __('Custom Logo', 'abaris'),
                        'compiler' => 'true',
                        //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'desc'=> __('Upload logo to use as site title', 'abaris'),
                        'subtitle' => __('Upload any media using the WordPress native uploader', 'abaris'),
                        'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
                        ),

                    array(
                        'id'=>'site-description',
                        'type' => 'switch', 
                        'title' => __('Site Description', 'abaris'),
                        'subtitle'=> __('Enable to show site description in header.', 'abaris'),
                        "default"       => 1,
                        'on' => 'Enable',
                        'off' => 'Disable',
                        ),

                    array(
                        'id'=>'favicon',
                        'type' => 'media', 
                        'preview'=> false,
                        'title' => __('Custom Favicon (ICO)', 'abaris'),
                        'desc' => __('You can upload an ico image that will represent your website\'s favicon (16px X 16px)', 'abaris'),
                        ),

                    array(
                        'id'=>'ipad-icon-retina',
                        'type' => 'media', 
                        'preview'=> false,
                        'title' => __('Apple iPad Retina Icon Upload (144px X 144px)', 'abaris'),
                        'desc'=> __('For third-generation iPad with high-resolution Retina display', 'abaris'),
                        ),

                    array(
                        'id'=>'iphone-icon-retina',
                        'type' => 'media', 
                        'preview'=> false,
                        'title' => __('Apple iPhone Retina Icon Upload (114px X 114px)', 'abaris'),
                        'desc'=> __('For iPhone with high-resolution Retina display', 'abaris'),
                        ),

                    array(
                        'id'=>'ipad-icon',
                        'type' => 'media', 
                        'preview'=> false,
                        'title' => __('Apple iPad Icon Upload (72px X 72px)', 'abaris'),
                        'desc'=> __('For first- and second-generation iPad', 'abaris'),
                        ),

                    array(
                        'id'=>'iphone-icon',
                        'type' => 'media', 
                        'preview'=> false,
                        'title' => __('Apple iPhone Icon Upload (57px X 57px)', 'abaris'),
                        'desc'=> __('For non-Retina iPhone, iPod Touch, and Android 2.1+ devices', 'abaris'),
                        ),          
                    )
            );


            $this->sections[] = array(
                'title' => __('Footer', 'abaris'),
                'desc' => __('Theme options related to footer area of theme', 'abaris'),
                'icon' => 'el el-arrow-down',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields' => array(  

                    array(
                        'id'=>'footer-widgets',
                        'type' => 'switch', 
                        'title' => __('Enable Footer Widget Area', 'abaris'),
                        'subtitle'=> __('Check to enable 4 Column Footer widget Area', 'abaris'),
                        "default"       => 0,
                        'on' => 'Enable',
                        'off' => 'Disable',
                        ),

                    array(
                        'id'=>'footer-text',
                        'type' => 'textarea',
                        'title' => __('Footer Copyright Text', 'abaris'), 
                        'subtitle' => __('Footer copyright text. HTML Allowed', 'abaris'),
                        'desc' => __('This field is even HTML validated!', 'abaris'),
                        'default' => __( 'Powered by <a href="http://wordpress.org/" target="_blank">WordPress</a>. Theme by <a href="http://www.webulousthemes.com/">Webulous Themes</a>.', 'abaris' ),
                        'validate' => 'html',
                        ),

                    array(
                        'id'        => 'upgrade-notice-1',
                        'type'      => 'info',
                        'notice'    => true,
                        'style'     => 'critical',
                        'icon'      => 'el el-info-circle',
                        'title'     => __('Abaris Pro Options. <a href="http://www.webulousthemes.com/?add-to-cart=21">Upgrade Now</a> for just $39.', 'abaris'),
                        'desc'      => __('These options are available only in Abaris Pro version theme. Upgrade now for just $39 .', 'abaris')
                    ),

                    array(
                        'id'=>'footer-menu',
                        'type' => 'select',
                        'data' => 'menus',
                        'title' => __('Select Menu', 'abaris'),
                        'subtitle'=> __('Select menu to display in footer.', 'abaris'),
                        ),

                    )
                );

                $this->sections[] = array(
                    'title' => __('Home', 'abaris'),
                    'desc' => __('Theme options related to home page', 'abaris'),
                    'icon' => 'el el-home',
                    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                    'fields' => array(  

                        array(
                            'id'=>'slides',
                            'type' => 'slides',
                            'title' => __('Flex Slider Options', 'abaris' ),
                            'subtitle'=> __('Unlimited slides with drag and drop sortings.', 'abaris' ),
                            'show' => array( 'title' => true, 'description' => true, 'url' => true ),
                        ),

                        array(
                            'id'        => 'upgrade-notice-2',
                            'type'      => 'info',
                            'notice'    => true,
                            'style'     => 'critical',
                            'icon'      => 'el el-info-circle',
                            'title'     => __('Flex Slider Post Type and Multiple Sliders. <a href="http://www.webulousthemes.com/?add-to-cart=21">Upgrade Now</a> for just $39.', 'abaris'),
                            'desc'      => __('Upgrade to Abaris Pro version to use Flex Slider Custom Post Type<br> and setup multiple sliders. You can also tweak slider effects.', 'abaris')
                        ),
                        array(
                        'id'=>'service-icon-1',
                        'type' => 'select',
                        'data' => 'elusive-icons',
                        'title' => __('1. Service Icon', 'abaris' ), 
                        'subtitle' => __('Select icon that represents your service', 'abaris' ),
                        ),
                        array(
                            'id'=>'service-description-1',
                            'type' => 'textarea',
                            'title' => __('1. Service Description', 'abaris' ), 
                            'subtitle' => __('Custom HTML, Just like a text box widget.', 'abaris' ),
                            'desc' => __('This field is even HTML validated!', 'abaris' ),
                            'validate' => 'html',
                        ),

                        array(
                            'id'=>'service-icon-2',
                            'type' => 'select',
                            'data' => 'elusive-icons',
                            'title' => __('2. Service Icon', 'abaris' ), 
                            'subtitle' => __('Select icon that represents your service', 'abaris' ),
                        ),
                        array(
                            'id'=>'service-description-2',
                            'type' => 'textarea',
                            'title' => __('2. Service Description', 'abaris' ), 
                            'subtitle' => __('Custom HTML, Just like a text box widget.', 'abaris' ),
                            'desc' => __('This field is even HTML validated!', 'abaris' ),
                            'validate' => 'html',
                        ),

                        array(
                            'id'=>'service-icon-3',
                            'type' => 'select',
                            'data' => 'elusive-icons',
                            'title' => __('3. Service Icon', 'abaris' ), 
                            'subtitle' => __('Select icon that represents your service', 'abaris' ),
                        ),
                        array(
                            'id'=>'service-description-3',
                            'type' => 'textarea',
                            'title' => __('3. Service Description', 'abaris' ), 
                            'subtitle' => __('Custom HTML, Just like a text box widget.', 'abaris' ),
                            'desc' => __('This field is even HTML validated!', 'abaris' ),
                            'validate' => 'html',
                        ),

                        array(
                            'id'=>'features',
                            'type' => 'textarea',
                            'title' => __('Why Us? (or) Featrues', 'abaris' ), 
                            'subtitle' => __('A list is best, like "Why Us?", "Features".', 'abaris' ),
                            'validate' => 'html',
                        ),  


                        array(
                            'id'=>'skill-heading',
                            'type' => 'text',
                            'title' => __('Skills Heading', 'abaris' ), 
                            'subtitle' => __('Enter heading of the skills list', 'abaris' ),
                        ),  

                        array(
                            'id'=>'skill-1',
                            'type' => 'text',
                            'title' => __('1. Skill Name', 'abaris' ), 
                            'subtitle' => __('Enter name of the skill', 'abaris' ),
                        ),      
                        array(
                            'id'=>'percentage-1',
                            'type' => 'spinner',
                            'title' => __('1. Skill Percentage', 'abaris' ), 
                            'desc' => __('Enter 0 to 100', 'abaris' ),
                            'min' => '0',
                            'max' => '100',
                            'step' => '5',
                        ),

                        array(
                            'id'=>'skill-icon-1',
                            'type' => 'select',
                            'data' => 'elusive-icons',
                            'title' => __('1. Skill Icon', 'abaris' ), 
                            'subtitle' => __('Select icon that represents this skill', 'abaris' ),
                        ),

                        array(
                            'id'=>'skill-2',
                            'type' => 'text',
                            'title' => __('2. Skill Name', 'abaris' ), 
                            'subtitle' => __('Enter name of the skill', 'abaris' ),
                        ),      

                        array(
                            'id'=>'percentage-2',
                            'type' => 'spinner',
                            'title' => __('2. Skill Percentage', 'abaris' ), 
                            'desc' => __('Enter 0 to 100', 'abaris' ),
                            'min' => '0',
                            'max' => '100',
                            'step' => '5',
                        ),

                        array(
                            'id'=>'skill-icon-2',
                            'type' => 'select',
                            'data' => 'elusive-icons',
                            'title' => __('2. Skill Icon', 'abaris' ), 
                            'subtitle' => __('Select icon that represents this skill', 'abaris' ),
                        ),

                        array(
                            'id'=>'skill-3',
                            'type' => 'text',
                            'title' => __('3. Skill Name', 'abaris' ), 
                            'subtitle' => __('Enter name of the skill', 'abaris' ),
                        ),

                        array(
                            'id'=>'percentage-3',
                            'type' => 'spinner',
                            'title' => __('3. Skill Percentage', 'abaris' ), 
                            'desc' => __('Enter 0 to 100', 'abaris' ),
                            'min' => '0',
                            'max' => '100',
                            'step' => '5',
                        ),

                        array(
                            'id'=>'skill-icon-3',
                            'type' => 'select',
                            'data' => 'elusive-icons',
                            'title' => __('3. Skill Icon', 'abaris' ), 
                            'subtitle' => __('Select icon that represents this skill', 'abaris' ),
                        ),

                        array(
                            'id'=>'skill-4',
                            'type' => 'text',
                            'title' => __('4. Skill Name', 'abaris' ), 
                            'subtitle' => __('Enter name of the skill', 'abaris' ),
                            ),

                        array(
                            'id'=>'percentage-4',
                            'type' => 'spinner',
                            'title' => __('4. Skill Percentage', 'abaris' ), 
                            'desc' => __('Enter 0 to 100', 'abaris' ),
                            'min' => '0',
                            'max' => '100',
                            'step' => '5',
                        ),

                        array(
                            'id'=>'skill-icon-4',
                            'type' => 'select',
                            'data' => 'elusive-icons',
                            'title' => __('4. Skill Icon', 'abaris' ), 
                            'subtitle' => __('Select icon that represents this skill', 'abaris' ),
                        ),

                        array(
                            'id'=>'skill-5',
                            'type' => 'text',
                            'title' => __('5. Skill Name', 'abaris' ), 
                            'subtitle' => __('Enter name of the skill', 'abaris' ),
                        ),

                        array(
                            'id'=>'percentage-5',
                            'type' => 'spinner',
                            'title' => __('5. Skill Percentage', 'abaris' ), 
                            'desc' => __('Enter 0 to 100', 'abaris' ),
                            'min' => '0',
                            'max' => '100',
                            'step' => '5',
                        ),

                        array(
                            'id'=>'skill-icon-5',
                            'type' => 'select',
                            'data' => 'elusive-icons',
                            'title' => __('5. Skill Icon', 'abaris' ), 
                            'subtitle' => __('Select icon that represents this skill', 'abaris' ),
                        ),

                        array(
                            "id" => "homepage_blocks",
                            "type" => "sorter",
                            "title" => "Homepage Layout Manager",
                            "desc" => "Organize how you want the layout to appear on the homepage",
                            "compiler"=>'true',
                            'options' => array(
                                "enabled" => array(
                                    "placebo" => "placebo", //REQUIRED!
                                    'default' => "Default content"
                                ),
                                "disabled" => array(
                                    "placebo" => "placebo", //REQUIRED!
                                    "slider" => "Slider",
                                    "services" => "Services",
                                    "features" => "Why Us and Skills",
                                    'recent_posts' => 'Recent Posts',
                                ),
                            ),
                        ),  
		                array(
		                    'id'        => 'upgrade-notice-3',
		                    'type'      => 'info',
		                    'notice'    => true,
		                    'style'     => 'critical',
		                    'icon'      => 'el el-info-circle',
		                    'title'     => __('Abaris Pro Options. <a href="http://www.webulousthemes.com/?add-to-cart=21">Upgrade Now</a> for just $39.', 'abaris'),
		                    'desc'      => __('These options are available only in Abaris Pro version theme. Upgrade now for just $39 .', 'abaris')
		                ),
		                array(
		                    'id'=>'home-pagebuilder',
		                    'type' => 'switch', 
		                    'title' => __('Use Page Builder.', 'abaris'),
		                    'subtitle'=> __('Check this to disable theme options for home page content and use page builder to enter content', 'abaris'),
		                    "default" => 0,
		                    'on' => 'Enable',
		                    'off' => 'Disable',
		                    ),

		                array(
		                    'id' => 'home-flexslider',
		                    'type' => 'text',
		                    'title' => __( 'Enter FlexSlider shortcode', 'abaris' ),
		                    'subtitle' => __( 'FlexSlider for Home Page', 'abaris' ),
		                    'desc' => __( 'Enter a FlexSlider shortcode to be displayed on Home Page', 'abaris' ),

		                ),
                    )
                );

                $this->sections[] = array(
                    'title' => __('Blog', 'abaris'),
                    'desc' => __('Blog options for site', 'abaris'),
                    'icon' => 'el el-file',
                    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                    'fields' => array(  

                        array(
                            'id'=>'featured-image',
                            'type' => 'switch', 
                            'title' => __('Featured Image', 'abaris'),
                            'subtitle'=> __('Check to show featured image', 'abaris'),
                            "default"       => 0,
                            'on' => 'Show',
                            'off' => 'Hide',
                            ),

                        array(
                            'id'=>'single-featured-image',
                            'type' => 'switch', 
                            'title' => __('Single Post Featured Image', 'abaris'),
                            'subtitle'=> __('Check to show featured image on single post', 'abaris'),
                            "default"       => 0,
                            'on' => 'Show',
                            'off' => 'Hide',
                            ),
                    array(
                        'id'        => 'upgrade-notice-4',
                        'type'      => 'info',
                        'notice'    => true,
                        'style'     => 'critical',
                        'icon'      => 'el el-info-circle',
                        'title'     => __('Abaris Pro Options. <a href="http://www.webulousthemes.com/?add-to-cart=21">Upgrade Now</a> for just $39.', 'abaris'),
                        'desc'      => __('These options are available only in Abaris Pro version theme. Upgrade now for just $39', 'abaris')
                    ),
                    
                    array(
                        'id'=>'show-author-bio',
                        'type' => 'switch', 
                        'title' => __('Author Bio Box', 'abaris'),
                        'subtitle'=> __('Show Author information box below single post.', 'abaris'),
                        "default"       => 0,
                        'on' => 'Show',
                        'off' => 'Hide',
                        ),

                    array(
                        'id'=>'show-social-sharing',
                        'type' => 'switch', 
                        'title' => __('Social Sharing Box', 'abaris'),
                        'subtitle'=> __('Show social sharing options box below single post.', 'abaris'),
                        "default"       => 0,
                        'on' => 'Show',
                        'off' => 'Hide',
                        ),

                    array(
                        'id'=>'show-related-posts',
                        'type' => 'switch', 
                        'title' => __('Related Posts', 'abaris'),
                        'subtitle'=> __('Show related posts.', 'abaris'),
                        "default"       => 0,
                        'on' => 'Show',
                        'off' => 'Hide',
                        ),

                    array(
                        'id'=>'show-comments',
                        'type' => 'switch', 
                        'title' => __('Comments', 'abaris'),
                        'subtitle'=> __('Show comments.', 'abaris'),
                        "default"       => 1,
                        'on' => 'Show',
                        'off' => 'Hide',
                        ),

                    array(
                        'id'=>'show-post-meta',
                        'type' => 'switch', 
                        'title' => __('Post Meta', 'abaris'),
                        'subtitle'=> __('Show post meta.', 'abaris'),
                        "default"       => 1,
                        'on' => 'Show',
                        'off' => 'Hide',
                        ),
                    /*
                     array(
                        'id'=>'post-content',
                        'type' => 'select',
                        'title' => __('Post Content', 'abaris'),
                        'subtitle'=> __('Select Excerpt or Full Content  to show on blog / archive pages.', 'abaris'),
                        'options' => array( '1' => ' Excerpt ', '2' => ' Full Content ' ),
                        'default' => '1'
                    ),
                    */


                    array(
                        'id'=>'excerpt-length',
                        'type' => 'text',
                        'title' => __('Excerpt Length', 'abaris' ), 
                        'subtitle' => __('Input the number of words you want to cut from the content to be the excerpt of search and archive page.', 'abaris' ),
                        'default' => 100,
                        ),
                    )
                );

            $this->sections[] = array(
                'title' => __('Social Sharing Box', 'abaris'),
                'desc' => __('Social Sharing Icons Setup', 'abaris'),
                'icon' => 'el el-share',
                'fields' => array(  
                    array(
                        'id'        => 'upgrade-notice-5',
                        'type'      => 'info',
                        'notice'    => true,
                        'style'     => 'critical',
                        'icon'      => 'el el-info-circle',
                        'title'     => __('Abaris Pro Options. <a href="http://www.webulousthemes.com/?add-to-cart=21">Upgrade Now</a> for just $39.', 'abaris'),
                        'desc'      => __('These options are available only in Abaris Pro version theme. Upgrade now for just $39 .', 'abaris')
                    ),

                    array( 
                        'id' => 'ss_box_facebook',
                        'type' => 'switch',
                        'title' => 'Facebook',
                        'subtitle' => 'Show facebook sharing option in single posts.',
                        'default' => 0,
                        'on' => 'Show',
                        'off' => 'Hide',
                    ), 

                    array( 
                        'id' => 'ss_box_twitter',
                        'type' => 'switch',
                        'title' => 'Twitter',
                        'subtitle' => 'Show twitter sharing option in single posts.',
                        'default' => 0,
                        'on' => 'Show',
                        'off' => 'Hide',
                    ),

                    array( 
                        'id' => 'ss_box_linkedin',
                        'type' => 'switch',
                        'title' => 'LinkedIn',
                        'subtitle' => 'Show linkedin sharing option in single posts.',
                        'default' => 0,
                        'on' => 'Show',
                        'off' => 'Hide',
                    ),

                    array( 
                        'id' => 'ss_box_googleplus',
                        'type' => 'switch',
                        'title' => 'Google Plus',
                        'subtitle' => 'Show googleplus sharing option in single posts.',
                        'default' => 0,
                        'on' => 'Show',
                        'off' => 'Hide',
                    ),

                    array( 
                        'id' => 'ss_box_email',
                        'type' => 'switch',
                        'title' => 'Email',
                        'subtitle' => 'Show email sharing option in single posts.',
                        'default' => 0,
                        'on' => 'Show',
                        'off' => 'Hide',
                    ),
                )
            );

            $this->sections[] = array(
                'title' => __('Social Network', 'abaris'),
                'desc' => __('Social Network Links', 'abaris'),
                'icon' => 'el el-share',
                'fields' => array(
                    array(
                        'id'        => 'upgrade-notice-6',
                        'type'      => 'info',
                        'notice'    => true,
                        'style'     => 'critical',
                        'icon'      => 'el el-info-circle',
                        'title'     => __('Abaris Pro Options. <a href="http://www.webulousthemes.com/?add-to-cart=21">Upgrade Now</a> for just $39.', 'abaris'),
                        'desc'      => __('These options are available only in Abaris Pro version theme. Upgrade now for just $39 .', 'abaris')
                    ),

                    array( 
                        'id' => 'social-digg',
                        'type' => 'text',
                        'title' => 'Digg',
                        'subtitle' => 'Your Digg link',
                    ),

                    array( 
                        'id' => 'social-dribble',
                        'type' => 'text',
                        'title' => 'Dribble',
                        'subtitle' => 'Your Dribble link',
                    ),

                    array( 
                        'id' => 'social-facebook',
                        'type' => 'text',
                        'title' => 'Facebook',
                        'subtitle' => 'Your Facebook link',
                    ),

                    array( 
                        'id' => 'social-flickr',
                        'type' => 'text',
                        'title' => 'Flickr',
                        'subtitle' => 'Your Flickr link',
                    ),

                    array( 
                        'id' => 'social-google',
                        'type' => 'text',
                        'title' => 'Google',
                        'subtitle' => 'Your Google link',
                    ),

                    array( 
                        'id' => 'social-linkedin',
                        'type' => 'text',
                        'title' => 'LinkedIn',
                        'subtitle' => 'Your LinkedIn link',
                    ),

                    array( 
                        'id' => 'social-pinterest',
                        'type' => 'text',
                        'title' => 'Pinterest',
                        'subtitle' => 'Your Pinterest link',
                    ),

                    array( 
                        'id' => 'social-rss',
                        'type' => 'text',
                        'title' => 'RSS',
                        'subtitle' => 'Your RSS link',
                    ),

                    array( 
                        'id' => 'social-skype',
                        'type' => 'text',
                        'title' => 'Skype',
                        'subtitle' => 'Your Skype link',
                    ),

                    array( 
                        'id' => 'social-tumblr',
                        'type' => 'text',
                        'title' => 'Tumblr',
                        'subtitle' => 'Your Tumblr link',
                    ),

                    array( 
                        'id' => 'social-twitter',
                        'type' => 'text',
                        'title' => 'Twitter',
                        'subtitle' => 'Your Twitter link',
                    ),

                    array( 
                        'id' => 'social-vimeo',
                        'type' => 'text',
                        'title' => 'Vimeo',
                        'subtitle' => 'Your Vimeo link',
                    ),

                    array( 
                        'id' => 'social-youtube',
                        'type' => 'text',
                        'title' => 'YouTube',
                        'subtitle' => 'Your YouTube link',
                    ),

                )
            );
            $this->sections[] = array(
                'title' => __('Support', 'abaris'),
                'desc' => __('Documentation', 'abaris'),
                'icon' => 'el el-user',
                'fields' => array(

                    array(
                        'id'        => 'support-notice',
                        'type'      => 'info',
                        'style'     => 'critical',
                        'title'     => __('Support and Documentation.', 'abaris'),
                        'desc'      => __('Please refer to <a href="http://demo.webulous.in/abaris/documentation/">documentation</a> page of this site\'s demo to know how to use theme options specific to this theme. For professional support about customization and other advices from theme author, Please <a href="http://www.webulousthemes.com/?add-to-cart=21">Upgrade</a> to Abaris Pro Version', 'abaris')
                    ),
                )
            );

            $this->sections[] = array(
                'title' => __('Why Upgrade?', 'abaris'),
                'desc' => __('Features you\'ll get in Pro Version', 'abaris'),
                'icon' => 'el el-magic',
                'fields' => array(
                    
                    array(
                        'id'        => 'pro-features',
                        'type'      => 'raw',
                        'content'   => $featuresHTML,
                    ),
                    

                )
            );

            $this->sections[] = array(
                'title' => __('Flex Slider', 'abaris'),
                'desc' => __('Flex Slider Settings', 'abaris'),
                'icon' => 'el el-screen',
                'fields' => array(

                    array(
                        'id'        => 'upgrade-notice-7',
                        'type'      => 'info',
                        'notice'    => true,
                        'style'     => 'critical',
                        'icon'      => 'el el-info-circle',
                        'title'     => __('Abaris Pro Options. <a href="http://www.webulousthemes.com/?add-to-cart=21">Upgrade Now</a> for just $39.', 'abaris'),
                        'desc'      => __('These options are available only in Abaris Pro version theme. Upgrade now for just $39 .', 'abaris')
                    ),
                    
                    array(
                        'id' => 'flexslider_animation',
                        'type' => 'select',
                        'title' => 'Animation',
                        'subtitle' => 'Select slider animation effect.',
                        'default' => '1',
                        'options' => array( 1 => 'fade', 2 => 'slide'),
                    ),

                    array(
                        'id' => 'flexslider_slide_direction',
                        'type' => 'select',
                        'title' => 'Slide Direction',
                        'subtitle' => 'Select direction to slide (if you are using the "Slide" animation)',
                        'default' => '1',
                        'options' => array( '1' => 'horizontal', '2' => 'vertical' ),
                    ),

                    array(
                        'id'        => 'flexslider_slideshow_speed',
                        'type'      => 'spinner',
                        'title'     => 'Slideshow Speed',
                        'subtitle'      => 'Set the delay between each slide animation (in milliseconds)',
                        'default'       => '7000',
                      'min' => '0',
                      'max' => '10000',
                      'step' => '100',
                    ),

                    array(
                        'id'        => 'flexslider_animation_speed',
                        'type'      => 'spinner',
                        'title'     => 'Animation Speed',
                        'subtitle'      => 'Set the duration of each slide animation (in milliseconds)',
                        'default'       => '600',
                      'min' => '0',
                      'max' => '10000',
                      'step' => '100',
                    ),

                    array(
                        'id' => 'flexslider_slideshow',
                        'type'      => 'switch',
                        'title' => 'Slideshow',
                        'subtitle' => 'Animate the slideshows automatically',
                        'default' => 0,
                        'on'        => 'Yes',
                        'off'       => 'No',
                    ), 

                    array(
                        'id' => 'flexslider_smooth_height',
                        'type'      => 'switch',
                        'title' => 'Auto Height',
                        'subtitle' => 'Adjust the height of the slideshow to the height of the current slide',
                        'default' => 0,
                        'on'        => 'Yes',
                        'off'       => 'No',
                    ), 

                    array(
                        'id' => 'flexslider_direction_nav',
                        'type'      => 'switch',
                        'title' => 'Previous / Next Buttons',
                        'subtitle' => 'Display the "Previous/Next" Buttons',
                        'default' => 0,
                        'on'        => 'Show',
                        'off'       => 'Hide',
                    ), 

                    array(
                        'id' => 'flexslider_control_nav',
                        'type'      => 'switch',
                        'title' => 'Pagination',
                        'subtitle' => 'Display the slideshow pagination',
                        'default' => 0,
                        'on'        => 'Show',
                        'off'       => 'Hide',
                    ), 

                    array(
                        'id' => 'flexslider_keyboard_nav',
                        'type'      => 'switch',
                        'title' => 'Keyboard Navigation',
                        'subtitle' => 'Enable keyboard navigation',
                        'default' => 0,
                        'on'        => 'Enable',
                        'off'       => 'Disable',
                    ), 

                    array(
                        'id' => 'flexslider_mousewheel_nav',
                        'type'      => 'switch',
                        'title' => 'Mouse Wheel Navigation',
                        'subtitle' => 'Enable the mousewheel navigation',
                        'default' => 0,
                        'on'        => 'Enable',
                        'off'       => 'Disable',
                    ), 


                    array(
                        'id' => 'flexslider_pauseplay',
                        'type'      => 'switch',
                        'title' => 'Pause / Play',
                        'subtitle' => 'Enable the "Pause/Play" event',
                        'default' => 0,
                        'on'        => 'Enable',
                        'off'       => 'Disable',
                    ), 

                    array(
                        'id' => 'flexslider_randomize',
                        'type'      => 'switch',
                        'title' => 'Random Slides',
                        'subtitle' => 'Randomize the order of slides in slideshows',
                        'default' => 0,
                        'on'        => 'Yes',
                        'off'       => 'No',
                    ), 

                    array(
                        'id' => 'flexslider_animation_loop',
                        'type'      => 'switch',
                        'title' => 'Loop Slideshow',
                        'subtitle' => 'Loop the slideshow animations',
                        'default' => 0,
                        'on'        => 'Yes',
                        'off'       => 'No',
                    ), 

                    array(
                        'id' => 'flexslider_pause_on_action',
                        'type'      => 'switch',
                        'title' => 'Pause On Action',
                        'subtitle' => 'Pause the slideshow autoplay when using the pagination or "Previous/Next" navigation',
                        'default' => 0,
                        'on'        => 'Yes',
                        'off'       => 'No',
                    ), 

                    array(
                        'id' => 'flexslider_pause_on_hover',
                        'type'      => 'switch',
                        'title' => 'Pause On Hover',
                        'subtitle' => 'Pause the slideshow autoplay when hovering over a slide',
                        'default' => 0,
                        'on'        => 'Yes',
                        'off'       => 'No',
                    ), 

                    array(
                        'id'        => 'flexslider_prev_text',
                        'type'      => 'text',
                        'title'     => '"Previous" Button',
                        'subtitle'      => 'The text to display on the "Previous" button.',
                        'default'       => 'Previous',
                    ),

                    array(
                        'id'        => 'flexslider_next_text',
                        'type'      => 'text',
                        'title'     => '"Next" Button',
                        'subtitle'      => 'The text to display on the "Next" button.',
                        'default'       => 'Next',
                    ),

                    array(
                        'id'        => 'flexslider_play_text',
                        'type'      => 'text',
                        'title'     => '"Play" Button',
                        'subtitle'      => 'The text to display on the "Play" button.',
                        'default'       => 'Play',
                    ),

                    array(
                        'id'        => 'flexslider_pause_text',
                        'type'      => 'text',
                        'title'     => '"Pause" Button',
                        'subtitle'      => 'The text to display on the "Pause" button.',
                        'default'       => 'Pause',
                    ),
                )
            );

            $this->sections[] = array(
                'title' => __('Light Box', 'abaris'),
                'desc' => __('Light Box Settings', 'abaris'),
                'icon' => 'el el-idea',
                'fields' => array(

                    array(
                        'id'        => 'upgrade-notice-8',
                        'type'      => 'info',
                        'notice'    => true,
                        'style'     => 'critical',
                        'icon'      => 'el el-info-circle',
                        'title'     => __('Abaris Pro Options. <a href="http://www.webulousthemes.com/?add-to-cart=21">Upgrade Now</a> for just $39.', 'abaris'),
                        'desc'      => __('These options are available only in Abaris Pro version theme. Upgrade now for just $39 .', 'abaris')
                    ),
                    
                    array( 
                        'id' => 'lightbox_theme',
                        'type' => 'select',
                        'title' => 'Lightbox Theme',
                        'subtitle' => '',
                        'default' => '1',
                        'options' => array(
                            '1' => 'pp_default',
                            '2' => 'light_rounded',
                            '3' => 'dark_rounded',
                            '4' => 'light_square',
                            '5' => 'dark_square',
                            '6' => 'facebook'
                        ),
                    ),
                                        
                    array( 
                        'id' => 'lightbox_animation_speed',
                        'type' => 'select',
                        'title' => 'Animation Speed',
                        'subtitle' => '',
                        'default' => '1',
                        'options' => array( '1' => 'Fast', '2' => 'Slow', '3' => 'Normal' ),
                    ),

                    array( 
                        'id' => 'lightbox_slideshow',
                        'type' => 'spinner',
                        'title' => 'Autoplay Gallery Speed',
                        'subtitle' => 'If autoplay is set to true, select the slideshow speed in ms. (Default: 5000, 1000 ms = 1 second)',
                        'default' => '5000',
                        'min' => '1000',
                        'max' => '10000',
                        'step' => '100',
                    ),

                    array( 
                        'id' => 'lightbox_autoplay_slideshow',
                        'type'      => 'switch',
                        'title' => 'Autoplay Gallery',
                        'subtitle' => 'Check to autoplay the lightbox gallery',
                        'default' => 0,
                        'on'        => 'Yes',
                        'off'       => 'No',
                    ),

                    array( 
                        'id' => 'lightbox_opacity',
                        'type' => 'text',
                        'title' => 'Background Opacity',
                        'subtitle' => 'Enter 0.1 to 1.0',
                        'default' => '0.7',
                    ),

                    array( 
                        'id' => 'lightbox_show_title',
                        'type'      => 'switch',
                        'title' => 'Title',
                        'subtitle' => 'Select visibility of the title',
                        'default' => 1,
                        'on'        => 'Show',
                        'off'       => 'Hide',
                    ),


                    array( 
                        'id' => 'lightbox_overlay_gallery',
                        'type'      => 'switch',
                        'title' => 'Show Gallery Thumbnails',
                        'subtitle' => 'Check to show gallery thumbnails',
                        'default' => 1,
                        'on'        => 'Show',
                        'off'       => 'Hide',
                    ),


                    array( 
                        'id' => 'lightbox_social_tools',
                        'type'      => 'switch',
                        'title' => 'Social Icons',
                        'subtitle' => 'Check to show social sharing icons',
                        'default' => 1,
                        'on'        => 'Show',
                        'off'       => 'Hide',
                    ),

                )
            );

            $this->sections[] = array(
                'title' => __('Typography', 'abaris'),
                'desc' => __('Typography and Link Color Settings', 'abaris'),
                'icon' => 'el el-font',
                'fields' => array(

                    array(
                        'id'        => 'upgrade-notice-9',
                        'type'      => 'info',
                        'notice'    => true,
                        'style'     => 'critical',
                        'icon'      => 'el el-info-circle',
                        'title'     => __('Abaris Pro Options. <a href="http://www.webulousthemes.com/?add-to-cart=21">Upgrade Now</a> for just $39.', 'abaris'),
                        'desc'      => __('These options are available only in Abaris Pro version theme. Upgrade now for just $39 .', 'abaris')
                    ),
                    
                    array(
                        'id'=>'custom-typography',
                        'type' => 'switch', 
                        'title' => __('Enable Custom Typography', 'abaris'),
                        'subtitle'=> __('Turn on to customize typography and turn off for default typography.', 'abaris'),
                        'default'       => 0,
                        'on' => 'Enable',
                        'off' => 'Disable',
                        ),    

                    array(
                        'id'       => 'opt-link-color',
                        'type'     => 'link_color',
                        'title'    => __('Links Color Option', 'abaris'),
                        'subtitle' => __('Only color validation can be done on this field type', 'abaris'),
                        'desc'     => __('This is the description field, again good for additional info.', 'abaris'),
                        'default'  => array(
                            'regular'  => '#ff4200', // blue
                            'hover'    => '#ff4200', // red
                            'active'   => '#ff4200',  // purple
                            'visited'  => '#ff4200'  // purple
                        )
                    ),

                    array(
                        'id'        => 'dummy-typography',
                        'type'      => 'typography',
                        'title'     => __('Font Preview', 'abaris'),
                        'google'    => true,
                        'text-align'    => false,
                        'subsets'   => false,
                        'line-height'   => false,
                        'color' => false,
                        'subtitle'  => __('Preview Google fonts using this field. Sets nothing, just preview.', 'abaris'),
                        'default'   => array( 'font-family' => 'Abel', 'font-size' => '24px' )
                    ),

                    array(
                        'id'        => 'bd-typography',
                        'type'      => 'typography',
                        'title'     => __('Body Font', 'abaris'),
                        'google'    => true,
                        'text-align'    => false,
                        'subsets'   => false,
                        'line-height'   => false,
                        'preview'   => false,
                        'subtitle'  => __('Specify the body font properties.', 'abaris'),
                        'default'   => array(
                            'color'         => '#333',
                            'font-style'    => '400',
                            'font-family'   => 'Roboto',
                            'google'        => true,
                            'font-size'     => '14px',
                            'line-height'   => '1.4',
                        )
                    ),

                    array(
                        'id'        => 'nav-typography',
                        'type'      => 'typography',
                        'title'     => __('Navigation Font', 'abaris'),
                        'google'    => true,
                        'text-align'    => false,
                        'subsets'   => false,
                        'line-height'   => false,
                        'preview'   => false,
                        'subtitle'  => __('Specify the navigation font properties.', 'abaris'),
                        'default'   => array(
                            'color'         => '#ffffff',
                            'font-style'    => '400',
                            'font-family'   => 'Roboto',
                            'google'        => true,
                            'font-size'     => '14px'
                        )
                    ),

                    array(
                        'id'        => 'h1-typography',
                        'type'      => 'typography',
                        'title'     => __('H1 Font Properties', 'abaris'),
                        'google'    => true,
                        'text-align'    => false,
                        'subsets'   => false,
                        'line-height'   => false,
                        'preview'   => false,
                        'subtitle'  => __('Specify the h1 font properties.', 'abaris'),
                        'default'   => array(
                            'color'         => '#333',
                            'font-style'    => '400',
                            'font-family'   => 'Bree Serif',
                            'google'        => true,
                            'font-size'     => '47.6px'
                        )
                    ),

                    array(
                        'id'        => 'h2-typography',
                        'type'      => 'typography',
                        'title'     => __('H2 Font Properties', 'abaris'),
                        'google'    => true,
                        'text-align'    => false,
                        'subsets'   => false,
                        'line-height'   => false,
                        'preview'   => false,
                        'subtitle'  => __('Specify the h2 font properties.', 'abaris'),
                        'default'   => array(
                            'color'         => '#333',
                            'font-style'    => '400',
                            'font-family'   => 'Bree Serif',
                            'google'        => true,
                            'font-size'     => '30.8px'
                        )
                    ),

                    array(
                        'id'        => 'h3-typography',
                        'type'      => 'typography',
                        'title'     => __('H3 Font Properties', 'abaris'),
                        'google'    => true,
                        'text-align'    => false,
                        'subsets'   => false,
                        'line-height'   => false,
                        'preview'   => false,
                        'subtitle'  => __('Specify the h3 font properties.', 'abaris'),
                        'default'   => array(
                            'color'         => '#333',
                            'font-style'    => '400',
                            'font-family'   => 'Bree Serif',
                            'google'        => true,
                            'font-size'     => '23.8px'
                        )
                    ),

                    array(
                        'id'        => 'h4-typography',
                        'type'      => 'typography',
                        'title'     => __('H4 Font Properties', 'abaris'),
                        'google'    => true,
                        'text-align'    => false,
                        'subsets'   => false,
                        'line-height'   => false,
                        'preview'   => false,
                        'subtitle'  => __('Specify the h4 font properties.', 'abaris'),
                        'default'   => array(
                            'color'         => '#333',
                            'font-style'    => '400',
                            'font-family'   => 'Bree Serif',
                            'google'        => true,
                            'font-size'     => '21px'
                        )
                    ),

                    array(
                        'id'        => 'h5-typography',
                        'type'      => 'typography',
                        'title'     => __('H5 Font Properties', 'abaris'),
                        'google'    => true,
                        'text-align'    => false,
                        'subsets'   => false,
                        'line-height'   => false,
                        'preview'   => false,
                        'subtitle'  => __('Specify the h5 font properties.', 'abaris'),
                        'default'   => array(
                            'color'         => '#333',
                            'font-style'    => '400',
                            'font-family'   => 'Bree Serif',
                            'google'        => true,
                            'font-size'     => '18.2px'
                        )
                    ),

                    array(
                        'id'        => 'h6-typography',
                        'type'      => 'typography',
                        'title'     => __('H6 Font Properties', 'abaris'),
                        'google'    => true,
                        'text-align'    => false,
                        'subsets'   => false,
                        'line-height'   => false,
                        'preview'   => false,
                        'subtitle'  => __('Specify the h6 font properties.', 'abaris'),
                        'default'   => array(
                            'color'         => '#333',
                            'font-style'    => '400',
                            'font-family'   => 'Bree Serif',
                            'google'        => true,
                            'font-size'     => '16.1px'
                        )
                    ),
                )
            );

        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id' => 'redux-opts-1',
                'title' => __('Theme Information 1', 'abaris'),
                'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'abaris')
            );

            $this->args['help_tabs'][] = array(
                'id' => 'redux-opts-2',
                'title' => __('Theme Information 2', 'abaris'),
                'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'abaris')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'abaris');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name' => 'abaris', // This is where your data is stored in the database and also becomes your global variable name.
                'display_name' => $theme->get('Name'), // Name that appears at the top of your panel
                'display_version' => $theme->get('Version'), // Version that appears at the top of your panel
                'menu_type' => 'menu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu' => true, // Show the sections below the admin menu item or not
                'menu_title' => __('Theme Options', 'abaris'),
                'page' => __('Theme Options', 'abaris'),
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '', // Must be defined to add google fonts to the typography module
                //'admin_bar' => false, // Show the panel pages on the admin bar
                'global_variable' => '', // Set a different name for your global variable other than the opt_name
                'dev_mode' => false, // Show the time the page took to load, etc
                'customizer' => true, // Enable basic customizer support
                // OPTIONAL -> Give you extra features
                'page_priority' => null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent' => 'themes.php', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions' => 'manage_options', // Permissions needed to access the options panel.
                'menu_icon' => '', // Specify a custom URL to an icon
                'last_tab' => '', // Force your panel to always open to a specific tab (by id)
                'page_icon' => 'icon-themes', // Icon displayed in the admin panel next to your menu_title
                'page_slug' => '_options', // Page slug used to denote the panel
                'save_defaults' => true, // On load save the defaults to DB before user clicks save or not
                'default_show' => false, // If true, shows the default value next to each field that is not the default value.
                'default_mark' => '', // What to print by the field's title if the value shown is default. Suggested: *
                // CAREFUL -> These options are for advanced use only
                'transient_time' => 60 * MINUTE_IN_SECONDS,
                'output' => true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag' => true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                //'domain'             	=> 'redux-framework', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
                //'footer_credit'      	=> '', // Disable the footer credit of Redux. Please leave if you can help it.
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database' => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'show_import_export' => true, // REMOVE
                'system_info' => false, // REMOVE
                'help_tabs' => array('docs'),
                'help_sidebar' => '', // __( '', $this->args['domain'] );            
            );


            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.		
            $this->args['share_icons'][] = array(
                'url' => 'https://github.com/venkatraj',
                'title' => 'Visit me on GitHub',
                'icon' => 'el el-github'
                    // 'img' => '', // You can use icon OR img. IMG needs to be a full URL.
            );
            $this->args['share_icons'][] = array(
                'url' => 'https://www.facebook.com/pages/webulous/170827696548',
                'title' => 'Like us on Facebook',
                'icon' => 'el el-facebook'
            );
            $this->args['share_icons'][] = array(
                'url' => 'https://twitter.com/webulous',
                'title' => 'Follow us on Twitter',
                'icon' => 'el el-twitter'
            );
            $this->args['share_icons'][] = array(
                'url' => 'https://www.linkedin.com/company/coding-geek',
                'title' => 'Find us on LinkedIn',
                'icon' => 'el el-linkedin'
            );



            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace("-", "_", $this->args['opt_name']);
                }
                //$this->args['intro_text'] = sprintf(__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'abaris'), $v);
                $this->args['intro_text'] = sprintf(__('<p class="btn-upgrade"><a href="http://www.webulousthemes.com/?add-to-cart=21"><i class="el el-upload"></i> Upgrade for just $39</a> <a href="http://demo.webulous.in/abarispro/" class="vide-demo"><i class="el el-eye-open"></i>View Demo</a><a href="http://www.webulousthemes.com/forums/forum/free-support/" target="_blank" class="btn-help">Ask A Question</a><a href="http://docs.webulous.in/abaris-free/" target="_blank" class="btn-help">Documentation</a></p>', 'abaris'), $v);
            } else {
                $this->args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'abaris');
            }
            
           //$this->args['intro_text'] = __('<p><a href="#">Buy Pro Version</a> <a href="#">Donate</a> <a href="#">Support</a> <a href="#">Rate This Theme</a></p>', 'abaris');

            // Add content after the form.
            $this->args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'abaris');
           $this->args['footer_text'] .= '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">';
           $this->args['footer_text'] .= '<input type="hidden" name="cmd" value="_donations">';
           $this->args['footer_text'] .= '<input type="hidden" name="business" value="uma@codinggeek.om">';
           $this->args['footer_text'] .= '<input type="hidden" name="lc" value="US">';
           $this->args['footer_text'] .= '<input type="hidden" name="item_name" value="Theme">';
           $this->args['footer_text'] .= '<input type="hidden" name="item_number" value="Abaris">';
           $this->args['footer_text'] .= '<input type="hidden" name="no_note" value="0">';
           $this->args['footer_text'] .= '<input type="hidden" name="currency_code" value="USD">';
           $this->args['footer_text'] .= '<input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_LG.gif:NonHostedGuest">';
           $this->args['footer_text'] .= '<p>Like this theme? Help me in further development ';
           $this->args['footer_text'] .= '<input type="submit" value="Donate Now!" class="button button-primary" name="submit"></p>';
           //$this->args['footer_text'] .= '<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"  style="float: right; margin-top: -20px;">';
           //$this->args['footer_text'] .= '<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">';
           $this->args['footer_text'] .= '</form>';
        }

    }

    new Redux_Framework_sample_config();
}


/**

  Custom function for the callback referenced above

 */
if (!function_exists('redux_my_custom_field')):

    function redux_my_custom_field($field, $value) {
        print_r($field);
        print_r($value);
    }

endif;

/**

  Custom function for the callback validation referenced above

 * */
if (!function_exists('redux_validate_callback_function')):

    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';
        /*
          do your validation

          if(something) {
          $value = $value;
          } elseif(something else) {
          $error = true;
          $value = $existing_value;
          $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }


endif;
