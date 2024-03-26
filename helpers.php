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
 * @param array $data
 * @return void
 */

function loadView($name, $data = [])
{
    $viewPath = basePath("App/views/{$name}.view.php");
    if (file_exists($viewPath)) {
        extract($data);
        require $viewPath;
    } else {
        echo "View {$name} not found";
    }
}


/**
 * Load a partial
 * 
 * @param string $name
 * @param array $data
 * @return void
 */

function loadPartial($name, $data = [])
{
    $partialPath = basePath("App/views/partials/{$name}.php");

    if (file_exists($partialPath)) {
        extract($data);
        require $partialPath;
    } else {
        echo "Partial {$name} not found";
    }
}

/**
 * Inspect a value(s)
 * 
 * @param mixed $value
 * @return void
 */

function inspect($value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}

/**
 * Inspect a value(s) and die
 * 
 * @param mixed $value
 * @return void
 */

function inspectAndDie($value)
{
    echo '<pre>';
    die(var_dump($value));
    echo '</pre>';
}

/**
 * Format price
 * 
 * @param string $price
 * @return string Formatted Price
 */

function formatPrice($price)
{
    return '£' . number_format(floatval($price));
}

/**
 * Snitize Data
 * 
 * @param string $dirtyData
 * @return string
 * 
 */
function sanitize($dirtyData)
{
    return filter_var(trim($dirtyData), FILTER_SANITIZE_SPECIAL_CHARS);
}

/**
 * Redirect to a given URL
 * 
 * @param string url
 * @return void
 */

function redirect($url)
{
    header("Location: {$url}");
    exit;
}
