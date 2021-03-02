<?php
    namespace MVC\Models;

    use MVC\Core\Model;

    class TaskModel extends Model
    {
        protected $title;
        protected $description;
        protected $id;

        public function __set($name, $value)
        {
            $this->$name = $value;
        }

        public function __get($name)
        {
            return $this->$name;
        }
    }
?>
