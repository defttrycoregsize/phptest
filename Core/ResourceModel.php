<?php
    namespace MVC\Core;

    use MVC\Config\Database;
    use PDO;

    class ResourceModel implements ResourceModelInterface
    {
        protected $table;
        protected $id;
        protected $model;

        public function _init($table, $id, $model)
        {
            $this->table = $table;
            $this->id = $id;
            $this->model = $model;
        }

        public function index($model)
        {
            $sql = "SELECT * FROM " . $this->table;
            $req = Database::getBdd()->prepare($sql);
            $req->execute();

            return $req->fetchAll(PDO::FETCH_OBJ);
        }

        public function save($model){
            /* Column Insert */
            $properties = $model->getProperties();
            $columnsInsert = implode(',', array_keys($properties));

            /* Value Insert */
            $placeNames = [];
            foreach ($properties as $key => $value) {
                array_push($placeNames, ':' . $key);
            }
            $valuesInsert = implode(',', $placeNames);

            /* Column Update */
            $columsUpdate = [];
            foreach (array_keys($properties) as $value) {
                if ($value !== 'id') {
                    array_push($columsUpdate, $value . ' = :' . $value);
                }
            }
            $columsUpdate = implode(',', $columsUpdate);

            /* TRUE => Create, FALSE => Edit */
            if ($model->id === null) {
                $sql = 'INSERT INTO '.$this->table.' ('.$columnsInsert.', created_at, updated_at) VALUES ('.$valuesInsert.', :created_at, :updated_at)';
                $req = Database::getBdd()->prepare($sql);
                $date = array("created_at" => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'));

                return $req->execute(array_merge($properties, $date));

            }else {
                $sql = 'UPDATE '.$this->table.' SET ' . $columsUpdate . ', updated_at = :updated_at WHERE id = :id';
                $req = Database::getBdd()->prepare($sql);
                $date = array("id" => $model->id, 'updated_at' => date('Y-m-d H:i:s'));

                return $req->execute(array_merge($properties, $date));
            }
        }

        public function get($id)
        {
            $class = get_class($this->model);
            $sql = "SELECT * FROM ". $this->table ." WHERE id = :id";
            $req = Database::getBdd()->prepare($sql);
            $req->setFetchMode(PDO::FETCH_INTO, new $class);
            $req->execute(['id' => $id]);

            return $req->fetch();
        }

        public function delete($model)
        {
            $sql = "DELETE FROM ". $this->table ." WHERE id = ". $model->id;
            $req = Database::getBdd()->prepare($sql);

            return $req->execute(['id' => $model->id]);
        }
    }
?>
