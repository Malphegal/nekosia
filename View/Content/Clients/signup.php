<div class="container">
    <form method="post" class="flex-centered" enctype="multipart/form-data">
        <h3>Viens nous rejoindre !</h3>
        <div class="logo-input">
            <div class="i-container flex-centered">
                <i class="fas fa-user"></i>
            </div>
            <input type="text" name="signup-nickname" placeholder="Pseudo" required />
        </div>
        <div class="logo-input">
            <div class="i-container flex-centered">
                <i class="fas fa-key"></i>
            </div>
            <input type="password" name="signup-pw" placeholder="Mot de passe" required />
        </div>
        <div class="logo-input">
            <div class="i-container flex-centered">
                <i class="fas fa-at"></i>
            </div>
            <input type="email" name="signup-email" placeholder="E-mail" required />
        </div>
        <div class="logo-input">
            <div class="i-container flex-centered">
                <i class="far fa-user-circle"></i>
            </div>
            <input type="file" name="signup-avatar" accept=".png, .jpeg, .jpg" />
        </div>
        <input type="submit" value="Créer un compte" id="submit" />
    </form>
</div>