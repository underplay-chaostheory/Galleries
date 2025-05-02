        <div class="backarrowdiv">
            <a class="backarrow" href="/UNDERPLAY/Art/display" target='_self'>
                <img class="buttonIcon" src='/UNDERPLAY/views/ressources/images/icons/backarrow.png'>
            </a>
        </div>
        <div class="wrapper" id="settingdiv">
            <form action="/UNDERPLAY/Art/update_settings" method="post">
                <div class="editinfo">
                    <label class="label inline">Filtrage du nom : </label>
                    <textarea class="textarea inline" id="name" name="name_like"><?= $info['filtrageName'] ?></textarea>
                </div>
                <div class="editinfo">
                    <label class="label inline">Types autorisés</label>
                    <div class="checkboxGroup inline">
                        <div class="wrapper">
                            <input class="checkbox inline" type="checkbox" name="wallpaper" id="wallpaper" <?php if($info['wallpaper']){echo "checked";}?> >
                            <label class="label inline" for="wallpaper">Wallpaper</label>
                        </div>
                        <div class="wrapper">
                            <input class="checkbox inline" type="checkbox" name="portrait" id="portrait" <?php if($info['portrait']){echo "checked";}?> >
                            <label class="label inline" for="portrait">Portrait</label>
                        </div>
                        <div class="wrapper">
                            <input class="checkbox inline" type="checkbox" name="other" id="other" <?php if($info['other']){echo "checked";}?> >
                            <label class="label inline" for="other">Other</label>
                        </div>
                    </div>
                </div>
                <div class="editinfo">
                    <label class="label inline">Catégories autorisées</label>
                    <div class="checkboxGroup inline">
                        <div class="wrapper">
                            <input class="checkbox inline" type="checkbox" name="code_0" id="code_0" <?php if($info['code_0']){echo "checked";}?> >
                            <label class="label inline" for="code_0">Scène stylé</label>
                        </div>
                        <div class="wrapper">
                            <input class="checkbox inline" type="checkbox" name="code_1" id="code_1" <?php if($info['code_1']){echo "checked";}?> >
                            <label class="label inline" for="code_1">Scène ok</label>
                        </div>
                        <div class="wrapper">
                            <input class="checkbox inline" type="checkbox" name="code_2" id="code_2" <?php if($info['code_2']){echo "checked";}?> >
                            <label class="label inline" for="code_2">Portrait stylé</label>
                        </div>
                        <div class="wrapper">
                            <input class="checkbox inline" type="checkbox" name="code_3" id="code_3" <?php if($info['code_3']){echo "checked";}?> >
                            <label class="label inline" for="code_3">Portrait ok</label>
                        </div>
                        <div class="wrapper">
                            <input class="checkbox inline" type="checkbox" name="code_4" id="code_4" <?php if($info['code_4']){echo "checked";}?> >
                            <label class="label inline" for="code_4">Insane</label>
                        </div>
                        <div class="wrapper">
                            <input class="checkbox inline" type="checkbox" name="code_5" id="code_5" <?php if($info['code_5']){echo "checked";}?> >
                            <label class="label inline" for="code_5">Other</label>
                        </div>
                    </div>
                </div>
                <div class="editinfo">
                    <label class="label inline">Fullscreen only</label>
                    <div class="checkboxGroup inline">
                        <div class="wrapper">
                            <input class="radio inline" type="radio" name="fullscreen" value="Oui" <?php if($info['fullscreen']){echo "checked";}?> >
                            <label class="label inline" for="Oui">Oui</label>
                        </div>
                        <div class="wrapper">
                            <input class="radio inline" type="radio" name="fullscreen" value="Non" <?php if(!$info['fullscreen']){echo "checked";}?> >
                            <label class="label inline" for="Non">Non</label>
                        </div>
                    </div>
                </div>
                <div class="editinfo">
                    <label class="label inline">Exclure des dossiers : </label>
                    <textarea class="textarea inline" id="exclude_directory" name="exclude_directory"><?= $info['excludeDirectory'] ?></textarea>
                </div>
                <div class="editinfo">
                    <label class="label inline">Restreindre aux dossiers : </label>
                    <textarea class="textarea inline" id="restrict_directory" name="restrict_directory"><?= $info['restrictDirectory'] ?></textarea>
                </div>
                <div class="saving">
                    <input type="submit" value="Save">
                </div>
            </form>
        </div>