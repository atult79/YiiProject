<?php
   namespace app\models;
   use Yii;
   use yii\base\Model;
   use yii\data\ActiveDataProvider;
   use \yii\db\Query;
   
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
        public function insertdata($name,$email,$dob,$password,$image)
        {
            echo $dob;
            Yii::$app->db->createCommand()->insert('Registration', [
                'name' => $name,
                'email' => $email,
                'dob'=>$dob,
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
            $up=$up_data;
            return $up;
        }
        public function updatedata($id,$name,$email,$dob,$password,$image)
        {
            Yii::$app->db->createCommand('UPDATE Registration SET name="'.$name.'",dob="'.$dob.'",email="'.$email.'",password="'.$password.'",image="'.$image.'" WHERE user_id='.$id)
            ->execute();
        }
        public function deletedata($id)
        {
            Yii::$app->db->createCommand()->delete('Registration', 'user_id='.$id)->execute();
        }
        public function gridview()
        {
            $query = new Query();
            $provider = new ActiveDataProvider([
                'query' => $query->from('Registration'),
                'pagination' => [
                    'pageSize' => 20,
                ],
                'sort'=>['attributes'=>['name']],
            ]);
            return $provider;
        }
   }

?>