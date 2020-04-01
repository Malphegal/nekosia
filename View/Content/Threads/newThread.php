<div class="container">
    <form method="post" class="flex-centered">
        <label for="newthread-theme">Theme</label>
        <select name="newthread-theme" id="pet-select">
            <?php
                foreach ($args_content as $id => $theme)
                    echo "<option value=\"$id\">$theme</option>";
            ?>
        </select>
        <label for="newthread-title">Nom du topic</label>
        <input type="text" name="newthread-title" require />
        <label for="newthread-post">Message</label>
        <textarea name="newthread-post" id="newthread-post" cols="30" rows="10" require></textarea>
        <input type="submit" value="Écrire !" />
    </form>
</div>