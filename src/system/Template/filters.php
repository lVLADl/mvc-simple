<?php

global $twig;

/*
$twig->addFilter(new \Twig\TwigFilter('date', function($value) {
    return $value . '[' . date('Y.M.D') . ']';
}));
*/

$twig->addFunction(new \Twig\TwigFunction('buildPathByRoute', function(string $routeName) {
    return buildPathByRoute($routeName);
}));