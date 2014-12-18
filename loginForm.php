<?php
/**
* Created in collaboration by:
*
* @author Gerardo Medrano <GMedranoCode@gmail.com>
* @author Marc Hayes <Marc.Hayes.Tech@gmail.com>
* @author Steven Chavez <schavez256@yahoo.com>
* @author Joseph Bottone <hi@oofolio.com>
*
*/
?>
<!DOCTYPE html>

<html>
<body>
<br>
<br>
<br>
<section class="loginform cf">
<form name="login" action="index_submit" method="get" accept-charset="utf-8">
    <ul>
        <li><label for="email">Email</label>
        <input type="email" name="email" placeholder="yourname@email.com" required></li>
        <li><label for="passwordHash">Password</label>
        <input type="passwordHash" name="passwordHash" placeholder="password" required></li>
        <li>
        <input type="submit" value="Login"></li>
    </ul>
</form>
</section>