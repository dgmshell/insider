<?php

/**
 * Class Controllers
 *
 * Esta clase sirve como controlador base en el framework MVC.
 * Se encarga de cargar el modelo correspondiente y manejar la
 * interacción entre el modelo y las vistas.
 */
class Controllers
{
    /**
     * @var mixed
     *
     * Almacena la instancia del modelo que se está utilizando.
     * Puede ser de cualquier tipo, dependiendo del modelo que se
     * cargue dinámicamente.
     */
    protected mixed $model;

    /**
     * @var Views
     *
     * Instancia de la clase Views que se utiliza para renderizar
     * las vistas correspondientes a las acciones del controlador.
     */
    protected Views $views;

    /**
     * Controllers constructor.
     *
     * Inicializa una nueva instancia de la clase Controllers.
     * Crea una nueva instancia de Views y carga el modelo correspondiente.
     */
    public function __construct()
    {
        $this->views = new Views();
        $this->loadModel();
    }

    /**
     * Carga el modelo correspondiente a este controlador.
     *
     * El nombre del modelo se deriva del nombre de la clase del controlador
     * añadiendo 'Model' al final. Por ejemplo, si la clase del controlador
     * se llama 'UserController', se intentará cargar el modelo 'UserModel'.
     *
     * Si el archivo del modelo existe en la ruta especificada, se incluye
     * y se crea una nueva instancia del modelo, que se almacena en la
     * propiedad `$model`.
     *
     * @return void
     */
    public function loadModel(): void
    {
        $model      = get_class($this) . 'Model'; // Deriva el nombre del modelo
        $routeClass = 'Models/' . $model . ".php"; // Define la ruta del archivo del modelo

        if (file_exists($routeClass)) {
            require_once $routeClass; // Incluye el archivo del modelo si existe
            $this->model = new $model(); // Crea una nueva instancia del modelo
        }
    }
}