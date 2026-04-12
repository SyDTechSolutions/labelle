<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAppType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si el tipo de app es 'individual', verificar si la ruta está permitida
        if (config('app.type') === 'individual') {
            $allowedRoutes = [
                '/',
                'home',
                'invoices*',
                'receptor/mensajes*',
                'reports/invoices/summary',
                'reports/invoices',
                'reports/receptors',
                'settings',
                'users*',
                'customers*',
                'products*',
                'taxes*',
                'configfactura*',
                'login',
                'logout',
                'csrf-token',
                'hacienda*',
                'cxc*', // Permitir CxC por si se factura a crédito
                'payments*', // Permitir pagos relacionados
            ];

            $currentPath = $request->path();
            $isAllowed = false;

            foreach ($allowedRoutes as $pattern) {
                if (fnmatch($pattern, $currentPath)) {
                    $isAllowed = true;
                    break;
                }
            }

            if (!$isAllowed) {
                abort(403, 'Acceso no permitido en versión Individual');
            }
        }

        return $next($request);
    }
}

