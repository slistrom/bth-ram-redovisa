<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

// Prepare classes
$classes[] = "article";
if (isset($class)) {
    $classes[] = $class;
}


?><article <?= classList($classes) ?>>
<h1>Weather report</h1>
<p>Skriv in en IP-adress nedan för att se vädret där den IP-adressen originerar.</p>
<form action="weather/map" method="POST">
    <label for="ip">IP-adress</label>
    <input type="text" id="ip" name="ip" value="<?= $userIP ?>">

    <input type="submit" value="Submit">
</form>

</article>
