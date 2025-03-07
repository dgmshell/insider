<?php
class Attendances extends Controllers
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
    public function attendances(): void
    {
        $data["pageName"]     = "attendances";
        $data["pageTitle"]     = "Attendances";
        //$users = $this->model->getUsers();
        //debug($_SESSION['permissions']);
        //debug($_SESSION['permissionsModule']);
        $this->views->getViews($this, 'attendances', $data);
    }

    /**
     * @throws Exception
     */
    public function push(): void{
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);
        $check = null;
        if (empty($json)) {
            $check=0;
        }else{
            $check=1;
        }
        $request = $this->model->setPush($check,$_SESSION['userData']["profileIdentity"]);
        debug($request);
    }
    public function setNewUser(): void{
        $user     = "newUser";
        $users = $this->model->setNewUser($user);

    }
}