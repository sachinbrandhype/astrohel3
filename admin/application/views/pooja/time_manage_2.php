<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?= $page_title ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-star-o" aria-hidden="true"></i>Home</a></li>
            <li><a href="<?php echo base_url(); ?>pooja/">Lists</a></li>
            <li class="active"><?= $page_title ?></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
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
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $page_title ?></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div id="schedule"></div>
                    <!-- <form  method="post"></form> -->
                    <button class="btn btn-sm btn-primary" onclick="save_data()" id="save_time_slots" >Save</button>

                </div>
            </div>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script src="<?=base_url()?>assets/js/schedule/dist/jquery.schedule.min.js"></script>

<link rel="stylesheet" href="<?=base_url()?>assets/js/schedule/dist/jquery.schedule.min.css">

<script type="text/javascript">
console.log(<?=$time_arr?>)
(function($){

    $('#schedule').jqs({
        mode: 'edit',
        hour: 24,
        days: 7,
        periodDuration: 30,
        data: [],
        periodOptions: true,
        periodColors: [],
        periodTitle: '',
        periodBackgroundColor: 'rgba(82, 155, 255, 0.5)',
        periodBorderColor: '#2a3cff',
        periodTextColor: '#000',
        periodRemoveButton: 'Remove',
        periodDuplicateButton: 'Duplicate',
        periodTitlePlaceholder: 'Title',
        daysList: [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday'
        ],
        onInit: function () {},
        onAddPeriod: function (period,jqs) {

        },
        onRemovePeriod: function () {},
        onDuplicatePeriod: function () {},
        onClickPeriod: function () {}
        })


        save_data = () => {
            var url = "<?=base_url()?>pooja/save_time_manage/<?=$pooja_location_id?>";
            var time = $("#schedule").jqs('export');

            console.log(JSON.parse(time));
            $.ajax({url: url,
            type:'POST',
            data:{time:time},
            success: function(result){
                // console.log(result);
                // $("#div1").html(result);
                var res = JSON.parse(result);
                if(res['status']){
                    alert('Time Slots Save Successfully');
                }
            }});

        }
}(jQuery));
</script>