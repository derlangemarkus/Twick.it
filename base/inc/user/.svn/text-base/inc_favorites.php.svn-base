<?php
$favorites = TwickFavorite::fetchByUserId($user->getId());


if ($favorites) {
    foreach($favorites as $favorite) {
        $twick = $favorite->findTwick();
        if (!$twick) {
            continue;
        }
        $twick->display(false, 3, false, false, "&userId=" . $user->getId());
    }
} else {
    ?>
    <!-- Sprechblase | START -->
    <div class="sprechblase">
        <h2>&nbsp;<span>&nbsp;</span></h2>
        <div class="sprechblase-main">
            <div class="sprechblase-achtung">&nbsp;</div>
            <div class="sprechblase-rechts">
                <div class="blase-header" id="eingabeblase-head">
                    <div class="kurzerklaerung"><span><?php loc('user.noFavorites.title') ?></span></div>
                </div>
                <div class="blase-body">
                    <div class="twick-link">
                        <?php loc('user.noFavorites.text', array('<a href="' . $user->getUrl() . '">' .  htmlspecialchars($user->getDisplayName()) . '</a>')) ?>
                        <br />
                        <br />
                        <a href="<?php echo($user->getUrl()) ?>"><?php loc('user.noFavorites.link',  htmlspecialchars($user->getDisplayName())) ?></a>
                    </div>
                </div>
                <div class="blase-footer" id="eingabeblase-footer">&nbsp;</div>
            </div>
            <div class="clearbox">&nbsp;</div>
        </div>
    </div>
    <!-- Sprechblase | ENDE -->

    <?php
}
?>