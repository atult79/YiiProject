<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\RegistrationForm;
use yii\web\UploadedFile;
use yii\helpers\Url;

class DemoController extends Controller
{
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
            ],
        ];
    }
    public function actionRegistration() {
        $model = new RegistrationForm;
        if ($model->load(Yii::$app->request->post())) {
            $request = Yii::$app->request;
            $name=$request->post('RegistrationForm')['name'];
            $email=$request->post('RegistrationForm')['email'];
            $password=$request->post('RegistrationForm')['password'];
            $model->image = UploadedFile::getInstance($model, 'image');
            if($model->image){
                $model->image->saveAs('uploads/' . $model->image->baseName . '.' . $model->image->extension);
            }
            $model->insertdata($name,$email,$password,Url::home()."uploads/".$model->image->baseName.".".$model->image->extension);
            return $this->render('registration', ['model' => $model,'data'=>$model->displaydata()]);
        }
        return $this->render('registration', ['model' => $model,'data'=>$model->displaydata()]);
    }
    public function actionUpdate($id)
    {
        $model=new RegistrationForm();
        if ($model->load(Yii::$app->request->post())) {
            $request = Yii::$app->request;
            $name=$request->post('RegistrationForm')['name'];
            $email=$request->post('RegistrationForm')['email'];
            $password=$request->post('RegistrationForm')['password'];
            $model->image = UploadedFile::getInstance($model, 'image');   
            $model->image->saveAs('uploads/' . $model->image->baseName . '.' . $model->image->extension);
            $model->updatedata($id,$name,$email,$password,Url::home()."uploads/".$model->image->baseName.".".$model->image->extension);
            return $this->render('registration', ['model' => $model,'data'=>$model->displaydata()]);
        }
        $up=$model->fetchid($id);   
        return $this->render('registration', ['model' => $model,'data'=>$model->displaydata(),'up'=>$up]);
    }
    public function actionDelete($id)
    {
        $model=new RegistrationForm();
        $model->deletedata($id);
        return $this->render('registration', ['model' => $model,'data'=>$model->displaydata()]);
    }
}

