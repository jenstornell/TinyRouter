<?php

route("/", function($matches) {
  return 'Home!';
});

route("user/:num", function($matches) {
  return $matches[1];
});

route("about/:any", 'about');

function about($matches) {
  return "About $matches[1]";
}

function routeHook($input, $matches) {
  print_r($matches);
  return 'homeit';
  die;
}