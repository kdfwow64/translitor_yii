<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\FooterLinks */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Footer Links'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="footer-links-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute'=>'status',
                'value'=> ($model->status) ? '<strong><span class="text-success bold">'.Yii::t('app', 'Yes').'</span></strong>':'<strong><span  class="text-danger">'.Yii::t('app', 'No').'</span></strong>',
                'format'=>'raw',
            ],
            'sort_order',
            'title',
            [
                'attribute'=>'link',
                'value'=> Html::a(Html::encode($model->link),$model->link),
                'format'=>'raw',
            ],
            [
                'attribute'=>'img',
                'value'=> Html::img($model->img, ['style' => 'width:90px;']),
                'format'=>'raw',
            ],
        ],
    ]) ?>

</div>
