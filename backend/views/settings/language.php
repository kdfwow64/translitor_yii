<?php
$this->title = Yii::t('backend', 'editing headers');
if(!empty($lang_items_mass)){?>
    <form action="" method="post">
        <?php
        $i = 0;
        foreach ($lang_items_mass as $key => $one){?>
            <?php
            if($i==0){?>
                <div class="row">
            <?php }
            if($i%3 == 0){;?>
                </div>
                <?php if($i!=count($lang_items_mass)-1){?>
                    <div class="row">
                        <div class="col-xs-9 col-sm-4">
                            <label class="lang-labels" for="<?=$key;?>"><?=($i+1).". ".$key;?></label>
                            <input class="lang-inputs fl-r" id="<?=$key;?>" type="text" name="<?=str_replace(" ","_",$key)?>" value="<?=$one?>" />
                        </div>
                <?php }?>
            <?php }else{?>
                <div class="col-xs-9 col-sm-4">
                    <label class="lang-labels" for="<?=$key;?>"><?=($i+1).". ".$key;?></label>
                    <input class="lang-inputs fl-r" id="<?=$key;?>" type="text" name="<?=str_replace(" ","_",$key)?>" value="<?=$one?>" />
                </div>
                <?php if($i == count($lang_items_mass)-1){?>
                    </div>
                <?php }?>
            <?php }
            $i++;
        }?>

        <input type="submit" value="<?=Yii::t('backend', 'Submit')?>" />
    </form>
<?php } ?>