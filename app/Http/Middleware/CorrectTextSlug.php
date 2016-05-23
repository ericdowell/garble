<?php

namespace Garble\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class CorrectTextSlug
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->correctSlug($request);

        return $next($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    protected function correctSlug(&$request)
    {
        $slug = $request->input('slug');
        $validateMethod = ($request->isMethod('POST') ||
            $request->isMethod('PUT') ||
            $request->isMethod('PATCH')
        );
        if (!empty($slug) && $validateMethod) {
            $strSlug = Str::slug($slug);
            if ($strSlug !== $slug) {
                $request->request->set('slug', $strSlug);
            }
        }
    }
}
