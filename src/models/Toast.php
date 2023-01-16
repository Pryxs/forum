<?php

namespace App\models;

class Toast
{
    private static function getToastHTML($message, $class)
    {
    return <<<HTML
        <div class="toast {$class}" id="toast">
            {$message}
        </div> 
HTML;
    }

    private static function getToastScript()
    {
        return <<<HTML
            <script>
                var toast = document.getElementById('toast');

                if(toast){
                    toast.classList.add("launch");
                }

                toast.addEventListener("animationend", function() {
                    toast.classList.remove("launch");
                });
            </script>
HTML;
    }


    public static function waitingToast()
    {
        return self::getToastMessage() != NULL ? true : false;
    }


    public static function setToast(string $message, string $class)
    {
        setcookie('toast_message', $message, 0, '/');
        setcookie('toast_class', $class, 0, '/');
    }


    public static function getToastMessage()
    {
        return $_COOKIE['toast_message'];
    }


    public static function getToastClass()
    {
        return $_COOKIE['toast_class'];
    }


    public static function unsetToast()
    {
        unset($_COOKIE['toast_message']); 
        unset($_COOKIE['toast_class']); 
        setcookie('toast_message', '', time() - 3600, '/');
        setcookie('toast_class', '', time() - 3600, '/');
    }


    public static function mountToast()
    {
        ob_start();
        echo self::getToastHTML(self::getToastMessage(), self::getToastClass());
        echo self::getToastScript();
        // ob_end_flush();
        self::unsetToast();
        return ob_get_clean();
    }

}