<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use App\Models\School; // Asegúrate de que el modelo School esté correctamente importado

class SetSchoolDatabase
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Obtener el subdominio desde la solicitud
        $subdomain = explode('.', $request->getHost())[0];

        // Verificar si el subdominio corresponde a un colegio
        $school = School::where('subdomain', $subdomain)->first();

        if ($school) {
            // Cambiar la conexión a la base de datos del colegio
            $dbName = 'school_' . $subdomain;
            config(['database.connections.school.database' => $dbName]);

            // Reconectar con la nueva base de datos
            DB::purge('school');
            DB::reconnect('school');
        } else {
            // Si el subdominio no corresponde a un colegio, manejar el caso (redirigir o mostrar error)
            abort(404, 'Colegio no encontrado');
        }

        return $next($request);
    }
}
