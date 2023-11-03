<?php

class IndexSQL {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getCategories() {
        $queryCategories = "SELECT * FROM categorias";
        $stmtCategories = $this->conn->query($queryCategories);
        return $stmtCategories->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAuthors() {
        $queryAuthors = "SELECT * FROM autor";
        $stmtAuthors = $this->conn->query($queryAuthors);
        return $stmtAuthors->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchBooks($search) {
        $query = "SELECT libros.id, libros.titulo, libros.descripcion, libros.portada, autor.nombre AS autor_nombre, autor.apellido AS autor_apellido, categorias.nombre AS categoria, libros.precio, libros.fecha_publicacion
                  FROM libros
                  INNER JOIN autor ON libros.autor_id = autor.id
                  INNER JOIN categorias ON libros.categoria_id = categorias.id
                  WHERE libros.titulo LIKE :search
                  OR autor.nombre LIKE :search
                  OR autor.apellido LIKE :search
                  OR categorias.nombre LIKE :search";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBooks($selectedCategory, $selectedAuthor) {
        $query = "SELECT libros.id, libros.titulo, libros.descripcion, libros.portada, autor.nombre AS autor_nombre, autor.apellido AS autor_apellido, categorias.nombre AS categoria, libros.precio, libros.fecha_publicacion
                  FROM libros
                  INNER JOIN autor ON libros.autor_id = autor.id
                  INNER JOIN categorias ON libros.categoria_id = categorias.id";

        if ($selectedCategory) {
            $query .= " WHERE libros.categoria_id = :category";
        } elseif ($selectedAuthor) {
            $query .= " WHERE libros.autor_id = :author";
        }

        $stmt = $this->conn->prepare($query);

        if ($selectedCategory) {
            $stmt->bindParam(':category', $selectedCategory, PDO::PARAM_INT);
        } elseif ($selectedAuthor) {
            $stmt->bindParam(':author', $selectedAuthor, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPriceAverages() {
        $queryPriceAverage = "SELECT c.nombre AS categoria, AVG(l.precio) AS precio_promedio
                            FROM libros l
                            INNER JOIN categorias c ON l.categoria_id = c.id
                            GROUP BY c.nombre";
        $stmtPriceAverage = $this->conn->query($queryPriceAverage);
        return $stmtPriceAverage->fetchAll(PDO::FETCH_ASSOC);
    }
}




?>