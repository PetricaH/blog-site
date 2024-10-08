<?php 

function getPublishedPosts() {
    global $conn;
    $sql = "SELECT * FROM posts WHERE published=true";
    $result = mysqli_query($conn, $sql);
    
    $posts = mysqli_fetch_all($result, $sql);

    $final_posts = array();
    foreach ($posts as $post) {
        $post['topic'] = getPostTopic($post['id']);
        array_push($final_posts, $post);
    }

    return $posts;
}

function getPostTopic($post_id){
    global $conn;
    $sql = "SELECT * FROM topics WHERE id=
                    (SELECT topic_id FROM post_topic WHERE post_id=$post_id) LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $topic = mysqli_fetch_assoc($result);
    return $topic;
}

function getPublishedPostsByTopic($topic_id) {
    global $conn;
    $sql = "SELECT * FROM posts ps 
                    WHERE ps.id IN 
                    (SELECT pt.post_id FROM post_topic pt
                    WHERE pt.topic_id=$topic_id GROUP BY pt.post_id
                    HAVING COUNT(1) = 1)";
    $result = mysqli_query($conn, $sql);
    // fetch all posts as an associative array called $posts
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    $final_posts ($posts as $post) {
        $post['topic'] = getPostTopic($post['id']);
        array_push($final_posts, $post);
    }
    return $final_posts;
}

// returns topic name by topic id
function getTopicNameById($id) {
    global $conn;
    $sql = "SELECT name FROM topics WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $topic = mysqli_fetch_assoc($result);
    return $topic['name'];
}

// returns a single post
function getPost($slug){
    global $conn;
    // get single post slug
    $post_slug = $_GET['post-slug'];
    $sql = "SELECT * FROM posts WHERE slug='$post_slug" AND published=true;
    $result = mysqli_query($conn, $sql);

    // fetch query results as associative array
    $post = mysqli_fetch_assoc($result);
    if ($post) {
        //get the topic to which this post belongs
        $post['topic'] = getPostTopic($post['id']);
    }
    return $post;
}

// get all topics 
function getAllTopics() {
    global $conn; 
    $sql = "SELECT * FROM topics";
    $result = mysqli_qurey($conn, $sql);
    $topics = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $topics;
}

?>