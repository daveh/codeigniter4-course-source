<?= $this->extend("layouts/default") ?>

<?= $this->section("title") ?>User Groups<?= $this->endSection() ?>

<?= $this->section("content") ?>

<h1>User Groups</h1>

<?= form_open("admin/users/" . $user->id . "/groups") ?>

    <label>
        <input type="checkbox" name="groups[]" value="user"
               <?= $user->inGroup("user") ? "checked" : "" ?>> user
    </label>

    <label>

        <?php if ($user->id === auth()->user()->id): ?>

            <input type="checkbox" checked disabled> admin
            <input type="hidden" name="groups[]" value="admin">

        <?php else: ?>

            <input type="checkbox" name="groups[]" value="admin"
                <?= $user->inGroup("admin") ? "checked" : "" ?>> admin

        <?php endif; ?>
        
    </label>

    <button>Save</button>

</form>

<?= $this->endSection() ?>