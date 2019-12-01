<?php

$Test = new Controller('test');

$Test->get('/test', function ($req) {
  return Response::success("test is working");
});
