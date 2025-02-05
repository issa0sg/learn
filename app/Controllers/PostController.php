<?php

namespace App\Controllers;

use App\Entities\Post;
use App\Services\PostService;
use Learn\Custom\Controller\AbstractController;

class PostController extends AbstractController
{
    public function __construct(protected PostService $postService)
    {
    }

    public function index(int $id)
    {
        $post = $this->postService->findOrFail($id);

        return $this->render('post_index.html.twig', [
            'post' => $post
        ]);
    }

    public function create()
    {
        return $this->render('post_create.html.twig');
    }

    public function store()
    {
        $post = Post::create(
            $this->request->postData('title'),
            $this->request->postData('description'),
        );

        $result = $this->postService->save($post);

        dd($result);
    }
}