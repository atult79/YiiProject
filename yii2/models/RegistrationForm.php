<?php
   namespace app\models;
   use Yii;
   use yii\base\Model;
   class RegistrationForm extends Model {

        public $password;
        public $email;
        public $name;
        public $image;
        public $verifyCode;
        public $dob;
        /**
        * @return array customized attribute labels
        */
        public function attributeLabels() {
            return [
                'verifyCode' => 'Verification Code'
            ];
        }
        public function rules() {
            return [
                [['name'],'required'],
                [['password', 'email','image','dob'], 'required'],
                ['email','email'],
                ['verifyCode', 'captcha'],
            ];
        }
        public function insertdata($name,$email,$password,$image)
        {
            Yii::$app->db->createCommand()->insert('Registration', [
                'name' => $name,
                'email' => $email,
                'password'=>$password,
                'image'=>$image
            ])->execute();
        }
        public function displaydata()
        {
            $data = Yii::$app->db->createCommand('SELECT * FROM Registration')
            ->queryAll();
            return $data;
        }
        public function fetchid($id)
        {
            $up_data = Yii::$app->db->createCommand('SELECT * FROM Registration WHERE user_id='.$id)
           ->queryOne();
            $up['name']=$up_data['name'];
            $up['email']=$up_data['email'];
            $up['password']=$up_data['password'];
            $up['image']=$up_data['image'];
            return $up;
        }
        public function updatedata($id,$name,$email,$password,$image)
        {
            Yii::$app->db->createCommand('UPDATE Registration SET name="'.$name.'",email="'.$email.'",password="'.$password.'",image="'.$image.'" WHERE user_id='.$id)
            ->execute();
        }
        public function deletedata($id)
        {
            Yii::$app->db->createCommand()->delete('Registration', 'user_id='.$id)->execute();
        }
   }
?>