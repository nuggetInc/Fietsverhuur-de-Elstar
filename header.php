<?php

$current = $children[0];
for ($i = 0; $i < count($children); $i++)
{
    if (str_starts_with($page, $children[$i]->getName()))
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
                    <li class="current"><a href="?page=<?= $child->getName() ?>"><?= $child->getDisplay() ?></a></li>
                    <?php require("header.php"); ?>
                </div>
            <?php else : ?>
                <li class="current"><a href="?page=<?= $child->getName() ?>"><?= $child->getDisplay() ?></a></li>
            <?php endif ?>
        <?php else : ?>
            <li><a href="?page=<?= $child->getName() ?>"><?= $child->getDisplay() ?></a></li>
        <?php endif ?>
    <?php endforeach ?>
</ul>