<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?= $page_title ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>Welcome/"><i class="fa fa-user-md"></i>Home</a></li>
            <li><a href="<?php echo base_url(); ?>pooja/"><i class="fa fa-user-md"></i>Lists</a></li>

            <li class="active"><?= $page_title ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <?php
                if ($this->session->flashdata('message')) {
                    $message = $this->session->flashdata('message');
                ?>
                    <div class="alert alert-<?php echo $message['class']; ?>">
                        <button class="close" data-dismiss="alert" type="button">x</button>
                        <?php echo $message['message']; ?>
                    </div>
                <?php
                }
                ?>
            </div>

            <ol class="breadcrumb">
                <li><a href="<?=base_url('pooja/datewisetime/'.$pooja_id)?>"><button class="btn add-new" type="button"><b><i class="fa fa-fw fa-plus"></i> Add</b></button></a>
            </ol>


            <div class="col-xs-12">

                <!-- /.box -->
                <div class="box">
                    <div class="box-header">

                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i=1;
                                foreach ($results as $card) {
                                ?>

                                    <tr>
                                        <td><?=$i?></td>

                                        <td class="center">
                                            <?=    $card->date ?>
                                        </td>

                                        <td>
                                        <a class="btn btn-sm btn-primary" href="<?php echo base_url(); ?>pooja/edit_datewisetime/<?php echo $card->id; ?>">
                                                <i class="fa fa-fw fa-file"></i>Edit</a>
                                            <a class="btn btn-sm btn-danger" href="<?php echo base_url(); ?>pooja/delete_datewisetime/<?php echo $card->id; ?>" onClick="return doconfirm()">
                                                <i class="fa fa-fw fa-trash"></i>Delete</a>
                                        </td>
                                    </tr>
                                <?php
                                $i++;
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Image </th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

<!-- Modal -->
<div id="add_venue" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Image</h4>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="save_category" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>

    </div>
</div>
<script>
    base_url = "<?php echo base_url(); ?>";
    config_url = "<?php echo base_url(); ?>";
</script>