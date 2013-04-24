<?php
/**
 * Post Snippets Help.
 *
 * Class to handle the help texts and tabs on the settings screen.
 *
 * @package		Post Snippets
 * @author		Johan Steen <artstorm at gmail dot com>
 * @since		Post Snippets 1.8.9
 */
class PostSnippets_Help
{
	/**
	 * Constructor.
	 *
	 * @since	Post Snippets 1.8.9
	 * @param	string	The option page to load the help text on
	 */
	public function __construct( $option_page )
	{
		// parent::__construct();
		// If WordPress is 3.3 or higher, use the new Help API, otherwise call
		// the old contextual help action.
		global $wp_version;
		if ( version_compare($wp_version, '3.3', '>=') ) {
			add_action( 'load-' . $option_page, array(&$this,'addHelpTabs') );
		} else {
			add_action( 'contextual_help', array(&$this,'addHelp'), 10, 3 );
		}
	}

	/**
	 * Setup the help tabs and sidebar.
	 *
	 * @since	Post Snippets 1.8.9
	 */
	public function addHelpTabs() {
		$screen = get_current_screen();
		$screen->set_help_sidebar( $this->helpSidebar() );
		$screen->add_help_tab( array(
			'id'      => 'basic-plugin-help',
			'title'   => __( 'Basic', PostSnippets::TEXT_DOMAIN ),
			'content' => $this->helpBasic()
		) );
		$screen->add_help_tab( array(
			'id'      => 'shortcode-plugin-help',
			'title'   => __( 'Shortcode', PostSnippets::TEXT_DOMAIN ),
			'content' => $this->helpShortcode()
		) );
		if ( PostSnippets::canExecutePHP() ) {
			$screen->add_help_tab( array(
				'id'      => 'php-plugin-help',
				'title'   => __( 'PHP', PostSnippets::TEXT_DOMAIN ),
				'content' => $this->helpPhp()
			) );
		}
		$screen->add_help_tab( array(
			'id'      => 'advanced-plugin-help',
			'title'   => __( 'Advanced', PostSnippets::TEXT_DOMAIN ),
			'content' => $this->helpAdvanced()
		) );
	}

	/**
	 * The right sidebar help text.
	 * 
	 * @since	Post Snippets 1.8.9
	 * @return	string	The help text
	 */
	public function helpSidebar()
	{
		return '<p><strong>'.
		__( 'For more information:', PostSnippets::TEXT_DOMAIN ).
		'</strong></p>

		<p><a href="http://wpstorm.net/wordpress-plugins/post-snippets/" target="_blank">'.
		__( 'Post Snippets Documentation', PostSnippets::TEXT_DOMAIN ).
		'</a></p>

		<p><a href="http://wordpress.org/tags/post-snippets?forum_id=10" target="_blank">'.
		__( 'Support Forums', PostSnippets::TEXT_DOMAIN ).
		'</a></p>';
	}

	/**
	 * The basic help tab.
	 * 
	 * @since	Post Snippets 1.9.1
	 * @return	string	The help text
	 */
	public function helpBasic()
	{
		return '<h2>'.
		__( 'Title', PostSnippets::TEXT_DOMAIN ).
		'</h2>
		<p>'.
		__( 'Give the snippet a title that helps you identify it in the post editor. This also becomes the name of the shortcode if you enable that option', PostSnippets::TEXT_DOMAIN ).
		'</p>

		<h2>'.
		__( 'Variables', PostSnippets::TEXT_DOMAIN ).
		'</h2>
		<p>'.
		__( 'A comma separated list of custom variables you can reference in your snippet. A variable can also be assigned a default value that will be used in the insert window by using the equal sign, variable=default.', PostSnippets::TEXT_DOMAIN ).
		'</p>
		<p><strong>'.
		__( 'Example', PostSnippets::TEXT_DOMAIN ).
		'</strong><br/>
		<code>url,name,role=user,title</code></p>'.

		'<h2>'.
		__( 'Snippet', PostSnippets::TEXT_DOMAIN ).
		'</h2>
		<p>'.
		__('This is the block of text, HTML or PHP to insert in the post or as a shortcode. If you have entered predefined variables you can reference them from the snippet by enclosing them in {} brackets.', PostSnippets::TEXT_DOMAIN ).
		'</p>
		<p><strong>'.
		__( 'Example', PostSnippets::TEXT_DOMAIN ).
		'</strong><br/>'.
		__( 'To reference the variables in the example above, you would enter {url} and {name}. So if you enter this snippet:', PostSnippets::TEXT_DOMAIN ).
		'<br/>
		<code>This is the website of &lt;a href="{url}"&gt;{name}&lt;/a&gt;</code>
		<br/>'.
		__( 'You will get the option to replace url and name on insert if they are defined as variables.', PostSnippets::TEXT_DOMAIN).
		'</p>
		
		<h2>'
		. __( 'Description', PostSnippets::TEXT_DOMAIN ).
		'</h2>
		<p>'.
		__( 'An optional description for the Snippet. If filled out, the description will be displayed in the snippets insert window in the post editor.', PostSnippets::TEXT_DOMAIN).
		'</p>';
	}

