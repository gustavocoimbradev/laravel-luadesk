<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{

    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user' => $request->user(),
                'is_admin' => $request->user() ? (bool) auth()->user()->is_admin : false
            ],
            'count' => [
                'pending' => ($request->user() ? (bool) auth()->user()->is_admin : false) ? (\App\Models\Ticket::countPending() > 99 ? '99+' : \App\Models\Ticket::countPending()) : 0
            ],
            'route' => request()->route()->getName(),
            'flash' => [
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error')
            ]
        ];
    }
}
