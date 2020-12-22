<?php

    if (! function_exists('function_not_exists'))
    {
        function function_not_exists(string $functionName): bool
        {
            return !function_exists($functionName);
        }
    }

    if (function_not_exists('trimSpecialChars'))
    {
        function trimSpecialChars(string $string): string
        {
            return ucfirst(str_replace('_', ' ', $string));
        }
    }

    if (function_not_exists('activeSidebarLink'))
    {
        function activeSidebarLink(int $index, string $segment, $active = 'list-group-item-info')
        {
            return request()->segment($index) === $segment ? $active : '';
        }
    }





