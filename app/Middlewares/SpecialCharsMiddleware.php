<?php

namespace Middlewares;

use Src\Request;
use function Collect\collection;
class SpecialCharsMiddleware
{
    public function handle(Request $request):Request
    {
        collect($request->all())
            ->each(function ($value, $key) {
                $request->set($key, is_string($value) ? htmlspecialchars($value) : $value);
            }, $request);
        return $request;
    }
}
