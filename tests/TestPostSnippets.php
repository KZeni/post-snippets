<?php
/**
 * Post Snippets Unit Tests.
 */
class TestPostSnippets extends WP_UnitTestCase {

    private $plugin = 'post-snippets';

    public function setUp()
    {
        parent::setUp();
        $this->plugin = PostSnippets::getInstance();

		$snippets = array();
		array_push($snippets, array(
		    'title' => "TestTmp",
		    'vars' => "",
		    'description' => "",
		    'shortcode' => false,
		    'php' => false,
		    'snippet' => "A test snippet..."));
			update_option('post_snippets_options', $snippets);
    }

	// -------------------------------------------------------------------------
	// Tests
	// -------------------------------------------------------------------------

    public function testPluginInitialization()
    {
        $this->assertFalse( null == $this->plugin );
    }

	public function testGetSnippet()
	{
		$test = PostSnippets::getSnippet('TestTmp');
		$this->assertTrue(is_string($test));
		$this->assertEquals($test, 'A test snippet...');
	}
}
