<?php
namespace App\Repositories;

use App\Models\Comment;
use App\Contracts\CommentContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

 
class CommentRepository extends BaseRepository implements CommentContract
{
   
    public function __construct(Comment $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

  
    public function listComments(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

   
    public function findCommentById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }

    }

    public function deleteComment($id)
    {
        $comment = $this->findCommentById($id);

        $comment->delete();

        return $comment;
    }

    

}