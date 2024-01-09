<?php
    class Post{
        function __construct()
        {
            
        }

        // GET
        
        function getAllPosts(){
            echo "Hola desde el metodo getAllPost() de POST Controller <br>";
        }

        function getPostById($id){
            echo "Hola desde el metodo getPostById".$id." de POST Controller <br>";
            echo "El id del Post es ".$id."<br>";
        }

        // POST
        public function createPost($data){
            echo "Hola desde el metodo createPost() de POST Controller <br>";
            echo "Los datos del POST son ".json_encode($data)."<br>";
        }

        // PUT

        public function updatePost($id, $data) {
            echo "Hola desde el metodo updatePost() de POST Controller <br>";
            echo "El ID del post es ".$id."<br>";
            echo "Los datos del Post son ".json_encode($data)."<br>";
        }

        //DELETE

        public function deletePost($id){
            echo "Hola desde el metodo deletePost de POST Controller <br>";
            echo "El id del POST es " .$id. "<br>";
        }

        

    }
?>