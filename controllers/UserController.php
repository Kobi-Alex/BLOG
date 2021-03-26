<?php
    namespace controllers;

    use core\BaseController;
    use models\UserModel;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    class UserController extends BaseController
    {
        public function __construct()
        {
            $this->layots = 'navbar';
            if(!isset($_SESSION)) session_start();
        }
        public function actionIndex()
        {
            echo __CLASS__;
        }
        // public function actionCreate()
        // {
        //     echo __CLASS__ . 'create';
        // }
        public function actionLogin()
        {
            $this->layots = NULL;
            $model = new UserModel;
            if ($model->loadPost() ) {
                $user = UserModel::find()
                ->where(['email'=> $model->email, 'password'=>$this->passwordHasher($model->password), 'confirm' => 1])
                ->one();

                if ($user) {

                    $_SESSION['auth'] = $user->id;
                    $_SESSION['user'] = json_encode([
                        'email'=>$user->email,
                        'role'=>$user->role,
                        'nick'=>$user->nick,
                        'url_avatar'=>$user->url_avatar
                    ]);
                    // $_SESSION['role']=$user->role;
                    // $_SESSION['url_avatar']=$user->url_avatar;
                    // $_SESSION['nick']=$user->nick;
                    $this->redirect('/blog');
                } else {
                    $_SESSION['error'] = 'Login are password is not correct!!';
                }
            }
            $this->render('login', ['model' => $model]);
        }
        
        public function actionRegister()
        {
            // Пошук пo email  чи немає такого в базі
            //1. find SELECT * FROM table
            //2. where - add fields and value
            //3. All - SELECT*  (array(obj))
            //4. One - виконати і повернути обєкт

            $this->layots = NULL;
            // $this->layots = false;

           
            $model = new UserModel;
            if ($model->loadPost() && $model->validate()) {
                
                $user = UserModel::find()
                    ->where(['email'=> $model->email])
                    ->one();
                if (!$user) {
                    $model->password = $this->passwordHasher($model->password);
                    if ($_FILES['avatar']['name'] != "") {
                        $fileExtention = explode('.', $_FILES['avatar']['name']);
                        $fileName = md5(microtime()) . '.' . $fileExtention[count($fileExtention)-1];
                        if (!file_exists('avatar')) {
                            mkdir('avatar');
                        }
                        move_uploaded_file($_FILES['avatar']['tmp_name'], 'avatar/' . $fileName);
    
                    } else {
                        $fileName = 'avatar2.png';
                    }
                    $model->url_avatar = 'avatar/' . $fileName;
                    // var_dump($_FILES);
                    // die();
                   if ($model->save()) {
                       $this->actionSendEmail($model);
                        $_SESSION['success'] = 'success';
                    } else {
                        $_SESSION['error'] = 'Error';
                    }
                } else {
                    $_SESSION['error'] = 'User with this email is alredy registered';
                    // $this->redirect('/blog');
                }
                // var_dump($user);
                // die();

                $this->redirect('/blog');
            }
            $this->render('create', ['model' => $model]);
        }

        public function actionSendEmail($user)
        {
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = USER_EMAIL;                     //SMTP username
                $mail->Password   = PASSWORD_EMAIL;                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom(USER_EMAIL, NAME_EMAIL);
                $mail->addAddress($user->email, $user->nick);     //Add a recipient
                // $mail->addAddress('ellen@example.com');               //Name is optional
                // $mail->addReplyTo('info@example.com', 'Information');
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');

                //Attachments
                // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Confirm registration';
                $mail->Body    = '<p> Confirm </p> <a href="http://localhost/user/confirm?user=' . $user->id . '"target="_blank"> Click link </a>';
                // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();
                // echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                die();
            }
        }

        public function actionConfirm()
        {
            //1.Перевырити чи данний клористувач не підтвердив свою елю адресу
            $user = UserModel::find()->where(['id' => $_GET['user'], 'confirm'=>1])->one();
            if ($user) {
                // redirect->...........
                echo('Link is not exist!!!');
                die();
            }
            // var_dump ($_GET);
            // die();
            $model = new UserModel;
            $user = UserModel::find()
                    ->where(['id' => $_GET['user']])
                    ->one();

            foreach ($user as $key => $value) {
                $model->{$key} = $value;
            }
            $model->confirm = 1;
            $model->update(['id' => $_GET['user']]);
            $this->redirect('/blog');

        }

        public function actionLogout()
        {
            session_unset();
            session_destroy();
            $this->redirect('/blog');
        }

        public function actionEdit()
        {
            $model = new UserModel;
            $user = UserModel::find()
                    ->where(['id' => $_GET['id']])
                    ->one();

            foreach ($user as $key => $value) {
                $model->{$key} = $value;
            }

            //місце для поста

            if ($model->loadPost() && $model->validate()) {
                $model->password = $this->passwordHasher($model->password);
                if ($_FILES['avatar']['name'] != '') {
                    if ($model->url_avatar != 'avatar/avatar2.png') {
                        unlink($model->url_avatar);
                    }
                    $fileExtention = explode('.', $_FILES['avatar']['name']);
                    $fileName = md5(microtime()) . '.' . $fileExtention[count($fileExtention)-1];
                    if (!file_exists('avatar')) {
                        mkdir('avatar');
                    }
                    move_uploaded_file($_FILES['avatar']['tmp_name'], 'avatar/' . $fileName);
                    $model->url_avatar = 'avatar/' . $fileName;
                }
                if ($model->update(['id' => $user->id])){
                    $_SESSION['success'] = 'OK';
                } else {
                    $_SESSION['error'] = 'ERROR';
                    
                }
                $this->redirect('/blog');
            }

            $this->render('create', ['model' => $model]);


        }
    }       