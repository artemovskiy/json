<?php
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 04.01.2018
 * Time: 13:49
 */

namespace Xydens\JSON;

use Xydens\JSON\Exceptions\JsonErrorCtrlChar;
use Xydens\JSON\Exceptions\JsonErrorDepth;
use Xydens\JSON\Exceptions\JsonErrorStateMismatch;
use Xydens\JSON\Exceptions\JsonErrorSyntax;
use Xydens\JSON\Exceptions\JsonErrorUTF8;

class JSON {

    public static function decode($json_string){
        $decoded = json_decode($json_string);
        if($decoded === null || $decoded === false){
            self::handleError();
        }
        return $decoded;
    }

    public static function encode($object){
        $encoded = json_encode($object);
        if($encoded == false){
            self::handleError();
        }
        return $encoded;
    }

    public static function handleError(){
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return false;
                break;
            case JSON_ERROR_DEPTH:
                throw new JsonErrorDepth('Достигнута максимальная глубина стека');
                break;
            case JSON_ERROR_STATE_MISMATCH:
                throw new JsonErrorStateMismatch('Некорректные разряды или несоответствие режимов');
                break;
            case JSON_ERROR_CTRL_CHAR:
                throw new JsonErrorCtrlChar('Некорректный управляющий символ');
                break;
            case JSON_ERROR_SYNTAX:
                throw new JsonErrorSyntax('Синтаксическая ошибка, некорректный JSON');
                break;
            case JSON_ERROR_UTF8:
                throw new JsonErrorUTF8('Некорректные символы UTF-8, возможно неверно закодирован');
                break;
            default:
                throw new JSONException('Неизвестная ошибка');
                break;
        }

    }
}