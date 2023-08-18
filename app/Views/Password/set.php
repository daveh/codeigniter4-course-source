<?= $this->extend("layouts/default") ?>

<?= $this->section("title") ?>Set Password<?= $this->endSection() ?>

<?= $this->section("content") ?>

<h1>Set Password</h1>

<?php if (session()->has("errors")): ?>

    <ul>
        <?php foreach(session("errors") as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>

<?php endif; ?>

<?= form_open() ?>

<label for="password">Password</label>
<input type="password" id="password" name="password">

<label for="password_confirmation">Repeat password</label>
<input type="password" id="password_confirmation" name="password_confirmation">

<button>Save</button>

</form>

<?= $this->endSection() ?>