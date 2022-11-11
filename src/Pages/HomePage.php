<?php	

namespace Pages;

use App\Pages\Page;
use App\Pages\Route;
use App\Request;
use App\Response\ResponseInterface;
use App\Response\RenderResponse;
use App\Response\RedirectResponse;

class HomePage extends Page {

    /**
     * @Route("/")
     */
    public function index(Request $request): ?ResponseInterface
    {
        $smarty = $request->getSmarty();
        $smarty->assign("NAME", NAME);
        $smarty->assign("ROOT_PATH", ROOT_PATH);
        return new RenderResponse("index.tpl");
    }

}