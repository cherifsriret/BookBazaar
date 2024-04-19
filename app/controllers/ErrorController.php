<?php

class ErrorController
{
   
    public function forbidden()
    {
        $title = "Forbidden";
        return Helper::view('403',['title' => $title]);
    }

    public function notFound()
    {
        $title = "Not Found";
        return Helper::view('404',['title' => $title]);
    }

    public function serverError()
    {
        $title = "Server Error";
        return Helper::view('500',['title' => $title]);
    }

}