	/**
	 * The shortcode help tab.
	 * 
	 * @since	Post Snippets 1.9.1
	 * @return	string	The help text
	 */
	public function helpShortcode()
	{
		return '<p>'.
		__( 'When enabling the shortcode checkbox, the snippet is no longer inserted directly but instead inserted as a shortcode. The obvious advantage of this is of course that you can insert a block of text or code in many places on the site, and update the content from one single place.', PostSnippets::TEXT_DOMAIN ).
		'</p>

		<p>'.
		__( 'The name to use the shortcode is the same as the title of the snippet (spaces are not allowed). When inserting a shortcode snippet, the shortcode and not the content will be inserted in the post.', PostSnippets::TEXT_DOMAIN ).
		'</p>
		<p>'.
		__( 'If you enclose the shortcode in your posts, you can access the enclosed content by using the variable {content} in your snippet. The {content} variable is reserved, so don\'t use it in the variables field.', PostSnippets::TEXT_DOMAIN ).
		'</p>

		<h2>'
		. __( 'Options', PostSnippets::TEXT_DOMAIN ).
		'</h2>
		<p><strong>PHP</strong><br/>'.
		__( 'See the dedicated help section for information about PHP shortcodes.', PostSnippets::TEXT_DOMAIN ).
		'</p>
		<p><strong>wptexturize</strong><br/>'.
		sprintf(__( 'Before the shortcode is outputted, it can optionally be formatted with %s, to transform quotes to smart quotes, apostrophes, dashes, ellipses, the trademark symbol, and the multiplication symbol.', PostSnippets::TEXT_DOMAIN ), '<a href="http://codex.wordpress.org/Function_Reference/wptexturize">wptexturize</a>' ).
		'</p>';
	}

	/**
	 * The PHP help tab.
	 * 
	 * @since	Post Snippets 1.9.1
	 * @return	string	The help text
	 */
	public function helpPhp()
	{
		return '<p>'.
		__('Snippets defined as shortcodes can optionally also be evaluated as PHP Code by enabling the PHP checkbox. PHP snippets is only available when treating the snippet as a shortcode.', PostSnippets::TEXT_DOMAIN ).
		'</p>
		<p><strong>'.
		__( 'Example PHP Snippet', PostSnippets::TEXT_DOMAIN ).
		'</strong><br/>
		<code>
		for ($i=1; $i<5; $i++) {<br/>
			echo "{loop_me}&lt;br/&gt;";<br/>
		};
		</code></p>

		<p>'.
		__( 'With a snippet defined like the one above, you can call it with its shortcode definition in a post. Let\'s pretend that the example snippet is named phpcode and have one variable defined loop_me, then it would be called like this from a post:' , PostSnippets::TEXT_DOMAIN ).
		'</p>

		<code>[phpcode loop_me="post snippet with PHP!"]</code>

		<p>'.
		__( 'When the shortcode is executed the loop_me variable will be replaced with the string supplied in the shortcode and then the PHP code will be evaluated. (Outputting the string five times in this case. Wow!)', PostSnippets::TEXT_DOMAIN ).
		'</p>
		<p>'.
		__( 'Note the evaluation order, any snippet variables will be replaced before the snippet is evaluated as PHP code. Also note that a PHP snippet don\'t need to be wrapped in &lt;?php #code; ?&gt;.', PostSnippets::TEXT_DOMAIN ).
		'</p>';
	}

	/**
	 * The advanced help tab.
	 * 
	 * @since	Post Snippets 1.9.1
	 * @return	string	The help text
	 */
	public function helpAdvanced()
	{
		return '<p>'.
		__('You can retrieve a Post Snippet directly from PHP, in a theme for instance, by using the PostSnippets::getSnippet() method.', PostSnippets::TEXT_DOMAIN).
		'</p>

		<h2>'.
		__('Usage', PostSnippets::TEXT_DOMAIN).
		'</h2>
		<p>'.
		'<code>
		&lt;?php $my_snippet = PostSnippets::getSnippet( $snippet_name, $snippet_vars ); ?&gt;
		</code></p>

		<h2>'.
		__('Parameters', PostSnippets::TEXT_DOMAIN).
		'</h2>
		<p>
		<code>$snippet_name</code><br/>'.
		__('(string) (required) The name of the snippet to retrieve.', PostSnippets::TEXT_DOMAIN).

		'<br/><br/><code>'.
		'$snippet_vars
		</code><br/>'.
		__('(string) The variables to pass to the snippet, formatted as a query string.', PostSnippets::TEXT_DOMAIN).
		'</p>

		<h2>'.
		__('Example', PostSnippets::TEXT_DOMAIN).
		'</h2>
		<p><code>
		&lt;?php<br/>
			$my_snippet = PostSnippets::getSnippet( \'internal-link\', \'title=Awesome&url=2011/02/awesome/\' );<br/>
			echo $my_snippet;<br/>
		?&gt;
		</code></p>';
	}


	// -------------------------------------------------------------------------
	// For compability with WordPress before v3.3.
	// -------------------------------------------------------------------------

	/**
	 * Contextual Help for WP < v3.3.
	 *
	 * Combines the help tabs above into one long help text for the help tab
	 * when run on WordPress versions before v3.3.
	 *
	 * @since		Post Snippets 1.7.1
	 * @return		string		The Contextual Help
	 */
	public function addHelp($contextual_help, $screen_id, $screen) {
		if ( $screen->id == 'settings_page_post-snippets/post-snippets' ) {
			$contextual_help  = '<h1>'.__( 'Basic', PostSnippets::TEXT_DOMAIN ).'</h1>';
			$contextual_help .= $this->help_basic();
			$contextual_help .= '<h1>'.__( 'Shortcode', PostSnippets::TEXT_DOMAIN ).'</h1>';
			$contextual_help .= $this->help_shortcode();
			$contextual_help .= '<h1>'.__( 'PHP', PostSnippets::TEXT_DOMAIN ).'</h1>';
			$contextual_help .= $this->help_php();
			$contextual_help .= '<h1>'.__( 'Advanced', PostSnippets::TEXT_DOMAIN ).'</h1>';
			$contextual_help .= $this->help_advanced();
		}
		return $contextual_help;
	}
}
