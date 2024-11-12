
<?php
/**
 *
 */
class AuthModel extends Mysql
{
    private $strUserEmail;
    private $strUserPassword;
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function setLogin($data)
    {
        $this->strUserEmail = $data["userEmail"];
        $this->strUserPassword = $data["userPassword"];

        $query = "SELECT * FROM users WHERE userEmail = ?";
        $request = $this->find($query, [$this->strUserEmail]);

        if (empty($request)) {
            return json_encode([
                "status" => "ERROR_USER_NOT_FOUND"
            ]);
        }

        if ($request['userStatus'] == 0) {
            return json_encode([
                "status" => "ERROR_ACCOUNT_DISABLED"
            ]);
        }

        if (!password_verify($this->strUserPassword, $request['userPassword'])) {
            return json_encode([
                "status" => "ERROR_INVALID_PASSWORD"
            ]);
        }

        return json_encode([
            "status" => "SUCCESS_USER_VALID",
            "data" => $request
        ]);
    }


}

