<div id="login-full" class="container">
    <form method="post" class="flex-centered">
        <h3>Connexion</h3>
        <input type="text" name="signin-nickname" placeholder="Pseudo" required/>
        <input type="text" name="signin-pw" placeholder="Mot de passe" required/>
        <div>
            <label>Se souvenir de moi ?</label>
            <input type="checkbox" name="signin-remember" />
        </div>
        <input type="submit" value="Se connecter" id="submit" />
    </form>
    <a href="index.php?ctrl=client&action=signup">Pas de compte ?</a>
</div>