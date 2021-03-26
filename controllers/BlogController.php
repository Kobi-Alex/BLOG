<?php
    namespace controllers;
    
    use core\BaseController;
    use models\RecordModel;
    use models\UserModel;
    use models\CommentModel;

    class BlogController extends BaseController
    {
        public function __construct()
        {
            // $this->layots = 'navbar';
            if(!isset($_SESSION)) session_start();
            // if (!isset($_SESSION['auth'])) {
            //     $this->redirect('/blog');
            // }
        }
        
        public function actionIndex()
        {
            // echo __CLASS__;
            // require_once './views/blog/index.php';
            // $model =['id'=> 1, 'record'=>"My record #1"];
            // $this->render('index', ['model' => $model, 'user' => 'author']);
            $authorNicks = [];
            $blogs = RecordModel::find()
                                ->where(['status' => 'approved'])
                                ->all();

            foreach ($blogs as $blog) {
                // $comment = CommentModel::find()
                //                         ->where(['status' => 'approved', 'blog_id' => $blog->id])
                //                         ->all();
                $user = UserModel::find()
                                    ->where(['id' => $blog->user_id])
                                    ->one();
                $authorNicks[$blog->id] = $user->nick;
            }
            
            $this->layots = 'navbar';
            $this->render('index', ['blogs' => $blogs, 'authorNicks' => $authorNicks]);
        }

        public function actionCreate()
        {
            $model = new RecordModel;
            if ($model->loadPost() && $model->validate()) {

                $model->user_id = $_SESSION['auth'];
                if ($model->save()) {
                    $_SESSION['success'] = 'Success';
                } else {
                    $_SESSION['error'] = 'Error';
                }
                $this->redirect('/blog');
            }
            $this->render('create', ['model' => $model]);
        }

        public function actionItem()
        {
            $id = $_GET['id'];
            $folloverNicks = [];
            $record = RecordModel::find()
                                ->where(['id'=> $id])
                                ->one();
            $comments = CommentModel::find()
                                ->where(['record_id'=>$id,'status' => 'approved'])
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
    }