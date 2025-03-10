
<?php
/**
 *
 */
class AttendancesModel extends Mysql
{
    private $intUserId;
    private $strUserEmail;
    private $strUserPassword;
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function getTodayAttendance($userId): array
    {

        $query   = "SELECT * FROM attendances WHERE userId = ? AND DATE(attendanceCreatedIn) = CURDATE()";
        return $this->find($query,[$userId]);
    }

    /**
     * @throws Exception
     */
    public function checkAttendanceStatus($userId): string
    {
        $query = "SELECT attendanceStartTime, attendanceEndTime 
              FROM attendances 
              WHERE userId = ? 
              AND DATE(attendanceCreatedIn) = CURDATE()";

        $request = $this->find($query, [$userId]);

        if (!empty($request) && !empty($request['attendanceStartTime']) && !empty($request['attendanceEndTime']) && $request['attendanceEndTime'] !== "00:00:00") {
            return json_encode([
                "status" => "SUCCESS_ATTENDANCE"
            ]);
        }

        return json_encode([
            "status" => "NO_ATTENDANCE_FOUND"
        ]);
    }


    public function setPush($userId, $attendanceStartTime, $attendanceEndTime, $attendanceStartNote,$attendanceEndNote):false|string
    {

        $attendanceEndTime = !empty($attendanceEndTime) ? $attendanceEndTime : "00:00:00";
        $attendanceStartNote = !empty($attendanceStartNote) ? $attendanceStartNote : "";
        $attendanceEndNote = !empty($attendanceEndNote) ? $attendanceEndNote : "";
        $this->beginTransaction();
        try {

                $query = "INSERT INTO attendances (userId, attendanceStartTime, attendanceEndTime, attendanceStartNote,attendanceEndNote) VALUES (?, ?, ?, ?,?)";
                $setData = array($userId, $attendanceStartTime, $attendanceEndTime, $attendanceStartNote,$attendanceEndNote);

                $insertedId = $this->save($query, $setData);
            $this->commitTransaction();
            //debug($insertedIds);
            return json_encode([
                "status" => "SUCCESS_ATTENDANCE_INSERT",
                "insertedId"=>$insertedId
            ]);
        } catch (Exception $e) {
            $this->rollbackTransaction();
            throw $e;
        }
    }
    public function updateCheckOut($userId,  $currentTime, $attendanceEndNote): false|string
    {

        $attendanceEndNote = !empty($attendanceEndNote) ? $attendanceEndNote : "";
        $this->beginTransaction();
        try {
            $query = "SELECT * FROM attendances WHERE userId = ? AND DATE(attendanceCreatedIn) = CURDATE()";
            $request = $this->find($query, [$userId]);

            if (empty($request)) {
                return json_encode([
                    "status" => "ERROR_ATTENDANCE_NOT_FOUND"
                ]);
            }

// Validar si 'attendanceEndTime' está vacío, NULL o en "00:00:00"
            if (!isset($request['attendanceEndTime']) || empty($request['attendanceEndTime']) || $request['attendanceEndTime'] === "00:00:00") {
                // Obtener el ID del usuario
                $attendanceId = $request['userId'];

                // Query para actualizar la hora de salida
                $query = "UPDATE attendances 
              SET attendanceEndTime = ?, attendanceEndNote = ? 
              WHERE userId = ? AND DATE(attendanceCreatedIn) = CURDATE()";  // Asegurar que solo actualizamos el de hoy

                $setData = array($currentTime, $attendanceEndNote, $attendanceId);

                $updatedRows = $this->updateRecord($query, $setData);

                if ($updatedRows > 0) {
                    return json_encode([
                        "status" => "SUCCESS_ATTENDANCE_UPDATE"
                    ]);
                } else {
                    return json_encode([
                        "status" => "ERROR_ATTENDANCE_UPDATE_FAILED"
                    ]);
                }
            } else {
                return json_encode([
                    "status" => "ERROR_ATTENDANCE_ALREADY_REGISTERED"
                ]);
            }

        } catch (Exception $e) {
            $this->rollbackTransaction();
            throw $e;
        }
    }
    public function updateCheckOutQ($userId, $checkOut) {
        $sql = "UPDATE attendances SET check_out = ? WHERE user_id = ? AND check_out IS NULL";
        $query = $this->db->prepare($sql);
        return $query->execute([$checkOut, $userId]);
    }

    /**
     * @throws Exception
     */
    public function setsPush($check,$data): false|string
    {


        return json_encode(array("check"=>$check,"data"=>$data));

        $this->strUserEmail = $data["userEmail"];
        $this->strUserPassword = $data["userPassword"];

        $query = "SELECT * FROM users WHERE userName = ?";
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

    /**
     * @throws Exception
     */
    public function sessionLogin(int $userId): void
    {
        $this->intUserId = $userId;
        $sql = "SELECT u.userId, u.userName, u.userStatus, u.roleId, r.roleName, r.roleDescription, r.roleStatus, p.profileNames, p.profileSurnames,profileIdentity
            FROM users u
            INNER JOIN profiles p 
            ON u.userId = p.userId
            INNER JOIN roles r 
            ON u.roleId = r.roleId
            WHERE u.userId = $this->intUserId";
        $request = $this->find($sql);
        $_SESSION['userData'] = $request;
    }
}

