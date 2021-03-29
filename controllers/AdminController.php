<?php
    namespace controllers;
    
    use core\BaseController;
    use models\RecordModel;
    use models\UserModel;
    use models\CommentModel;

    class AdminController extends BaseController 
    {
        public function __construct()
        {
            if(!isset($_SESSION)) session_start();
        }

        public function actionIndex()
        {
            $authorNicks = [];
            $comentsCount = [];
            $blogs = RecordModel::find()
                            ->all();

            foreach ($blogs as $blog) {
                $comments = CommentModel::find()
                            ->where(['record_id' => $blog->id])
                            ->all();
                $user = UserModel::find()
                        ->where(['id' => $blog->user_id])
                        ->one();
                $authorNicks[$blog->id] = $user->nick;
                $comentsCount[$blog->id] = count($comments);
            }
            $this->layots = 'navbar';
            $this->render('index', ['blogs' => $blogs, 'authorNicks' => $authorNicks, 'comentsCount' => $comentsCount]);
        }

        public function actionItem()
        {
            $id = $_GET['id'];
            $folloverNicks = [];
            $record = RecordModel::find()
                    ->where(['id'=> $id])
                    ->one();
            $comments = CommentModel::find()
                        ->where(['record_id'=>$id])
                        ->all();
            foreach ($comments as $comment) {
                $user = UserModel::find()
                        ->where(['id' => $comment->user_id])
                        ->one();
                $folloverNicks[$comment->id] = $user->nick;
            }
            $this->layots = 'navbar';
            $this->render('item', ['record'=>$record, 'comments' => $comments, 'folloverNicks' => $folloverNicks]);
        }

        public function actionChangeStatus()
        {
            $blogs = new RecordModel;
            $record = RecordModel::find()
                        ->where(['id' => $_GET['id']])
                        ->one();
                        
            foreach ($record as $key => $value) {
                $blogs->{$key} = $value;
            }

            $blogs->status = $_GET['status'];  
            if ($blogs->validate()) {

                if ($blogs->update(['id' => $record->id])){
                    $_SESSION['success'] = 'OK';
                } else {
                    $_SESSION['error'] = 'ERROR';
                }
                $this->redirect('/admin/index');
            }
            $this->render('index', ['blogs' => $blogs]);
        }

        // При видаленні затверджених записів («аpproved»), записи з БД не видаляються. 
        // Змінюється статус записів на «not аpproved» та видаляються всі коментарі до них.
        public function actionDeleteRecords()
        {
            $modelRecord = new RecordModel;
            $modelComment = new CommentModel;

            $record = RecordModel::find()
                        ->where(['id' => $_GET['id']])
                        ->one();
            $comments = CommentModel::find()
                        ->where(['record_id' => $_GET['id']])
                        ->all();
            
            foreach ($record as $key => $value) {
                $modelRecord->{$key} = $value;
            }
            foreach ($comments as $key => $value) {
                $modelComment->{$key} = $value;
            }

            if ($record->status == 'approved') { 
                $modelRecord->status = 'not approved';
                if ($modelRecord->validate()) {
                    if ($modelRecord->update(['id' => $_GET['id']])) {
                        $modelComment->delete(['record_id' => $_GET['id']]);
                        $_SESSION['success'] = 'OK';
                    } else {
                        $_SESSION['error'] = 'ERROR';
                    }
                }
            } else if ($record->status == 'not approved') {
                if ($modelRecord->delete(['id' => $_GET['id']])) {
                    $_SESSION['success'] = 'OK';
                } else {
                    $_SESSION['error'] = 'ERROR';
                }
            }
            $this->redirect('/admin/index');
        }

        public function actionChangeRoleUser()
        {
            $modelUser = new UserModel;
            $user = UserModel::find()
                        ->where(['id' => $_GET['id']])
                        ->one();
                        
            foreach ($user as $key => $value) {
                $modelUser->{$key} = $value;
            }

            $modelUser->role = $_GET['role'];  
            if ($modelUser->validate()) {

                if ($modelUser->update(['id' => $_GET['id']])){
                    $_SESSION['success'] = 'OK';
                } else {
                    $_SESSION['error'] = 'ERROR';
                }
                $this->redirect('/user/index');
            }
            $this->render('index', ['users' => $modelUser]);
        }

        public function actionDeleteUser()
        {
            $modelUser = new UserModel;
            $user = UserModel::find()
                        ->where(['id'=>$_GET['id']])
                        ->one();
            
            foreach ($user as $key => $value) {
                $modelUser->{$key} = $value;
            }
            if ($modelUser->delete(['id' => $_GET['id']])) {
                $_SESSION['success'] = 'OK';
            } else {
                $_SESSION['error'] = 'ERROR';
            }
            $this->redirect('/user/index');
        }
    }
    