<?php
/**
 * Handles the plugin help screen.
 *
 * @author  Johan Steen <artstorm at gmail dot com>
 * @link    http://johansteen.se/
 */
class PostSnippets_Help
{
    /**
     * Define actions.
     *
     * @param   string  The option page to load the help text on
     * @return void
     */
    public function __construct($optionPage)
    {
        add_action('load-'.$optionPage, array(&$this,'addHelpTabs'));
    }

    /**
     * Setup the help tabs and sidebar.
     *
     * @return void
     */
    public function addHelpTabs()
    {
        $screen = get_current_screen();
        $screen->set_help_sidebar($this->content('help/sidebar'));
        $screen->add_help_tab(
            array(
            'id'      => 'basic-plugin-help',
            'title'   => __('Basic', PostSnippets::TEXT_DOMAIN),
            'content' => $this->content('help/basic')
            )
        );
        $screen->add_help_tab(
            array(
            'id'      => 'shortcode-plugin-help',
            'title'   => __('Shortcode', PostSnippets::TEXT_DOMAIN),
            'content' => $this->content('help/shortcode')
            )
        );
        $screen->add_help_tab(
            array(
            'id'      => 'post-plugin-help',
            'title'   => __('Post Editor', PostSnippets::TEXT_DOMAIN),
            'content' => $this->content('help/post')
            )
        );
        if (!defined('POST_SNIPPETS_DISABLE_PHP')) {
            $screen->add_help_tab(
                array(
                'id'      => 'php-plugin-help',
                'title'   => __('PHP', PostSnippets::TEXT_DOMAIN),
                'content' => $this->content('help/php')
                )
            );
        }
        $screen->add_help_tab(
            array(
            'id'      => 'advanced-plugin-help',
            'title'   => __('Advanced', PostSnippets::TEXT_DOMAIN),
            'content' => $this->content('help/advanced')
            )
        );
        $screen->add_help_tab(
            array(
            'id'      => 'filters-plugin-help',
            'title'   => __('Filters', PostSnippets::TEXT_DOMAIN),
            'content' => $this->content('help/filters')
            )
        );
    }

    /**
     * Get the content for a help tab
     *
     * @param  string  $tab
     * @return string
     */
    private function content($tab)
    {
        return PostSnippets_View::render(
            $tab,
            array('td' => PostSnippets::TEXT_DOMAIN)
        );
    }
}
