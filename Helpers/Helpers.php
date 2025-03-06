<?php
function router(): string
{
    return ROUTER;
}
function files(): string
{
    return ROUTER . 'Assets/';
}
// Función para generar un token CSRF utilizando la función 'token'
function generateCsrfToken($length, $prefix, $hash): string
{
    return token($length, $prefix, $hash); // Llama a la función token
}

// Función para generar un token aleatorio con una longitud especificada, un prefijo opcional y la opción de aplicar hash
function token($length = 32, $prefix = '', $hash = false): string
{
    try {
        // Intenta generar bytes aleatorios seguros
        $randomBytes = random_bytes($length);
    } catch (Exception $e) {
        // Si falla, usa un método menos seguro (mt_rand) como fallback
        $randomBytes = '';
        for ($i = 0; $i < $length; $i++) {
            $randomBytes .= chr(mt_rand(0, 255));
        }
    }

    // Convierte los bytes aleatorios en formato hexadecimal
    $token = bin2hex($randomBytes);

    // Si se solicita, aplica el algoritmo hash sha256 al token
    if ($hash) {
        $token = hash('sha256', $token);
    }

    // Si hay un prefijo, lo añade al principio del token
    if (!empty($prefix)) {
        $token = $prefix . $token;
    }

    return $token;
}

function debug($data): void
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

/**
 * @throws Exception
 */

function verifyId(string $table, string $column, int $id): array
{

    require_once ("Models/HelpersModel.php");
    $request = new HelpersModel();
    return $request->verifyId($table, $column, $id);
}
/**
 * Maneja errores de carga de controlador o método.
 *
 * Esta función incluye el controlador de errores para gestionar las
 * situaciones en las que el controlador o el método no se puedan cargar.
 *
 * @return void
 */
function handleError(): void
{
    require_once 'Controllers/Errors.php'; // Incluye el controlador de errores
}
function validateId(mixed $id): bool
{
    if (filter_var($id, FILTER_VALIDATE_INT) === false || $id <= 0) {
        return false;
    }
    return true;
}

function getPermissions(int $moduleId): void
{
    try {
        require_once ("Models/PermissionsModel.php");
        // Instanciar el modelo de permisos
        $objPermissions = new PermissionsModel();

        // Suponiendo que el roleId es de la sesión o algún valor predefinido
        $roleId = $_SESSION['userData']['roleId'] ?? 0;
        //$roleId = 1;
        // Obtener permisos del rol
        $arrayPermissions = $objPermissions->permissionsModule($roleId);

        // Asignar permisos generales y específicos del módulo a la sesión
        $_SESSION['permissions'] = $arrayPermissions;

        $_SESSION['permissionsModule'] = $arrayPermissions[$moduleId] ?? '';

    } catch (Exception $e) {
        // Manejo de errores
        error_log("Error al obtener permisos: " . $e->getMessage());
        // Asignar valores por defecto en caso de error
        $_SESSION['permissions'] = [];
        $_SESSION['permissionsModule'] = '';
    }
}
//ME DQUEDE AQUI SEGUIR CON LOS PERMISOS YA LOS OBTENGO TODOS EN LA SESION Y EL PERMISOS POR MODULO TAMBIEN HA QUE VALIDAR
function adminHeader($data=""): void
{
    $adminHeader = "Views/Template/adminHeader.php";
    require_once $adminHeader;
}
function adminNav($data=""): void
{
    $adminNav = "Views/Template/adminNav.php";
    require_once $adminNav;
}
function adminFooter($data=""): void
{
    $adminFooter = "Views/Template/adminFooter.php";
    require_once $adminFooter;

}
function adminSidebar($data=""): void
{
    $adminSidebar = "Views/Template/adminSidebar.php";
    require_once $adminSidebar;

}

function emptyFields(array $fields): array {
    $emptyFields = [];
    foreach ($fields as $name => $value) {
        if (empty($value)) {
            $emptyFields[] = $name;
        }
    }
    return $emptyFields;
}