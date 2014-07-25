<?php
include_once 'Translation.php';
include_once 'Translator.php';
include_once 'Exception.php';



$key = 'trnsl.1.1.20140725T045620Z.4b0ba6038be6185f.f217e8285f349aa5eb4adbf0a60d8943785e8179';

https://translate.yandex.net/api/v1.5/tr.json/translate?key=trnsl.1.1.20140725T045620Z.4b0ba6038be6185f.f217e8285f349aa5eb4adbf0a60d8943785e8179&text=hello&lang=en-ru&format=plain
use Yandex\Translate\Translator;
use Yandex\Translate\Exception;

try {
  $translator = new Translator($key);
  $translation = $translator->translate('Hello world', 'en-ru');

  echo $translation; // Привет мир

} catch (Exception $e) {
  echo $e;
}