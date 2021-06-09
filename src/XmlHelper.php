<?php

namespace matejch\xmlhelper;

/**
 * Loading xml file
 */
class XmlHelper extends \yii\base\BaseObject
{
    /**
     * If parser result as array, this is default
     * @var boolean
     */
    public $asArray = true;

    public function parse($rawBody, $contentType)
    {
        libxml_use_internal_errors(true);

        $result = simplexml_load_string($rawBody, 'SimpleXMLElement', LIBXML_NOCDATA);

        if($result === false) {
            $errors = libxml_get_errors();

            $msg = '';
            foreach ($errors as $error) {
                $msg .= $this->parseError($error);
            }

            libxml_clear_errors();

            throw new \Exception($msg ?? 'Error message not found');
        }

        if (!$this->asArray) {
            return $result;
        }
        return json_decode(json_encode($result), true);
    }

    private function parseError($error): string
    {
        $message = '';
        switch ($error->level) {
            case LIBXML_ERR_WARNING:
                $message .= "Warning $error->code: ";
                break;
            case LIBXML_ERR_ERROR:
                $message .= "Error $error->code: ";
                break;
            case LIBXML_ERR_FATAL:
                $message .= "Fatal Error $error->code: ";
                break;
        }

        $message .= trim($error->message) .
            "\n  Line: $error->line" .
            "\n  Column: $error->column";

        if ($error->file) {
            $message .= "\n  File: $error->file";
        }

        return $message."\n";
    }
}
