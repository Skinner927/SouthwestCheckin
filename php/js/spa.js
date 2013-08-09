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

// Represents a checkin row
function Checkin(data) {
  this.fname = ko.observable(data.fname);
  this.lname = ko.observable(data.lname);
  this.confirmation = ko.observable(data.confirmation);
  this.datetime = ko.observable(moment.unix(data.datetime).format('MM/DD/YYYY hh:mm A'));
}

function CheckinViewModel() {
  // Data
  var self = this;
  self.pages = ['List', 'Reports']; // Defined pages
  self.currentPage = ko.observable();
  self.currentCheckinEdit = ko.observable();
  
  // Later load this with AJAX
  self.checkinList = ko.observableArray([]);
  
  $.getJSON('api/list', function(data){
    var mappedCheckins = $.map(data, function(item) { return new Checkin(item); });
    self.checkinList(mappedCheckins);
  });
  
  // Operations
  self.removeCheckin = function(checkin) { self.checkinList.destroy(checkin); };
  self.editCheckin = function(checkin) {
    // Set element to current edit
    self.currentCheckinEdit(checkin);
    
    var id = self.checkinList.indexOf(checkin);
    
    
    
    //$('tr#'+id).fadeTo(500, 0.5);
  };
  
  self.Temp = function(){ self.currentCheckinEdit(null); };
  
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
  }).run();
}

// Initializes Date/Time pickers
ko.bindingHandlers.dateTimePicker = {
  init: function(element) {
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
      
      
      console.log('hide: ', element);
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
      
        console.log('show: ', element);
      }
    }
  }
}

// Bind the VM
ko.applyBindings(new CheckinViewModel());


