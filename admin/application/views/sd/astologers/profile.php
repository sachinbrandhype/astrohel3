<?php  
function star_function($integer){
    $integer=intval($integer);

    $star1 = '<span class="fa fa-star">';
    $star2 = '<span class="fa fa-star">';
    $star3 = '<span class="fa fa-star">';
    $star4 = '<span class="fa fa-star">';
    $star5 = '<span class="fa fa-star">';
    if($integer>=1){
        $star1 = '<span class="fa fa-star checked">';
    }
    if($integer>=2){
        $star2 = '<span class="fa fa-star checked">';
    }
    if($integer>=3){
        $star3 = '<span class="fa fa-star checked">';
    }
    if($integer>=4){
        $star4 = '<span class="fa fa-star checked">';
    }
    if($integer>=5){
        $star5 = '<span class="fa fa-star checked">';
    }


    echo $star1.$star2.$star3.$star4.$star5;


}
?>
<div class="content-wrapper">
    <style>
       span.fa.fa-star.checked {
    color: #ffd00e;
}
    </style>
   <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Astrologer Details
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo $_SERVER['HTTP_REFERER'];?>">Astrologer List</a></li>
            <li class="active">Astrologer Details</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3">
            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                <img
                    class="profile-user-img img-responsive img-circle"
                    src="<?=base_url('uploads/astrologers/'.($astrologer->image?$astrologer->image:'default.png'))?>"
                    alt="User profile picture"
                />

                <h3 class="profile-username text-center"><?=ucwords($astrologer->name)?></h3>
               
                <p  class="text-center"><?=$astrologer->is_premium==1 ? '<span class="label label-primary">Premium</span>' : ''?></p>

                <p class="text-muted text-center"><?=ucwords($profession)?></p>

                <ul class="list-group list-group-unbordered">
                
                    <li class="list-group-item">
                    <b>Earning</b> <a target="_blank" href="<?=base_url('consultation/fetchConsultations/?astrologer_id='.$astrologer->id)?>" class="pull-right">&#x20b9; <?=$total_astrologer_earning?></a>
                    </li>
                    <li class="list-group-item">
                    <b>Followers</b> <a class="pull-right"><?=$total_followers?></a>
                    </li>
                    <li class="list-group-item">
                    <b>Total Video Call Bookings</b> <a target="_blank" href="<?=base_url('consultation/fetchConsultations/?type=1&astrologer_id='.$astrologer->id)?>" class="pull-right"><?=$total_video_calls?></a>
                    </li>
                    <li class="list-group-item">
                    <b>Total Audio Call Bookings</b> <a  target="_blank" href="<?=base_url('consultation/fetchConsultations/?type=2&astrologer_id='.$astrologer->id)?>" class="pull-right"><?=$total_audio_calls?></a>
                    </li>

                    <li class="list-group-item">
                    <b>Total Chat Bookings</b> <a  target="_blank" href="<?=base_url('consultation/fetchConsultations/?type=3&astrologer_id='.$astrologer->id)?>" class="pull-right"><?=$total_chat_calls?></a>
                    </li>

                    <li class="list-group-item">
                    <b>Total Report Bookings</b> <a  target="_blank" href="<?=base_url('consultation/fetchConsultations/?type=4&astrologer_id='.$astrologer->id)?>" class="pull-right"><?=$total_report_calls?></a>
                    </li>

                    <li class="list-group-item">
                    <b>Total Live Streaming</b> <a  target="_blank" href="<?=base_url('consultation/fetchConsultations/?type=5&astrologer_id='.$astrologer->id)?>" class="pull-right"><?=$total_lives?></a>
                    </li>

                    <li class="list-group-item">
                    <b>Total Live Joiners</b> <a class="pull-right"><?=$total_live_joiners?></a>
                    </li>

                    <li class="list-group-item">
                    <b>Total Gifts</b> <a class="pull-right"><?=$total_gifts?></a>
                    </li>

                    <li class="list-group-item">
                    <b>Overall Clients Served</b> <a class="pull-right"><?=$total_client_served?></a>
                    </li>

                    <li class="list-group-item">
                    <b>Overall Minutes Served(Video,Audio,Chat)</b> <a class="pull-right"><?=$total_booking_minutes?></a>
                    </li>

                    <li class="list-group-item">
                    <b>Total Live Minutes(Broadcasting) </b> <a class="pull-right"><?=$total_live_minutes?></a>
                    </li>

                    

                    
                </ul>

                <a href="<?=base_url('sd/astrologers/edit_astrologers/'.$astrologer->id)?>" target="_blank" class="btn btn-primary btn-block"
                    ><b>Edit Profile</b></a
                >
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

           
            <!-- /.box -->
            </div>
            <!-- /.col -->
           
            <div class="col-md-9">
            
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#profile" data-toggle="tab">Profile</a>
                    </li>
                    <li><a href="#permission" data-toggle="tab">Permissions</a></li>
                    <li><a href="#service_offered" data-toggle="tab">Services Offered</a></li>
                    <li><a href="#timeline" data-toggle="tab">Reviews</a></li>
                    <!-- <li><a href="#settings" data-toggle="tab">Settings</a></li> -->
                    </ul>
                    <div class="tab-content">
                    <div class="active tab-pane" id="profile">

                        <div class="box-body">

                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <strong><i class="fa fa-user margin-r-5"></i> Name</strong>
                                    <p class="text-muted">
                                        <?=ucwords($astrologer->name)?>
                                    </p>
                                    <hr />

                                    <strong><i class="fa fa-phone margin-r-5"></i> Phone</strong>
                                    <p class="text-muted">
                                        <?=ucwords($astrologer->phone)?>
                                    </p>
                                    <hr />

                                    <strong><i class="fa fa-inbox margin-r-5"></i> Email</strong>
                                    <p class="text-muted">
                                        <?=ucwords($astrologer->email)?>
                                    </p>
                                    <hr />

                                    <strong
                                        ><i class="fa fa-pencil margin-r-5"></i> Skills</strong
                                    >

                                    <p>
                                        <?php  
                                        $label_arr = ['danger','success','info','warning','primary'];
                                        
                                        ?>
                                        <?php
                                        foreach ($all_skills_arr as $key => $value) : ?>
                                        <?php $random_label = $label_arr[array_rand($label_arr,1)]; ?>
                                        <span class="label label-<?=$random_label?>"><?=ucwords($value->name)?></span>
                                        <?php endforeach;  ?>
                                    </p>
                                    <hr />

                                    <strong><i class="fa fa-briefcase margin-r-5"></i> Experience</strong>
                                    <p class="text-muted">
                                        <?=ucwords($astrologer->experience)?>
                                    </p>
                                    <hr />

                                    <strong
                                        ><i class="fa fa-map-marker margin-r-5"></i>
                                        Location</strong
                                    >
                                    <p class="text-muted"><?=$astrologer->address?></p>
                                    <hr />

                                    <strong><i class="fa fa-book margin-r-5"></i> Education</strong>
                                    <p class="text-muted">
                                        <?=ucwords($astrologer->expertise)?>
                                    </p>
                                    <hr />

                                    <strong
                                        ><i class="fa fa-map-marker margin-r-5"></i>
                                        Location</strong
                                    >
                                    <p class="text-muted"><?=$astrologer->address?></p>
                                    <hr />

                                    <!-- <i class="fas fa-rupee-sign"></i> -->

                                    
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <strong><i class="fa fa-inbox margin-r-5"></i> Aadhar Number</strong>
                                    <p class="text-muted">
                                        <?=ucwords($astrologer->aadhar_number)?>
                                    </p>
                                    <hr />

                                    <strong><i class="fa fa-inbox margin-r-5"></i> PAN Number</strong>
                                    <p class="text-muted">
                                        <?=ucwords($astrologer->pan_number)?>
                                    </p>
                                    <hr />
                                    
                                    <strong><i class="fa fa-inbox margin-r-5"></i> Bank Name</strong>
                                    <p class="text-muted">
                                        <?=ucwords($astrologer->pan_number)?>
                                    </p>
                                    <hr />
                                    <strong><i class="fa fa-inbox margin-r-5"></i> Bank Account No</strong>
                                    <p class="text-muted">
                                        <?=ucwords($astrologer->bank_account_no)?>
                                    </p>
                                    <hr />

                                    <strong><i class="fa fa-bookmark margin-r-5"></i> Earning Percentage</strong>
                                    <p class="text-muted">
                                    <?=($astrologer->share_percentage)?>%
                                    </p>
                                    <hr />

                                    <strong><i class="fa fa-tags margin-r-5"></i> Chat Booking Price</strong>
                                    <p class="text-muted">
                                    &#x20b9; <?=($astrologer->price_per_mint_chat)?>/min
                                    </p>
                                    <hr />

                                    <strong><i class="fa fa-tags margin-r-5"></i> Audio Call Booking Price</strong>
                                    <p class="text-muted">
                                    &#x20b9; <?=($astrologer->price_per_mint_audio)?>/min
                                    </p>
                                    <hr />

                                    <strong><i class="fa fa-tags margin-r-5"></i> Video Call Booking Price</strong>
                                    <p class="text-muted">
                                    &#x20b9; <?=($astrologer->price_per_mint_video)?>/min
                                    </p>
                                    <hr />

                                    <strong><i class="fa fa-tags margin-r-5"></i> Live Price</strong>
                                    <p class="text-muted">
                                     <?=intval($astrologer->price_per_mint_broadcast) ? '&#x20b9; '.($astrologer->price_per_mint_broadcast).'/min'  : 'N/A' ?>
                                    </p>
                                    <hr />
                                    
                                </div>
                            </div>
                            
                            
                            

                            

                            <div class="row">
                                <div class="col-lg-12 col-md-12">

                                    <strong><i class="fa fa-file-text-o margin-r-5"></i> Biography</strong>
                                    <p>
                                        <?= $astrologer->bio?>
                                    </p>
                                    <hr />

                                    <strong><i class="fa fa-file-text-o margin-r-5"></i> Aadhar Image</strong>
                                    <img style="width: 100px;" src="<?=base_url('uploads/astrologers/'.$data->aadhar_card_front_image)?>">
                                    <hr />

                                    <strong><i class="fa fa-file-text-o margin-r-5"></i> PAN Image</strong>
                                    <img style="width: 100px;" src="<?=base_url('uploads/astrologers/'.$data->pan_card_image)?>">
                                    <hr />

                                </div>
                            </div>
                        </div>
                        <!-- Post -->
