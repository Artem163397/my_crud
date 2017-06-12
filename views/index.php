<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\bootstrap\Modal;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
<?= $generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
	<div class="box box-default">	
		<div class="box-body">
		<!-- <img src="http://cbscao.ru/sites/default/files/pictures/13249/develop900.jpg" alt="Наш логотип">-->
<?php if(!empty($generator->searchModelClass)): ?>
<?= "    <?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
<?php endif; ?>

    <p>
        <?= "<?= " ?>Html::a(<?= $generator->generateString('Добавить') ?>, ['create'], [
        'data-target'=>'/<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>/create',
        'class' => 'btn btn-success','onClick'=>"
        $('#modal').modal('show')
        .find('#modal-content')
        .load($(this).attr('data-target'));
        return false;"]) ?>
   </p>
<?= $generator->enablePjax ? '<?php Pjax::begin(); ?>' : '' ?>
<?php if ($generator->indexWidgetType === 'grid'): ?>
	
		</div>
	</div>
	</div>
	
	<div class="box box-default">	
		<div class="box-body" style="overflow-x: auto;">    
	<?= "<?= " ?>GridView::widget([
        'dataProvider' => $dataProvider,
        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
            //['class' => 'yii\grid\SerialColumn'],
			//[
			//'attribute'=>'id',
			//'content'=>function ($data){
			//	return '<span class="label label-warning" style="font-size:13px;">'.Html::a($data->id.'   ', ['update','id' =>$data->id], ['style'=>'color:#ffffff;']).'</span>';

			// },
			//],

<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
				echo "           '" . $name . "',\n";
        } else {
            echo "            // '" . $name . "',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (++$count < 6 and $column->name <> 'id') {
            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        } else {
            echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>
			['class' => 'yii\grid\ActionColumn',
			    'template' => '{edit}{delete} ',
                'buttons' => [
                    'edit' => function ($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', [''], ['data-target'=>'/<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>/update?id='.$key,'onClick'=>"
                            $('#modal').modal('show')
                            .find('#modal-content')
                            .load($(this).attr('data-target'));
                            return false;"]);
                    },
                ],
            ],
           // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php else: ?>
	</div>
</div>
<div class="box box-default">	
	<div class="box-body" style="overflow-x: auto;">
    <?= "<?= " ?>ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
        },
    ]) ?>
<?php endif; ?>

	</div>
</div>
    <?= $generator->enablePjax ? '<?php Pjax::end(); ?>' : '' ?>
    <?= "<?php
    Modal::begin([
        'header' => 'Добавление доски',
        'id' => 'modal',
        'size'=>'modal-lg',
    ]);
    echo \"<div id='modal-content'>Загружаю...</div>\";
    Modal::end();
    ?>" ?>

</div>
