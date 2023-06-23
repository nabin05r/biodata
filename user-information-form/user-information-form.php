<?php
/**
 * PLugin Name: User Information Form
 * Description: This plugin will take information of logged-in user through form
 * Author: Nabin Magar
 * Version: 1.0.0
 * Text Domain: user-information-form
 */

if (!defined('ABSPATH')) {
   exit;
}

class UserInformationForm
{

   public function __construct()
   {

      //Create custom post type
      add_action('init', array($this, 'create_custom_post_type'));

      //Add assets (js,css)
      add_action('wp_enqueue_scripts', array($this, 'load_assets'));

      //Add shortcode
      add_shortcode('user-information-form', array($this, 'load_shortcode'));

      //Load Javascript and what 'wp_footer' does is adds code to the footer of website
      add_action('wp_footer', array($this, 'load_javascript'));

      //Register Rest API
      add_action('rest_api_init', array($this, 'register_rest_api'));

      //Adding MetaBox 
      add_action('add_meta_boxes', array($this, 'create_metabox'));
   }

   public function create_custom_post_type()
   {

      //Store all the arguments for our custom post type in args variable
      $args = array(

         'public' => true,
         'has_archive' => true,
         'supports' => false,
         'exclude_from_search' => true,
         'publicly_queryable' => false,
         // 'capability' => 'manage_options',
         'capability_type' => 'page',
         'labels' => array(
            'name' => 'User Information Form',
            'singular_name' => 'User Information Entry'
         ),
         'menu_icon' => 'dashicons-media-text',

      );

      register_post_type('user_information', $args);

   }

   public function load_assets()
   {

      wp_enqueue_style(
         'user_information_form',
         plugin_dir_url(__FILE__) . 'css/style.css',
         array(),
         1,
         'all'
      );

   }

   public function load_shortcode()
   {

      ?>
      
      
      <h1>Registration Form</h1>
      <p> Fill the form and register yourself</p>
      <div class="registration-form">

         <form  id = "user_registration_form" method="POST">
         
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>

            <label for="phone">Phone:</label>
            <input type="tel" name="phone" id="phone" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="address">Address:</label>
            <input type="text" name="address" id="address" required>

            <label for="education">Education:</label>
            <input type="text" name="education" id="education" required>

            <label for="experience">Experience:</label>
            <select id="experience" name="experience" required>
               <option value="">Select Occupation Type</option>
               <option value="IT">IT</option>
               <option value="ENGINEER">ENGINEER</option>
               <option value="MANAGEMENT">MANAGEMENT</option>
            </select>

            <label for="about-me">About Me:</label>
            <textarea name="about-me" id="about-me" rows="5" required></textarea>

            <button type="submit">Register</button>
         </form>

         <div id="form-success" style="background:green; color:#fff; margin-top:20px;"></div>
         <div id="form-error" style="background:red; color:#fff;"></div>
         
      </div>

      <?php

   }

   public function load_javascript(){

      ?>

         <script>

            //It wil grab a nonce which is loaded in every session and make sure csrf forgey not happens, makes sure form is being filled from the website
            var nonce = '<?php echo wp_create_nonce('wp_rest');?>';
           
           // created this function so that I can use $ sign instead of jQuery
           (function($){

            $('#user_registration_form').submit(function(event) {

               // This functionn will prevent the browser from redirecting to next page when we click submit
               event.preventDefault();
               
               // All the form data will be serialized
               var form = $(this).serialize();
               console.log(form);

               //Send the form field data to backend via Ajax
               $.ajax({

                  method: 'post',
                  url: '<?php echo get_rest_url(null, 'user-information-form/send-data');?>',
                  headers: {'X-WP-Nonce': nonce},
                  data: form,
                  success: function(){
                     
                     $("#form-success").html("Your form was sent").fadeIn();
                  },
                  error: function(){
                     $("#form-error").html("There was error submitting your form").fadeIn();
                  }

               })

            }) 

           })(jQuery)
            

         </script>

      <?php

   }

 
   public function register_rest_api(){

        // This function will allows us to register routes, so it knows to receive data from that specific routes
        register_rest_route( 'user-information-form', 'send-data', array(
                  'methods' => 'POST',
                  'callback' => array($this, 'handle_information_form')
        ));

   }

   public function handle_information_form($data){
      //this is where we will handle the data that gets posted
     
      $headers = $data->get_headers();
      $params = $data->get_params();

      $nonce = $headers['x_wp_nonce'][0];
      if(!wp_verify_nonce( $nonce, 'wp_rest')){
         return new WP_REST_Response('Message not send', 422);
      }

      //
     
      $post_arr = [
         'post_title' => $params['name'],
         'post_type' => 'user_information',
         'post_status' => 'publish'
      ];
         
     $post_id = wp_insert_post($post_arr);

     foreach($params as $label => $value){
         
      add_post_meta( $post_id, $label, $value);

     }
      
      if($post_id){
         return new WP_REST_Response('Thank you for registering', 200); 
      }

   }

   public function create_metabox(){

      add_meta_box('custom_information_form', 'Submisson', array($this, 'display_submission'), 'user_information');

   }

   public function display_submission(){
      
      $postmetas = get_post_meta(get_the_ID());

      echo "<ul>";

      foreach($postmetas as $key => $value ){
         echo '<li>'. $key . ":" .$value[0]. '</li>';
      }

      echo "</ul>";

   }

}

new UserInformationForm;