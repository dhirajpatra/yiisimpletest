<?php

/**
 * Created by PhpStorm.
 * User: dhiraj
 * Date: 22/7/16
 * Time: 11:57 AM
 */
class LendController extends Controller
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
                'actions'=>array('index','view', 'Borrow'),
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create','update', 'Borrow'),
                'users'=>array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin','delete', 'Borrow'),
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
        $model=new Lend();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Lend']))
        {
            $model->attributes=$_POST['Lend'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->id));
        }

        $this->render('create',array(
            'model'=>$model,
        ));
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

        if(isset($_POST['Lend']))
        {
            $model->attributes=$_POST['Lend'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->id));
        }

        $this->render('update',array(
            'model'=>$model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Lend the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=Lend::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * save into lending_details
     */
    public function actionBorrow()
    {
        if(isset($_POST)){
            //print_r($_POST); exit;
            $model = new Lend();

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);
            // need to check user is already taken 8 books or less
            $alreadyBorrowed = $model->howManyBooksBorrowedByUser($_POST['user_id']);
            if($alreadyBorrowed < 8){
                $model->user_id = $_POST['user_id'];
                $model->book_id = $_POST['books'];
                $model->taken_at = date('Y-m-d H:i:s');

                if($model->save()){
                    Yii::import('application.controllers.BookController');
                    BookController::updateAvailable($_POST['books'], 1);

                    echo CJSON::encode(array(
                        'status'=>'success'
                    ));
                    Yii::app()->end();
                }
            }else{
                echo CJSON::encode(array(
                    'status'=>'error: already borrowed '.$alreadyBorrowed
                ));
                Yii::app()->end();
            }

        }
    }
}