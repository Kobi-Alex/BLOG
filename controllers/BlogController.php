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
            $comentsCount = [];
            $blogs = RecordModel::find()
                            ->where(['status' => 'approved'])
                            ->all();

            foreach ($blogs as $blog) {
                $comments = CommentModel::find()
                            ->where(['status' => 'approved', 'record_id' => $blog->id])
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

        public function actionIndexAuthor()
        {
            $author_id = $_SESSION['auth'];
            $comentsCount = [];
            $blogs = RecordModel::find()
                    ->where(['user_id' => $author_id])
                    ->all();

            foreach ($blogs as $blog) {
                $comments = CommentModel::find()
                            ->where(['record_id' => $blog->id])
                            ->all();

                $comentsCount[$blog->id] = count($comments);
            }
            
            $this->layots = 'navbar';
            $this->render('indexAuthor', ['blogs' => $blogs, 'comentsCount' => $comentsCount]);
        }

        public function actionItemAuthor()
        {
            $id = $_GET['id'];
            $record = RecordModel::find()
                        ->where(['id'=> $id])
                        ->one();
            $comments = CommentModel::find()
                        ->where(['record_id'=>$id])
                        ->all();

            $this->layots = 'navbar';
            $this->render('itemAuthor', ['record'=>$record, 'comments' => $comments]);
        }

        public function actionItemEdit()
        {
            $model = new RecordModel;
            $record = RecordModel::find()
                        ->where(['id' => $_GET['id']])
                        ->one();

            foreach ($record as $key => $value) {
                $model->{$key} = $value;
            }

            if ($model->loadPost() && $model->validate()) {

                $model->date = date("Y-m-d H:i:s");
                if ($model->update(['id' => $record->id])){
                    $_SESSION['success'] = 'OK';
                } else {
                    $_SESSION['error'] = 'ERROR';
                    
                }
                $this->redirect('/blog/indexAuthor');
            }
            $this->render('create', ['model' => $model]);

        }

        // При оновленні запису змінюється дата запису, 
        // всі коментарі до запису видаляються, запис потребує модерації адміністратора.
        public function actionUpdateItem()
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
            
            $modelRecord->status = 'not approved';
            $modelRecord->date = date("Y-m-d H:i:s");

            if ($modelRecord->validate()) {

                if ($modelRecord->update(['id' => $_GET['id']])){
                    $modelComment->delete(['record_id' => $_GET['id']]);
                    $_SESSION['success'] = 'OK';
                } else {
                    $_SESSION['error'] = 'ERROR';
                }
            }
            $this->redirect('/blog/indexAuthor');
        }

        public function actionLikeDislikeRecord()
        {
            if (isset($_POST)) {
                $id = $_POST['id'];
                $type = $_POST['type'];

                $model = new RecordModel;
                $record = RecordModel::find()
                        ->where(['id' => $id])
                        ->one();
                
                foreach ($record as $key => $value) {
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