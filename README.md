# User Information Form - WordPress Plugin Documentation

## Table of Contents
1. Introduction
2. Installation
3. Usage
4. Plugin Structure
5. AJAX Implementation
6. User Information Custom Post Type (CPT)
7. Viewing Form Submissions

## 1. Introduction
The User Information Form is a custom WordPress plugin that allows users to submit their personal information through a form. The plugin collects data such as name, phone, email, address, education, experience, and about me. This documentation provides a guide on how to install, configure, and use the plugin.

## 2. Installation
To install the User Information Form plugin, follow these steps:

1. Download the plugin ZIP file.
2. Log in to your WordPress dashboard.
3. Navigate to "Plugins" > "Add New".
4. Click on the "Upload Plugin" button.
5. Choose the plugin ZIP file and click "Install Now".
6. Once the installation is complete, click "Activate" to activate the plugin.

## 3. Usage
To use the User Information Form plugin, follow these steps:

1. After activating the plugin, a new menu item called "User Information Form" will appear in the WordPress admin sidebar.
2. Click on "User Information Form" to access the plugin settings page.
3. On the settings page, you can configure the form fields and customize the submission behavior.
4. Save the settings to apply your changes.

## 4. Plugin Structure
The User Information Form plugin has the following structure:

- `user-information-form.php`: The main plugin file that initializes the plugin and sets up the hooks.
- `assets/`: Directory containing CSS and JavaScript files.


## 5. AJAX Implementation
The User Information Form plugin utilizes AJAX to handle form submissions without refreshing the page. The AJAX implementation consists of the following files:

- `assets/user-information-form.js`: JavaScript file responsible for handling the form submission through AJAX. It sends a request to the server and displays a success message upon successful submission.
- `includes/ajax-handler.php`: PHP file that receives the AJAX request, validates the form data, and saves it in the WordPress database.

## 6. User Information Custom Post Type (CPT)
The User Information Form plugin creates a custom post type called "User Information" to store the form submissions. The CPT has the following meta fields:

- Name
- Phone
- Email
- Address
- Education
- Experience
- About Me

The CPT is registered using the `includes/cpt.php` file. You can customize the CPT settings and meta fields by modifying this file.

## 7. Viewing Form Submissions
To view the form submissions:

1. Go to the WordPress admin sidebar.
2. Click on "User Information" to access the list of User Information CPT entries.
3. Each entry represents a form submission and displays the submitted data.

You can click on an entry to view the detailed information. The User Information CPT can also be displayed in a sidebar widget using the provided `includes/sidebar-widget.php` file.

---

This documentation provides an overview of the User Information Form WordPress plugin. It covers installation, usage, plugin structure, AJAX implementation, User Information CPT, and viewing form
