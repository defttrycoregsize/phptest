<?php
    namespace MVC\Controllers;

    use MVC\Core\Controller;
    use MVC\Models\TaskModel;
    use MVC\Models\TaskRepository;

    class TasksController extends Controller
    {

        public function __construct()
        {
            $this->taskRepository = new TaskRepository();
        }

        function index()
        {
            $tasks = new TaskModel();

            $d['tasks'] = $this->taskRepository->getAll($tasks);

            $this->set($d);

            $this->render("index");
        }

        function create()
        {
            if (isset($_POST["title"]) && isset($_POST["description"]))
            {
                $task= new TaskModel();
                $task->title = $_POST["title"];
                $task->description = $_POST["description"];

                if ($this->taskRepository->add($task))
                {
                    header("Location: " . WEBROOT . "tasks/index");
                }
            }

            $this->render("create");
        }

        function edit($id)
        {
             $d["task"] = $this->taskRepository->showById($id);

             if (isset($_POST["title"]) && isset($_POST["description"]))
             {
                 $task= new TaskModel();
                 $task->id = $_POST["id"];
                 $task->title = $_POST["title"];
                 $task->description = $_POST["description"];

                 if ($this->taskRepository->update($task))
                 {
                     header("Location: " . WEBROOT . "tasks/index");
                 }
             }

             $this->set($d);
             $this->render("edit");
         }

        function delete($id)
         {
             $task = new TaskModel();
             $task->id = $id;

             if ($this->taskRepository->destroy($task))
             {
                 header("Location: " . WEBROOT . "tasks/index");
             }
         }
    }
?>
