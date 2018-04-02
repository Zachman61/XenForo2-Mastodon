<?php

namespace Z61\Mastodon\Option;

use XF\Option\AbstractOption;

class InstanceUrl extends AbstractOption
{
    public static function verifyOption(&$value, \XF\Entity\Option $option)
    {
        if (filter_var($value, FILTER_VALIDATE_URL) === false)
        {
            $option->error(\XF::phrase('z61_mastodon_invalid_url'));
        }

        $value = rtrim($value, '/\\');
        return true;
    }
}