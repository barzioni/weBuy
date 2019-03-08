<?php

class User
{

    private $conn;
    private $table_name = "users";

    public $id;
    public $email;
    public $password;
    public $info;
    public $likes;
    public $created;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        if (!empty($this->email) && !empty($this->password)) {

            if (!$this->emailExists()) {

                $query = "INSERT INTO " . $this->table_name . " SET role=3, email=:email, password=:password, created=:created";

                $stmt = $this->conn->prepare($query);

                $this->email = htmlspecialchars(strip_tags($this->email));
                $this->password = htmlspecialchars(strip_tags($this->password));

                $stmt->bindParam(":email", $this->email);

                $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
                $stmt->bindParam(':password', $password_hash);
                $this->created = date('Y-m-d H:i:s');
                $stmt->bindParam(":created", $this->created);

                if ($stmt->execute()) {

                    $data = array(
                        "jwt" => makeToken(),
                        "exp" => 3600,
                        "userId" => $this->conn->lastInsertId()
                    );
                    return response('User was created', $data, 201);
                }
                return response('Unable to create user', null, 503);
            }
            return response('User is already exists', null, 401);
        }
        return response('Data is incomplete', null, 400);
    }

    public function login()
    {
        $row = $this->emailExists();

        if ($row) {

            if (password_verify($this->password, $row['password'])) {

                unset($row['password']);
                $row['likes'] = json_decode($row['likes']);

                $data = array(
                    "jwt" => makeToken(),
                    "exp" => 3600,
                    "userData" => $row,
                );

                return response('User login success', $data, 200);
            }
            return response('Wrong password', null, 401);
        }
        return response('User login failed', null, 401);
    }

    function emailExists()
    {

        $query = "SELECT id, email, password, likes FROM " . $this->table_name . " WHERE email = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bindParam(1, $this->email);
        $stmt->execute();
        $num = $stmt->rowCount();

        if ($num > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function update($data)
    {

        // if password needs to be updated
        $password_set = !empty($this->password) ? ", password = :password" : "";

        // if no posted password, do not update the password
        $query = "UPDATE " . $this->table_name . "
            SET
                firstname = :firstname,
                lastname = :lastname,
                email = :email
                {$password_set}
            WHERE id = :id";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->email = htmlspecialchars(strip_tags($this->email));

        // bind the values from the form
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':email', $this->email);

        // hash the password before saving to database
        if (!empty($this->password)) {
            $this->password = htmlspecialchars(strip_tags($this->password));
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $password_hash);
        }

        // unique ID of record to be edited
        $stmt->bindParam(':id', $this->id);

        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
