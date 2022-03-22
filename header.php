<?php

$current = $children[0];
for ($i = 0; $i < count($children); $i++)
{
    if (str_starts_with($uri, ROOT . $children[$i]->getName()))
    {
        $current = $children[$i];

        break;
    }
}

?>
<ul>
    <?php foreach ($children as $child) : ?>
        <?php if ($child == $current) : ?>
            <?php $children = $child->getChildren(); ?>
            <?php if ($children) : ?>
                <div class="folder">
                    <a href="<?= ROOT . $child->getName() ?>">
                        <li class="current"><?= $child->getDisplay() ?></li>
                    </a>
                    <?php require("header.php"); ?>
                </div>
            <?php else : ?>
                <a href="<?= ROOT . $child->getName() ?>">
                    <li class="current"><?= $child->getDisplay() ?></li>
                </a>
            <?php endif ?>
        <?php else : ?>
            <a href="<?= ROOT . $child->getName() ?>">
                <li><?= $child->getDisplay() ?></li>
            </a>
        <?php endif ?>
    <?php endforeach ?>
</ul>