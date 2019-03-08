<?php

// https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html
class Product
{

    private $conn;
    private $table_name = "products";

    public $id;
    public $user_id;
    public $name;
    public $description;
    public $price;
    public $image;
    public $likes;
    public $timeleft;
    public $participants;
    public $participants_max;
    public $created;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function read()
    {
        $query = "SELECT * FROM " . $this->table_name . " p ORDER BY p.created DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($row) {
            return response('Success', $row, 200);
        }
        return response("No products found", null, 404);
    }

    function create()
    {

        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name, price=:price, description=:description, category_id=:category_id, created=:created";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->created = htmlspecialchars(strip_tags($this->created));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":created", $this->created);

        if ($stmt->execute()) {
            return true;
        }

        return false;

    }

    function readOne()
    {
        $query = "SELECT p.*, u.id, u.email, u.info
                  FROM " . $this->table_name . " p
                  LEFT JOIN `users` u ON u.id = p.user_id
                  WHERE p.id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return response('Success', $row, 200);
        }
        return response("Product does not exist", null, 404);
    }

    function update()
    {

        // update query
        $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,
                price = :price,
                description = :description,
                category_id = :category_id
            WHERE
                id = :id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind new values
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);

        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function delete()
    {

        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind id of record to delete
        $stmt->bindParam(1, $this->id);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;

    }

    function search($keywords)
    {

        // select all query
        $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            WHERE
                p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?
            ORDER BY
                p.created DESC";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $keywords = htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";

        // bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    public function readPaging($from_record_num, $records_per_page)
    {

        // select query
        $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            ORDER BY p.created DESC
            LIMIT ?, ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind variable values
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

        // execute query
        $stmt->execute();

        // return values from database
        return $stmt;
    }

    public function count()
    {
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }

    public function like($jwt, $userId, $like)
    {
        if ($this->id && $jwt && $userId) {

            if (validToken($jwt)) {

                $query = "SELECT p.likes AS product, u.likes AS user
                          from " . $this->table_name . " p, users u 
                          WHERE p.id = :id AND u.id = :userId";

                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(':id', $this->id);
                $stmt->bindParam(':userId', $userId);

                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $p_likes = $row['product'] ? json_decode($row['product'], true) : 0;
                $p_likes = $like ? --$p_likes : ++$p_likes; // false means user didn't liked product before

                $u_likes = $row['user'] ? json_decode($row['user'], true) : array();
                if (in_array($this->id, $u_likes)) {
                    $key = array_search($this->id, $u_likes);
                    unset($u_likes[$key]);
                } else {
                    array_push($u_likes, $this->id);
                }
                $u_likes = json_encode(array_values($u_likes), true);


                $query = "UPDATE " . $this->table_name . " p, users u 
                          SET p.likes = :pLikes, 
                              u.likes = :uLikes 
                          WHERE p.id = :id AND u.id = :userId";

                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(':pLikes', $p_likes);
                $stmt->bindParam(':uLikes', $u_likes);
                $stmt->bindParam(':id', $this->id);
                $stmt->bindParam(':userId', $userId);

                if ($stmt->execute()) {
                    return response("Product liked", null, 201);
                }
                return response("Something went wrong", null, 400);
            }
            return response("Not allowed to do that", null, 405);
        }
        return response("Unable to like product. Data is incomplete.", null, 400);

    }

}