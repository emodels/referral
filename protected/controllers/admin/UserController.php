<?php

class UserController extends Controller
{
    public function init(){

        if (Yii::app()->user->isGuest){

            $this->redirect(Yii::app()->createUrl('site/login'));
        }
        else{

            if (Yii::app()->user->user_type != '0') {
                $this->redirect(Yii::app()->baseUrl . '/mission');
            }
        }
    }
    
	public function actionAdd()
	{
        $model = new User;

        if(Yii::app()->getRequest()->getIsAjaxRequest()) {

            echo CActiveForm::validate( array( $model));
            Yii::app()->end();
        }

        if (isset($_POST['User'])) {

            $model->attributes = $_POST['User'];
            $model->user_type = 1;
            $model->entry = 0;
            $model->logo = CUploadedFile::getInstance($model, 'logo');

            if (isset($model->logo)){

                $tmpfile_contents = file_get_contents($model->logo->tempName);

                $model->logo = base64_encode($tmpfile_contents);

                if ($model->logo_width == '') {

                    $model->addError('logo_width', 'Logo Width cannot be blank.');
                }

                if ($model->logo_height == '') {

                    $model->addError('logo_height', 'Logo Height cannot be blank.');
                }
            }

            if (User::model()->findByAttributes(array('username'=>$model->username))) {

                $model->addError('user_name', 'User name already used, try else');
                Yii::app()->user->setFlash('notice', "User name already used, try else");
            }
            else{

                if(!$model->hasErrors() && $model->save()){

                    Yii::app()->user->setFlash('success', "New Partner Added.");
                    $this->refresh();

                } else{

                    print_r($model->getErrors());
                }
            }
        }
                
		$this->render('add',array('model' => $model));
	}

	public function actionDelete($id)
	{
                if(Yii::app()->request->isPostRequest)
                {
                        $user = User::model()->findByPk($id);
                        if(isset($user)){
                            try{
                                if($user->delete()){
                                    echo 'Partner Deleted';
                                }else{
                                    echo 'Error while Deleting';
                                }
                            }
                            catch(Exception $ex){
                                echo 'Can not delete this Partner since it is used for Referral Records';
                            }
                                
                        }
                }else{
                        throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
                }
	}

	public function actionIndex()
	{
            /*$dataProvider=new CActiveDataProvider('User', array('criteria'=>array('condition'=> 'user_type = 1', 'order'=>'id DESC')));
            $this->render('index',array(
                'dataProvider'=>$dataProvider,
            ));*/
            
            $model = new User('search');
            $model->unsetAttributes();
            
            if(isset($_GET['User'])){
                $model->attributes=$_GET['User'];
            }
            
            $model->user_type = 1;
            
            $this->render('index',array(
                'dataProvider'=>$model,
            ));
        }

	public function actionUpdate($id)
	{
        $model = User::model()->findByPk($id);

        $logo_existing = $model->logo;

        if (isset($_POST['User'])) {

            $model->attributes = $_POST['User'];

            $logo = CUploadedFile::getInstance($model, 'logo');

            if (isset($logo)){

                $tmpfile_contents = file_get_contents($logo->tempName);

                $model->logo = base64_encode($tmpfile_contents);

            } else {

                $model->logo = $logo_existing;
            }

            if (isset($model->logo)) {

                if ($model->logo_width == '') {

                    $model->addError('logo_width', 'Logo Width cannot be blank.');
                }

                if ($model->logo_height == '') {

                    $model->addError('logo_height', 'Logo Height cannot be blank.');
                }
            }

            if (!$model->hasErrors() && $model->save()) {

                Yii::app()->user->setFlash('success', "Partner Updated.");
                $this->redirect(Yii::app()->baseUrl . '/admin/user');

            } else{

                Yii::app()->user->setFlash('notice', 'Error saving record');
            }
        }
                
		$this->render('update',array('model' => $model));
	}
        
        public function actionExportCSV(){
            $users = Entry::model()->findAll();
            
            $user_array = array();
            foreach ($users as $user){
                if (strpos($user->email, '@') !== false){
                    $user_array[] = array(
                        'first_name'=>$user->first_name,
                        'last_name'=>$user->last_name,
                        'status'=>$user->status0->status,
                        'priority'=>($user->priority == "0") ? "Low" : (($user->priority == "1") ? "Medium" : "High"),
                        'email'=>$user->email,
                        'address'=>$user->address,
                        'state'=>$user->state,
                        'zip'=>$user->zip,
                        'country'=>$user->country,
                        'telephone'=>$user->telephone,
                        'entry_added_date'=>$user->entry_added_date,
                        'entry_last_updated_date'=>$user->entry_last_updated_date
                    );
                }
            }
            
            $this->download_send_headers("emails_data_export_" . date("Y-m-d") . ".csv");
            echo $this->array2csv($user_array);
        }
        
        private function array2csv(&$array)
        {
           ob_start();
           $df = fopen("php://output", 'w');
           fputcsv($df, array_keys($array[0]));
           foreach ($array as $row) {
              fputcsv($df, $row);
           }
           fclose($df);
           return ob_get_clean();
        }
        
        private function download_send_headers($filename) {
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");
            header("Content-Disposition: attachment;filename={$filename}");
            header("Content-Transfer-Encoding: binary");
        }
}