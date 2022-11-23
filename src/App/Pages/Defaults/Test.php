<?php	

namespace App\Pages\Defaults;

use App\Pages\Page;
use App\Pages\Route;
use App\Request;
use App\Response\ResponseInterface;
use App\Response\RenderResponse;
use App\Response\RedirectResponse;

class Test extends Page {

    /**
     * @Route("/test")
     */
    public function index(Request $request): ?ResponseInterface
    {
        $smarty = $request->getSmarty();
        $smarty->assign("TRACE", $request->getData()["traceString"]);
        $smarty->assign("CLASS", $request->getData()["class"]);
        $smarty->assign("ERROR", $request->getData()["error"]);
        $smarty->assign("LINE", $request->getData()["line"]);
        $smarty->assign("FILE", $request->getData()["file"]);
        $smarty->assign("CODE", $request->getData()["code"]);

        $i = 0;
        $fileCode = "";

        $line = $request->getData()["line"];
        $find = [$line - 3, $line - 2, $line - 1, $line, $line + 1, $line + 2, $line + 3];
        $needToFind = count($find);
        $found = 0;

        $file = new \SplFileObject($request->getData()["file"]);
        while (!$file->eof()) 
        {
            $a = $file->fgets();
            if (in_array($i, $find)) 
            {
                if ($i == $line - 2) $fileCode .= "<span class='hl-line'>" . $a . "</span>";
                else $fileCode .= $a;
                $found++;
            }

            if ($found >= $needToFind) break;
            
            $i++;
        }

        $replace = [
            "if" => "highlight",
            "throw" => "highlight",
            "new" => "highlight",
            "return" => "highlight",
            "use" => "type",
            "require" => "highlight",
            "require_once" => "highlight",
            "include" => "highlight",
            "include_once" => "highlight",
            "public" => "type",
            "function" => "type",
            "void" => "type",
            "namespace" => "type",
            "bool" => "type",
            "int" => "type",
            "string" => "type",
            "array" => "type",
            "foreach" => "highlight",
            "for" => "highlight",
            "self" => "type",
            "static" => "type",
            "class" => "type",
            "extends" => "type",
            "implements" => "type",
            "<?php" => "type",
            "private" => "type",
            "public" => "type",
        ];

        $fileCode = $this->toColor($fileCode, $replace, $line);

        $smarty->assign("FILE_CODE", $fileCode);

        return new RenderResponse("@Default.error/exception.tpl");
    }

    private function toColor(string $code, array $replace, int $line): string
    {
        $converted = "";
        $split = explode(" ", $code);
        foreach ($split as $v)
        {
            $op = "";
            $t = explode("->", $v);
            foreach ($t as $o)
            {
                if (substr($o, 0, 1) == "$")
                {
                    $z = $o;
                    $o = "<code class='variable'>" . $o . "</code>";
                    if (substr($v, 0, strlen($z) + 2) == $z . "->")
                    {
                        $o .= "->";
                    }
                }

                if (isset($replace[$o]))
                {
                    $c = $replace[$o];
                    $o = "<code class='" . $c . "'>" . $o . "</code>";
                }

                $op .= $o;
            }

            $converted .= $op . " ";
        }

        preg_match_all('/\"([a-zA-Z0-9!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]+)\"/', $converted, $h);
        for ($i = 0; $i < count($h); $i += 2) {
            foreach ($h[$i] as $tt) {
                $converted = str_replace($tt, "<code class='string'>" . $tt . "</code>", $converted);
            }
        }

        preg_match_all('/([0-9]+)/', $converted, $hh);
        for ($i = 0; $i < count($hh); $i += 2) {
            foreach ($hh[$i] as $tt) {
                $converted = str_replace($tt, "<code class='integer'>" . $tt . "</code>", $converted);
            }
        }

        $converted = str_replace("(", "<code class='function'>(</code>", $converted);
        $converted = str_replace(")", "<code class='function'>)</code>", $converted);

        $toReturn = "";
        $i = $line - 2;
        foreach (explode("\n", $converted) as $l)
        {
            $toReturn .= "<span class='line'>" . $i . "</span> " . $l . "\n";
            $i++;
        }

        return $toReturn;
    }

}