'use strict';


// Declare app level module which depends on filters, and services
angular.module('cms', [
  'ngRoute',
  'cms.alertServices',
  'cms.usersServices',
  'cms.admin_users',
  'cms.admin_pages',
]).
config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
  $locationProvider.html5Mode(true);
  $routeProvider.when('/admin', {templateUrl: '/assets/js/cms/app/partials/users_index.html', controller: 'AdminUsers'});
  $routeProvider.when('/admin/users', {templateUrl: '/assets/js/cms/app/partials/users_index.html', controller: 'AdminUsers'});
  $routeProvider.when('/admin/users/new', {templateUrl: '/assets/js/cms/app/partials/users_create.html', controller: 'AdminUserNew'});
  $routeProvider.when('/admin/users/:uid/edit', {templateUrl: '/assets/js/cms/app/partials/users_edit.html', controller: 'AdminEditUser'});
  $routeProvider.when('/pages', {templateUrl: '/assets/js/cms/app/partials/pages_index.html', controller: 'AdminPages'});
  $routeProvider.otherwise({redirectTo: '/pages'});
}]);