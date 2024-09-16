<?php 

    class Route {

        function handle_route($url) {
            global $routes;
            unset($routes['default_controller']);
            $url = ltrim($url, '/');

            if (empty($url)) {
                $url = '/';
            }

            $dest_route = $url;
            if(!empty($routes)) {
                foreach ($routes as $key => $value) {
                    if (preg_match('~' . $key . '~is', $url)) {
                        $dest_route = preg_replace('~' . $key . '~is', $value, $url);
                    };
                }
            }
            return $dest_route;
        }

    }




?>