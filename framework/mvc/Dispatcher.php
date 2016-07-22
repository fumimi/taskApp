<?php

// Dispatcher.php
// Class to carry out the distribution of the controller.

class Dispatcher {
    public function dispatch() {
        $params = array();
        if ('' != $_SERVER['REQUEST_URI']) {
            // パラメーターを"/"で分割
            $params = explode('/', $_SERVER['REQUEST_URI']);
        }

        // １番目のパラメーターをコントローラーとして取得
        $controller = 'index';
        if (0 < count($params)) {
            $controller = $params[0];
        }

        // パラメータより取得したコントローラー名によりクラス振分け
        $controllerInstance = null;
        switch ($controller) {
            case 'index':
                $controllerInstance = new IndexController();
                break;
            case 'product':
                $controllerInstance = new ProductController();
                break;
            case 'cart':
                $controllerInstance = new CartController();
                break;
            default:
                header("HTTP/1.0 404 Not Found");
                exit;
                break;
        }
    }
}

?>
