define(["jquery","underscore","backbone","models/employee"],function(e,t,n,r){var i=Backbone.Collection.extend({model:r,url:"/api/employee_service/getSubordinate"});return i});