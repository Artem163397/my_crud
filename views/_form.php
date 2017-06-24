<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

			<?= "<?php " ?>$form = ActiveForm::begin([
                'id' => 'order-form',
                'enableAjaxValidation' => true,
                'validationUrl' => ['<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>/validate'],
            ]); ?>

<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {?>
		<div class="row">
			<div class="col-md-4 vcenter">
				<?php echo "    <?= " . $generator->generateActiveField($attribute) . " ?>";?>
				
			</div>
		</div>
   <?php }		
} ?>	
<div style="display:none">
</div>
    <div class="form-group">
        <?= "<?= " ?>Html::submitButton($model->isNewRecord ? <?= $generator->generateString('Создать') ?> : <?= $generator->generateString('Изменить') ?>, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>


</div>
