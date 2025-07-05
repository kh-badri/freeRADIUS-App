<form action="<?= base_url('nas/tambah_aksi') ?>" method="post" class="ml-2">
    <div class="form-group">
        <label> IP Address </label>
        <input type="text" name="nasname" class="form-control" placeholder="IP Server">
        <?= form_error('nasname', '<div class="text-small text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
        <label> Short Name </label>
        <input type="text" name="shortname" class="form-control">
        <?= form_error('shortname', '<div class="text-small text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
        <label> Type </label>
        <input type="text" name="type" class="form-control" placeholder=" other ">
        <?= form_error('type', '<div class="text-small text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
        <label> Secret </label>
        <input type="text" name="secret" class="form-control">
        <?= form_error('secret', '<div class="text-small text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
        <label> Community </label>
        <input type="text" name="community" class="form-control">
        <?= form_error('community', '<div class="text-small text-danger">', '</div>'); ?>
    </div>
    <button type="submit" class="btn btn-primary mr-4"> <i class="fas fa-save "> Tambah </i></button>
    <button type="reset" class="btn btn-danger"> <i class="fas fa-trash"> Reset </i></button>
</form>