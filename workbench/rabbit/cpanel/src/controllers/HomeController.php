<?php
namespace Rabbit\Cpanel;

class HomeController extends BaseController
{

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $file = \File::get(\Config::get('cpanel::path.doc') . 'home.md');

        $document = \MarkdownPlus::make($file);
        $content = $document->getContent();

        return \View::make('cpanel::home.index', compact('content'));
    }

}
