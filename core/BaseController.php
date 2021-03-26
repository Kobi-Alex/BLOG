<?php
    namespace core;

    class BaseController
    {
        protected $layots;

        // виводимо views 
        public function render($views, array $params = [])
        {
            $className = lcfirst(str_replace('Controller', '', substr(get_class($this), strpos(get_class($this), '\\') + 1)));
            $viewPath = "./views/$className/$views.php";
            require_once './views/layots/header.php';
            if (isset($this->layots)) {
                require_once './views/layots/' . $this->layots . '.php';
            }
            // if ($this->layots) {
                //     require_once './views/layots/header.php';
            // }
            if (file_exists($viewPath)) {
                extract($params);
                require_once $viewPath;
            } else { 
                echo "view $viewPath not found";
                die();
            }
            require_once './views/layots/footer.php';
        }

        //кодування пароля
        protected function passwordHasher($password)
        {
            return sha1(SALT . $password . SALT);
        }

        //переспрямування
        public function redirect($path)
        {
            Header("Location: $path");
        }
    }