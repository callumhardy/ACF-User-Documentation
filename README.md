
# ACF User Documentation

This plugin creates two sections in the back end where you can create and display user documentation posts to help make using the site easier for a client with a customised interface.

# Usage

The plugin can be uploaded and activated as a Wordpress plugin or the file `ACF_User_Documentation.php` can be included directly in the theme's function file.

## Wordpress back end

The plugin creates two back end tabs.

First is the User Documentation post type, where administrators or other users with access can create Documentation posts.

Secondly there is the User Documentation page. All published User Documentation posts will appear on this page for the client to view.

## Filters

### acf_user_documentation_args

	function filter_function_name( $args ) {
	  // Do user manipulation here
	  return $args;
	}
	add_filter( 'acf_user_documentation_args', 'filter_function_name', 10, 2 );

**$args**

> (*array*) The current config arguments for the plugin

#### acf_user_documentation_args Parameters

**$allowed_users**

> (*int*/*string*) You may restrict who can view the User Documentation post type page. You may specify users by entering IDs or usernames. Only users whos ID or username appears in this array can see the User Documentation post type page. By default the array only displays the User Documentation post type page for a user with an ID of '1'.


# Examples

## Displaying the User Documentation Post Type Page page only for select users

Since the creation of user documentation posts are not really any use for a client. It would be a good idea to only allow them to view the User Documentation Page, which displays all the documentation posts whilst hiding the User Documentation post type page from them.

Here we are setting the plugin to only display the User Documentation post type page for a user with an id or '12' or a user name of 'ed_user'.

	add_filter( 'acf_user_documentation_args',function( $args ){
		
		$args = array(
			'allowed_users' => array( 12, 'ed_user' )
		);

		return $args;

	});

# Dependencies

There are two dependent plugins.

- [Advanced Custom Fielld](http://wordpress.org/plugins/advanced-custom-fields/)
- [ACF Options Page](http://www.advancedcustomfields.com/add-ons/options-page/)
