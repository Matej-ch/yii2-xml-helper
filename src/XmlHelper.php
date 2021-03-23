<?php

namespace matejch\xmlhelper;

/**
 * This is just an example.
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

        if($result ===false)
        {
            $errors = libxml_get_errors();
            $latestError = array_pop($errors);
            return [
                'message' => $latestError->message,
                'type' => $latestError->level,
                'code' => $latestError->code,
                'file' => $latestError->file,
                'line' => $latestError->line,
            ];
        }
        if (!$this->asArray) {
            return $result;
        }
        return json_decode(json_encode($result), true);
    }
}
