<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        /*if(isset($_FILES)){
            print_r($_FILES); exit;
        }*/

		if(isset($_POST['User']))
		{
            //print_r($_POST['User']); exit;
			$model->attributes = $_POST['User'];
			if($model->validate()){

                /*$rnd = rand(0,9999);
                $uploadedFile = CUploadedFile::getInstance($model,'photo');
                $fileName = "{$rnd}-{$uploadedFile}";  // random number + file name
                $model->photo = $fileName;
                $valid_format = "jpg,png,jpeg,gif";*/

                if($model->save()){
                    //$this->photo->saveAs(Yii::app()->basePath.'/images/' . $fileName);
                    /*if (!empty($uploadedFile)) {
                        $uploadedFile->saveAs(Yii::app()->basePath.'/images/'.$fileName);
                        Yii::app()->user->setFlash('success', 'Successfully saved');
                    }*/

                    echo CJSON::encode(array(
                        'status'=>'success'
                    ));

                    Yii::app()->end();
                }
            }else{
                $model -> save(FALSE);
                echo $errors = CActiveForm::validate($model);
                /*echo CJSON::encode(array(
                    $errors
                ));*/
                Yii::app()->end();
            }
		}

        /*$this->render('_form',array('model'=>$model));

		$this->render('create',array(
			'model'=>$model,
		));*/
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
            $_POST['User']['photo'] = $model->photo;
			$model->attributes = $_POST['User'];
            $uploadedFile=CUploadedFile::getInstance($model,'photo');

			if($model->save()){
                if(!empty($uploadedFile))  // check if uploaded file is set or not
                {
                    $uploadedFile->saveAs(Yii::app()->basePath.'/images/'.$model->photo);
                }

                $this->redirect(array('view','id'=>$model->id));
            }

		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		//$dataProvider=new CActiveDataProvider('User');
        //$dataProvider->setPagination(false);
        $result = array();
        foreach(User::model()->findAll() as $record) {
            $lend = array();
            // get book lending details
            $lendDetails = User::model()->with('borrowed', 'books')->findByPk($record->id);
            $totalBooksBorrowed = 0;
            foreach ($lendDetails->books as $lendData){
                $lend[] = array(
                    'title' => $lendData->title,
                    'author' => $lendData->author
                );
                $totalBooksBorrowed++;
            }

            $result[] = array(
                'user' => array(
                    'id' => $record->id,
                    'name' => $record->salutation . ' ' . $record->title . ' ' . $record->firstname .' '.$record->lastname,
                    'address1' => $record->streetnumber. ' '.$record->street,
                    'address2' => $record->zip.', '.$record->city,
                    'description' => $record->description,
                    'register_date' => date('d/m/Y', strtotime($record->register_date)),
                    'photo' => $record->photo,
                    'total' => $totalBooksBorrowed,
                    'books' => $lend
                )

            );
        }
        //echo '<pre>'; print_r($result); exit;
        $this->render('index',array(
            'result'=>$result,
        ));
        /*$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));*/
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


}
