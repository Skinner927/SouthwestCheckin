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
require_once('config.php');
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
      .noborderTable th, .noborderTable td {
        border-top: 0px solid white;
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
        <h2>Check In Queue</h2>
        <table class="table table-hover" >
          <thead><tr><th style="min-width:220px">Name</th><th style="min-width:262px">Confirmation #</th><th style="min-width:247px">Flight Date\Time</th><th>&nbsp;</th></tr></thead>
          
          <tbody data-bind="foreach: checkinList()">
            
            <tr data-bind="attr: {id: $index}, hideRow: $data == $root.currentCheckinEdit()">
              <td data-bind="text: fname() + ' ' + lname()"></td>
              <td data-bind="text: confirmation"></td>
              <td data-bind="text: datetime"></td>
              <td>
                <button class="btn btn-success" data-bind="click: $parent.editCheckin"><i class="icon-pencil icon-white"></i></button>
                <button class="btn btn-danger" data-bind="click: $parent.removeCheckin"><i class="icon-remove icon-white"></i></button>
              </td>
            </tr>
            <!-- Edit block -->
            <tr data-bind="attr: {editfor: $index}" style="display:none">
              <td colspan="4">
                <div style="display:none">
                  <table border="0" class="noborderTable">
                    <tr>
                      <td>               
                          <input type="text" data-bind="value: fname" placeholder="First Name" /><br/>
                          <input type="text" data-bind="value: lname" placeholder="Last Name" />                
                      </td>
                      <td>
                        <input type="text" data-bind="value: confirmation" class="input-small" placeholder="Confirmation #" /><br/>
                        <div class="control-group error">
                          <input type="password" name="password" placeholder="Password" />
                          <span class="help-block">Use the same password as when created.</span>
                        </div>
                      </td>
                      <td>
                        <div class="input-append date" data-bind="dateTimePicker: true">
                          <input data-format="MM/dd/yyyy HH:mm PP" type="text" data-bind="value: datetime" value=""></input>
                          <span class="add-on">
                            <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                          </span>
                        </div>
                        <div style="margin-top: 10px;">
                          <button class="btn btn-success" style="margin-right: 5px"><i class="icon-check icon-white"></i> Save</button><button class="btn btn-danger" data-bind="click: $root.stopEdit"><i class="icon-remove-sign icon-white"></i> Cancel</button>
                        </div>
                      </td>
                      <td></td>
                    </tr>
                  </table>
                </div>
              </td>
            </tr>
          </tbody> 
        </table>
      </div>
      <!-- /List View -->
      
    </div> <!-- /container -->
    
    <script type="text/html" id="editCheckinTemplate">
      <div>
        <table class="table table-hover" >
          <tr>
            <td><legend>First Name</legend><input type="text" data-bind="value: fname()" /></td>
          </tr>
        </table>
      </div>
    </script>
    
    <script type="text/html" id="fsd">
      <div>
       <div class="input-append date" data-bind="dateTimePicker: true">
                  <input data-format="MM/dd/yyyy HH:mm PP" type="text" data-bind="value: datetime()"></input>
                  <span class="add-on">
                    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                  </span>
                </div>
      </div>
    </script>

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
  </body>
</html>
