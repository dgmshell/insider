
<?php
/**
 *
 */
class UsersModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function getUsers(): ?array
    {
        $query   = "SELECT * FROM users";
        return $this->findAll($query);
    }
    public function setNewUser(string $user): ?array{
        return array("id" => $user, "name" => $user);
    }
}
