
<body>
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Curis BETA</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
 
        <ul class="nav navbar-nav navbar-right">
          
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $username; ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="#">Action</a></li>
              <li><a href="#">Another action</a></li>
              <li><a href="#">Something else here</a></li>
              <li class="divider"></li>
              <li><?php echo $logOptions; ?></li>
            </ul>
          </li>
        </ul>

        <form class="navbar-form" role="search">
          <div class="input-group">
            <input id="search_q" type="text" class="form-control" placeholder="Search">
            <span class="input-group-btn">
              <button type="reset" class="btn btn-default">
                <span class="glyphicon glyphicon-remove">
                  <span class="sr-only">Close</span>
                </span>
              </button>
              <button type="submit" class="btn btn-default">
                <span class="glyphicon glyphicon-search">
                  <span class="sr-only">Search</span>
                </span>
              </button>
            </span>
          </div>
        </form>

         


      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
       <div id="display">

</div>
   <!-- <div class="container">
      <div class="row">
        <div class="alert alert-info">
                <strong>Alerts Dont Work on Bootsnipp!</strong> So when you hit enter or submit this form your result will show up in the green box below!
            </div>
            <div class="alert alert-success">
                <strong>Your Result!</strong> <span id="showSearchTerm"></span>
            </div>
    </div>
    </div>-->


    <!--section -->

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container">
    <div class="view-account">
        <section class="module">
            <div class="module-inner">
                <div class="side-bar">
                    <div class="user-info">
                        <?php echo $user_pic; ?>
                        <ul class="meta list list-unstyled">
                            <li class="name"><?php echo $username; ?>
                                <!--<label class="label label-info">UX Designer</label>-->
                            </li>
                           <!-- <li class="email"><a href="#"><?php echo $email;?></a></li>-->
                          <li class="name">
                            
  <i class="glyphicon glyphicon-map-marker"></i> From: <a href=" <?php echo $address; ?>"> <?php echo $address; ?> 
                          </a>
                     
                           
                            <br>
                            <i class="glyphicon glyphicon-gift"></i> Age: <?php echo $age; ?>
              <br>
              <i class="glyphicon glyphicon-tint"></i> Blood Group: <?php echo $blood_group; ?></p>


                          </li>
                        </ul>
                    </div>
                    <nav class="side-menu">
                        <ul class="nav">
                            <li><a href="profile.php"><span class="fa fa-user"></span> Profile</a></li>
                             <li><a href="account.php"><span class="fa fa-cog"></span> Account</a></li>
                            <li id="remview"><a href="#"><span class="fa fa-envelope"></span> Reminders <span class="badge"><?php echo $sql_pcount; ?></span> </a></li>
                            <li id="rembox"><a href="#"> <?php echo $push_notify;?></a></li>

<li id="alertview"><a href="#" ><span class="fa fa-clock-o"></span> Alerts <span class="badge"><?php echo $check_palert ; ?></span></a></li>
                            <li id="alertbox"><a href="#"> <?php echo $p_alert;?></a></li>
                           
                        </ul>
                    </nav>
                </div>

                <div class="content-panel">
                    <div class="content-header-wrapper">
                        <h2 class="title">My Drive</h2>
                        <div class="actions">
                        
                             <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Upload Record</button>
                        </div>
                    </div>
                    
                    <div class="drive-wrapper drive-grid-view">
                        <div class="grid-items-wrapper">
                            



<div class="panel panel-primary">
   <div class="panel-heading">Medical Timeline</div>
  <div class="space"> </div>
  <div class="panel-body">
        <div class="btn-group-vertical" role="group" aria-label="...">
          
<?php echo $time_line_div; ?>

</div>
</div>
</div>




                            </div>
                    </div>

                    
                </div>
            </div>
        </section>
    </div>
</div>
<!-- section end -->
                       
              
          

  
 
