<?php
class Auth extends Controllers
{
    protected Views $views;

    public function __construct()
    {
        parent::__construct();
        session_start();
        if (isset($_SESSION['login'])) {
            header('Location:'.router().'dashboard');
            exit();
        }
    }

    /**
     * @throws Exception
     */
    public function users(): void
    {

    }

    /**
     * @throws Exception
     */
    public function login(): void{
        $data["pageName"]     = "login";


        $this->views->getViews($this, 'login', $data);

    }
    public function setLogin()
    {
        // Obtener y decodificar los datos JSON recibidos en la solicitud
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        // Extraer los datos del formulario
        $FormData = [
            'userEmail' => $json['userEmail'] ?? '',
            'userPassword' => $json['userPassword'] ?? ''
        ];

        // Verificar si hay campos vacíos
        $FieldVerification = emptyFields($FormData);

        if (!empty($FieldVerification)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Algunos campos están vacíos.',
                'fields' => $FieldVerification,
                'redirect' => false
            ]);
            return; // Detener ejecución para evitar continuar
        }

        // Llamar al modelo para intentar iniciar sesión
        $request = $this->model->setLogin($FormData);
        $response = json_decode($request, true);
        // Verificar el resultado de la respuesta del modelo y responder según el caso
        switch ($response["status"]) {
            case "SUCCESS_USER_VALID":


                if($response['data']['userStatus'] == 1) {
                    $_SESSION['userId'] = $response['data']['userId'];
                    $_SESSION['login'] = true;


                    $arrayData = $this->model->sessionLogin($_SESSION['userId']);
                    debug($_SESSION['userData']);
                    echo json_encode(array(
                        'status' => 'login',
                        'message'=> 'Acceso exitoso, lo estamos redireccionando...',
                        'redirect'=>true));

                }


                echo json_encode([
                    'status' => 'success',
                    'message' => 'Usuario encontrado.',
                    'redirect' => true
                ]);
                break;

            case "ERROR_USER_NOT_FOUND":
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Usuario no encontrado.',
                    'redirect' => false
                ]);
                break;

            case "ERROR_ACCOUNT_DISABLED":
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Usuario deshabilitado. Contacta al administrador.',
                    'redirect' => false
                ]);
                break;

            case "ERROR_INVALID_PASSWORD":
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Contraseña incorrecta.',
                    'redirect' => false
                ]);
                break;

            default:
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error desconocido.',
                    'redirect' => false
                ]);
                break;
        }
    }

    public function signup(): void{
        $data["pageName"]      = "signup";
        $this->views->getViews($this, 'signup', $data);

    }
}