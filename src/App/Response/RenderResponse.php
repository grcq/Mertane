<?php

namespace App\Response;

use App\Mertane;
use App\Response\ResponseInterface;

class RenderResponse implements ResponseInterface {

    public function __construct(string $fileName)
    {
        $smarty = Mertane::$smarty;

        $smarty->display(ROOT_PATH . "/src/Resources/" . $fileName);
    }

}