<!-- Modal upload record -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
         <form class="form-vertical" action="uploader.php" id="FileUploader" enctype="multipart/form-data" method="post">
      <div class="modal-header"><h4>Upload your Medical Record </h4></div>
       <div class="modal-body">
        
      
      <div class="form-group">
            <label for="field-1" class="col-sm-4 control-label">Disease Name</label>

            <div class="col-sm-7">
              <div class="input-group">

                <span class="input-group-addon"><i class="entypo-user"></i></span>

                <input type="text" class="form-control" autofocus="" data-validate="required" data-message-required="value required" name="mTitle" id="mTItle">
              </div>
            </div>
          </div><br><br>
      
       <div class="form-group">
            <label for="field-1" class="col-sm-4 control-label">Disease Description</label>

            <div class="col-sm-7">
              <div class="input-group">

                <span class="input-group-addon"><i class="entypo-user"></i></span>

                <textarea class="form-control" autofocus="" data-validate="required" data-message-required="value required" name="mDesc" id="mDesc"></textarea>
              </div>
            </div>
          </div><br><br>
      <div class="space"></div>
      
        <div class="form-group">
            <label for="field-1" class="col-sm-4 control-label">Consulting doctor</label>

            <div class="col-sm-7">
              <div class="input-group">

                <span class="input-group-addon"><i class="entypo-user"></i></span>

                <input type="text" class="form-control" autofocus="" data-validate="required" data-message-required="value required" name="mDoc" id="mDoc">
              </div>
            </div>
          </div><br><br>
      
      
      
      <div class="form-group">
            <label for="field-1" class="col-sm-4 control-label">Checkup date</label>

            <div class="col-sm-7">
              <div class="input-group">

                <span class="input-group-addon"><i class="entypo-user"></i></span>

                <input type="date" class="form-control" autofocus="" data-validate="required" data-message-required="value required" name="mDate" id="mDate">
              </div>
            </div>
          </div><br><br>
      <div class="form-group">
        
               <label for="pres" class="col-sm-4 control-label">Prescription</label>
            <div class="col-sm-7 col-sm-offset-4">
      
              <div class="input-group">

                <span class="input-group-addon"><i class="entypo-user"></i></span>

                <input type="file" accept="image/*" class="form-control" data-message-required="value required" name="mFile" id="mFile">
        
        
        
              </div>
            </div>
    
      
         <label for="reports" class="col-sm-4 control-label">Medical Reports</label>
       <div class="col-sm-7 col-sm-offset-4">
       
      <div class="input-group">

                <span class="input-group-addon"><i class="entypo-user"></i></span>

                <input type="file" accept="image/*" class="form-control" data-message-required="value required" name="mFile2" id="mFile2">
        
        
        
              </div>
        </div>
          </div><br><br>
      
      
       
       
          
          <button type="submit" class="btn btn-primary btn-icon col-sm-offset-9" id="uploadButton">
                Submit
                <i class="entypo-left-open-mini"></i>
              </button>
        
         </div>
       </div>
     <br>
     <br>
    </form>
      
    </div>
  </div>
  

<div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="image-gallery-title"></h4>
            </div>
            <div class="modal-body">
                <img id="image-gallery-image" class="img-responsive" src="">
            </div>
            <div class="modal-footer">

                <div class="col-md-2">
                    <button type="button" class="btn btn-primary" id="show-previous-image">Previous</button>
                </div>

                <div class="col-md-8 text-justify" id="image-gallery-caption">
                    This text will be overwritten by jQuery
                </div>

                <div class="col-md-2">
                    <button type="button" id="show-next-image" class="btn btn-default">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
 
      $(function () {
        // Remove Search if user Resets Form or hits Escape!
    $('body, .navbar-collapse form[role="search"] button[type="reset"]').on('click keyup', function(event) {
      console.log(event.currentTarget);
      if (event.which == 27 && $('.navbar-collapse form[role="search"]').hasClass('active') ||
        $(event.currentTarget).attr('type') == 'reset') {
        closeSearch();
      }
    });

    function closeSearch() {
            var $form = $('.navbar-collapse form[role="search"].active')
        $form.find('input').val('');
      $form.removeClass('active');
    }

    // Show Search if form is not active // event.preventDefault() is important, this prevents the form from submitting
    $(document).on('click', '.navbar-collapse form[role="search"]:not(.active) button[type="submit"]', function(event) {
      event.preventDefault();
      var $form = $(this).closest('form'),
        $input = $form.find('input');
      $form.addClass('active');
      $input.focus();

    });
    // ONLY FOR DEMO // Please use $('form').submit(function(event)) to track from submission
    // if your form is ajax remember to call `closeSearch()` to close the search container
    $(document).on('click', '.navbar-collapse form[role="search"].active button[type="submit"]', function(event) {
      event.preventDefault();
      var $form = $(this).closest('form'),
        $input = $form.find('input');
      $('#showSearchTerm').text($input.val());
            closeSearch()
    });
    });
</script>
</body>