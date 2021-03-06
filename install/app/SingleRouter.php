<?php
namespace install\app;

use kira\core\App;
use kira\net\AbstractRouter;

/**
 * Роутер мастера приложения.
 *
 * Примеры мартшрутов:
 *  'routes' => [
 *     'install'          => 'SingleController/index',
 *     'install/success'  => 'SingleController/success',
 *  ]
 */
class SingleRouter extends AbstractRouter
{
    /**
     * Парсинг URL и вызов action-метода в соответствующем контроллере.
     * Учитывая, что контроллер всего один, путь к нему частично забит хардкодом.
     * @return void
     */
    public function callAction()
    {
        if (!isset($_SERVER['REQUEST_URI'])) {
            $this->throwError('неизвестный запрос');
        }

        $url = explode('?', $_SERVER['REQUEST_URI'])[0];
        $url = trim($url, '/');
        $routes = App::conf('router.routes');
        $routes = array_flip($routes);

        if (!$route = array_search($url, $routes)) {
            $this->throwError('роут не найден');
        }

        $route = explode('/', $route);
        $controller = KIRA_APP_NAMESPACE . 'app\\' . $route[0];
        $action = $route[1];

        (new $controller)->$action();
    }

    /**
     * Не нашли роут. Отвечаем сообщением об ошибке.
     * @param $msg
     */
    private function throwError($msg)
    {
        if (!headers_sent()) {
            header('Content-Type: text/html; charset=UTF-8');
        }
        exit($msg);
    }

    /**
     * Заглушка.В этом приложении нет такой необходимости. Поэтому нет реализации.
     * Построение URL по описанию.
     * @param mixed $route
     * @param array $params
     * @return string
     */
    public function url($route, array $params = [])
    {
        return '';
    }

    /**
     * Заглушка.В этом приложении нет такой необходимости. Поэтому нет реализации.
     * Собираем из массива GET-строку запроса, которая пишется в URL после знака вопроса
     * @param array $params
     * @return string
     */
    public function makeQueryString(array $params)
    {
        return '';
    }

    /**
     * Заглушка
     * Названия контроллера, к которому обратился роутер после парсинга запроса
     * @return string
     */
    public function getController()
    {
        return '';
    }

    /**
     * Заглушка
     * Названия метода-действия, которое вызвал роутер после парсинга запроса
     * @return string
     */
    public function getAction()
    {
        return '';
    }
}
