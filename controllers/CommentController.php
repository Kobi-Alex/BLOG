<?php
    namespace controllers;
    
    use core\BaseController;
    use models\RecordModel;
    use models\UserModel;
    use models\CommentModel;

    class CommentController extends BaseController 
    {
        public function __construct()
        {
            if(!isset($_SESSION)) session_start();
        }
        
        public function actionIndex()
        {
            $comments = CommentModel::find()
                        ->all();
            foreach ($comments as $comment) {
                $user = UserModel::find()
                        ->where(['id' => $comment->user_id])
                        ->one();
                $folloverNicks[$comment->id] = $user->nick;
            }
            $this->layots = 'navbar';
            $this->render('index', ['comments' => $comments, 'folloverNicks' => $folloverNicks]);
        }

       
        public function actionChangeStatus()
        {
            $commentModel = new CommentModel;
            $recordModel = new RecordModel;
            $userModel = new UserModel;

            $comment = CommentModel::find()
                        ->where(['id' => $_GET['id']])
                        ->one();
            $record = RecordModel::find()
                        ->where(['id' => $comment->record_id])
                        ->one();
            $user = UserModel::find()
                        ->where(['id' => $record->user_id])
                        ->one();
                        
            foreach ($comment as $key => $value) {
                $commentModel->{$key} = $value;
            }

            $commentModel->status = $_GET['status'];  
            if ($commentModel->validate()) {

                if ($commentModel->update(['id' => $comment->id])){
                    $_SESSION['success'] = 'OK';
                } else {
                    $_SESSION['error'] = 'ERROR';
                }
            }
            if (isset($_GET['type'])) {
                $this->redirect("/comment/index");
            } else {
                $this->redirect("/admin/item?id=$record->id&author=$user->nick");
            }

        }

        public function actionComment()
        {
            $model = new CommentModel;
            $model->record_id = $_GET['id'];
            $author = $_GET['author'];
            if ($model->loadPost() && $model->validate()) {

                $model->user_id = $_SESSION['auth'];
                if ($model->save()) {
                    $_SESSION['success'] = 'Success';
                } else {
                    $_SESSION['error'] = 'Error';
                }
                $this->redirect("/blog/item?id=$model->record_id&author=$author");
            }
            $this->render('comment', ['model' => $model]);
        }

        public function actionCommentLikeDislikeRecord()
        {
            if (isset($_POST)) {
                $id = $_POST['id'];
                $type = $_POST['type'];

                $model = new CommentModel;
                $comment = CommentModel::find()
                            ->where(['id' => $id])
                            ->one();
                
                foreach ($comment as $key => $value) {
                    $model ->{$key} = $value;
                }

                $model->{$type}++;
                if ($model->update(['id' => $id])) {
                    echo json_encode(['status' => 'success', 'id' => $id, 'type' => $model->{$type}]);
                } else {
                    echo json_encode(['status' => 'error', 'id' => $id]);
                }
            } else {
                echo json_encode(['status' => 'error']);
            }
        }
    }