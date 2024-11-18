<?php

class Views
{
    private const VIEWS_PATH = 'Views/';

    /**
     * Renderiza la vista especificada para el controlador dado.
     *
     * @param object $controller El objeto del controlador
     * @param string $view El nombre de la vista a renderizar
     * @param array $data Datos opcionales para pasar a la vista
     * @throws Exception Si la vista no se encuentra.
     */
    public function getViews(object $controller, string $view, array $data = [],$data1 = [],$data2 = [],$data3 = []): void
    {
        // Obtener el nombre corto del controlador
        $controllerName = (new \ReflectionClass($controller))->getShortName();

        // Construir la ruta de la vista
        $viewPath = self::VIEWS_PATH . ($controllerName === 'Home' ? '' : $controllerName . '/') . $view . '.php';

        // Verificar si el archivo de vista existe
        if (!file_exists($viewPath)) {
            throw new Exception("La vista $viewPath no fue encontrada.");
        }

        // Incluir la vista
        require_once $viewPath;
    }
}