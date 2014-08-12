<?php

/*
|----------------------------------
| Documents routes
|----------------------------------
*/
Route::group(
    array('prefix' => 'doc'),
    function () {

        /**
         * Introduction
         */
        Route::get(
            'introduction',
            array(
                'as' => 'doc.introduction',
                'uses' =>
                    function () {
                        $file = \File::get(Config::get('doc::path.md') . 'introduction.md');

                        $document = \MarkdownPlus::make($file);
                        $content = $document->getContent();

                        return View::make('doc::layout', compact('content'));
                    }
            )
        );
        /**
         * Company
         */
        Route::get(
            'company',
            array(
                'as' => 'doc.company',
                'uses' =>
                    function () {
                        $file = \File::get(Config::get('doc::path.md') . 'company.md');

                        $document = \MarkdownPlus::make($file);
                        $content = $document->getContent();

                        return View::make('doc::layout', compact('content'));
                    }
            )
        );

    }
);
