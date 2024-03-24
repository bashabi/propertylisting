<?php

/**
 * Get the base Path
 * 
 * @param string $path
 * @return string
 */

function basePath($path = '')
{
    return __DIR__ . '/' . $path;  // get the absoulute path
}

/**
 * Load a view
 * 
 * @param string $name
 * @return void
 */

function loadView($name)
{

    require basePath("views/{$name}.view.php");
}


/**
 * Load a partial
 * 
 * @param string $name
 * @return void
 */

function loadPartial($name)
{
    require basePath("views/partials/{$name}.php");
}
