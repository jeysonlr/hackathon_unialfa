<?php

 declare(strict_types=1);

 namespace App;

 use Mezzio\Application;
 use Psr\Container\ContainerInterface;

 class RoutesDelegator
 {
     /**
      * @param ContainerInterface $container
      * @param string $serviceName
      * @param callable $callback
      * @return Application
      */
     public function __invoke(ContainerInterface $container, string $serviceName, callable $callback): Application
     {
         /** @var Application $app */
         $app = $callback();

         return $app;
     }
 }