<!--                         
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">3,200</h5>
                                    <span class="description-text">SALES</span>
                                </div>
                            </div>
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">13,000</h5>
                                    <span class="description-text">FOLLOWERS</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">35</h5>
                                    <span class="description-text">PRODUCTS</span>
                                </div>
                            </div>
                        </div> -->

                        <!-- POST -->
                        <!-- <div class="post">
                            <div class="user-block">
                                <img
                                class="img-circle img-bordered-sm"
                                src="../../dist/img/user1-128x128.jpg"
                                alt="user image"
                                />
                                <span class="username">
                                <a href="#">Jonathan Burke Jr.</a>
                                <a href="#" class="pull-right btn-box-tool"
                                    ><i class="fa fa-times"></i
                                ></a>
                                </span>
                                <span class="description"
                                >Shared publicly - 7:30 PM today</span
                                >
                            </div>
                            <p>
                                Lorem ipsum represents a long-held tradition for
                                designers, typographers and the like. Some people hate
                                it and argue for its demise, but others ignore the hate
                                as they create awesome tools to help create filler text
                                for everyone from bacon lovers to Charlie Sheen fans.
                            </p>
                            <ul class="list-inline">
                                <li>
                                <a href="#" class="link-black text-sm"
                                    ><i class="fa fa-share margin-r-5"></i> Share</a
                                >
                                </li>
                                <li>
                                <a href="#" class="link-black text-sm"
                                    ><i class="fa fa-thumbs-o-up margin-r-5"></i>
                                    Like</a
                                >
                                </li>
                                <li class="pull-right">
                                <a href="#" class="link-black text-sm"
                                    ><i class="fa fa-comments-o margin-r-5"></i>
                                    Comments (5)</a
                                >
                                </li>
                            </ul>

                            <input
                                class="form-control input-sm"
                                type="text"
                                placeholder="Type a comment"
                            />
                        </div> -->
                        <!-- /.post -->

                        <!-- Post -->
                        <!-- <div class="post clearfix">
                            <div class="user-block">
                                <img
                                class="img-circle img-bordered-sm"
                                src="../../dist/img/user7-128x128.jpg"
                                alt="User Image"
                                />
                                <span class="username">
                                <a href="#">Sarah Ross</a>
                                <a href="#" class="pull-right btn-box-tool"
                                    ><i class="fa fa-times"></i
                                ></a>
                                </span>
                                <span class="description"
                                >Sent you a message - 3 days ago</span
                                >
                            </div>
                            <p>
                                Lorem ipsum represents a long-held tradition for
                                designers, typographers and the like. Some people hate
                                it and argue for its demise, but others ignore the hate
                                as they create awesome tools to help create filler text
                                for everyone from bacon lovers to Charlie Sheen fans.
                            </p>

                            <form class="form-horizontal">
                                <div class="form-group margin-bottom-none">
                                <div class="col-sm-9">
                                    <input
                                    class="form-control input-sm"
                                    placeholder="Response"
                                    />
                                </div>
                                <div class="col-sm-3">
                                    <button
                                    type="submit"
                                    class="btn btn-danger pull-right btn-block btn-sm"
                                    >
                                    Send
                                    </button>
                                </div>
                                </div>
                            </form>
                        </div> -->
                        <!-- /.post -->

                        
                        <!-- /.post -->
                    </div>
                    <div class="tab-pane" id="permission">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                <strong><i  class="fa fa-inbox margin-r-5"></i> Permissions</strong>
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>Chat</td>
                                            <td><?=$astrologer->chat_status == 1 ? '<i class="fa fa-check-circle" style="color: #22e322;">' : '<i class="fa fa-times-circle" style="color: red;">'?></td>
                                        </tr>
                                        <tr>
                                            <td>Audio</td>
                                            <td><?=$astrologer->audio_status == 1 ? '<i class="fa fa-check-circle" style="color: #22e322;">' : '<i class="fa fa-times-circle" style="color: red;">'?></td>
                                        </tr>
                                        <tr>
                                            <td>Video</td>
                                            <td><?=$astrologer->video_status == 1 ? '<i class="fa fa-check-circle" style="color: #22e322;">' : '<i class="fa fa-times-circle" style="color: red;">'?></td>
                                        </tr>
                                        <tr>
                                            <td>Report</td>
                                            <td><?=$astrologer->can_take_horoscope == 1 ? '<i class="fa fa-check-circle" style="color: #22e322;">' : '<i class="fa fa-times-circle" style="color: red;">'?></td>
                                        </tr>
                                        <tr>
                                            <td>Broadcasting</td>
                                            <td><?=$astrologer->can_take_broadcast == 1 ? '<i class="fa fa-check-circle" style="color: #22e322;">' : '<i class="fa fa-times-circle" style="color: red;">'?></td>
                                        </tr>
                                    </table>
                                </div>  
                                
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="service_offered">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <strong><i class="fa fa-inbox margin-r-5"></i> Services Offered for Report</strong>
                                    <?php $serial_no=0; ?>
                                    <table class="table table-bordered">

                                        <?php foreach ($all_skills_arr as $key1): ?>
                                            <?php if($key1->type==2): ?>
                                                <tr>
                                                    <td><i class="fa fa-check-circle"></i> <?=$key1->name?></td>
                                                    <td>&#x20b9; <?=$key1?$key1->horoscope_price:0?></td>
                                                </tr>
                                            <?php endif; ?>
                                            <?php $serial_no++; ?>
                                        <?php endforeach; ?>
                                    </table>
                                    <hr />
                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="timeline">
                        <!-- The timeline -->
                        <ul class="timeline timeline-inverse">
                            <!-- <li class="time-label">
                                <span class="bg-red"> 10 Feb. 2014 </span>
                            </li> -->
                            <!-- <li>
                                <i class="fa fa-envelope bg-blue"></i>

                                <div class="timeline-item">
                                <span class="time"
                                    ><i class="fa fa-clock-o"></i> 12:05</span
                                >

                                <h3 class="timeline-header">
                                    <a href="#">Support Team</a> sent you an email
                                </h3>

                                <div class="timeline-body">
                                    Etsy doostang zoodles disqus groupon greplin oooj
                                    voxy zoodles, weebly ning heekya handango imeem
                                    plugg dopplr jibjab, movity jajah plickers sifteo
                                    edmodo ifttt zimbra. Babblely odeo kaboodle quora
                                    plaxo ideeli hulu weebly balihoo...
                                </div>
                                <div class="timeline-footer">
                                    <a class="btn btn-primary btn-xs">Read more</a>
                                    <a class="btn btn-danger btn-xs">Delete</a>
                                </div>
                                </div>
                            </li> -->
                            <!-- <li>
                                <i class="fa fa-user bg-aqua"></i>

                                <div class="timeline-item">
                                <span class="time"
                                    ><i class="fa fa-clock-o"></i> 5 mins ago</span
                                >

                                <h3 class="timeline-header no-border">
                                    <a href="#">Sarah Young</a> accepted your friend
                                    request
                                </h3>
                                </div>
                            </li> -->
                            <?php if(!empty($reviews)) : ?>
                                    <?php foreach ($reviews as $key => $value) : ?>
                                        <?php $ci =& get_instance();
                                        $usr = $ci->db->get_where('user',['id'=>$value->user_id])->row();
                                        ?>
                                        <li>
                                            <i class="fa fa-comments bg-yellow"></i>

                                            <div class="timeline-item">
                                            <span class="time"
                                                ><i class="fa fa-clock-o"></i> <?=date('d M Y g:ia',strtotime($value->created_at))?></span
                                            >

                                            <h3 class="timeline-header">
                                                <a><?=$usr->name?></a> commented order ID #<?=$value->booking_id?><br/> <?=star_function($value->rate)?>
                                            </h3>

                                            <div class="timeline-body">
                                                <?=$value->message?>
                                            </div>
                                            <!-- <div class="timeline-footer">
                                                <a class="btn btn-warning btn-flat btn-xs"
                                                >View comment</a
                                                >
                                            </div> -->
                                            </div>
                                        </li>
                                    <?php endforeach ; ?>
                                <?php else : ?>
                                    <h5 style="text-align: center;" >No Reviews</h5>

                                <?php endif; ?>

                            
                            <!-- <li class="time-label">
                                <span class="bg-green"> 3 Jan. 2014 </span>
                            </li>

                            <li>
                                <i class="fa fa-camera bg-purple"></i>

                                <div class="timeline-item">
                                <span class="time"
                                    ><i class="fa fa-clock-o"></i> 2 days ago</span
                                >

                                <h3 class="timeline-header">
                                    <a href="#">Mina Lee</a> uploaded new photos
                                </h3>

                                <div class="timeline-body">
                                    <img
                                    src="http://placehold.it/150x100"
                                    alt="..."
                                    class="margin"
                                    />
                                    <img
                                    src="http://placehold.it/150x100"
                                    alt="..."
                                    class="margin"
                                    />
                                    <img
                                    src="http://placehold.it/150x100"
                                    alt="..."
                                    class="margin"
                                    />
                                    <img
                                    src="http://placehold.it/150x100"
                                    alt="..."
                                    class="margin"
                                    />
                                </div>
                                </div>
                            </li> -->
                            <li>
                                <i class="fa fa-clock-o bg-gray"></i>
                            </li>
                        </ul>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="settings">
                        <form class="form-horizontal">
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label"
                            >Name</label
                            >

                            <div class="col-sm-10">
                            <input
                                type="email"
                                class="form-control"
                                id="inputName"
                                placeholder="Name"
                            />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-sm-2 control-label"
                            >Email</label
                            >

                            <div class="col-sm-10">
                            <input
                                type="email"
                                class="form-control"
                                id="inputEmail"
                                placeholder="Email"
                            />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label"
                            >Name</label
                            >

                            <div class="col-sm-10">
                            <input
                                type="text"
                                class="form-control"
                                id="inputName"
                                placeholder="Name"
                            />
                            </div>
                        </div>
                        <div class="form-group">
                            <label
                            for="inputExperience"
                            class="col-sm-2 control-label"
                            >Experience</label
                            >

                            <div class="col-sm-10">
                            <textarea
                                class="form-control"
                                id="inputExperience"
                                placeholder="Experience"
                            ></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputSkills" class="col-sm-2 control-label"
                            >Skills</label
                            >

                            <div class="col-sm-10">
                            <input
                                type="text"
                                class="form-control"
                                id="inputSkills"
                                placeholder="Skills"
                            />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label>
                                <input type="checkbox" /> I agree to the
                                <a href="#">terms and conditions</a>
                                </label>
                            </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-danger">
                                Submit
                            </button>
                            </div>
                        </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
            <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
</div>