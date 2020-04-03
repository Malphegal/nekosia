<div id="login-full" class="container">
    <form method="post" class="flex-centered" action="<?= $_SERVER["REQUEST_URI"] ?>">
        <h3>Connexion</h3>
        <input type="text" name="signin-nickname" placeholder="Pseudo" class="inputtext-bottom" required/>
        <input type="password" name="signin-pw" placeholder="Mot de passe" class="inputtext-bottom" required/>
        <div>
            <label>Se souvenir de moi ?</label>
            <input type="checkbox" name="signin-remember" />
        </div>
        <input type="submit" value="Se connecter" id="submit" class="fancy-submit" />
    </form>
    <a href="<?= RELATIVE_DIR ?>client/signup">Pas de compte ? Viens nous rejoindre ici !</a>
</div>