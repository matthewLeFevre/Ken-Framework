<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/includes.php';

$group = new Controller('group');

$group->addAction('createGroup',

  Function($payload){

    $filterLoad = Controller::filterPayload($payload);
                  Controller::required(['userId'], $filterLoad);
    $createGroup = create_group($filterLoad);

  }, TRUE);