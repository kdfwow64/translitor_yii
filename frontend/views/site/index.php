<?php

use yii\helpers\Html;
use yii\base\DynamicModel;
use dosamigos\tinymce\TinyMce;
use yii\widgets\ActiveForm;

$model = new \yii\base\DynamicModel(['source', 'result']);
$model->addRule(['source', 'result'], 'string');
$form = ActiveForm::begin();

?>
<div class="wrap">
    <div class="tMainContainer" id="tMainContainer">
        <!--    <h1>--><? //=isset(Yii::$app->params['seotitle']) ? Yii::$app->params['seotitle'] : '';?><!--</h1>-->
        <noscript>
            <p><strong>В вашем броузере отключен JavaScript, который необходим для работы сайта.</strong></p>
            <p>Вы можете <a href="https://www.enable-javascript.com/ru/" target=_blank>включить</a>
                JavaScript или воспользоваться <A href="https://translitor.org/classic/">классическим транслитом</A>.
            </p>
        </noscript>

        <form class="form" name="searchform">
            <div class="tBoxBannerLeft">
                <div class="tTextArea0">
                    <div class="tWzgBlock0 clearfix">
                        <div class="button-box">
                            <div class="button-sub-block">
                                <ul class="tWzg">
                                    <li class="brd-r" id="forhint1">
                                        <input class="search" type="button" highlight="green"
                                               onclick="$('body,html').animate({scrollTop: $('#searchblock').offset().top}, 1000);"
                                               title="Искать">
                                    </li>
                                    <li class="no-xs">
                                        <input class="print" type="button"
                                               onclick="getselectedtext(); setfoc(); document.secondaryform.action='/tools/print/'; document.secondaryform.setAttribute('target', '_blank'); document.secondaryform.submit();"
                                               title="Распечатать текст">
                                    </li>
                                </ul>
                            </div>
                            <div class="button-sub-block">
                                <div class="title">Режим ввода текста <i class="inform text-input"></i></div>
                                <div class="block-content translit">
                                    <input id="translit_flag" type="checkbox" checked hidden>
                                    <label for="translit_flag">Транислит<i class="translit"></i></label>
                                </div>
                            </div>
                            <div class="button-sub-block">
                                <div class="title">Конвертировать текст <i class="inform convert"></i></div>
                                <div class="block-content">
                                    <div class="tSwitcherContainer">
                                            <span class="tcbs" id="tcb_switch">
                                              <span onclick="setfoc();" id="translit_button"
                                                    class="nowrap active">Кириллица</span>
                                              <input onclick="changelanguage();setfoc();" id="translit_switch_icon"
                                                     class="switch" type="button">
                                              <span onclick="changelanguage();" class="nowrap tcbul" id="user_current_lang">Латиница</span>
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <div class="block fl-rt">
                                <div class="title"></div>
                                <i class="auto-translate"></i>
                                <div class="block-content">
                                    <input
                                            id="turn_off_auto_transl"
                                            type="checkbox"
                                            checked="checked"
                                            onclick="turn_off_auto_translate($(this));"
                                            title="Turn off auto translate"
                                            hidden>
                                    <label
                                            for="turn_off_auto_transl"
                                            id="turn_off_auto_transl_label"
                                            title="Turn off auto translate"
                                    >Авто-перевод</label>
                                    <i class="inform translate"></i>

                                </div>
                                <input
                                        id="translate_btn"
                                        type="button"
                                        disabled="disabled"
                                        onclick="google_translate();setfoc();"
                                        title="Перевести"
                                        value="Перевести">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tBoxWzg">
                    <input type="hidden" id="language_from" value="ru">
                    <ul class="languages from">
                        <li data-lang="ru" class="item active">русский</li>
                        <li data-lang="uk" class="item">украинский</li>
                        <li data-lang="be" class="item">белорусский</li>
                        <li data-lang="pl" class="item">польский</li>
<!--                        <li onclick="getUserLanguageGoogle();">определить язык</li>-->
                        <li class="languages_list_li">
                            <input class="turn_list6" type="checkbox"/>
                            <div class="arrow"></div>
                            <div class="languages_list from">
                                <?php echo $this->render('//layouts/parts/language_table.php', ['id' => "language_from_table", 'default_language' => 'ru']); ?>
                            </div>
                        </li>
                    </ul>
                    <textarea dir="ltr" id="sourse" name="subject" rows="18" wrap="virtual" class="txtarea"
                              onkeypress="translate_letter(event);"
                              onkeyup="lettcount(); savechanges(); key_up_process();"></textarea>

                    <button class="vk_icon" onclick="VirtualKeyboard.toggle('sourse','td'); return false;"><i class="inform virt-keyb"></i></button>
                    <i class="copy-btn"></i>
                    <div id="td"></div>
                    <div class="letterscounter_wraper" title="Счетчик количества символов в тексте">
                        <span id="letterscounter">0</span>/10000
                    </div>
                    <div class="recomended-language">
                        <span class="text">Перевести с:</span>
                        <span class="lang" data-val="ru">Русский</span>
                    </div>
                </div>
                <div class="between-block">
                    <div class="switch" onclick="move_data_from_right_to_left();"></div>
                </div>
                <div class="txtarea_translate">
                    <input type="hidden" id="language_to" value="en">
                    <ul class="languages to">
                        <li data-lang="en" class="item active">английский</li>
                        <li data-lang="de" class="item">немецкий</li>
                        <li data-lang="fr" class="item">французкий</li>
                        <li data-lang="es" class="item">испанский</li>
                        <li class="languages_list_li right">
                            <input class="turn_list7" type="checkbox"/>
                            <div class="arrow"></div>
                            <div class="languages_list to">
                                <?php echo $this->render('//layouts/parts/language_table.php', ['id' => "language_to_table", 'default_language' => 'en']); ?>
                            </div>
                        </li>
                    </ul>
                    <textarea disabled id="translate_span"></textarea>
                    <i class="copy-btn"></i>
                </div>
            </div>
        </form>

        <hr class="hr">
        <div class="spelling">
            <div class="title">Проверка орфографии</div>
            <div class="content"></div>
        </div>

        <form name="secondaryform" method="POST">
            <input type="hidden" name="subject" value="">
            <input type="hidden" name="extendedsubject" value="">
            <input type="hidden" name="direction" value="ru">
            <input type="hidden" name="cp" value="">
        </form>
        <?php /*?>
    <!--    нижний баннер-->
    <div class="home-bottom-ads">
        <?php if (Yii::$app->keyStorage->get('ads.top_landlords_search_page')) : ?>
            <div class="row">
                <div class="col-xs-12" style="margin-bottom: 20px;">
                    <?= Yii::$app->keyStorage->get('ads.top_landlords_search_page')?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php */ ?>


    </div>
</div>
<script src="/js/custom.js?t=1"></script>
<script>
    var api_key = '<?=$api_key?>';
    //Init();//for keyboard
    //console.log(EXPERIMENT_IDS);
</script>


<?php //echo $this->render('//layouts/parts/google-code.php');?>
<?php if (!empty(Yii::$app->params['text_block_1']) && Yii::$app->controller->id != 'cabinet') {
    echo Yii::$app->params['text_block_1'];
} ?>


<!--<textarea id="text11" rows="6" wrap="soft" onfocus="VirtualKeyboard.attachInput(this)"></textarea>-->

<!--<div id="td"></div>-->
<div id="lfilter" onclick="setFilter()"></div>
<div id="layouts"></div>
<script type="text/javascript"
        src="/virtual_kb/vk_loader.js?vk_layout=CN%20Chinese%20Simpl.%20Pinyin&vk_skin=flat_gray"></script>