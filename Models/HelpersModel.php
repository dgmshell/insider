
<?php
/**
 *
 */
class HelpersModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function verifyId(int $id): array
    {
        $query   = "SELECT COUNT(*) as total FROM users WHERE userId = ?";
        return $this->find($query, (array)$id);
    }
}
