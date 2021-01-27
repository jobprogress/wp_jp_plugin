<?php 
    class Form_Settings extends JobProgress {
        /**
         * [$validation_error validation error
         * @var null
         */
        public $wp_error = null;

        /**
         * [$input description]
         * @var array
         */
        public $input = array();
        
        /**
         * 
         * @return [type] [description]
         */
        public function __construct() {
            parent::__construct();
            add_action( 'admin_menu',array($this, 'jp_admin_page') );
            add_action( 'admin_init', array( $this, 'form_register_settings' ) );
        }


        /**
         * jobprogress admin section menus show on left side
         * @return [type] [description]
         */
        public function jp_admin_page() {
            // show Settings label on menu list
            add_submenu_page( 
                'jp_admin_page', 
                'Form Settings', 
                'Settings', 
                'manage_options', 
                'jp_settings_page', 
                array($this, 'index')
            );
        }


        function form_register_settings(){
            register_setting( 'jp_form_settings', 'jp_customer_form_fields', 'sd_callback_function' );
        }

        /**
         * form fields manager in admin panel
         * @return [type] [description]
         */
        public function index() {
            $settings 	= get_option( 'jp_customer_form_fields' );
            // if(!empty(get_option( 'jp_customer_form_fields' )) || get_option( 'jp_customer_form_fields' ) != '') {
            //     print_r($settings);
            // }
            // if(empty(get_option( 'jp_customer_form_fields' )) || get_option( 'jp_customer_form_fields' ) == '') {
            //     $settings = array(
            //         array(
            //             'name' => 'customer_type',
            //             'title' => 'Customer Type',
            //             'order' => '0',
            //             'isActive' => '0'
            //             'isRequired' => true
            //         ),
            //         array(
            //             'name' => 'customer_name',
            //             'title' => 'Customer Name',
            //             'order' => '1',
            //             'isActive' => '0',
            //             'isRequired' => true
            //         ),
            //         array(
            //             'name' => 'company_name',
            //             'title' => 'Company Name',
            //             'order' => '2',
            //             'isActive' => '0',
            //             'isRequired' => false
            //         ),
            //         array(
            //             'name' => 'customer_phone',
            //             'title' => 'Customer Phone',
            //             'order' => '3',
            //             'isActive' => '0',
            //             'isRequired' => false
            //         ),
            //         array(
            //             'name' => 'customer_email',
            //             'title' => 'Customer Email',
            //             'order' => '4',
            //             'isActive' => '0',
            //             'isRequired' => false
            //         ),
            //         array(
            //             'name' => 'customer_address',
            //             'title' => 'Customer Address',
            //             'order' => '5',
            //             'isActive' => '0',
            //             'isRequired' => false
            //         ),
            //         array(
            //             'name' => 'billing_address',
            //             'title' => 'Billing Address',
            //             'order' => '6',
            //             'isActive' => '0',
            //             'isRequired' => false
            //         ),
            //         array(
            //             'name' => 'referred_by',
            //             'title' => 'Referred By',
            //             'order' => '7',
            //             'isActive' => '0',
            //             'isRequired' => false
            //         ),
            //         array(
            //             'name' => 'trades',
            //             'title' => 'Trades',
            //             'order' => '8',
            //             'isActive' => '0',
            //             'isRequired' => true
            //         ),
            //         array(
            //             'name' => 'decription',
            //             'title' => 'Description',
            //             'order' => '9',
            //             'isActive' => '0',
            //             'isRequired' => true
            //         )
            //     )
            //     print_r($settings);
            // }
            
            // hide/show and sorting of form fields form
            return require_once(JP_PLUGIN_DIR. 'form-settings-index-page.php');
        }
    }