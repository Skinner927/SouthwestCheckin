<?php
/*
  Copyright (C) 2013  Dennis Skinner skinner927@gmail.coms

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License along
  with this program; if not, write to the Free Software Foundation, Inc.,
  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/
require('config.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $site['title'];?></title>
    <link href="favicon.ico" rel="icon" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
    <style type="text/css">
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }

      .rowLikeTable {
        border: 1px solid #DDDDDD;
        border-bottom-width: 0px;
        padding: 8px;
        height: 30px;
      }
      
      .lastRow {
        border-bottom-width: 1px;
      }
      
      .rowLikeTable:hover {
        background-color: #F5F5F5;
      }
      
      .editBlock {
        border-top: 1px solid black;
        margin-bottom: 8px;
        padding: 8px 8px;
        background-color: #DDDDDD;
        border-radius: 0px 0px 7px 7px; 
        -moz-border-radius: 0px 0px 7px 7px; 
        -webkit-border-radius: 0px 0px 7px 7px; 
        display: none;
      }
    </style>
  </head>
  <body>
  
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#"><?php echo $site['title'];?></a>
          <div class="nav-collapse collapse">
            <ul class="nav" data-bind="foreach: pages">
              <li data-bind="css: { active: $data == $root.currentPage() }, click: $root.goToPage"><a href="#" data-bind="text: $data"></a></li>
            </ul>            
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
      
      <!-- List View -->
      <div data-bind="visible: $root.currentPage() == 'List'">
        <h2>Add Flight</h2>
        <div class="well well-small">
          <form id="newCheckinForm">
          <div class="container">
            <div class="span3">
              <input type="text" name="fname" placeholder="First Name" /><br/>
              <input type="text" name="lname" placeholder="Last Name" />
            </div>
            <div class="span3">
              <input type="text" name="confirmation" placeholder="Confirmation #" /><br/>
              <input type="password" name="password" placeholder="New Password" />  
            </div>
            <div class="span3">
              <div class="input-append date" data-bind="dateTimePicker: true">
                <input data-format="MM/dd/yyyy HH:mm PP" type="text" name="datetime" placeholder="Flight Date" />
                <span class="add-on">
                  <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                </span>
              </div>
              <div style="margin-top: 10px;">
                <button class="btn btn-success" type="submit" style="margin-right: 5px"><i class="icon-plus icon-white"></i> Add</button>
              </div>
            </div>
            </div>
          </form>
        </div>
        <h2>Check In Queue</h2>
        <div class="row-fluid">
          <div class="span3"><h5>Name</h5></div>
          <div class="span3"><h5>Confirmation #</h5></div>
          <div class="span3"><h5>Flight Date\Time</h5></div>
          <div class="span3"><h5>&nbsp;</h5></div>
        </div>
        <!-- ko foreach: checkinList() -->
        <div class="row-fluid rowLikeTable" data-bind="attr: {id: $index()}, hideRow: $data == $root.currentCheckinEdit(), css: { lastRow: $index() == ($root.visibleCheckins().length - 1)}">
          <div class="span3" data-bind="text: fname() + ' ' + lname()"></div>
          <div class="span3" data-bind="text: confirmation"></div>
          <div class="span3" data-bind="text: datetime"></div>
          <div class="span3">
            <button class="btn btn-success" data-bind="click: $parent.editCheckin"><i class="icon-pencil icon-white"></i></button>
            <button class="btn btn-danger" data-bind="click: $parent.removeCheckin"><i class="icon-remove icon-white"></i></button>
          </div>
        </div>
        <!-- Edit Block -->
        <div class="row-fluid editBlock" data-bind="attr: {editfor: $index()}">
          <form data-bind="submit: $root.updateCheckin" method="POST">
            <div class="span3">
              <input type="text" data-bind="value: fname" placeholder="First Name" /><br/>
              <input type="text" data-bind="value: lname" placeholder="Last Name" />
            </div>
            <div class="span3">
              <input type="text" data-bind="value: confirmation" class="input-small" placeholder="Confirmation #" /><br/>
              <div class="control-group error">
                <input type="password" name="password" placeholder="Password" />
                <span class="help-block" style="white-space: nowrap;">Use the same password as when created. Required to save changes.</span>
              </div>
            </div>
            <div class="span3">
              <div class="input-append date" data-bind="dateTimePicker: true">
                <input data-format="MM/dd/yyyy HH:mm PP" type="text" data-bind="value: datetime" value=""></input>
                <span class="add-on">
                  <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                </span>
              </div>
              <div style="margin-top: 10px;">
                <button class="btn btn-success" style="margin-right: 5px" data-bind="enableEditSaveValidate: true"><i class="icon-check icon-white"></i> Save</button><button class="btn btn-danger" data-bind="click: $root.stopEdit"><i class="icon-remove-sign icon-white"></i> Close</button>
              </div>
            </div>
            <div class="span3"></div>
          </form>
        </div>
        <!-- /ko -->
      </div>
      <!-- /List View -->
      
    </div> <!-- /container -->
    
    <div class="modal hide fade" id="modal-password">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Remove Check In</h3>
      </div>
      <div class="modal-body">
        <p>Enter password to remove check in</p>
        <input id="modal-password-password" type="password" />
      </div>
      <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Close</a>
        <a href="#" id="modal-password-submit" data-dismiss="modal" class="btn btn-primary" data-bind="click: $root.removeCheckinFinish">Submit</a>
      </div>
    </div>
    
    <div class="modal hide fade" id="modal-blank">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 id="modal-blank-title">Remove Check In</h3>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal" id="modal-blank-ok">Ok</a>
      </div>
    </div>
    
   

    <!-- JQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Knockout -->
    <script src="js/knockout.js"></script>
    <!-- Sammy.js -->
    <script src="js/sammy.js" type="text/javascript"></script>
    <!-- Enable responsive features in IE8 with Respond.js (https://github.com/scottjehl/Respond) -->
    <script src="js/respond.js" type="text/javascript"></script>
    <!-- Date/Time Picker (http://tarruda.github.io/bootstrap-datetimepicker/) -->
    <script src="js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <!-- Moment Date/Time library -->
    <script src="js/moment.min.js" type="text/javascript"></script>
    <!-- SPA -->
    <script src="js/spa.js" type="text/javascript"></script>
    <!-- Crypto Lib -->
    <script src="js/sha512.js"></script>
  </body>
</html>
