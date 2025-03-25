<?php
    require_once __DIR__ . '../../../../Controller/CasoController.php';

    $getambite = new CasoController();
    $getambite -> getambientesp($_POST['ambiente_id']);


