<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

namespace Core\Enums;

/**
 * Http Response
 *
 * @package App\Component
 */
class HttpResponse
{
    /**
     * Available status code response
     */
    const CODE_200 = 200;
    const CODE_301 = 301;
    const CODE_302 = 302;
    const CODE_400 = 400;
    const CODE_401 = 401;
    const CODE_403 = 403;
    const CODE_404 = 404;
    const CODE_405 = 405;
    const CODE_429 = 429;
    const CODE_500 = 500;
    const CODE_501 = 501;
    const CODE_503 = 503;

    /**
     * возвращает список
     *
     * @return array
     */
    public static function getList()
    {
        return [
            static::CODE_200,
            static::CODE_301,
            static::CODE_302,
            static::CODE_400,
            static::CODE_401,
            static::CODE_403,
            static::CODE_404,
            static::CODE_405,
            static::CODE_429,
            static::CODE_500,
            static::CODE_501,
            static::CODE_503,
        ];
    }
}
