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
<h1>Information om me-sidans API</h1>
<p>Denna sida har ett API där det går att göra POST och GET förfrågningar mot APIet för att validera en IP-adress.</p>
<p>När en förfrågan skickas till APIet få får man ett JSON svar tillbaka som beskriver ifall informationen man skickat validerades som en IP-adress.</p>

<h4>POST</h4>
<p>Det går att skicka en POST request mot följande URL och inkludera IP-adressen med värde "ip" i bodyn för att validera en IP-adress mot APIet</p>
<p>http://www.student.bth.se/~stli19/dbwebb-kurser/ramverk1/me/redovisa/htdocs/api/validate</p>

<h4>GET</h4>
<p>Det går även att göra en GET request mot APIet för att validera en IP-adress.</p>
<p>Klicka t.ex. på följande länk för att se hur det fungerar</p>
<p><a href="../api/validate?ip=37.156.192.51">Länk till GET validering av IPv4 adress.</a></p>
<p><a href="../api/validate?ip=2001:0db8:0000:0000:0000:8a2e:0370:7334">Länk till GET validering av IPv6 adress.</a></p>

<h4>Formulär</h4>
<p>Ett tredje alternativ för att testa APIet är att fylla i en IP-adress i nedan formulär och skicka det för validering till APIet.</p>
<form action="validate" method="POST">
    <label for="ip">IP-adress</label>
    <input type="text" id="ip" name="ip" placeholder="x.x.x.x">

    <input type="submit" value="Submit">
</form>

</article>
