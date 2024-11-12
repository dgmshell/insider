<?php
class Permissions extends Controllers
{
    protected Views $views;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function permissions(): void
    {
        $data["PAGE_NAME"]     = "permissions";


        $this->views->getViews($this, 'permissions', $data);
    }

    /**
     * @throws Exception
     */
    public function assign($id): void
    {
        // Verifica si el ID es válido
        if (!validateId($id)) {
            handleError();
            exit();
        }

        $verifyIdDb = verifyId($id);
        if (empty($verifyIdDb['total']) || $verifyIdDb['total'] == 0) {
            handleError();
            echo "id no encontrado";
            exit();
        }

        $modules = $this->model->getModules($id);
        $permissionsRole = $this->model->permissionRoleId($id);

        $defaultPermissions = ['c' => 0, 'r' => 0, 'u' => 0, 'd' => 0];
        $data1 = ['roleId' => $id];


        foreach ($modules as &$module) {
            $module['permissions'] = $defaultPermissions;

            foreach ($permissionsRole as $permRole) {
                if ($permRole['moduleId'] === $module['moduleId']) {
                    $module['permissions'] = [
                        'c' => $permRole['c'],
                        'r' => $permRole['r'],
                        'u' => $permRole['u'],
                        'd' => $permRole['d'],
                    ];
                    break;
                }
            }
        }

        $data1['modules'] = $modules;

        $data["userId"] = $id;
        $this->views->getViews($this, 'assign', $data, $data1);
    }
    public function assignPermissions1(): array {
        $modules = $_POST['module'];
        $roleId = $_POST['roleId'];

        // Elimina permisos anteriores para este rol
        $this->model->deletePermissions($roleId);

        // Almacena los IDs insertados
        $insertedIds = [];

        foreach ($modules as $module) {
            $moduleId = $module['moduleId'];
            $c = empty($module['c']) ? 0 : 1;
            $r = empty($module['r']) ? 0 : 1;
            $u = empty($module['u']) ? 0 : 1;
            $d = empty($module['d']) ? 0 : 1;

            // Asigna permisos y guarda el ID insertado
            $insertedId = $this->model->assignPermissions($roleId, $moduleId, $c, $r, $u, $d);
            $insertedIds[] = $insertedId; // Agrega el ID a la lista
            //debug($insertedId);
        }

        // Retorna todos los IDs insertados
        return $insertedIds;
    }
    public function assignPermissions(): false|string
    {
        $modules = $_POST['module'];
        $roleId = $_POST['roleId'];
        $this->model->deletePermissions($roleId);
        // Llama al modelo para asignar permisos
        $response= $this->model->assignPermissions($modules, $roleId);
        //debug($request);
        return json_encode($response);
    }


}