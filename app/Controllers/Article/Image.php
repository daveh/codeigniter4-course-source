<?php

namespace App\Controllers\Article;

use App\Controllers\BaseController;
use App\Models\ArticleModel;
use App\Entities\Article;
use CodeIgniter\Exceptions\PageNotFoundException;
use RuntimeException;
use finfo;

class Image extends BaseController
{
    private ArticleModel $model;

    public function __construct()
    {
        $this->model = new ArticleModel;
    }

    public function new($id)
    {
        $article = $this->getArticleOr404($id);

        return view("Article/Image/new", [
            "article" => $article
        ]);
    }

    public function create($id)
    {
        $article = $this->getArticleOr404($id);

        $file = $this->request->getFile("image");

        if ( ! $file->isValid()) {

            $error_code = $file->getError();

            if ($error_code === UPLOAD_ERR_NO_FILE) {

                return redirect()->back()
                                 ->with("errors", ["No file selected"]);
            }

            throw new RuntimeException($file->getErrorString() . " " . $error_code);

        }

        if ($file->getSizeByUnit("mb") > 2) {

            return redirect()->back()
                             ->with("errors", ["File too large"]);
        }

        if ( ! in_array($file->getMimeType(), ["image/png", "image/jpeg"])) {

            return redirect()->back()
                             ->with("errors", ["Invalid file format"]);
        }

        $path = $file->store("article_images");

        $path = WRITEPATH . "uploads/" . $path;

        service("image")
            ->withFile($path)
            ->fit(200, 200, "center")
            ->save($path);

        $article->image = $file->getName();

        $this->model->protect(false)
                    ->save($article);

        return redirect()->to("articles/$id")
                         ->with("message", "Image uploaded.");
    }

    public function get($id)
    {
        $article = $this->getArticleOr404($id);

        if ($article->image) {

            $path = WRITEPATH . "uploads/article_images/" . $article->image;

            $finfo = new finfo(FILEINFO_MIME);

            $type = $finfo->file($path);

            header("Content-Type: $type");
            header("Content-Length: " . filesize($path));

            readfile($path);
            exit;
        }
    }

    public function delete($id)
    {
        $article = $this->getArticleOr404($id);

        $path = WRITEPATH . "uploads/article_images/" . $article->image;

        if (is_file($path)) {

            unlink($path);
        }

        $article->image = null;

        $this->model->protect(false)
                    ->save($article);

        return redirect()->to("articles/$id")
                         ->with("message", "Image removed.");
    }

    private function getArticleOr404($id): Article
    {
        $article = $this->model->find($id);

        if ($article === null) {

            throw new PageNotFoundException("Article with id $id not found");

        }

        return $article;
    }    
}
