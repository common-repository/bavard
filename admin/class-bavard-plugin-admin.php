<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.bavard.ai
 * @since      1.0.0
 *
 * @package    Bavard_Plugin
 * @subpackage Bavard_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Bavard_Plugin
 * @subpackage Bavard_Plugin/admin
 * @author     davidwbrwnJon <davidwbrwnwebmob2997@gmail.com>
 */
class Bavard_Plugin_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        add_action('admin_menu', array($this, 'addPluginAdminMenu'), 9);
        add_action('admin_init', array($this, 'registerAndBuildFields'));
        add_action('wp_footer', array($this, 'displayChatBot'));
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/bavard-plugin-admin.css', array(), $this->version, 'all');

    }

    /**
     * Add plugin admin menu to the sidebar
     */

    public function addPluginAdminMenu()
    {
        //add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
        add_menu_page(
            $this->plugin_name,
            'Bavard Settings',
            'administrator',
            $this->plugin_name,
            array($this, 'displayPluginAdminDashboard'),
            'dashicons-nametag',
            26
        );
    }

    public function registerAndBuildFields()
    {
        /**
         * First, we add_settings_section. This is necessary since all future settings must belong to one.
         * Second, add_settings_field
         * Third, register_setting 
         */

        do_settings_sections('bavard_section');
        add_settings_section(
            // ID used to identify this section and with which to register options
            'bavard_section',
            // Title to be displayed on the administration page
            '',
            // Callback used to render the description of the section
            array($this, 'showDescription'),
            // Page on which to add this section of options
            'bavard_settings'
        );
        unset($args);
        $args = array(
            'type' => 'input',
            'subtype' => 'checkbox',
            'id' => 'enableBavard',
            'name' => 'enableBavard',
            'required' => 'true',
            'get_options_list' => '',
            'value_type' => 'normal',
            'wp_data' => 'option',
        );

        add_settings_field(
            'enableBavard', // id
            'Enabled', // title
            array($this, 'render_settings_field'), // callback
            'bavard_settings', // page
            'bavard_section', // section
            $args
        );

        register_setting(
            'bavard_settings',
            'enableBavard'
        );
        /** agent id */
        unset($args);
        $args = array(
            'type' => 'input',
            'subtype' => 'text',
            'id' => 'agentId',
            'name' => 'agentId',
            'required' => 'true',
            'get_options_list' => '',
            'value_type' => 'normal',
            'wp_data' => 'option',
        );

        add_settings_field(
            'agentId', // id
            'Agent ID', // title
            array($this, 'render_settings_field'), // callback
            'bavard_settings', // page
            'bavard_section', // section
            $args
        );

        register_setting(
            'bavard_settings',
            'agentId'
        );

        /** Debug Mode */

        unset($args);
        $args = array(
            'type' => 'input',
            'subtype' => 'checkbox',
            'id' => 'debugMode',
            'name' => 'debugMode',
            'required' => 'true',
            'get_options_list' => '',
            'value_type' => 'normal',
            'wp_data' => 'option',
        );

        add_settings_field(
            'debugMode', // id
            'Debug Mode', // title
            array($this, 'render_settings_field'), // callback
            'bavard_settings', // page
            'bavard_section', // section
            $args
        );

        register_setting(
            'bavard_settings',
            'debugMode'
        );

        /** Development Mode */

        unset($args);
        $args = array(
            'type' => 'input',
            'subtype' => 'checkbox',
            'id' => 'devMode',
            'name' => 'devMode',
            'required' => 'true',
            'get_options_list' => '',
            'value_type' => 'normal',
            'wp_data' => 'option',
        );

        add_settings_field(
            'devMode', // id
            'Development Mode', // title
            array($this, 'render_settings_field'), // callback
            'bavard_settings', // page
            'bavard_section', // section
            $args
        );

        register_setting(
            'bavard_settings',
            'devMode'
        );

        /** agent name */
        unset($args);
        $args = array(
            'type' => 'input',
            'subtype' => 'text',
            'id' => 'gaTrackingCode',
            'name' => 'gaTrackingCode',
            'required' => 'true',
            'get_options_list' => '',
            'value_type' => 'normal',
            'wp_data' => 'option',
        );

        add_settings_field(
            'gaTrackingCode', // id
            'Google Analytics Tracking Code', // title
            array($this, 'render_settings_field'), // callback
            'bavard_settings', // page
            'bavard_section', // section
            $args
        );

        register_setting(
            'bavard_settings',
            'gaTrackingCode'
        );

        /** Ban URL Mode */

        unset($args);
        $args = array(
            'type' => 'textarea',
            'id' => 'urlBox',
            'name' => 'urlBox',
            'required' => 'true',
            'get_options_list' => '',
            'value_type' => 'normal',
            'wp_data' => 'option',
        );

        add_settings_field(
            'urlBox', // id
            'Paths (none means all paths)', // title
            array($this, 'render_settings_field'), // callback
            'bavard_settings', // page
            'bavard_section', // section
            $args
        );

        register_setting(
            'bavard_settings',
            'urlBox'
        );
    }

    public function showDescription()
    {
        echo '<p>If you haven\'t already, create and publish a bot in the Bavard console.</p>';
        echo '<p>Then copy agent id and fill in the fields below. Leave debug and development modes unchecked and click Save.</p>';
    }

    public function displayChatBot()
    {
        $settings = array('enableBavard', 'agentId', 'debugMode', 'devMode', 'urlBox', 'gaTrackingCode');
        $isEnabled = get_option($settings[0]) == 1 ? true : false;
        $agentId = get_option($settings[1]);
        $debugMode = get_option($settings[2]) == 1 ? 'true' : 'false';
        $devMode = get_option($settings[3]) == 1 ? 'true' : 'false';
        $urlList = get_option($settings[4]);
        $gaTrackingCode = get_option($settings[5]);

        $displayBlock = $isEnabled ? "
        <script defer src=\"https://bavard-widget-prod.web.app/main.bundle.js\"></script>
        <script defer>
          window.addEventListener(\"load\", (event) => {
            window.loadBavard({
                agentId: '$agentId',
                gaTrackingCode: '$gaTrackingCode',
                debug: $debugMode,
                dev: $devMode,
            });
        });
        </script>" : "";
        // display the codeblock

        $current_path = $_SERVER["REQUEST_URI"];
        $paths = preg_split("/[\s]+/", $urlList);

        if (in_array($current_path, $paths) || strlen($paths[0]) == 0) {
            echo $displayBlock;
        }
    }

    /**
     * Plugin View function
     */

    public function displayPluginAdminDashboard()
    {
        require_once 'partials/' . $this->plugin_name . '-admin-display.php';
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/bavard-plugin-admin.js', array('jquery'), $this->version, false);

    }

    /**
     * Register Settings
     */

    public function render_settings_field($args)
    {
        if ($args['wp_data'] == 'option') {
            $wp_data_value = get_option($args['name']);
        } elseif ($args['wp_data'] == 'post_meta') {
            $wp_data_value = get_post_meta($args['post_id'], $args['name'], true);
        }

        switch ($args['type']) {

            case 'input':
                $value = ($args['value_type'] == 'serialized') ? serialize($wp_data_value) : $wp_data_value;
                if ($args['subtype'] != 'checkbox') {
                    $prependStart = (isset($args['prepend_value'])) ? '<div class="input-prepend"> <span class="add-on">' . $args['prepend_value'] . '</span>' : '';
                    $prependEnd = (isset($args['prepend_value'])) ? '</div>' : '';
                    $step = (isset($args['step'])) ? 'step="' . $args['step'] . '"' : '';
                    $min = (isset($args['min'])) ? 'min="' . $args['min'] . '"' : '';
                    $max = (isset($args['max'])) ? 'max="' . $args['max'] . '"' : '';
                    if (isset($args['disabled'])) {
                        // hide the actual input bc if it was just a disabled input the info saved in the database would be wrong - bc it would pass empty values and wipe the actual information
                        echo $prependStart . '<input type="' . $args['subtype'] . '" id="' . $args['id'] . '_disabled" ' . $step . ' ' . $max . ' ' . $min . ' name="' . $args['name'] . '_disabled" size="40" disabled value="' . esc_attr($value) . '" /><input type="hidden" id="' . $args['id'] . '" ' . $step . ' ' . $max . ' ' . $min . ' name="' . $args['name'] . '" size="40" value="' . esc_attr($value) . '" />' . $prependEnd;
                    } else {
                        echo $prependStart . '<input type="' . $args['subtype'] . '" id="' . $args['id'] . '" "' . $args['required'] . '" ' . $step . ' ' . $max . ' ' . $min . ' name="' . $args['name'] . '" size="40" value="' . esc_attr($value) . '" />' . $prependEnd;
                    }

                } else {
                    $checked = ($value) ? 'checked' : '';
                    echo '<input type="' . $args['subtype'] . '" id="' . $args['id'] . '" "' . $args['required'] . '" name="' . $args['name'] . '" size="40" value="1" ' . $checked . ' />';
                }
                break;
            case 'textarea':
                $value = ($args['value_type'] == 'serialized') ? serialize($wp_data_value) : $wp_data_value;
                echo '<textarea id="' . $args['id'] . '" name="' . $args['name'] . '" rows="6" cols="80">' . esc_attr($value) . '</textarea>';
            default:
                # code...
                break;
        }
    }

}
