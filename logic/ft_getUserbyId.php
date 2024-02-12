<?php
    function getUserById($id) {
        $db = dbConnect();

        // Get user by ID query
        $queryUserById = "SELECT name, surname , email FROM user WHERE id = :id";

        // Get user by ID
        $queryPrepUserId = $db->prepare($queryUserById);
        $queryPrepUserId->bindParam(':id', $id, \PDO::PARAM_INT);
        $queryPrepUserId->execute();
        return $queryPrepUserId->fetch(PDO::FETCH_ASSOC);
    }
?>
