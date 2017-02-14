<?php
   use yii\bootstrap\ActiveForm;
   use yii\bootstrap\Html;
   use yii\helpers\Url;
   use yii\jui\DatePicker;
   use yii\captcha\Captcha;
   use yii\grid\GridView;
   use yii\data\ActiveDataProvider;    

   if(isset($up))
   {
       $model->name=$up['name'];
       $model->email=$up['email'];
       $model->dob=$up['dob'];
       $model->password=$up['password'];
       $model->image=$up['image'];
   }
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
<div class="row">
    <table border="1">
        <tr>
            <td>Name</td>
            <td>Email</td>
            <td>Image</td>
            <td>Update</td>
            <td>Delete</td>
        </tr>
        <?php
            foreach($data as $value)
            {
                echo "<tr><td>".$value['name']."</td><td>".$value['email']."</td><td><img src=".$value['image']." height=50 width=50> </td>"
                    . "<td><a href='". Url::to(['demo/update/', 'id'=> $value['user_id']])."'>Update</a></td>"
                    . "<td><a href='". Url::to(['demo/delete/', 'id'=> $value['user_id']])."'>Delete</a></td></tr>";
            }
        ?>
    </table>
</div>