<!DOCTYPE html>
<html lang="fr">
    <head>
<!-- a gerer : 'head','header','footer' -->
        <title><?= $title ?></title>
<?php if ($css != null): ?>
<?php foreach($css as $css_file): ?>
        <link href="<?= ROOT ?>/views/ressources/css/<?= $css_file ?>.css" rel="stylesheet">
<?php endforeach; ?>
<?php endif; ?>
<?php if ($js != null): ?>
<?php foreach($js as $js_file): ?>
        <script src='<?= ROOT ?>/views/ressources/js/<?= $js_file ?>.js'></script>
<?php endforeach; ?>
<?php endif; ?>
<?php if ($police != null): ?>
<?php foreach($police as $police_link): ?>
        <link href="<?= $police_link ?>" rel="stylesheet">
<?php endforeach; ?>
<?php endif; ?>
<?php if ($meta != null): ?>
<?php foreach($meta as $police_link): ?>
<?php endforeach; ?>
<?php endif; ?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>

<?= $content ?>

    </body>
</html>
