<h2><?php _e('The Post Editor', $td); ?></h2>


<h3><?php _e('Title', $td); ?></h3>
<p>
<?php _e('Give the snippet a title that helps you identify it in the post editor. This also becomes the name of the shortcode if you enable that option.', $td); ?>
</p>


<h3><?php _e('Variables', $td); ?></h3>
<p>
<?php _e('A comma separated list of custom variables you can reference in your snippet. A variable can also be assigned a default value that will be used in the insert window by using the equal sign, variable=default.', $td); ?>
</p>

<p>
    <strong><?php _e('Example', $td); ?></strong>
    <pre><code>url,name,role=user,title</code></pre>
</p>


<h3><?php _e('Snippet', $td); ?></h3>
<p>
<?php _e('This is the block of text, HTML or PHP to insert in the post or as a shortcode. If you have entered predefined variables you can reference them from the snippet by enclosing them in {} brackets.', $td); ?>
</p>

<p><strong><?php _e('Example', $td); ?></strong></p>
<p><?php _e('To reference the variables in the example above, you would enter {url} and {name}. So if you enter this snippet:', $td); ?></p>
<p><?php _e('So if you enter this snippet:', $td); ?></p>

<pre><code>This is the website of &lt;a href="{url}"&gt;{name}&lt;/a&gt;</code></pre>

<p><?php _e('You will get the option to replace url and name on insert if they are defined as variables.', $td); ?></p>


<h3><?php _e('Description', $td); ?></h3>
<p>
<?php _e('An optional description for the Snippet. If filled out, the description will be displayed in the snippets insert window in the post editor.', $td); ?>
</p>
