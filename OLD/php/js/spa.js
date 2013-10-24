/*
  Copyright (C) 2013  Dennis Skinner skinner927@gmail.com

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

// Represents a checkin row
function Checkin(data) {
  this.id = ko.observable(data.id);
  this.fname = ko.observable(data.fname);
  this.lname = ko.observable(data.lname);
  this.confirmation = ko.observable(data.confirmation);
  this.datetime = ko.observable(moment.unix(data.datetime).format('MM/DD/YYYY hh:mm A'));
}

function CheckinViewModel() {
  $(document).ready(function(){$('.rowLikeTable').last().css('border-bottom-width', '1px');});
  
  // Data
  var self = this;
  //self.pages = ['List', 'Reports']; // Defined pages
  self.pages = ['List']; // Defined pages
  self.currentPage = ko.observable();
  self.currentCheckinEdit = ko.observable();
  self.currentCheckinBackup = null;  
  self.checkinList = ko.observableArray([]);
  
  self.visibleCheckins = ko.computed(function(){
    return ko.utils.arrayFilter(self.checkinList(), function(checkin) { return !checkin._destroy });
  });
  
  // Operations
  // Remove a checkin from the list
  self.removeCheckin = function(checkin) { 
    // Prompt the user, upon complete the modalSubmitPass event is fired
    // That finishes up this process
    $('#modal-password-password').val('');
    $('#modal-password').data('checkin', checkin);    
    $('#modal-password').modal('show');
  };
  // Called when the modal password has been submitted (assists above)
  self.removeCheckinFinish = function (btn) {
    pass = CryptoJS.SHA512(CryptoJS.SHA512($('#modal-password-password').val())).toString();
    console.log('pass: ', $('#modal-password-password').val());
    // Get the checkin data stored in the modal
    var checkin = $('#modal-password').data('checkin');
    var data = ko.toJS(checkin);
    data.password = pass;

    // Post the delete
    $.post('api/delete', {data: JSON.stringify(data)}, function(result){
      if(result.error){
        // there was an error!
        niceAlert(result.error);
      }
      else {
        // Success
        self.checkinList.destroy(checkin);  
      }
    }, 'json');   
  }
  
  // Begin edit of Checkin (dropdown appears)
  self.editCheckin = function(checkin) {
    // Set element to current edit
    self.currentCheckinEdit(checkin);
    // Backup
    self.currentCheckinBackup = ko.toJS(checkin);
    // Gotta change the time back to unix
    self.currentCheckinBackup.datetime = moment(self.currentCheckinBackup.datetime).unix();
    
    var id = self.checkinList.indexOf(checkin);   
 
  };  
  
  // Cancel and edit, undo the changes
  self.stopEdit = function(){
  
    // We need to resore the old values first
    var newCheckin = new Checkin(self.currentCheckinBackup);
    self.checkinList.replace(self.currentCheckinEdit(), newCheckin);
    
    // Now get the index of the new checkin so we can open and close it before the user notices
    var index = self.checkinList.indexOf(newCheckin);
    $("div[editfor='" + index +"']").show().slideUp(500);
        
    // Then hide the window (if there is one) and cleanup
    self.currentCheckinEdit(null); 
    self.currentCheckinBackup = null; 
  };
  
  // When the edit form is submitted, this processes it
  self.updateCheckin = function(){
    // Get the id so we can access the form
    var id = self.checkinList.indexOf(this);
    var form = $("div[editfor='" + id + "']").find('form').eq(0);
    
    var data = ko.toJS(this);
    // This is still insecure if sent over http but it'll slow down the scriptkiddies
    data.password = CryptoJS.SHA512(CryptoJS.SHA512(form.find("input[name='password']").val())).toString();
    
    // Post the update
    $.post('api/update', {data: JSON.stringify(data)}, function(result){
      if(result.error){
        // there was an error!
        niceAlert(result.error);
      } else {
        // Success
        self.currentCheckinEdit(null); 
        self.currentCheckinBackup = null; 
      }
    }, 'json');
  };
  
  // Add a new checkin
  self.addNewCheckin = function() {   
    try {
      // Start progress bar
      NProgress.start();
    
      // Serialize form
      var data = $('#newCheckinForm').serializeObject();
      
      // Lock inputs after serialization (FF freaks out otherwise)
      $('form#newCheckinForm :input').attr('disabled', 'true');
      
      // Blank passwords are changed to something "random" (Better than blank I guess)
      if(data.password.length < 1) {
        var keylist="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*1234567890";
        var temp='';
        for (i=0;i<15;i++)
          temp+=keylist.charAt(Math.floor(Math.random()*keylist.length));
        data.password = temp;
      }      
      
      // hash the password
      data.password = CryptoJS.SHA512(CryptoJS.SHA512(data.password)).toString();
      
      $.post('api/new', {data: data}, function(result) {
        if(result.error){
          niceAlert(result.error);
        } else {
          // Clear the form
          //$('#newCheckinForm').find('input').val('');
          // Refresh
          self.loadList();
          // Show success        
          $('#addSuccessAlert').fadeIn(500).delay(5000).fadeOut(1000);       
        }
      }, 'json')
      .error(function(){ niceAlert('An unknown error occurred. Please try again.');})
      .always(function(){ NProgress.done(); $('form#newCheckinForm :input').removeAttr('disabled'); });
    } catch(e) {
      console.error(e);
      NProgress.done(); 
      $('form.newCheckinForm :input').removeAttr('disabled');
      niceAlert('An unknown error occurred. Please try again.');
    }
  }
  
  // Load the list of checkins
  self.loadList = function() {    
    $.getJSON('api/list', function(data){
      var mappedCheckins = $.map(data, function(item) { return new Checkin(item); });
      self.checkinList(mappedCheckins);
    });
  }
  // init
  self.loadList();
  moment().local();
  $('#addSuccessAlert').hide();
  
  // Behaviours    
  self.goToPage = function(page) { location.hash = page };
    
  // Client-side routes    
  Sammy(function() {
      this.get('#:page', function() {
        location.hash = this.params.page;
        self.currentPage(this.params.page);
      });
      
      // Default
      this.get('', function() { this.app.runRoute('get', '#List') });
      
      // Override this function so that Sammy doesn't mess with forms
      this._checkFormSubmission = function(form) {
          return (false);
      };
  }).run();
  
  // Modals setup (init)
  $('#modal-password-password').keyup(function(e){
    if(e.which == 13) //ENTER
      $('#modal-password-submit').click();
  });  
  $('#modal-password').on('shown', function(){
    $('#modal-password-password').focus();
  });  
  $('#modal-blank').on('shown', function(){
    $('#modal-blank-ok').focus();
  }); 
}

// Initializes Date/Time pickers
ko.bindingHandlers.dateTimePicker = {
  init: function(element, valueAccessor, allBindingsAccessor) {
    // Init the Date/Time picker
    $(element).datetimepicker({      
      language: 'en',
      pick12HourFormat: true, 
      pickSeconds: false
    });  
  }
}

// Properly fades out and disables rows
ko.bindingHandlers.hideRow = {
  update: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext){
    if(valueAccessor() == true){
      // Save so we can show the element again later
      var el = $(element);
      el.data('gone', true);
      
      // Disable all buttons
      el.find('button').attr("disabled", "disabled");
      el.fadeTo(200, 0.3);
      
      // Show the edit pane
      el.siblings("div[editfor='" + el.attr('id') + "']").slideDown(500);      
    }
    else {
      if($(element).data('gone') === true) {
        // Revert everything above
        var el = $(element);
        el.data('gone', false);
        
        // Fade In (el.fadeIn wasn't working)
        el.fadeTo(200, 1.0, function(){
          el.find("button").removeAttr('disabled');
        });
        
        // Hide the edit pane
        el.siblings("div[editfor='" + el.attr('id') + "']").slideUp(500);      
      }
    }
  }
}

// Enables or disables the button upon validation
ko.bindingHandlers.enableEditSaveValidate = {
  init: function(element) {
    var el = $(element);
    var pass = el.parents('form').eq(0).find("input[name='password']");
    
    //init
    el.attr('disabled', 'disabled');
    
    pass.keyup(function(){
      // disable the button if password is too short
      if($(this).val().length > 0)
        el.removeAttr('disabled');
      else
        el.attr('disabled', 'disabled');
    });   
  }
}

function niceAlert(msg) {
  $('#modal-blank-title').text(msg);   
  $('#modal-blank').modal('show');  
}

// Makes a form serialize to a json object
// http://stackoverflow.com/questions/1184624/convert-form-data-to-js-object-with-jquery
$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

// Bind the VM
ko.applyBindings(new CheckinViewModel());

// Configure the progress bar
NProgress.configure({ trickleRate:0.2, trickleSpeed: 700});


