<?php
final class ControllerError extends Controller
{
    public function error($errorMsg)
    {
        $header = "default";
        $footer = "default";
        $template = "default";
        $js = null;
        $css = null;
        $police = null;
        $meta = null;
        $this->render('error', compact('errorMsg', 'header', 'footer', 'template', 'js', 'css', 'police', 'meta'));
    }
}