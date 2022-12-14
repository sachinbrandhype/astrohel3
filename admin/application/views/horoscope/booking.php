<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?= $page_title ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>Welcome/"><i class="fa fa-user-md"></i>Home</a></li>
            <li class="active"><?= $page_title ?></li>
        </ol>
    </section>


    <?php
    if ($this->session->flashdata('message')) {
        $message = $this->session->flashdata('message');
    ?>
        <div class="alert alert-<?php echo $message['class']; ?>">
            <button class="close" data-dismiss="alert" type="button">×</button>
            <?php echo $message['message']; ?>
        </div>
    <?php
    }
    ?>
    <!-- Main content -->
    <section class="content">
        <!-- Main content -->
        <div class="row">
            <ul class="nav nav-tabs">
                <li class="<?= ($today == 1) ? 'active' : '' ?>"><a href="<?= base_url() . 'horoscope_matching/bookings/' . $user_id . '/1/' ?>">Today's Bookings</a></li>
                <!-- <li class="<?= ($today == 2) ? 'active' : '' ?>"><a href="<?= base_url() . 'horoscope_matching/bookings/' . $user_id . '/2/' ?>">Tomorrow's Bookings</a></li> -->
                <li class="<?= ($today == 0) ? 'active' : '' ?>"><a href="<?= base_url() . 'horoscope_matching/bookings/' . $user_id . '/0/' ?>">All Bookings</a></li>
            </ul>
        </div>
        <div class="row">
            <br>
        </div>
        <div class="row">
            <ul class="nav nav-pills">
                <li class="<?= ($status == 0) ? 'active' : '' ?>"><a href="<?= base_url() . 'horoscope_matching/bookings/' . $user_id . '/' . $today . '/0/' ?>">New</a></li>
                <li class="<?= ($status == 2) ? 'active' : '' ?>"><a href="<?= base_url() . 'horoscope_matching/bookings/' . $user_id . '/' . $today . '/2/' ?>">Cancelled</a></li>
                <li class="<?= ($status == 1) ? 'active' : '' ?>"><a href="<?= base_url() . 'horoscope_matching/bookings/' . $user_id . '/' . $today . '/1/' ?>">Completed</a></li>
                <li class="<?= ($status == 3) ? 'active' : '' ?>"><a href="<?= base_url() . 'horoscope_matching/bookings/' . $user_id . '/' . $today . '/3/' ?>">All</a></li>
            </ul>
        </div>
        <div class="row">

            <!-- /.box -->
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?= $page_title ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form method='post' action="<?= base_url() ?>horoscope_matching/bookings/<?= $user_id ?>/0/3/">
                        <div class="search form-group" style="float:right">
                            <?php if ($search) 
                            {
                                ?>
                               <input type="text" class="" value="<?= $search ?>" name="search">
                                <?php
                            } 
                            else {
                                 ?>
                               <input type="text" class="" value="" name="search">
                                <?php
                            }
                             ?>
                            
                            <input type="submit" name="submit" value="Search" class="btn btn-sm btn-primary">
                        </div>
                    </form>
                    <table class="table table-bordered table-striped ">
                        <thead>
                            <tr>
                                <th>ID </th>
                                <th>User Name </th>
                                <th>Boy Name </th>
                                <th>Boy DOB </th>
                                <th>Girl Name </th>
                                <th>Girl DOB </th>
                                <th>Amount </th>
                                <th>Uploaded Files</th>
                                <th>Status </th>
                                <th>Tr </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($data as $key) : 
                               // print_r($key);die; ?>
                                <tr>
                                    <td class="center"><?= $key->id; ?></td>
                                    <td class="center"><?= $key->name ?></td>
                                    <td class="center"><?= $key->boy_name ?></td>
                                    <td class="center"><?= $key->boy_dob ?></td>
                                    <td class="center"><?= $key->girl_name ?></td>
                                    <td class="center"><?= $key->girl_dob ?></td>
                                    <td class="center"><?= $key->total_amount ?></td>
                                    <td class="center">
                                        <?php
                                        $file_arr = explode("||",$key->uploads_doc);
                                        $q =1;
                                        if(!empty($key->uploads_doc)){
                                            foreach ($file_arr as $a) {
                                                $im = explode(",",$a);
                                                ?>
                                                <a target="_blank" href="<?=base_url().'uploads/horoscope_matching/'.$im[0]?>">File - <?=$q++?></a><br/>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </td>

                                    <td class="center">
                                        <?php
                                        if ($key->status == 0) {
                                            echo "<span class='badge bg-green'>New</label>";
                                        } elseif ($key->status == 1) {
                                            echo "<span class='badge bg-blue'>Completed</label>";
                                        } elseif ($key->status == 2 || $key->status == 3 || $key->status == 4) {
                                            echo "<span class='badge bg-red'>Cancelled</label>";
                                        }
                                        ?>
                                    </td>
                                    <td class="center">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#view_details_<?= $key->id ?>">
                                            View
                                        </button>
                                        <div class="modal fade" id="view_details_<?= $key->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Booking Details</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <p><b>Boy Details</b></p>
                                                                <ul>
                                                                  <li>Boy Name : <?= $key->boy_name ?></li>
                                                                  <li>Boy DOB : <?= $key->boy_dob ?></li>
                                                                  <li>Boy TOB : <?= $key->boy_tob ?></li>
                                                                  <li>Boy POB : <?= $key->boy_pob ?></li>
                                                                  <li>Boy Address : <?= $key->boy_lat_long_address ?></li>
                                                                </ul>
                                                               
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p><b>Girl Details</b></p>
                                                                <ul>
                                                                  <li>Girl Name : <?= $key->girl_name ?></li>
                                                                  <li>Girl DOB : <?= $key->girl_dob ?></li>
                                                                  <li>Girl TOB : <?= $key->girl_tob ?></li>
                                                                  <li>Girl POB : <?= $key->girl_pob ?></li>
                                                                  <li>Girl Address : <?= $key->girl_lat_long_address ?></li>
                                                                </ul>
                                                               
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <p><b>Booking Details</b></p>
                                                                <table class="table">
                                                                    <tr>
                                                                        <td>Booking ID</td>
                                                                        <td><?= $key->id ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Discount</td>
                                                                        <td><?= $key->discount_amount ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Total Amount</td>
                                                                        <td><?= $key->total_amount ?></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php if ($key->status == 0) { ?>
                                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#confirm_<?= $key->id ?>">
                                                Upload File
                                            </button>
                                            <!-- The Modal -->
                                            <div class="modal fade" id="confirm_<?= $key->id ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Confirm</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <div class="modal-body">
                                                            <form method="post" enctype="multipart/form-data">
                                                                <div class="form-group">
                                                                    <label for="">File</label>
                                                                    <input type="file" name="image[]" class="form-control" multiple required>
                                                                </div>
                                                                <input type="hidden" name="id" value="<?= $key->id ?>">
                                                                <div class="form-group">
                                                                    <input type="submit" name="confirm" value="Submit" class="btn btn-sm btn-primary">
                                                                </div>
                                                            </form>
                                                        </div>

                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php
                                        if ($key->status == 0 && !empty($key->uploads_doc)) {
                                        ?>
                                            <a onclick="return confirm('Are you sure?')" class="btn btn-sm btn-primary" href="<?= base_url('horoscope_matching/confirm_booking/' . $key->id) ?>">Confirm</a>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if ($key->status == 0) {
                                        ?>
                                            <a onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger" href="<?= base_url('horoscope_matching/cancel_booking/' . $key->id) ?>">Cancel</a>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                            if (($key->status == 2 || $key->status == 3) && $key->refund_status != 1) {
                                                ?>
                                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#refund_<?= $key->id ?>">
                                                Refund
                                                </button>

                                                <div class="modal fade" id="refund_<?=$key->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <form method="post">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Refund</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="">Amount</label>
                                                                        <input type="number" min="1" name="amount" placeholder="Amount" value="<?=$key->total_amount?>" class="form-control">
                                                                    </div>
                                                                    <input type="hidden" name="id" value="<?= $key->id ?>">
                                                                    <div class="form-group">
                                                                        <input onclick="return confirm('Are you sure?')" type="submit" name="refund_booking" value="Submit" class="btn btn-sm btn-primary">
                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        ?>
                                    </td>
                                </tr>
                            <?php
                            endforeach ?>
                        </tbody>
                    </table>
                    <div class="example">
    <!-- <nav> -->
        
        <?php
        //  echo $pagination_links; 
        echo $pagination_links;
        ?>
        
    <!-- </nav> -->
    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

