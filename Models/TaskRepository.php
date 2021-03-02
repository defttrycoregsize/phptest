<?php
    namespace MVC\Models;

    use MVC\Models\TaskResourceModel;
    use MVC\Models\TaskModel;

    class TaskRepository {
        protected $taskResourceModel;

        public function __construct()
        {
            $this->taskResourceModel =new TaskResourceModel();
        }

        public function getAll($model)
        {
            return $this->taskResourceModel->index($model);
        }

        public function add($model)
        {
            return $this->taskResourceModel->save($model);
        }

        public function showById($id)
        {
            return $this->taskResourceModel->get($id);
        }

        public function update($model)
        {
            return $this->taskResourceModel->save($model);
        }

        public function destroy($model)
        {
            return $this->taskResourceModel->delete($model);
        }
    }
?>
