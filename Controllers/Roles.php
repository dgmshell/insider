<?php
class Roles extends Controllers
{
    protected Views $views;

    public function __construct()
    {
        parent::__construct();
        getPermissions(MD_ROLES);
    }

    /**
     * @throws Exception
     */
    public function roles(): void
    {
        $data["pageName"]     = "roles";

        //$users = $this->model->getUsers();
        debug($_SESSION['permissions']);
        debug($_SESSION['permissionsModule']);
        $this->views->getViews($this, 'roles', $data);
    }

    /**
     * @throws Exception
     */
    public function new(): void{
        $data["pageName"]     = "newUser";
        $this->views->getViews($this, 'new', $data);

    }
    public function setNewUser(): void{
        $user     = "newUser";
        $users = $this->model->setNewUser($user);

    }
}