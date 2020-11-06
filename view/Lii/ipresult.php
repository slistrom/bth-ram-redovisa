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
<h1>Validerings resultat</h1>

<?php if ($ip) : ?>
    <?php if ($resultIPv4) : ?>
        <p><?= $ip ?> is a valid IPv4 address</p>
    <?php else : ?>
        <p><?= $ip ?> is not a valid IPv4 address</p>
    <?php endif; ?>

    <?php if ($resultIPv6) : ?>
        <p><?= $ip ?> is a valid IPv6 address</p>
    <?php else : ?>
        <p><?= $ip ?> is not a valid IPv6 address</p>
    <?php endif; ?>

    <?php if ($domain) : ?>
        <p><?= $ip ?> has domainname <?= $domain ?></p>
    <?php else : ?>
        <p>No domainname found for <?= $ip ?></p>
    <?php endif; ?>

<?php endif; ?>



<p></p>
<a href="../ip">Gör en ny validering</a>
</article>
