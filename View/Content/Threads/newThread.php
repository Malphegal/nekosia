<div class="container">
    <form method="post" class="column-flexed">
        <div>
            <label for="newthread-theme">Theme</label>
            <select name="newthread-theme" id="pet-select">
                <?php
                    foreach ($args_content as $id => $theme)
                        echo "<option value=\"$id\">$theme</option>";
                ?>
            </select>
        </div>
        <input type="text" name="newthread-title" placeholder="Titre" required />
        <label for="newthread-post">Message</label>
        <textarea name="newthread-post" id="newthread-post" cols="30" rows="10" required></textarea>
        <input type="submit" value="Écrire !" class="fancy-submit" />
    </form>
</div>