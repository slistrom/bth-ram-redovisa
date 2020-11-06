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
<h1>Validera en IP-adress</h1>
<p>Skriv in en IP-adress nedan för att validera den.</p>
<form action="ip/validate" method="POST">
    <label for="ip">IP-adress</label>
    <input type="text" id="ip" name="ip" placeholder="x.x.x.x">

    <input type="submit" value="Submit">
</form>

<?= var_dump($_POST); ?>
</article>
