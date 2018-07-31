<?php
$site_logo = !empty(Yii::$app->params['logo_img']) ? Yii::$app->params['logo_img'] : '/design/img/logo-new.png';
?>
<!--    вехний баннер-->
<?php /*?>
    <div class="banner-top">
    <div class="home-top-ads">
        <?php if (Yii::$app->keyStorage->get('ads.top_home_page')) : ?>
            <div class="row">
                <div class="col-xs-12" style="margin-bottom: 20px;">
                    <?= Yii::$app->keyStorage->get('ads.top_home_page')?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php */ ?>
<header>
    <div class="wrap">
        <div class="LogoContainer">
            <a class="logo" href="/">
                <img src="<?= $site_logo ?>" alt="<?= Yii::$app->params['site_name'] ?>">
                <div class="logo-bottom-text">Русская Клавиатура и Мульти-языковый словарь</div>
            </a>
            <div class="tMyTranslit">
                <span>
                    <img class="tMenuLink" id="tMenuSwitch" src="/img/burger.png" alt=""/>
                </span>
            </div>
            <div class="tMenuBox" id="menubox">
                <label style="font-weight: bold"><?= Yii::t('app', 'Pages') ?>:</label>
                <ul>
                    <?php
                    if (!empty($menu_links)) {
                        foreach ($menu_links as $one) { ?>
                            <li>
                                <a href="<?= Yii::$app->params['site_url'] . "/page/" . $one['url'] ?>"><?= $one['title'] ?></a>
                            </li>
                        <?php }
                    } ?>
                </ul>
            </div>
        </div>
    </div>
</header>