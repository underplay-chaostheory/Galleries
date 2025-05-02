        <div class="wrapper">
            <div class="wrapper" id="displayImage">
                <img src="<?= $image['path']) ?>" alt="image introuvable" id="image">
                    
            </div>
            <div class="wrapper" id="info">
                <form action="<?= ROOT ?>/Art/update_img" method="post" id="editinfoform">
                    <div class="editinfo">
                        <label class="label inline">Nom : </label>
                        <input class="input inline" id="name" name="name" type="text" value="<?= $image['name'] ?>">
                    </div>
                    <div class="editinfo">
                        <label class="label inline">Type : </label>
                        <select class="select inline" id="type" name="type">
                            <option value="wallpaper" <?php if($image['type'] == "wallpaper") { echo "selected"; }?> >Wallpaper</option>
                            <option value="portrait" <?php if($image['type'] == "portrait") { echo "selected"; }?> >Portrait</option>
                            <option value="other" <?php if($image['type'] == "other") { echo "selected"; }?> >Other</option>
                        </select>
                    </div>
                    <div class="editinfo">
                        <label class="label inline">Catégorie : </label>
                        <select class="select inline" id="category" name="category">
                            <option value="0" <?php if($image['category'] == 0) { echo "selected"; }?> >Catégorie 0</option>
                            <option value="1" <?php if($image['category'] == 1) { echo "selected"; }?> >Catégorie 1</option>
                            <option value="2" <?php if($image['category'] == 2) { echo "selected"; }?> >Catégorie 2</option>
                            <option value="3" <?php if($image['category'] == 3) { echo "selected"; }?> >Catégorie 3</option>
                            <option value="4" <?php if($image['category'] == 4) { echo "selected"; }?> >Catégorie 4</option>
                            <option value="5" <?php if($image['category'] == 5) { echo "selected"; }?> >Catégorie 5</option>
                        </select>
                    </div>
                    <div class="editinfo">
                        <label class="label inline">Fullscreen : </label>
                        <select class="select inline" id="fullscreen" name="fullscreen">
                            <option value="yes" <?php if($image['fullscreen'] == 1) { echo "selected"; }?> >Possible</option>
                            <option value="no" <?php if($image['fullscreen'] == 0) { echo "selected"; }?> >Impossible</option>
                        </select>
                    </div>
                    <input id="path" type="hidden" name="path" value="<?= $image['path'] ?>">
                    <input id="id" type="hidden" name="id" value="<?= $image['id'] ?>">
                    <div class="saving">
                        <input id="Savebutton" type="submit" value="Save">
                    </div>
                </form>
                <form action="<?= ROOT ?>/Art/settings" method="post" id="formsettings">
                    <input type="submit" id="gotosettings" value="">
                </form>
            </div>
        </div>
