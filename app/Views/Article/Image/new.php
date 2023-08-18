<?= $this->extend("layouts/default") ?>

<?= $this->section("title") ?>Edit Article Image<?= $this->endSection() ?>

<?= $this->section("content") ?>

<h1>Edit Article Image</h1>

<?php if (session()->has("errors")): ?>

    <ul>
        <?php foreach(session("errors") as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>

<?php endif; ?>

<?= form_open_multipart("articles/" . $article->id . "/image/create") ?>

    <label for="image">Image file</label>
    <input type="file" id="image" name="image">

    <button>Upload</button>

</form>

<?= $this->endSection() ?>