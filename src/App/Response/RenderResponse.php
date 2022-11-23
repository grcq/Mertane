<?php

namespace App\Response;

use App\Mertane;
use App\Request;
use App\Response\ResponseInterface;

class RenderResponse implements ResponseInterface {

    public function __construct(string $fileName)
    {
        $smarty = Mertane::getSmarty();

        $path = ROOT_PATH . "/src/Resources/" . $fileName;
        if (strlen($fileName) >= strlen("@Default."))
        {
            if (substr($fileName, 0, strlen("@Default.")) == "@Default.")
            {
                $path = ROOT_PATH . "/src/App/Pages/Defaults/Resources/" . substr($fileName, strlen("@Default."), strlen($fileName));
            }
        }

        $smarty->display($path);
    }

}