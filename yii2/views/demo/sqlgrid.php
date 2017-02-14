<?php
   use yii\bootstrap\ActiveForm;
   use yii\helpers\Url;
   use yii\jui\DatePicker;
   use yii\captcha\Captcha;
   use yii\grid\GridView;
   use yii\bootstrap\Html;
   use yii\data\ActiveDataProvider;    

   if(isset($up))
   {
       $model->name=$up['name'];
       $model->email=$up['email'];
       $model->dob=$up['dob'];
       $model->password=$up['password'];
       $model->image=$up['image']; 
       $up="";
   }
   else
   {
        $model->name="";
       $model->email="";
       $model->dob="";
       $model->password="";
       $model->image=""; 
   }
   \yii\widgets\Pjax::begin(); 
?>
<div class = "row">
   <div class = "col-lg-5">
        <?php $form = ActiveForm::begin(['id' => 'registration']); ?>
        <?= $form->field($model, 'name')->textInput() ?>
       <?= $form->field($model, 'dob')->widget(\yii\jui\DatePicker::classname(), [
           'dateFormat' => 'yyyy-MM-dd',
        ]) ->textInput()?>
        <?= $form->field($model, 'email')->input('email') ->textInput()?>
        <?= $form->field($model, 'password')->passwordInput() ?>
       <?= $form->field($model, 'image')->fileInput() ?>
       <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
            'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
        ]) ?>
        <div class = "form-group">
           <?= Html::submitButton('Insert', ['class' => 'btn btn-primary',
              'name' => 'registration-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>
   </div>
</div>
<?php

   echo GridView::widget([
      'dataProvider' => $provider,
       'summary'=>'', 
       'columns' => [
           ['class' => 'yii\grid\SerialColumn'],
           'user_id',
            'name',
           'dob',
           'email',
           //'image',
           [
                'attribute'=>'image',
                'label'=>'Image',
                'format'=>'html',
                'value' => function ($data) {
                       $url = $data['image'];
                       return Html::img($url, ['alt'=>'myImage','width'=>'50','height'=>'50']);
                }
            ],
            [   'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'template' => '{update}{delete}',
                'buttons' => [
                        'update' => function ($url, $model) {
                                    $url='gupdate?id='. $model['user_id'];
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => Yii::t('app', 'View'),]);
                                },
                        'delete' => function ($url, $model) {
                                    $url='gdelete?id='.$model['user_id'];
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['title' => Yii::t('app', 'Delete'), 'data' => ['confirm' => 'Are you sure you want to delete this item?','method' => 'post'], 'data-ajax' => '1']);
                    }
                ],
                
            ], 
        ],
         
   ]);
   
   \yii\widgets\Pjax::end();
?>